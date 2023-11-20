<?php

    class User extends AppModel {

        public $primaryKey = 'user_id';

        // In User.php (Model)
        public $validate = [
            'user_name' => [
                'notBlank' => [
                    'rule' => 'notBlank',
                    'message' => 'Please enter a username.',
                ],
                'length' => [
                    'rule' => ['lengthBetween', 5, 20],
                    'message' => 'Username should be between 5 and 20 characters.',
                ],
            ],
            'email' => array(
                'emailRule' => array(
                    'rule' => 'email',
                    'message' => 'Please enter a valid email address.'
                ), 
                'uniqueEmail' => array(
                    'rule' => array('isUnique', array('email', 'user_id')),
                    'message' => 'This email has already been taken'
                )
            ),
            
            'password' => [
                'rule' => ['minLength', 6],
                'message' => 'Password must be at least 6 characters long.',
            ],
            
        ];



    }