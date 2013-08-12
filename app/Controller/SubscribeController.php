<?php

App::uses('AppController', 'Controller');

class IndexController extends AppController {

    public $uses = null;
    protected $error = array(
        'error' => 0,
        'message' => 'success'
    );

    public function beforeFilter() {
        $this->Auth->allow("signin", "signup", "reset", "index");
        $this->Auth->deny("logout");
        parent::beforeFilter();
        
        if ($this->Auth->loggedIn()) {
            if (in_array(strtolower ($this->request->action), array ("signin", "signup"))) {
                
                $this->redirect ("/user/");
            }
        }
    }

    public function index() {

        
    }
    
    function subscribe() {
        
    }
    
    function send ()
    {
        
    }

}