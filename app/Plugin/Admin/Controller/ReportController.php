<?php

class ReportController extends AdminAppController {
    
    public function beforeFilter() {
        $this->Auth->allow();
        $this->Auth->allow('guest');
	parent::beforeFilter();
    }
    
    public function sales () { 
    }
    
    public function member () {
        
    }
    
    public function visits () {
        
    }
}
?>
