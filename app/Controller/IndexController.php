<?php

App::uses('AppController', 'Controller');

class IndexController extends AppController {

    public $uses = null;
    protected $_error = array(
        'error' => 0,
        'message' => 'success'
    );

    public function beforeFilter() {
        $this->Auth->allow("signin", "signup", "reset", "index");
        $this->Auth->deny("logout");
        parent::beforeFilter();

        if (!$this->request->is('ajax')) {
            $this->layoutInit();
        }
        
        if ($this->Auth->loggedIn()) {
            if (in_array(strtolower($this->request->action), array("signin", "signup"))) {

                $this->redirect("/user/");
            }
        }
    }

    public function index() {

        $this->loadModel('Product');
        $data = $this->Product->find('all', array(
            "conditions" => array("type" => "product", "is_featured" => 1),
            "order" => array("modified" => "DESC"),
            "limit" => 8,
            "page" => 0
        ));

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $value['Product']['featured'] = unserialize($value['Product']['featured']);
                $data[$key] = $value;
            }
        }

        $this->set('data', $data);
    }

    public function signin() {

        if ($this->request->is('ajax')) {
            $this->autoRender = false;

            $data = $this->request->data('signin');

            if ($this->request->is('post')) {

                $passwordHasher = new SimplePasswordHasher();
                $password = $passwordHasher->hash($data['password']);

                if (preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/i", $data['name']) == true) {
                    $conditions = array(
                        "email" => $data['name'],
                        "password" => $password
                    );
                } else if (preg_match("/^[a-zA-Z]{3,3}[0-9_a-zA-Z]*$/i", $data['name']) == true) {
                    $conditions = array(
                        "name" => $data['name'],
                        "password" => $password
                    );
                } else {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "invalid user name or email";
                    exit(json_encode($this->_error));
                }

                $this->loadModel('User');
                $result = $this->User->find(
                        "first", array("conditions" => $conditions)
                );

                if (empty($result)) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "Your user/email isn't found";
                    exit(json_encode($this->_error));
                }

                unset ($result['User']['data']);
                $this->Auth->login($result['User']);
                exit(json_encode($this->_error));
            }

            $this->_error['error'] = 1;
            $this->_error['message'] = "Not a validate input";
            exit(json_encode($this->_error));
        }
    }

    public function signup() {
        if ($this->request->is('ajax')) {

            if ($this->request->is('post')) {
                $this->autoRender = false;
                $data = $this->request->data('signup');

                if (!empty($data['name'])) {

                    $conditions = array(
                        "OR" => array(
                            "name" => $data['name'],
                            "email" => $data['email']
                        )
                    );

                    $this->loadModel('User');
                    $result = $this->User->find(
                            "first", array(
                        "conditions" => $conditions
                            )
                    );

                    if (!empty($result)) {
                        $this->_error['error'] = 1;
                        $this->_error['message'] = "User name or email already exists";
                        exit(json_encode($this->_error));
                    }

                    $data['name'] = strtolower($data['name']);
                    if (preg_match("/^[a-zA-Z]{3,3}[0-9_a-zA-Z]*$/i", $data['name']) == false) {
                        $this->_error['error'] = 1;
                        $this->_error['message'] = "Invalid name";
                        exit(json_encode($this->_error));
                    }

                    if (preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/i", $data['email']) == false) {
                        $this->_error['error'] = 1;
                        $this->_error['message'] = "Invalid email address";
                        exit(json_encode($this->_error));
                    }
                    
                    if (empty($data['password'])) {
                        $this->_error['error'] = 1;
                        $this->_error['message'] = "Password is required";
                        exit(json_encode($this->_error));
                    }

                    App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
                    $passwordHasher = new SimplePasswordHasher();
                    $password = $passwordHasher->hash($data['password']);

                    $user = array(
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'password' => $password,
                        'created' => time(),
                        'modified' => time(),
                        'type' => 'registered',
                        'guid' => uniqid(),
                        'verified_code' => sha1(uniqid()),
                        'verified_expire' => time () + 1000 * 60 * 60 * 24,
                        'active' => 0,
                    );

                    $this->loadModel('User');
                    $this->User->save($user);

                    $id = $this->User->id;
                    $user = array_merge(array("id" => $id), $user);
                    $this->Auth->login($user);
                    //$this->redirect($this->webroot . "user/");
                    
                    $var = array ('user' => $user);
                    try {
                    $this->email ("", $data['email'], "Confirm your signup now", null, "signup_verification", $var);
                    }
                    catch (Exception $e) {
                        $this->_error['error'] = 1;
                        $this->_error['message'] = $e->getMessage();
                        exit(json_encode($this->_error));
                    }

                    $this->_error['error'] = 0;
                    exit(json_encode($this->_error));
                }

                $this->_error['error'] = 1;
                $this->_error['message'] = "Not a validate input";
                exit(json_encode($this->_error));
            }

            $this->layout = false;
            $this->render("signup.ajax");
        }
    }
    
    protected function email($from, $to, $subject, $content, $template, $vars = array()) {
        $Email = new CakeEmail();
        $Email->template ($template);
        $Email->viewVars($vars);
        $Email->emailFormat('html');
        $Email->from($from);
        $Email->to($to);
        $Email->subject($subject);
        $Email->send();
    }

    function logout() {
        if ($this->request->is('ajax')) {
            $this->Auth->logout();
            $this->_error['error'] = 0;
            $this->_error['message'] = "";
            exit(json_encode($this->_error));
        }
        
        $this->redirect($this->Auth->logout());
    }

    function reset() {
        
    }

    function subscribe() {
        
    }

}