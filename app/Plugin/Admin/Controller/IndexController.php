<?php

class IndexController extends AdminAppController {

    protected $error = array(
        'error' => 0,
        'element' => '',
        'message' => '',
        'data' => ''
    );

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

                $passwordHasher = new SimplePasswordHasher();
                $password = $passwordHasher->hash($data['password']);

                $conditions = array();

                if (empty($data['name'])) {
                    $this->error['error'] = 1;
                    $this->error['message'] = "Name or email is required";
                    exit(json_encode($this->error));
                }

                if (empty($data['password'])) {
                    $this->error['error'] = 1;
                    $this->error['message'] = "Password is required";
                    exit(json_encode($this->error));
                }

                if (preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/i", $data['name']) == true) {
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
                    $this->error['error'] = 1;
                    $this->error['message'] = "Wrong user/email or password.";
                    exit(json_encode($this->error));
                }

                $this->Auth->login($result['Admin']);
                exit(json_encode($this->error));
            }

            $this->error['error'] = 1;
            $this->error['message'] = "Not a validate input";
            exit(json_encode($this->error));
        }
    }

    public function logout () {
        
        if (!$this->Auth->loggedIn()) {
            $this->redirect(array("controller" => "index", "action" => "index"));
        }
        
        $this->Auth->logout();
        $this->redirect(array("plugin" => "admin", "controller" => "index", "action" => "login"));
    }

}

?>
