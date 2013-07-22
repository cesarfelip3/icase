<?php

class MembershipController extends MembershipAppController {
    
    public $uses = false;
    
    public function beforeFilter() {
        $this->Auth->allow ();
	parent::beforeFilter();
    }
    
    public function index ()
    {
        echo "hello world";
        exit;
    }
}