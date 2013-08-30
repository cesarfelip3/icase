<?php

class CouponController extends AdminAppController {

    protected $error = array(
        'error' => 0,
        'element' => '',
        'message' => '',
        'data' => ''
    );

    public function beforeFilter() {
        $this->Auth->deny();
        $this->Auth->allow('install');
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

        $conditions = array("type" => "coupon");

        if (!empty($start) && !empty($end)) {
            $duration = array(
                "AND" => array(
                    array("expired >=" => strtotime($start)),
                    array("expired <=" => strtotime($end))
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
        $this->loadModel('Coupon');
        $total = $this->Coupon->find("count", array("conditions" => $conditions));

        if ($total <= 0) {
            $data = array();
        } else {
            $data = $this->Coupon->find('all', array(
                'limit' => $limit,
                'page' => $page + 1,
                'order' => 'modified DESC',
                'conditions' => $conditions,
                'fields' => array("Coupon.*")
                    )
            );
        }

        //=========================================================

        $pages = ceil($total / $limit);

        $filters = array(
            //"type='template'" => "Template",
            //"type='Coupon'" => "Coupon",
            "quantity=0" => "Empty Stocks"
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

            $data = $this->request->data('coupon');
            $category = $this->request->data('category');
            $action = $this->request->query('action');

            if (empty($data['name'])) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="coupon[name]"]';
                $this->error['message'] = 'Coupon name is required';
                exit(json_encode($this->error));
            }

            if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['value']) == false) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="coupon[value]"]';
                $this->error['message'] = 'Invalid value number';
                exit(json_encode($this->error));
            }

            if (preg_match("/^[0-9]{1,2}$/i", $data['discount']) == false) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="Coupon[discount]"]';
                $this->error['message'] = 'Invalid discount number';
                exit(json_encode($this->error));
            }

            $data['type'] = 'coupon';
            $data['status'] = 'unused';

            $this->loadModel('Coupon');

            $data['guid'] = uniqid();
            $data['created'] = time();
            $data['expired'] = strtotime($data['expired']);
            $data['modified'] = time();
            
            if ($data['created'] >= $data['expired']) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="Coupon[discount]"]';
                $this->error['message'] = 'Expired time is wrong';
                exit(json_encode($this->error));
            }

            $this->Coupon->create();
            $this->Coupon->save($data);
            $this->error['data'] = $this->Coupon->id;

            $this->error['element'] = 'input';
            exit(json_encode($this->error));
        }
    }

    //================================================================
    // @action: edit
    //================================================================

    public function edit() {

        $this->loadModel('Coupon');
        $this->_edit();

        $guid = $this->request->query("id");
        if (empty($guid)) {
            $this->redirect("/admin/Coupon");
        }

        $data = $this->Coupon->find('first', array("conditions" => array("guid" => $guid)));
        $data = $data['Coupon'];

        $this->set(array('data' => $data));
    }

    protected function _edit() {
        if ($this->request->is('ajax') && $this->request->is('post')) {
            $this->autoRender = false;

            $guid = $this->request->query("id");
            if (empty($guid)) {
                $this->error['error'] = 1;
                $this->error['message'] = 'Invalid ID';
                exit(json_encode($this->error));
            }

            $data = $this->Coupon->find('first', array("conditions" => array("guid" => $guid)));

            if (empty($data)) {
                $this->error['error'] = 1;
                $this->error['message'] = 'Coupon not exists';
                exit(json_encode($this->error));
            }

            $coupon = $data['Coupon'];

            $data = $this->request->data('coupon');
            $category = $this->request->data('category');
            $action = $this->request->query('action');

            if (empty($data['name'])) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="coupon[name]"]';
                $this->error['message'] = 'Coupon name is required';
                exit(json_encode($this->error));
            }

            if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['value']) == false) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="coupon[value]"]';
                $this->error['message'] = 'Invalid value number';
                exit(json_encode($this->error));
            }

            if (preg_match("/^[0-9]{1,2}$/i", $data['discount']) == false) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="Coupon[discount]"]';
                $this->error['message'] = 'Invalid discount number';
                exit(json_encode($this->error));
            }

            $this->loadModel('Coupon');

            $data['guid'] = uniqid();
            $data['modified'] = time();
            $data['expired'] = strtotime($data['expired']);

            if ($data['created'] >= $data['expired']) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="Coupon[discount]"]';
                $this->error['message'] = 'Expired time is wrong';
                exit(json_encode($this->error));
            }

            $this->Coupon->id = $coupon['id'];
            $this->Coupon->set($data);
            $this->Coupon->save();

            $this->error['element'] = 'input';
            exit(json_encode($this->error));
        }
    }

    //===========================================================
    //
    //===========================================================

    public function delete() {
        $id = $this->request->query('id');
        $this->loadModel('Coupon');

        $data = $this->Coupon->find('first', array("conditions" => array("id" => $id, 'type' => 'coupon')));
        if (empty ($data)) {
            $this->error['error'] = 1;
            $this->error['message'] = "Doesn't exist";
            exit(json_encode($this->error));
        }

        $this->Coupon->delete($id);
        exit(json_encode($this->error));
    }

 

}
?>
