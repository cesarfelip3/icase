<?php

App::uses('AppController', 'Controller');
class UserController extends AppController {
    
    public function beforeFilter() {
        $this->Auth->deny();
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
}