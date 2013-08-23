<?php

App::uses('AppController', 'Controller');

class UserController extends AppController {

    public $uses = false;

    public function beforeFilter() {
        $this->Auth->deny();
        parent::beforeFilter();
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

}