<?php

App::uses('AppController', 'Controller');

class UserController extends AppController {

    public $uses = false;

    public function beforeFilter() {
        $this->Auth->deny();
        parent::beforeFilter();
    }

    public function index() {

        $this->loadModel('Creation');
        $count = $this->Creation->find('count', array(
            "conditions" => array(
                "user_guid" => $this->_identity['guid']
        )));

        $this->loadModel("MediaToObject");
        $count2 = $this->MediaToObject->find('count', array(
            "conditions" => array(
                "object_guid" => $this->_identity['guid'],
                "type" => "user.creation",
        )));

        $this->loadModel("Order");
        $count3 = $this->Order->find('count', array(
            "conditions" => array(
                "buyer_guid" => $this->_identity['guid']
        )));

        $this->set('orders', $count3);
        $this->set('count', $count + $count2);
    }

    public function profile() {

        if ($this->request->is('ajax') && $this->request->is('post')) {
            $this->autoRender = false;

            $data = $this->request->data('user');

            if (isset ($data['name'])) {
                unset ($data['name']);
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
            $result = $this->User->find('first', array("conditions" => array("guid" => $this->_identity['guid'])));

            if (empty($result)) {
                $this->_error['error'] = 1;
                $this->_error['element'] = '';
                $this->_error['message'] = 'Something wrong with your account.';
                exit(json_encode($this->_error));
            }

            //$data['name'] = strtolower($data['name']);

            if (!empty($data['password'])) {
                $passwordHasher = new SimplePasswordHasher();
                $data['password'] = $passwordHasher->hash($data['password']);
            }

            $data['modified'] = time();

            if (isset($data['guid'])) {
                unset($data['guid']);
            }

            if (isset($data['active'])) {
                unset($data['active']);
            }

            $this->User->id = $result['User']['id'];

            require_once APP . 'Vendor' . DS . 'HtmlPurifier/library/HTMLPurifier.auto.php'; 
            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);
            
            foreach ($data as $key => $value) {
                if ($key == 'password') {
                    continue;
                }
                $data[$key] = $purifier->purify($value);
            }
            
            $this->User->set($data);
            $this->User->save();

            $this->_error['error'] = 0;
            $this->_error['element'] = 'input';
            exit(json_encode($this->_error));
        }

        $this->loadModel('User');
        $data = $this->User->find('first', array("conditions" => array("guid" => $this->_identity['guid'])));
        $this->set('data', $data['User']);
    }

}
