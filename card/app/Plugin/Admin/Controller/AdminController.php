<?php

//App::uses('AdminAppController', 'Controller');

class AdminController extends AdminAppController {

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {
        $this->layout = "admin";
    }

  

}

?>
