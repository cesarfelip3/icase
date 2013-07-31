<?php

class OrderController extends AdminAppController {
    
    public function beforeFilter() {
        $this->Auth->allow();
        $this->Auth->allow('guest');
	parent::beforeFilter();
    }
    
    public function index () { 
    }
    
    public function add () {
        
    }
    
    public function view () {
        
    }
    
    public function edit () {
        
    }
    
    public function delete () {
        
    }
}
?>
