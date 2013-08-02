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
        $id = $this->request->query ('id');
        
        $this->loadModel ('Order');
        $order = $this->Order->find ('first', array ('conditions' => array ('guid' => $id)));
        
        $this->loadModel ('UserDeliverInfo');
        $deliver = $this->UserDeliverInfo->find ('first', array ('conditions' => array ('guid' => $order['Order']['deliver_guid'])));
        
        $this->set ('data', $order);
        $this->set ('deliver', $deliver['UserDeliverInfo']);
    }
    
    public function edit () {
        
    }
    
    public function delete () {
        
    }
}
?>
