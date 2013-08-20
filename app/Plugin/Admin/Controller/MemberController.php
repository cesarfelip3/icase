<?php

class MemberController extends AdminAppController {

    protected $error = array(
        'error' => 0,
        'element' => '',
        'message' => '',
        'data' => ''
    );

    public function beforeFilter() {
        $this->Auth->deny();
        parent::beforeFilter();
    }

    public function index() {
        
        $page = $this->request->query('page');
        $limit = $this->request->query('limit');

        if (empty($limit)) {
            $limit = 25;
        }

        if (empty($page)) {
            $page = 0;
        }

        if ($page < 0) {
            $page = 0;
        }

        $keyword = $this->request->query('keyword');
        $filter = $this->request->query('filter');

        $start = $this->request->query('start');
        $end = $this->request->query('end');

        $conditions = array();

        if (!empty($start) && !empty($end)) {
            $duration = array(
                "AND" => array(
                    array("created >=" => strtotime($start)),
                    array("created <=" => strtotime($end))
            ));
            $conditions = array_merge($conditions, $duration);
        }

        if (!empty($keyword)) {
            $search = array(
                "OR" => array(
                    array("name LIKE " => "%" . $keyword . "%"),
                    array("description LIKE " => "%" . $keyword . "%"))
            );
            $conditions = array_merge($conditions, $search);
        }

        if (!empty($filter)) {
            $conditions = array($conditions, array($filter));
        }


        //=========================================================
        $this->loadModel('User');
        $total = $this->User->find("count", array("conditions" => $conditions));

        if ($total <= 0) {
            $data = array();
        } else {
            $data = $this->User->find('all', array(
                'limit' => $limit,
                'page' => $page + 1,
                'conditions' => $conditions,
                'fields' => array("User.*")
                    )
            );
            foreach ($data as $key => $value) {

                if ($value['User']['type'] == 'user') {
                    $value['User']['featured'] = unserialize($value['User']['featured']);
                    $value['User']['image'] = count($value['User']['featured']) > 0 ? $value['User']['featured'][0] : "";
                    $data[$key] = $value;
                }
            }
        }

        //=========================================================

        $pages = ceil($total / $limit);

        $filters = array(
            "type='register'" => "Registered",
            "type='guest'" => "Guest",
            "orders > 0" => "Has Orders"
        );

        $this->set(array(
            "data" => $data,
            "page" => $page,
            "limit" => $limit,
            "pages" => $pages,
            "keyword" => $keyword,
            "start" => $start,
            "end" => $end,
            "filter" => $filter,
            "filters" => $filters
        ));
    }

    public function add() {

        if ($this->request->is('ajax') && $this->request->is('post')) {
            $this->autoRender = false;

            $data = $this->request->data('user');
            $action = $this->request->query('action');

            if (empty($data['name'])) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="user[name]"]';
                $this->error['message'] = 'Customer name is required';
                exit(json_encode($this->error));
            }

            if (preg_match("/^[a-z]{1,}|[a-z]{1,}[0-9]{1,}$/i", $data['name']) == false) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="user[name]"]';
                $this->error['message'] = 'Invalid name, [a-z]...[0-9]...';
                exit(json_encode($this->error));
            }

            if (empty($data['email'])) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="user[email]"]';
                $this->error['message'] = 'Email is required';
                exit(json_encode($this->error));
            }

            if (preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/i", $data['email']) == false) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="user[email]"]';
                $this->error['message'] = 'Invalid email address';
                exit(json_encode($this->error));
            }

            if (empty($data['password'])) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="user[password]"]';
                $this->error['message'] = 'Password is required';
                exit(json_encode($this->error));
            }

            if (!isset($data['active'])) {
                $data['active'] = 0;
            }

            $this->loadModel('User');
            $result = $this->User->find('first', array("conditions" => array("OR" => array("name" => $data['name'], "email" => $data['email']))));

            if (!empty($result)) {
                $this->error['error'] = 1;
                $this->error['element'] = '';
                $this->error['message'] = 'User name or email exists';
                exit(json_encode($this->error));
            }

            $data['name'] = strtolower($data['name']);
            $passwordHasher = new SimplePasswordHasher();
            $data['password'] = $passwordHasher->hash($data['password']);

            $data['guid'] = uniqid();
            $data['created'] = time();
            $data['modified'] = time();
            $data['type'] = "register";

            $this->User->create();
            $this->User->save($data);
            $this->error['data'] = $this->User->id;

            $this->error['error'] = 0;
            $this->error['element'] = 'input';
            exit(json_encode($this->error));
        }
    }

    public function edit() {
        
        if ($this->request->is('ajax') && $this->request->is('post')) {
            $this->autoRender = false;

            $data = $this->request->data('user');
            $action = $this->request->query('action');

            if (empty($data['name'])) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="user[name]"]';
                $this->error['message'] = 'Customer name is required';
                exit(json_encode($this->error));
            }

            if (preg_match("/^[a-z]{1,}|[a-z]{1,}[0-9]{1,}$/i", $data['name']) == false) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="user[name]"]';
                $this->error['message'] = 'Invalid name, [a-z]...[0-9]...';
                exit(json_encode($this->error));
            }

            if (empty($data['email'])) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="user[email]"]';
                $this->error['message'] = 'Email is required';
                exit(json_encode($this->error));
            }

            if (preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/i", $data['email']) == false) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="user[email]"]';
                $this->error['message'] = 'Invalid email address';
                exit(json_encode($this->error));
            }

            if (!isset($data['active'])) {
                $data['active'] = 0;
            }

            $this->loadModel('User');
            $result = $this->User->find('first', array("conditions" => array("OR" => array("name" => $data['name'], "email" => $data['email']))));

            if (empty($result)) {
                $this->error['error'] = 1;
                $this->error['element'] = '';
                $this->error['message'] = 'User name or email doesn\'t exists';
                exit(json_encode($this->error));
            }

            $data['name'] = strtolower($data['name']);
            
            if (!empty ($data['password'])) {
                $passwordHasher = new SimplePasswordHasher();
                $data['password'] = $passwordHasher->hash($data['password']);
            }

            $data['modified'] = time();
            $data['type'] = "register";

            if (isset ($data['guid'])) {
                unset ($data['guid']);
            }
            
            $this->User->id = $result['User']['id'];
            $this->User->set($data);
            $this->User->save ();

            $this->error['error'] = 0;
            $this->error['element'] = 'input';
            exit(json_encode($this->error));
        }
        
        $guid = $this->request->query ('id');
        if (empty ($guid)) {
            $this->redirect ($this->base . "/admin/member/");
            //exit;
        }
        
        $this->loadModel('User');
        $data = $this->User->find('first', array("conditions" => array("guid" => $guid)));
        
        if (empty ($data)) {
            $this->redirect (array ("plugin"=>"admin", "controller"=>"member", "action"=>"index"));
        }
        
        $data = $data['User'];
        $this->set ('data', $data);
        
    }

    public function delete() {
        $id = $this->request->query('id');
        $this->loadModel('User');

        $this->User->delete($id);
        exit (json_encode($this->error));
    }

}

?>
