<?php

class IndexController extends AdminAppController {


    public function beforeFilter() {
        $this->Auth->allow();
        $this->Auth->deny('logout');

        parent::beforeFilter();
    }

    public function login() {

        if ($this->Auth->loggedIn()) {
            $this->redirect(array("plugin" => "admin", "controller" => "admin", "action" => "index"));
        }

        $this->layout = "admin.login";
        if ($this->request->is('ajax')) {
            $this->autoRender = false;

            $data = $this->request->data('signin');

            if ($this->request->is('post')) {


                $conditions = array();

                if (empty($data['name'])) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "Name or email is required";
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

                $passwordHasher = new SimplePasswordHasher();
                $password = $passwordHasher->hash($data['password']);

                if ($this->_validate ('email', $data['name']) == true) {
                    $conditions = array(
                        "email" => $data['name'],
                        "password" => $password,
                        "active" => 1
                    );
                } else {
                    $conditions = array(
                        "name" => $data['name'],
                        "password" => $password,
                        "active" => 1
                    );
                }

                $this->loadModel('Admin');
                $result = $this->Admin->find(
                        "first", array("conditions" => $conditions)
                );

                if (empty($result)) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "Wrong user/email or password.";
                    exit(json_encode($this->_error));
                }

                $this->Auth->login($result['Admin']);
                exit(json_encode($this->_error));
            }

            $this->_error['error'] = 1;
            $this->_error['message'] = "Not a validate input";
            exit(json_encode($this->_error));
        }
    }

    public function logout() {

        $this->Auth->logout();
        $this->redirect(array("plugin" => "admin", "controller" => "index", "action" => "login"));
    }

    public function captcha() {
        $this->Captcha->image();
        exit;
    }

}

?>
