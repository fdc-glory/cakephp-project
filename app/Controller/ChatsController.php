<?php

    App::uses('User', 'Model');

    class ChatsController extends AppController {

        public $uses = array('User', 'Chat', 'ChatHistory');

        public $components = array("Session");

        public function index() {
            $userId = $this->Auth->user('user_id');
            $this->set('user_id', $userId);

            // Fetch records from the "chats" table
            $this->Paginator->settings = array(
                'limit' => 10, 
                'conditions' => [
                    'AND' => [
                        'OR' => [
                            'Chat.sender_id' => $this->Auth->user('user_id'),
                            'Chat.receive_id' => $this->Auth->user('user_id'),
                        ],
                        'Chat.last_message_sent = ch.msg_content',
                    ],
                ],
                'joins' => [
                    [
                        'table' => 'chat_history',
                        'alias' => 'ch',
                        'type' => 'INNER',
                        'conditions' => 'Chat.chat_id = ch.chat_id',
                    ],
                    [
                        'table' => 'users',
                        'alias' => 'u',
                        'type' => 'INNER',
                        'conditions' => 'Chat.receive_id = u.user_id',
                    ],
                ],
                
                'fields' => [
                    'Chat.chat_id',
                    'Chat.sender_id',
                    'Chat.receive_id',
                    'Chat.last_message_sent',
                    'ch.created_at AS last_message_created_at',
                    'u.profile_img',
                ],
            );

            // debug($chats);
            $chats = $this->Paginator->paginate('Chat');
            $this->set('chats', $chats);
    
        }


        public function add() {
            $loggedInUserId = $this->Auth->user('user_id');
        
            // Populating dropdown with users excluding the currently logged-in user
            $userData = $this->User->find('list', [
                'conditions' => ['User.user_id !=' => $loggedInUserId],
                'fields' => ['user_id', 'user_name']
            ]);
            $this->set('userData', $userData);
        
            if ($this->request->is('post') && !empty($this->request->data["Chat"]["user_id"])) {
                $user_id = $this->request->data["Chat"]["user_id"];
                $chat_text = $this->request->data["Chat"]["chat_text"];
        
                $chat = $this->Chat->find('first', [
                    'fields' => ['chat_id'],
                    'conditions' => [
                        'OR' => [
                            [
                                'AND' => [
                                    'sender_id' => $loggedInUserId,
                                    'receive_id' => $user_id,
                                ],
                            ],
                            [
                                'AND' => [
                                    'sender_id' => $user_id,
                                    'receive_id' => $loggedInUserId,
                                ],
                            ],
                        ],
                    ],
                ]);
                

                if ($chat) {
                    // If the chat exists, update it
                    if ($this->request->is(['post', 'put'])) {
                        $this->Chat->id = $chat['Chat']['chat_id'];
                        if ($this->Chat->save([
                            'sender_id' => $loggedInUserId,
                            'receive_id' => $user_id,
                            'last_message_sent' => $chat_text
                        ])) {

                            $this->ChatHistory->save([
                                'chat_id' => $chat['Chat']['chat_id'],
                                'msg_content' => $chat_text,
                                'created_at' => date('Y-m-d H:i:s'),
                            ]);

                            $this->Session->setFlash('Message sent');
                            $this->redirect(['action' => 'index']); 

                        } 
                    }
                } else {
                    // If the chat doesn't exist, create a new one
                    if ($this->request->is('post')) {
                        $this->Chat->create();
                        if ($this->Chat->save([
                            'sender_id' => $loggedInUserId,
                            'receive_id' => $user_id,
                            'last_message_sent' => $chat_text
                        ])) {

                            // Get the ID of the newly created chat
                            $chatId = $this->Chat->getLastInsertID();

                            $this->ChatHistory->save([
                                'chat_id' => $chatId,
                                'msg_content' => $chat_text,
                                'created_at' => date('Y-m-d H:i:s'),
                            ]);

                            $this->Session->setFlash('Message sent');
                            $this->redirect(['action' => 'index']); 
                        } 
                    }
                }
            }
        }
        
        public function autocomplete()
        {       
            $this->autoRender = false;

            $term = $this->request->query('term');
            
            $userData = $this->User->find('all', array(
                'fields' => array('User.user_id', 'User.user_name'), 
                'conditions' => array('User.user_name LIKE' => '%' . $term . '%'),
                'limit' => 10
            ));


            echo json_encode(array_values($userData));
        }

        public function view($chat_id){

            $this->Paginator->settings = array(
                'limit' => 10, 
                'conditions' => array('ChatHistory.chat_id' => $chat_id),
                'joins' => [
                    [
                        'table' => 'chats',
                        'alias' => 'c',
                        'type' => 'INNER',
                        'conditions' => 'ChatHistory.chat_id = c.chat_id'
                    ],
                    [
                        'table' => 'users',
                        'alias' => 'u',
                        'type' => 'INNER',
                        'conditions' => 'c.receive_id = u.user_id',
                    ]
                ],
                'fields' => [
                    'ChatHistory.msg_content',
                    'ChatHistory.created_at',
                    'c.sender_id',
                    'c.receive_id',
                    'u.profile_img'
                ],
                'order' => ['ChatHistory.created_at' => 'DESC']
            );


            $chat_details = $this->Paginator->paginate('ChatHistory');
    
            $this->set('chat_details', $chat_details);
            $this->set('chat_id', $chat_id);
            
        }

        public function reply() {
            $this->autoRender = false;
        
            if ($this->request->is('ajax')) {

                $replyContent = $this->request->data('replyContent');
                $chatId = $this->request->data('chatId');

                // Simulate saving to the database
                $this->loadModel('ChatHistory');
                
                $dataToSave = array(
                    'chat_id' => $chatId,
                    'msg_content' => $replyContent,
                    'created_at' => date('Y-m-d H:i:s')
                );

                if ($this->ChatHistory->save($dataToSave)) {
                    

                    $chat = $this->Chat->findByChatId($chatId);
                    $chat_id = $chat["Chat"]["chat_id"];
                    $user_id = $this->Auth->user('user_id');

                    $result = $this->Chat->find('first', array(
                        'fields' => array(
                            '(CASE WHEN Chat.receive_id = ' . $user_id . ' THEN Chat.sender_id WHEN Chat.sender_id = ' . $user_id . ' THEN Chat.receive_id ELSE NULL END) AS receiveId'
                        ),
                        'conditions' => array(
                            'Chat.chat_id' => $chat_id
                        ),
                        'recursive' => -1
                    ));
                    
                    $receiveId = isset($result[0]['receiveId']) ? $result[0]['receiveId'] : null;


                    if ($chat) {
                        $this->Chat->id = $chat['Chat']['chat_id'];
                        $this->Chat->save([
                            'sender_id' => $user_id,
                            'receive_id' => $receiveId,
                            'last_message_sent'=> $replyContent
                        ]);
                    } else {

                        echo json_encode(['status' => 'error', 'message' => 'Chat record not found']);
                        return;
                    }
                }

            }
        }

        public function delete() {

            $this->autoRender = false;
        
            if ($this->request->is('ajax') && $this->request->is('post')) {
                $chatId = $this->request->data['chatId'];
                
                $this->loadModel('ChatHistory');
                $this->loadModel('Chat');

                $this->Chat->query("DELETE FROM chats WHERE chat_id = $chatId");
                $this->ChatHistory->query("DELETE FROM chat_history WHERE chat_id = $chatId");

                $this->Session->setFlash('Chat and chat history deleted successfully.');

            }
        }
        

    }
?>