<?php


App::uses('Controller', 'Controller');

class AppController extends Controller {

    public $helpers = array('Js');

    public $components = array(
        // 'Flash',
        'DebugKit.Toolbar',
        'Session',
        'Auth',
        'RequestHandler',
        'Paginator'
    );

    public function isAuthorized($user) {

        return true;
    }

    public function beforeFilter() {
        $this->Auth->allow('index');
        $this->set('logged_in', $this->Auth->loggedIn()); 
        $this->set('current_user', $this->Auth->user());

        
    }
}
