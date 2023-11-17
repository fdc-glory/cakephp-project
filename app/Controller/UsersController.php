<?php

    class UsersController extends AppController 
    {

        public $components = array("Session");

        public function beforeFilter(){
            $this->Auth->allow('add');
        }

        public function login(){
            // Check if the user is already authenticated
            if ($this->Auth->user()) {
                return $this->redirect(array('controller' => 'Messages', 'action' => 'index'));
            }

            //Auth login() but problem with hash password
            if ($this ->request->is('post')) {

                $email = $this->request->data['User']['email'];
                $password = $this->request->data['User']['password'];

                //Check is the entered username exists in database
                $user = $this->User->findByEmail($email);

                if (!empty($user)) {

                    $db_pass = $user['User']['password'];
                    
                    if (password_verify($password, $db_pass)) {

                        // Manually log in the user
                        $this->Auth->login($user['User']);

                        // Redirect after successful login
                        return $this->redirect($this->Auth->redirectUrl());
                        
                        
                    } else {
                        $this->Session->setFlash('Invalid password');
                    }
                } else {

                    $this->Session->setFlash('Invalid email');

                }

                

                
            }

        }

        public function logout() {
            $this->Auth->logout();
            $this->redirect('/users/login');
        }
        

        public function index(){
            //passing data from controller to views
            $this->set("framework", "Useless index");
        }

        public function add() {            
        
            if ($this->request->is('post')) {

                if ($this->data["User"]["password"] != $this->data["User"]["password_confirmation"]) {

                    $this->Session->setFlash("Password not match.");                

                } else {

                    $user_name = $this->data['User']['user_name'];
                    $email = $this->data['User']['email'];
                    $password = password_hash($this->data['User']['password'], PASSWORD_DEFAULT);
                    // echo $password;
                    $date_joined = date('Y-m-d H:i:s');
                    $login_time = date('Y-m-d H:i:s');
            
                    $user = $this->User->create();

                    $user['User'] = array(
                        'user_name' => $user_name,
                        'email' => $email,
                        'password' => $password,
                        'date_joined' => $date_joined,
                        'last_login_time' => $login_time
                    );
            
                    if ($this->User->save($user)) {
                        $this->Auth->login($user);
                        $this->Session->setFlash('Registration successful.');
                        $this->redirect(array('action' => 'thankyou')); 

                    } else {

                        $this->Session->setFlash('Registration failed. Please check your input.');
                    }
                }
            }
        }
        
        

        public function edit(){

        }

        public function thankyou(){

        }


    }
    
?>