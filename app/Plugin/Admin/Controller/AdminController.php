<?php

//App::uses('AdminAppController', 'Controller');

class AdminController extends AdminAppController {

    public function beforeFilter() {
        $this->Auth->deny();
        parent::beforeFilter();
    }

    public function index() {
        $this->layout = "admin";
    }

    public function order() {

        if ($this->request->is('ajax')) {
            $this->loadModel("Order");
            $data = $this->Order->find('all', array("order" => "created DESC", "limit" => 7, "page" => 0));

            $statistics = array();
            $statistics['orders'] = $this->Order->find('count', array('conditions' => array('status' => 'paid')));

            $total = $this->Order->find('all', array('fields' => array('sum(amount) AS total'), 'conditions' => array('status' => 'paid')));

            $statistics['total'] = $total[0][0]['total'];
            if (empty($statistics['total'])) {
                $statistics['total'] = 0;
            }

            $this->loadModel('User');
            $statistics['members'] = $this->User->find('count', array('conditions' => array('type' => 'registered')));
            $statistics['subscribes'] = $this->User->find('count', array('conditions' => array('subscribe' => 1)));


            $this->set('data', $data);
            $this->set('statistics', $statistics);
            $this->layout = false;
            $this->render("index.orders");
        }
    }

    public function stock() {

        if ($this->request->is('ajax')) {

            $this->loadModel("Product");
            $data = $this->Product->find('all', array("conditions" => array("type" => "product", "quantity <=" => 0), "order" => "created DESC", "limit" => 7, "page" => 0));
            $this->set('data', $data);
            $this->layout = false;
            $this->render("index.stock");
        }
    }

    public function member() {

        if ($this->request->is('ajax')) {
            $this->loadModel('User');
            $data = $this->User->find('all', array("conditions" => array("type" => "registered"), "order" => "created DESC", "limit" => 7, "page" => 0));
            $this->set('data', $data);
            $this->layout = false;
            $this->render("index.registerations");
        }
    }

}

?>
