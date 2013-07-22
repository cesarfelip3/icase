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
	
	$this->loadModel ('Template');
	$data = $this->Template->find("all",
	    array (
		"conditions" => array (
		     "active" => 1
		 ),
		"order" => array (
		    "created DESC",
		    'id DESC'
		)
	    )
	);
	
	foreach ($data as $key => $value) {
	    $value['Template']['image'] = $this->base . "/" . $value['Template']['image'];
	    $data[$key] = $value;
	}
	
	//print_r ($data);
	echo json_encode($data);
    }
}