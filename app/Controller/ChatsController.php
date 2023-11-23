<?php

    App::uses('User', 'Model');

    class ChatsController extends AppController {

        public $uses = array('User', 'Chat', 'ChatHistory');

        public function index() {
            $userId = $this->Auth->user('user_id');
            $this->set('user_id', $userId);

            // Fetch records from the "chats" table
            $chats = $this->Chat->find('all', [
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
                'conditions' => [
                    'AND' => [
                        'OR' => [
                            'Chat.sender_id' => $this->Auth->user('user_id'),
                            'Chat.receive_id' => $this->Auth->user('user_id'),
                        ],
                        'Chat.last_message_sent = ch.msg_content',
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
            ]);

            // debug($chats);
            // exit;

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
        
            if ($this->request->is('post')) {
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
        

        public function view($chat_id){

            $chat_details = $this->ChatHistory->find('all', [
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
                'conditions' => [
                    'ChatHistory.chat_id' => $chat_id
                ],
                'fields' => [
                    'ChatHistory.msg_content',
                    'ChatHistory.created_at',
                    'c.sender_id',
                    'c.receive_id',
                    'u.profile_img'
                ],
                'order' => ['ChatHistory.created_at' => 'DESC']
            ]);

            // debug($chat_details);

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
                    
                    //update chats table
                    $chat = $this->Chat->findByChatId($chatId);
                    // Check if the chat record was found
                    if ($chat) {
                        $this->Chat->id = $chat['Chat']['chat_id'];
                        $this->Chat->save([
                            'last_message_sent'=> $replyContent
                        ]);
                    } else {
                        // Handle the case when the chat record is not found
                        echo json_encode(['status' => 'error', 'message' => 'Chat record not found']);
                        return;
                    }


                }
                
        
                

            }
        }
        
        
        
    }
?>