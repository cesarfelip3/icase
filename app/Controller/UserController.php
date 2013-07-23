<?php

App::uses('AppController', 'Controller');
class UserController extends AppController {
    
    public function beforeFilter() {
        $this->Auth->deny();
        $this->Auth->allow('guest');
	parent::beforeFilter();
    }
    
    public function index ()
    {
        
    }
    
    public function profile ()
    {
        
    }
    
    public function order ()
    {
        
    }
    
    public function buy ()
    {
        
    }
    
    public function invoice ()
    {
        
    }
    
    public function guest ()
    {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            
            $action = $this->request->query ('action');
            
            if (empty ($action)) {
                exit ("");
            }
            
            if ($action == 'newuuid') {
                $uuid = uniqid ();
                exit ($uuid);
            }
            
        }
    }
}