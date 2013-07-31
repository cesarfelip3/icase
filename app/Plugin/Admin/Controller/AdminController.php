<?php

class AdminController extends AdminAppController {
    
    public function beforeFilter() {
        $this->Auth->allow();
        $this->Auth->allow('guest');
	parent::beforeFilter();
    }
    
    public function index () {
        $this->layout = "admin";
    }
}
?>
