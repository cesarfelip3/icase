<?php

class SettingController extends AdminAppController {
    
    public function beforeFilter() {
        $this->Auth->deny();
	parent::beforeFilter();
    }
    
    public function mail ()
    {
        
    }
    
    public function payment ()
    {
        
    }
}
?>
