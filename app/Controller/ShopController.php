<?php

App::uses('AppController', 'Controller');
class ShopController extends AppController {
    
    public $uses = false;
    
    public function beforeFilter() {
        $this->Auth->allow();
	parent::beforeFilter();
    }
    
    public function checkout () {
	
    }
    
    public function cart () {
        
	if ($this->request->is ("ajax")) {
	    $this->layout = false;
	    $orders = $this->request->data['orders'];
	    $data = array ();
	    
	    $action = $this->request->query ('action');
	    if ($action == "customize") {
		$images = $this->request->data['images'];
		
		if (empty ($images)) {
		    $this->set ('data', $data);
		    return;
		}
	    }
	    
	    if (empty ($orders)) {
		$this->set ('data', $data);
		return;
	    }
	    
	    $orders = explode (",", $orders);
	    
	    if (empty ($orders)) {
		$this->set ('data', $data);
		return;
	    }
	    
	    if ($action == "customize") {
		$images = explode (",", $images);
		
		if (empty ($images)) {
		    $this->set ('data', $data);
		    return;
		}
	    }
	    
	    $guids = array_flip ($orders);
	    $i = 0;
	    
	    foreach ($guids as $key => $value) {
		$guids[$key] = 0;
	    }
	    
	    foreach ($guids as $key => $value) {
		foreach ($orders as $order) {
		    if ($order == $key) {
			$guids[$key]++;
		    }
		}
	    }
	    
	    $this->loadModel ("Product");
	    $i = 0;
	    
	    foreach ($guids as $key => $value) {
		$data[$i]['data'] = $this->Product->findByGuid ($key);
		if (empty ($data[$i]['data'])) {
		    break;
		}
		if ($action == "customize") {
		    $data[$i]['data']['Product']['image'] = $images[$i];
		}
		$data[$i]['value'] = $value;
		$i++;
	    }
	    
	    $this->set ('data', $data);
	}
	
    }
        
    public function getTemplates () {
	
	if ($this->request->is('ajax')) {
	    $this->autoRender = false;
	    
	    $this->loadModel ('Product');
	    $data = $this->Product->find("all",
		array (
		    "conditions" => array (
			 "active" => 1,
			 "type" => "template"
		     ),
		    "order" => array (
			"created DESC",
			'id DESC'
		    )
		)
	    );
	    
	    foreach ($data as $key => $value) {
		$value['Product']['image'] = $this->base . "/" . $value['Product']['image'];
		$data[$key] = $value;
	    }
	    
	    //print_r ($data);
	    echo json_encode($data);
	}
    }
    
    // for test
    public function create () {
	
	$this->autoRender = false;
	
	$this->loadModel ('Product');
	$data = array (
	    'guid' => uniqid (),
	    'name' => "iphone",
	    "description" => "iphone 5 case description",
	    "price" => 29.32,
	    "tax" => 0,
	    "total" => 100,
	    "status" => "publish",
	    "created" => time (),
	    "modified" => time ()
	);
	
	$bulk = array ();
	for ($i = 0; $i < 3; ++$i) {
	    $data['price'] = 29.32 + rand (1, 100);
	    $data['guid'] = uniqid ();
	    $j = $i + 3;
	    $data['name'] = "iphone" . $j;
	    $data['type'] = 'template';
	    $data['image'] = 'img/template/iphone.png';
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