<?php

class ProductController extends ProductAppController {
    public $uses = false;
    
    public function beforeFilter() {
        $this->Auth->allow ();
	parent::beforeFilter();
    }
    
    public function index ()
    {
        
    }
}