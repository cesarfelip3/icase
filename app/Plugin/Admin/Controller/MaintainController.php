<?php


class MaintainController extends AdminAppController {

    public $uses = false;
    public $maintain = true;
    public $version = 0.2;

    public function beforeFilter() {
        $this->Auth->allow();
        parent::beforeFilter();

        if (!$this->maintain) {
            $this->redirect(array(
                "controller" => "index",
                "action" => "index"
            ));
        }
    }

    public function index() {
        
    }

}

?>