<?php

class AdminController extends AdminAppController {

    public function beforeFilter() {
        $this->Auth->allow();
        $this->Auth->allow('guest');
        parent::beforeFilter();
    }

    public function index() {
        $this->layout = "admin";
        
        if ($this->request->is ('ajax')) {
            
            $action = $this->request->query ('action');
            
            switch ($action) {
                case 'orders' :
                    $this->loadModel("Order");
                    $data = $this->Order->find ('all', array ("order" => "created DESC", "limit" => 7, "page" => 0));
                    
                    $statistics = array ();
                    $statistics['orders'] = $this->Order->find ('count', array ('conditions' => array ('status' => 'paid')));
                    
                    $total = $this->Order->find('all', array('fields' => array('sum(amount) AS total'), 'conditions'=>array('status'=>'paid')));
                    
                    $statistics['total'] = $total[0][0]['total'];
                    if (empty($statistics['total'])) {
                        $statistics['total'] = 0;
                    }
                    
                    $this->loadModel('User');
                    $statistics['members'] = $this->User->find ('count', array ('conditions' => array ('type' => 'register')));
                    $statistics['subscribes'] = $this->User->find ('count', array ('conditions' => array ('subscribe' => 1)));
                    
                    
                    $this->set ('data', $data);
                    $this->set ('statistics', $statistics);
                    $this->layout = false;
                    $this->render ("index.orders");
                    break;
                case 'stock' :
                    $this->loadModel("Product");
                    $data = $this->Product->find ('all', array ("conditions" => array ("type" => "product", "quantity <=" => 0), "order" => "created DESC", "limit" => 7, "page" => 0));
                    $this->set ('data', $data);
                    $this->layout = false;
                    $this->render ("index.stock");
                    break;
            }
        }
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
