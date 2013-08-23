<?php
class CaseController extends AppController {
    
    public function beforeFilter() {
        $this->Auth->allow ();
	parent::beforeFilter();
        
        if (!$this->request->is ('ajax')) {
            $this->layoutInit();
        }
    }
    
    public function newcase () {
	$this->set ('load_shop_cart', true);
        $this->layout = "default";
    }

}