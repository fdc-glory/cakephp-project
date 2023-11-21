<?php

    App::uses('User', 'Model');

    class MessagesController extends AppController {

        public function index() {
            $userId = $this->Auth->user('user_id');
            $this->set('user_id', $userId);


             // Get the model for Messages
            $messagesModel = $this->loadModel('Messages');

            // Write the raw SQL query
            
            $sql = " SELECT c.chat_id, 
                c.user_id AS sender_id, 
                c.receive_id AS receiver_id, 
                u_receiver.profile_img AS receiver_profile_img, 
                m.msg_id, 
                m.msg_content, 
                m.timestamp 
                FROM (SELECT chat_id, MAX(timestamp) AS max_timestamp FROM messages GROUP BY chat_id) latest_messages 
                JOIN messages m ON latest_messages.chat_id = m.chat_id 
                AND latest_messages.max_timestamp = m.timestamp JOIN chats c ON m.chat_id = c.chat_id JOIN users u_receiver ON c.receive_id = u_receiver.user_id 
                WHERE 37 IN (c.user_id, c.receive_id) 
                ORDER BY max_timestamp DESC, c.chat_id;";

                $db = ConnectionManager::getDataSource('default');
                $messages = $db->query($sql);

                // debug($messages);

            $this->set('messages', $messages);
    
        }

        public function new_message(){
            
            $this->loadModel('User');

            //populating dropdown with users.
            $userData = $this->User->find('list', [
                'fields' => ['user_id', 'user_name']
            ]);
            $this->set('userData', $userData);
        } 
        
        public function add() {
            // Use $this->request->data to access form data
            $receiver = $this->request->data["Message"]["receiver_id"];
            $content = $this->request->data["Message"]["msg_content"];
        
            debug($receiver);
            debug($content);
            exit;
        }
        
        
    }
?>