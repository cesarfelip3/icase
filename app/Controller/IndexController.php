<?php

App::uses('AppController', 'Controller');
class IndexController extends AppController {
    public $uses = null;
    
    public function beforeFilter() {
        $this->Auth->deny("logout");
	parent::beforeFilter();
    }
    
    public function login ()
    {
        
    }
    
    public function register ()
    {
        
    }
    
    public function logout ()
    {
        
    }
}