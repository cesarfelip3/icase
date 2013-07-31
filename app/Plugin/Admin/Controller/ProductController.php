<?php

class ProductController extends AdminAppController {
    
    public function beforeFilter() {
        $this->Auth->allow();
        $this->Auth->allow('guest');
	parent::beforeFilter();
    }
    
    public function index () {
    }
    
    public function add () {
        
    }
    
    public function edit () {
        
    }
    
    public function delete () {
        
    }
    
    public function category () {
        $this->layout = false;
        if ($this->request->is('ajax')) {
            $this->render ('category.ajax');
        }
        
    }
}
?>
