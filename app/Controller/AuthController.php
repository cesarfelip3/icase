<?php

App::uses('AppController', 'Controller');

class AuthController extends AppController {

    public $uses = false;

    public function beforeFilter() {
        $this->Auth->allow();
        $this->Auth->deny("logout");
        $this->Auth->deny("activelink");
        parent::beforeFilter();

        if ($this->Auth->loggedIn()) {
            if (in_array(strtolower($this->request->action), array("signin", "signup", "reset"))) {

                $this->redirect(array("controller" => "user", "action" => "index"));
            }
        }
    }

    public function index() {
        $this->redirect(array("controller" => "user", "action" => "index"));
    }

    public function signin() {

        if ($this->request->is('ajax')) {

            $this->autoRender = false;
            if ($this->request->is('post')) {

                $data = $this->request->data('signin');

                $passwordHasher = new SimplePasswordHasher();
                $password = $passwordHasher->hash($data['password']);

                if ($this->_validate('email', $data['name']) == true) {
                    $conditions = array(
                        "email" => $data['name'],
                        "password" => $password
                    );
                }

                if ($this->_validate("username", $data['name']) == true) {
                    $conditions = array(
                        "name" => $data['name'],
                        "password" => $password,
                    );
                } else {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "invalid user name or email";
                    exit(json_encode($this->_error));
                }
                
                if (empty ($data['captcha'])) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "Type correctly below captcha image";
                    exit(json_encode($this->_error));
                }
                
                if (!$this->Captcha->check ($data['captcha'])) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "Type correctly below captcha image";
                    exit(json_encode($this->_error));
                }
                

                $this->loadModel('User');
                $result = $this->User->find("first", array(
                    "conditions" => $conditions
                ));

                if (empty($result)) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "Your user/email isn't found";
                    exit(json_encode($this->_error));
                }

                $this->Auth->login($result['User']);
                $this->_error['error'] = 0;
                exit(json_encode($this->_error));
            }
        }
    }

    public function signup() {

        if ($this->request->is('ajax')) {
            
            $this->autoRender = false;
            if ($this->request->is('post')) {
                $data = $this->request->data('signup');

                if (empty($data['name']) || $this->_validate('username', $data['name']) == false) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "Invalid user name";
                    exit(json_encode($this->_error));
                }

                if ($this->_validate('email', $data['email']) == false) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "Invalid email address";
                    exit(json_encode($this->_error));
                }

                if (empty($data['password'])) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "Password is required";
                    exit(json_encode($this->_error));
                }
                
                if (empty ($data['captcha'])) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "Type correctly below captcha image";
                    exit(json_encode($this->_error));
                }
                
                if (!$this->Captcha->check ($data['captcha'])) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "Type correctly below captcha image";
                    exit(json_encode($this->_error));
                }

                $conditions = array(
                    "OR" => array(
                        "name" => $data['name'],
                        "email" => $data['email']
                    )
                );

                $this->loadModel('User');
                $result = $this->User->find("first", array(
                    "conditions" => $conditions
                ));

                if (!empty($result)) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "User name or email already exists";
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
                    'verified_expire' => time() + 1000 * 60 * 60 * 24,
                    'active' => 0,
                );

                $this->loadModel('User');
                $this->User->save($user);

                $id = $this->User->id;
                $user = array_merge(array("id" => $id), $user);
                $this->Auth->login($user);

                $var = array('data' => $user);

                try {
                    $from = array('sales@beautahfulcreations.com' => 'beautahfulcreations.com');
                    $this->_email($from, $data['email'], "Your account is ready, active it now", null, "user_signup", $var);
                } catch (Exception $e) {
                    $this->_error['error'] = 0;
                    $this->_error['message'] = $e->getMessage();
                    exit(json_encode($this->_error));
                }

                $this->_error['error'] = 0;
                exit(json_encode($this->_error));
            }
        }
    }

    public function formuser() {
        if ($this->request->is('ajax')) {
            $this->layout = false;
            $this->render("formuser.ajax");
        }
    }

    public function verify() {
        $id = $this->request->query('id');
        if (empty($id)) {
            return;
        }

        $this->loadModel('User');
        $data = $this->User->find('first', array("conditions" => array('verfied_code' => $id)));

        if (!empty($data)) {
            if ($data['User']['verfied_expire'] > time()) {
                $this->set('success', true);
                return;
            }
        }

        return;
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
        if ($this->request->is('ajax') && $this->request->is('post')) {
            $data = $this->request->data('reset');

            if (empty($data['email']) || $this->_validate('email', $data['email']) == false) {
                $this->_error['error'] = 1;
                $this->_error['message'] = "Invalid email address";
                exit(json_encode($this->_error));
            }

            $this->loadModel('User');
            $data = $this->User->find('first', array("conditions" => array("email" => $data['email'])));

            if (empty($data)) {
                $this->_error['error'] = 1;
                $this->_error['message'] = "Your email isn't in registration";
                exit(json_encode($this->_error));
            }

            try {
                $from = array('sales@beautahfulcreations.com' => 'beautahfulcreations.com');
                $var = array('data', $data['User']);
                $this->_email($from, $data['User']['email'], "Reset your password now", null, "signup_verification", $var);
            } catch (Exception $e) {
                $this->_error['error'] = 0;
                $this->_error['message'] = $e->getMessage();
                exit(json_encode($this->_error));
            }


            $this->_error['error'] = 0;
            $this->_error['message'] = "We have sent you email to reset your password.";
            exit(json_encode($this->_error));
        }
    }

    public function activelink() {

        if ($this->request->is('ajax')) {

            $this->loadModel('User');
            $data = $this->User->find('first', array("conditions" => array("guid" => $this->_identity['guid'])));
            $data = $data['User'];

            $this->User->id = $data['id'];
            $this->set(
                    array(
                        "verfied_code" => sha1(uniqid()),
                        "verified_expire" => time()
            ));
            $this->User->save();

            try {
                $from = array('sales@beautahfulcreations.com' => 'beautahfulcreations.com');
                $var = array('data' => $data);
                $this->_email($from, $data['email'], "Your account is ready, active it now", null, "user_signup", $var);
            } catch (Exception $e) {
                $this->_error['error'] = 1;
                $this->_error['message'] = $e->getMessage();
                exit(json_encode($this->_error));
            }

            $this->_error['error'] = 0;
            $this->_error['message'] = $e->getMessage();
            exit(json_encode($this->_error));
        }
    }
    
    public function captcha ()
    {
        $this->Captcha->image();
    }

}
