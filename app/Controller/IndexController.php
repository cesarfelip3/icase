<?php

App::uses('AppController', 'Controller');

class IndexController extends AppController {

    public $uses = false;
    public $cacheAction = array(
        'index' => array(
            'callbacks' => true, 
            'duration' => 3600000),
    );

    public function beforeFilter() {
        $this->Auth->allow();
        parent::beforeFilter();
    }

    public function index() {
        
        // here could use file cache
        $this->loadModel('Product');
        $data = $this->Product->find('all', array(
            "conditions" => array(
                "type" => "product",
                "is_featured" => 1,
                "quantity >" => 0),
            "order" => array("modified" => "DESC"),
            "limit" => 8,
            "page" => 0
        ));

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if (!empty($value['Product']['featured'])) {
                    $value['Product']['featured'] = unserialize($value['Product']['featured']);
                    $data[$key]['Product']['image'] = pathinfo($value['Product']['featured'][0], PATHINFO_FILENAME) . "_small.png";
                }
            }
        }
        $this->set('data', $data);
    }

    public function about() {
        
    }

}