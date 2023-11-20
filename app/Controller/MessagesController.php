<?php

    App::uses('User', 'Model');

    class MessagesController extends AppController {

        public function index() {
            $userId = $this->Auth->user('user_id');
            $this->set('user_id', $userId);
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