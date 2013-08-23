<?php

App::uses('AppController', 'Controller');

class OrderController extends AppController {

    public $uses = false;

    public function beforeFilter() {
        $this->Auth->deny();
        parent::beforeFilter();
    }

    public function index() {
        $guid = $this->_identity['guid'];

        if ($this->request->is('ajax')) {
            $this->layout = false;

            $this->loadModel("Order");
            $data = $this->Order->find('all', array("order" => "modified DESC", "conditions" => array("buyer_guid" => $this->_identity['guid'])));

            $this->set('data', $data);
            $this->render('order_list.ajax');
        }
    }
    
    public function view () {
        $guid = $this->request->query('id');

        if (empty($guid)) {
            $this->_error['error'] = 1;
            $this->_error['message'] = "";
            exit(json_encode($this->_error));
        }

        $this->loadModel("Order");
        $data = $this->Order->find("first", array("conditions" => array("guid" => $guid)));

        if (!empty($data)) {
            $this->loadModel("UserBillInfo");
            $bill = $this->UserBillInfo->find("first", array("conditions" => array("guid" => $data['bill_guid'])));

            $this->loadModel("UserDeliverInfo");
            $deliver = $this->UserDeliverInfo->find("first", array("conditions" => array("guid" => $data['deliver_guid'])));

            $this->set(array('bill' => $bill, 'deliver' => $deliver));
        }

        $this->set('data', $data);
    }

    public function delete() {
        $guid = $this->request->query('id');

        if (empty($guid)) {
            $this->_error['error'] = 1;
            $this->_error['message'] = "";
            exit(json_encode($this->_error));
        }

        $this->loadModel("Order");
        $data = $this->Order->find("first", array("conditions" => array("guid" => $guid)));

        if (!empty($data)) {
            $this->loadModel("UserBillInfo");
            $this->UserBillInfo->query("DELETE FROM user_bill_infos WHERE guid='{$data['bill_guid']}'");

            $this->loadModel("UserDeliverInfo");
            $this->UserDeliverInfo->query("DELETE FROM user_deliver_infos WHERE guid='{$data['deliver_guid']}'");

            exit(json_encode($this->_error));
        }

        $this->_error['error'] = 1;
        $this->_error['message'] = "";
        exit(json_encode($this->_error));
    }

}