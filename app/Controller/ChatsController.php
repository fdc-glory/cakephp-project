<?php

    App::uses('User', 'Model');

    class ChatsController extends AppController {

        public $uses = array('User', 'Chat', 'ChatHistory');

        public function index() {
            $userId = $this->Auth->user('user_id');
            $this->set('user_id', $userId);

            // Fetch records from the "chats" table
            $chats = $this->Chat->find('all', [
                'fields' => ['last_message_sent'],
                'conditions' => [
                    'OR' => [
                        'sender_id' => 2,
                        'receive_id' => 2
                    ]
                ]
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
                        'sender_id' => $loggedInUserId,
                        'receive_id' => $user_id
                    ]
                ]);

                if ($chat) {
                    // If the chat exists, update it
                    if ($this->request->is(['post', 'put'])) {
                        $this->Chat->id = $chat['Chat']['chat_id'];
                        if ($this->Chat->save(['last_message_sent' => $chat_text])) {

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
        

        public function view(){
            
        }
        
        
    }
?>