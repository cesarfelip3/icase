<?php
class CaseController extends AppController {
    
    public function beforeFilter() {
        $this->Auth->allow ();
	parent::beforeFilter();
    }
    
    public function newcase () {
	
    }

}