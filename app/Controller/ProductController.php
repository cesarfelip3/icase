<?php

App::uses('AppController', 'Controller');
class ProductController extends AppController {
    
    public $uses = false;
    
    public function beforeFilter() {
        $this->Auth->allow();
	parent::beforeFilter();
    }
    
    public function getTemplates () {
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