<?php

    class User extends AppModel {

        public $primaryKey = 'user_id';

        // In User.php (Model)
        public $validate = [
            'user_name' => [
                'rule' => 'notBlank',
                'message' => 'Please enter a username.',
            ],
            'email' => array(
                'emailRule' => array(
                    'rule' => 'email',
                    'message' => 'Please enter a valid email address.'
                ), 
                'uniqueEmail' => array(
                    'rule' => 'isUnique',
                    'message' => 'This email has already been taken'
                )
            ),
            'password' => [
                'rule' => ['minLength', 6],
                'message' => 'Password must be at least 6 characters long.',
            ],
        ];

        // public function beforeSaved() {
        //     if (isset($this->data['User']['password'])) {

        //         $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        //     }
        //     return true;
        // }


    }