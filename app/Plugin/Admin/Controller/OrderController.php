<?php

class OrderController extends AdminAppController {
    
    public function beforeFilter() {
        $this->Auth->allow();
        $this->Auth->allow('guest');
	parent::beforeFilter();
    }
    
    public function index () { 
        $this->loadModel('Order');
        
        $orders = $this->Order->find (
                "all",
                array (
                    "conditions" => array (
                        
                    ),
                    "page" => 0,
                    "limit" => 25
                )
        );
        
        $this->set ('data', $orders);
        
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
