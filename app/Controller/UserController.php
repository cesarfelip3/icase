<?php

App::uses('AppController', 'Controller');

class UserController extends AppController {

    public $uses = false;
    protected $_error = array(
        "error" => 0,
        "message" => "",
        "files" => array(),
        "data" => array(),
    );

    public function beforeFilter() {
        $this->Auth->allow();
        parent::beforeFilter();
        if (!$this->request->is('ajax')) {
            $this->layoutInit();
        }

        if (empty($this->_identity)) {
            $this->redirect(array("controller" => "index", "action" => "signin"));
        }
    }

    public function index() {
        
    }

    public function profile() {
        
        if ($this->request->is('ajax') && $this->request->is('post')) {
            $this->autoRender = false;

            $data = $this->request->data('user');

            if (empty($data['name'])) {
                $this->_error['error'] = 1;
                $this->_error['element'] = 'input[name="user[name]"]';
                $this->_error['message'] = 'Customer name is required';
                exit(json_encode($this->_error));
            }

            if (preg_match("/^[a-z]{1,}|[a-z]{1,}[0-9]{1,}$/i", $data['name']) == false) {
                $this->_error['error'] = 1;
                $this->_error['element'] = 'input[name="user[name]"]';
                $this->_error['message'] = 'Invalid name, [a-z]...[0-9]...';
                exit(json_encode($this->_error));
            }

            if (empty($data['email'])) {
                $this->_error['error'] = 1;
                $this->_error['element'] = 'input[name="user[email]"]';
                $this->_error['message'] = 'Email is required';
                exit(json_encode($this->_error));
            }

            if (preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/i", $data['email']) == false) {
                $this->_error['error'] = 1;
                $this->_error['element'] = 'input[name="user[email]"]';
                $this->_error['message'] = 'Invalid email address';
                exit(json_encode($this->_error));
            }
            
            if (preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/i", $data['email2']) == false) {
                $this->_error['error'] = 1;
                $this->_error['element'] = 'input[name="user[email2]"]';
                $this->_error['message'] = 'Invalid email address';
                exit(json_encode($this->_error));
            }

            if (!isset($data['active'])) {
                $data['active'] = 0;
            }

            $this->loadModel('User');
            $result = $this->User->find('first', array("conditions" => array("OR" => array("name" => $data['name'], "email" => $data['email']))));

            if (empty($result)) {
                $this->_error['error'] = 1;
                $this->_error['element'] = '';
                $this->_error['message'] = 'User name or email doesn\'t exists';
                exit(json_encode($this->_error));
            }

            $data['name'] = strtolower($data['name']);
            
            if (!empty ($data['password'])) {
                $passwordHasher = new SimplePasswordHasher();
                $data['password'] = $passwordHasher->hash($data['password']);
            }

            $data['modified'] = time();

            if (isset ($data['guid'])) {
                unset ($data['guid']);
            }
            
            if (isset ($data['active'])) {
                unset ($data['active']);
            }
            
            $this->User->id = $result['User']['id'];
            
            $this->User->set($data);
            $this->User->save ();

            $this->_error['error'] = 0;
            $this->_error['element'] = 'input';
            exit(json_encode($this->_error));
        }
        
        $this->loadModel('User');
        $data = $this->User->find ('first', array ("conditions" => array ("guid" => $this->_identity['guid'])));
        $this->set ('data', $data['User']);
    }

    public function order() {
        $guid = $this->_identity['guid'];
        $action = $this->request->query('action');

        if (empty($action)) {
            
        }

        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            
            switch ($action) {
                case "list" :
                    $this->order_list();
                    break;
                case "delete" :
                    $this->order_delete();
                    break;
                case "view" :
                    $this->order_view();
                    break;
            }
        }
    }

    protected function order_list() {

        $this->layout = false;
        
        $this->loadModel("Order");
        $data = $this->Order->find('all', array("order" => "modified DESC", "conditions" => array("buyer_guid" => $this->_identity['guid'])));
        
        $this->set('data', $data);
        $this->render('order_list.ajax');
    }

    protected function order_view() {
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

    protected function order_delete() {
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

    public function creation() {
        
        $this->loadModel('Creation');
        $data = $this->Creation->find ('all', array ("order" => "modified DESC", "conditions" => array ("user_guid" => $this->_identity['guid'])));
        
        $guid = $this->_identity['guid'];
        
        $this->loadModel("Media");
        $data2 = $this->Media->find('all', array(
            'joins' => array(
                array(
                    'table' => 'media_to_object',
                    'alias' => 'MediaToObject',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array("MediaToObject.object_guid = '{$guid}'")
                ),
            ),
            'conditions' => array(
                "MediaToObject.type" => "user.design",
            ),
            'fields' => array("Media.*")
        ));
        
        $this->set ('data2', $data2);
        $this->set ('data', $data);
    }

    protected function creation_progress() {
        
    }

    protected function creation_final() {
        
    }

    protected function creation_load() {
        
    }

    protected function creation_download() {
        
    }

    protected function creation_delete() {
        
    }

}