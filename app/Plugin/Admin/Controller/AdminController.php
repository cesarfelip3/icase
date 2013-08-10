<?php

class AdminController extends AdminAppController {

    public function beforeFilter() {
        $this->Auth->allow();
        $this->Auth->allow('guest');
        parent::beforeFilter();
    }

    public function index() {
        $this->layout = "admin";
    }

    public function login() {
        $this->layout = "admin.login";
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
                    $this->error['error'] = 1;
                    $this->error['message'] = "invalid user name or email";
                    exit(json_encode($this->error));
                }

                $this->loadModel('Admin');
                $result = $this->Admin->find(
                        "first", array("conditions" => $conditions)
                );

                if (empty($result)) {
                    $this->error['error'] = 1;
                    $this->error['message'] = "Your user/email isn't found";
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

}

?>
