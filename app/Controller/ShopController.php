<?php

App::uses('AppController', 'Controller');
class ShopController extends AppController {
    
    public $uses = false;
    
    public function beforeFilter() {
        $this->Auth->allow();
	parent::beforeFilter();
    }
    
    public function cart () {
        
	if ($this->request->is ("ajax")) {
	    $this->layout = false;
	    $product_guid = $this->request->query ('id');
	   
	    if (empty ($product_guid)) {
		exit ("");
	    }
	    
	    if (preg_match ("/[^a-z0-9A-Z]/i", $product_guid)) {
		exit ("");
	    }
	    
	    $this->loadModel ("Product");
	    $data = $this->Product->findByGuid ($guid);
	    
	    if (empty ($data)) {
		exit ("");
	    }
	    
	}
	
    }
    
    public function create () {
	
	$this->autoRender = false;
	
	$this->loadModel ('Product');
	$data = array (
	    'guid' => uniqid (),
	    'name' => "iphone 5 case",
	    "description" => "iphone 5 case description",
	    "price" => 29.32,
	    "tax" => 0,
	    "total" => 100,
	    "status" => "publish",
	    "created" => time (),
	    "modified" => time ()
	);
	
	$bulk = array ();
	for ($i = 0; $i < 50; ++$i) {
	    $data['price'] = 29.32 + rand (1, 100);
	    $data['guid'] = uniqid ();
	    $bulk[] = $data;
	}
	$this->Product->saveMany ($bulk);
    }
    
    public function template () {
	$this->autoRender = false;
	
	$this->loadModel ('Template');
	$data = array (
	    'name' => "iphone",
	    'image' => "uploads/iphone.png"
	);
	
	$bulk = array ();
	for ($i = 0; $i < 3; ++$i) {
	    $data['guid'] = uniqid ();
	    $bulk[] = $data;
	}
	
	$this->Template->saveMany ($bulk);
    }
}