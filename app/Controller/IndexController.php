<?php

App::uses('AppController', 'Controller');

class IndexController extends AppController {

    public $uses = false;

    public function beforeFilter() {
        $this->Auth->allow();
        parent::beforeFilter();
    }

    public function index() {

        // here could use file cache
        $this->loadModel('Product');
        $data = $this->Product->find('all', array(
            "conditions" => array("type" => "product", "is_featured" => 1, "quantity >" => 0),
            "order" => array("modified" => "DESC"),
            "limit" => 8,
            "page" => 0
        ));

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if (!empty($value['Product']['featured'])) {
                    $value['Product']['featured'] = unserialize($value['Product']['featured']);
                    if (file_exists(APP . "webroot/uploads/product/" . pathinfo($value['Product']['featured']['150w'][0], PATHINFO_FILENAME) . ".png")){
                        
                        $value["Product"]['featured']['150w'][0] = pathinfo($value['Product']['featured']['150w'][0], PATHINFO_FILENAME) . ".png";
                    }
                    $data[$key]['Product']['image'] = $value['Product']['featured']['150w'][0];
                }
            }
        }

        $this->set('data', $data);
    }

    public function about() {
        
    }

}