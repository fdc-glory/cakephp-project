<?php

    class ChatHistory extends AppModel {
        public $useTable = 'chat_history';

        public $belongsTo = array(
            'Receiver' => array(
                'className' => 'User',
                'foreignKey' => 'to_user'
            ),
            'Sender' => array(
                'className' => 'User',
                'foreignKey' => 'from_user'
            ),
        );
    }
?>