<?php

App::uses('AppController', 'Controller');

class IndexController extends AppController {

    public $uses = null;

    public function beforeFilter() {
        $this->Auth->allow("login", "register", "reset");
        $this->Auth->deny("logout");
        parent::beforeFilter();
    }

    public function signin () {

        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $error = array(
                'error' => 0,
                'message' => 'success'
            );

            $data = $this->request->data('signin');

            if (!empty($data['name'])) {

                App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
                $passwordHasher = new SimplePasswordHasher();
                $password = $passwordHasher->hash($data['password']);

                if ($data['name']) {
                    $conditions = array(
                        "email" => $data['name'],
                        "password" => $password
                    );
                }

                if ($data['name']) {
                    $conditions = array(
                        "name" => $data['name'],
                        "password" => $password
                    );
                }

                $this->loadModel('User');
                $result = $this->User->find(
                        "first", $conditions
                );

                if (empty($result)) {
                    $error['error'] = 1;
                    $error['message'] = "Your user/email or password isn't found";
                    exit(json_encode($error));
                }

                exit($error);
            }

            $error['error'] = 1;
            $error['message'] = "Not a validate input";
            exit($error);
        }
    }

    public function signup () {
        if ($this->request->is('ajax')) {
            $error = array(
                'error' => 0,
                'message' => 'success'
            );

            if ($this->request->is('post')) {
                $this->autoRender = false;
                $data = $this->request->data('signup');

                if (!empty($data['name'])) {

                    App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
                    $passwordHasher = new SimplePasswordHasher();
                    $password = $passwordHasher->hash($data['password']);

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

                    if (empty($result)) {
                        $error['error'] = 1;
                        $error['message'] = "Your user/email already exists";
                        exit(json_encode($error));
                    }

                    $user = array(
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'password' => $password
                    );

                    $this->loadModel('User');
                    $this->User->save($user);

                    exit(json_encode($error));
                }

                $error['error'] = 1;
                $error['message'] = "Not a validate input";
                exit(json_encode($error));
            }
            
            $this->layout = false;
            $this->render ("signup.ajax");
        }
    }

    function logout() {
        
    }

    function reset() {
        
    }

}