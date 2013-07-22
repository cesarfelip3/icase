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
	
	echo json_encode($data);
    }
}