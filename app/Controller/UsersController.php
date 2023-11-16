
<?php

    class UsersController extends AppController 
    {
        public $components = array("Session");

        public function index(){
            //passing data from controller to views
            $this->set("framework", "Cakephp");
        }

        
    }
    
?>