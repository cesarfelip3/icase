<?php

class ReportController extends AdminAppController {
    
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

    public function sales () {
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
    
    public function member () {
        
    }
    
    public function visits () {
        
    }
}
?>
