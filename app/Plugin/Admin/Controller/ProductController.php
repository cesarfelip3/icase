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
        $error = array (
            'error' => 0,
            'element' => '',
            'message' => '',
        );
        
        if ($this->request->is('ajax') && $this->request->is('post')) {
            $this->autoRender = false;
            $data = $this->request->data('product');
            
            if (empty ($data['name'])) {
                $error['error'] = 1;
                $error['element'] = 'input[name="product[name]"]';
                $error['message'] = 'Product name is required';
                exit (json_encode($error));
            }
            
            if (preg_match ("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['price']) == false) {
                $error['error'] = 1;
                $error['element'] = 'input[name="product[price]"]';
                $error['message'] = 'Invalid price number';
                exit (json_encode($error));
            }
            
            if (preg_match ("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['tax']) == false) {
                $error['error'] = 1;
                $error['element'] = 'input[name="product[tax]"]';
                $error['message'] = 'Invalid tax number';
                exit (json_encode($error));
            }
            
            if (preg_match ("/^[0-9]{1,2}$/i", $data['discount']) == false) {
                $error['error'] = 1;
                $error['element'] = 'input[name="product[discount]"]';
                $error['message'] = 'Invalid discount number';
                exit (json_encode($error));
            }
            
            $error['element'] = 'input';
            exit (json_encode($error));
        }
        
    }
    
    public function edit () {
        
    }
    
    public function delete () {
        
    }
    
    public function category () {
        if ($this->request->is('ajax')) {
            $this->layout = false;
            $this->render ('category.ajax');
        }
        
    }
}
?>
