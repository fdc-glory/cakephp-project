<?php

    class MessagesController extends AppController {

        public function index() {
            $userId = $this->Auth->user('user_id');
            $this->set('user_id', $userId);
        }
    }
?>