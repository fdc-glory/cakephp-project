<?php

    class Chat extends AppModel {
        public $useTable = 'chats';
        public $primaryKey = 'chat_id';

        public $belongsTo = array(
            'Sender' => array(
                'className' => 'User',
                'foreignKey' => 'sender_id'
            ),
            'Receive' => array(
                'className' => 'User',
                'foreignKey' => 'receive_id'
            )
        );

        
    }



?>
