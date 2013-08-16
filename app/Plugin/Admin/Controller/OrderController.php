<?php

class OrderController extends AdminAppController {

    protected $status = array (
            "awaiting" => "Awaiting Payment",
            "paid" => "Paid",
            "dispatch" => "Dispatched",
            "cancel" => "Cancelled",
            "refund" => "Refunded",
            "fail" => "Failed"
        );
    
    protected $error = array(
        'error' => 0,
        'element' => '',
        'message' => '',
    );
        
    public function beforeFilter() {
        $this->Auth->allow();
        $this->Auth->allow('guest');
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
                    array("title LIKE " => "%" . $keyword . "%"),
                    array("description LIKE " => "%" . $keyword . "%"))
            );
            $conditions = array_merge($conditions, $search);
        }

        if (!empty($filter)) {
            $conditions = array($conditions, array($filter));
        }

        //=========================================================
        $this->loadModel('Order');
        $data = $this->Order->find('all', array(
            'limit' => $limit,
            'page' => $page + 1,
            'conditions' => $conditions,
            'fields' => array("Order.*", "COUNT(*) AS count")
                )
        );

        if (!empty($data)) {
            $total = $data[0][0]['count'];
        } else {
            $total = 0;
        }

        if ($total == 0) {
            $data = array();
        }
        //=========================================================

        $pages = ceil($total / $limit);

        $filters = array(
            "status='awaiting'" => "Awaiting Payment",
            "status='paid'" => "Paid",
            "status='dispatch'" => "Dispatched",
            "status='cancel'" => "Cancelled",
            "status='refund'" => "Refunded",
            "status='fail'" => "Failed"
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
            "filters" => $filters,
            "status" => $this->status
        ));
    }

    public function add() {
        
    }

    public function view() {
        $id = $this->request->query('id');

        $this->loadModel('Order');
        $order = $this->Order->find('first', array('conditions' => array('guid' => $id)));

        $this->loadModel('UserDeliverInfo');
        $deliver = $this->UserDeliverInfo->find('first', array('conditions' => array('guid' => $order['Order']['deliver_guid'])));
        
        $this->loadModel('UserBillInfo');
        $bill = $this->UserBillInfo->find ('first', array('conditions' => array('guid' => $order['Order']['bill_guid'])));

        $this->set('data', $order);
        $this->set('status', $this->status);
        $this->set('deliver', $deliver['UserDeliverInfo']);
        $this->set('bill', $bill['UserBillInfo']);
    }

    public function edit() {
        $id = $this->request->query ('id');
        
        if ($this->request->is ('ajax')) {
            $this->autoRender = false;
            $data = $this->request->data ('order');
            $this->loadModel('Order');
            
            if ($id == 0) {
                if (isset ($data['selected'])) {
                
                    foreach ($data['selected'] as $key => $value) {
                        $this->Order->id = $value;
                        $this->Order->set (array("status" => $data[$value]['status']));
                        $this->Order->save();
                    }
                }
                exit (json_encode($this->error));
            }
            
            $this->Order->id = $id;
            
            $this->Order->set (array("status"=>$data[$id]['status']));
            $this->Order->save ();
            exit(json_encode($this->error));
        }
    }

    public function delete() {
        
    }

}

?>
