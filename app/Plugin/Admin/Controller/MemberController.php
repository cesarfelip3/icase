<?php

class MemberController extends AdminAppController {
    
    public function beforeFilter() {
        $this->Auth->allow();
        $this->Auth->allow('guest');
	parent::beforeFilter();
    }
    
    public function lists () {
    }
    
    public function add () {
        
    }
    
    public function edit () {
        
    }
    
    public function delete () {
        
    }
    
    public function profile () {
        
    }
}
?>
