<?php

    class UsersController extends AppController 
    {

        public $components = array("Session");

        public function beforeFilter(){
            parent::beforeFilter();
            $this->Auth->allow('add');
        }

        public function isAuthorized($user){
            if(in_array($this->action, array('edit','delete'))){
                if($user['user_id'] != $this->request->params['pass'][0]){
                    return false;
                }
            }
            return true;
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

                        // Authenticate the user
                        $this->Auth->login($user['User']);

                        // Update login_time
                        $this->User->id = $user['User']['user_id'];
                        $this->User->saveField('last_login_time', date('Y-m-d H:i:s'));

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
        
        

        public function view($user_id){

            $data = $this->User->findByUserId($user_id);

            $this->set('user', $data);

        }

        public function edit($user_id){
            $data = $this->User->findByUserId($user_id);

            $this->request->data = $data;
        }

        public function update($user_id){

            if ($this->request->is(array('post','put'))) {
                
                $this->request->data['User']['user_id'] = $user_id;

                //IMAGE UPLOAD

                $rootfolder = WWW_ROOT . 'img/uploads/' ;
                $img = $this->request->data["User"]["profile_img"]; //put the data into a var for easy use
                
                if (is_uploaded_file($img['tmp_name'])) {

                    // The file was successfully uploaded
                    move_uploaded_file($img['tmp_name'], $rootfolder . $img['name']);
                    $this->request->data['User']['profile_img'] = $img['name'];

                } else {
                    // No new file uploaded, retain the existing value
                    $this->request->data['User']['profile_img'] = $this->User->field('profile_img', ['user_id' => $user_id]);

                }
                
                // Check if the password is being updated
                if (!empty($this->request->data['User']['password'])) {

                    // Hash the new password
                    $this->request->data['User']['password'] = password_hash(
                        $this->request->data['User']['password'],
                        PASSWORD_DEFAULT
                    );

                } else {

                    // If the password is not being updated, remove it from the data
                    unset($this->request->data['User']['password']);

                }

                if($this->User->save($this->request->data)){

                    $this->Session->setFlash('Account has been edited');
                    $this->redirect(array('controllers' => 'users', 'action'=> 'view', $user_id));

                }

            }
        }

        

        public function thankyou(){

        }


    }
    
?>