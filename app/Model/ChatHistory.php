<?php

    class ChatHistory extends AppModel {
        public $useTable = 'chat_history';

        public $belongsTo = array(
            'Chats' => array(
                'className' => 'Chat',
                'foreignKey' => 'chat_id'
            ),

        );
    }
?>