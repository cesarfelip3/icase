<?php

class OrderController extends AdminAppController {

    protected $status = array(
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
            'order' => 'modified DESC',
            'conditions' => $conditions,
            'fields' => array("Order.*")
                )
        );

        if (!empty($data)) {
            $total = $this->Order->find("count", array("conditions" => $conditions));
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
        $bill = $this->UserBillInfo->find('first', array('conditions' => array('guid' => $order['Order']['bill_guid'])));

        $this->set(
                array(
                    "data" => $order['Order'],
                    "status" => $this->status,
                    "deliver" => $deliver['UserDeliverInfo'],
                    "bill" => $bill['UserBillInfo']
        ));

        if ($order['Order']['type'] == 'template') {
            $this->loadModel("Product");
            $data = $this->Product->find('first', array("conditions" => array("guid" => $order['Order']['product_guid'])));

            if (!empty($data)) {
                $png1 = unserialize($data['Product']['image']);
                $png1 = $png1['foreground'];

                $filename = pathinfo($png1, PATHINFO_FILENAME);
                $png2 = $filename . "_overlay.png";

                $jpeg = $order['Order']['attachement'];
                $filename = pathinfo($jpeg, PATHINFO_FILENAME);
            }

            $png1 = APP . "webroot" . DS . "img" . DS . "template" . DS . $png1;
            $png2 = APP . "webroot" . DS . "img" . DS . "template" . DS . $png2;

            $jpeg = APP . "webroot" . DS . "uploads" . DS . "preview" . DS . $jpeg;

            try {
                $this->overlayImage($png1, $jpeg, $filename . "_user.jpeg");
                $this->overlayImage($png2, $jpeg, $filename . "_admin.jpeg");
            } catch (Exception $e) {
                $this->Session->setFlash($e->getMessage());
            }
        }
    }

    protected function overlayImage($overlay, $jpeg, $final) {

        $final = APP . "webroot" . DS . "uploads" . DS . "preview" . DS . $final;
        if (file_exists($final)) {
            return;
        }

        $png = imagecreatefrompng($overlay);
        $jpeg = imagecreatefromjpeg($jpeg);

        //list($width, $height) = getimagesize('./image.jpg');
        //list($newwidth, $newheight) = getimagesize('./mark.png');
        $out = imagecreatetruecolor(780, 780);
        imagecopyresampled($out, $jpeg, 0, 0, 0, 0, 780, 780, 780, 780);
        imagecopyresampled($out, $png, 0, 0, 0, 0, 780, 780, 780, 780);

        imagejpeg($out, $final, 100);

        $image = file_get_contents($final);
        $image = substr_replace($image, pack("cnn", 1, 300, 300), 13, 5);

        file_put_contents($final, $image);
    }

    public function edit() {
        $id = $this->request->query('id');

        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $data = $this->request->data('order');
            $this->loadModel('Order');

            if ($id == 0) {
                if (isset($data['selected'])) {

                    foreach ($data['selected'] as $key => $value) {
                        $this->Order->id = $value;
                        $this->Order->set(array("status" => $data[$value]['status']));
                        $this->Order->save();
                    }
                }
                exit(json_encode($this->error));
            }

            $this->Order->id = $id;

            $this->Order->set(array("status" => $data[$id]['status']));
            $this->Order->save();
            exit(json_encode($this->error));
        }
    }

    public function delete() {
        
    }

    public function notify() {

        $guid = $this->request->query('id');

        $this->loadModel('Order');
        $data = $this->Order->find('first', array("conditions" => array("guid" => $id)));
        $email = $this->request->data('email');

        $this->loadModel('UserBillInfo');
        $bill = $this->UserBillInfo->find('first', array("conditions" => array("guid" => $data['Order']['bill_guid'])));

        $this->loadModel('UserDeliverInfo');
        $deliver = $this->UserDeliverInfo->find('first', array("conditions" => array("guid" => $data['Order']['bill_guid'])));
        $deliver = $deliver['UserDeliverInfo'];

        if (empty($email)) {
            $this->error['error'] = 1;
            $this->error['message'] = "";
            exit(json_encode($this->error));
        }

        try {
            if (!empty($data)) {

                $from = array("orders@beautahfulcreations.com" => "beautahfulcreations.com");
                $to = $email['email'];
                $subject = $email['subject'];
                $content = $email['content'];
                $template = "order_status_changed";
                $vars = array("order" => $data['Order'], "bill" => $bill['UserBillInfo'], 'content' => $content, 'deliver' => $deliver);
                $this->email($from, $to, $subject, $content, $template, $vars);
            }
        } catch (Exception $e) {
            $this->error['error'] = 1;
            $this->error['message'] = $e->getMessage();
            exit(json_encode($this->error));
        }
        
        exit(json_encode($this->error));
    }

    protected function email($from, $to, $subject, $content, $template, $vars = array()) {
        $Email = new CakeEmail();
        $Email->template($template);
        $Email->viewVars($vars);
        $Email->emailFormat('html');
        $Email->from($from);
        $Email->to($to);
        $Email->subject($subject);
        $Email->send();
    }

    public function fetch() {
        $id = $this->request->query('id');
        $action = $this->request->query('action');

        if ($action == "user" && $this->request->is('ajax')) {
            $this->loadModel('Order');
            $orders = $this->Order->find('all', array('conditions' => array('buyer_guid' => $id)));

            if (!empty($orders)) {
                $this->set('data', $orders);
            } else {
                $this->set('data', null);
            }

            $this->layout = false;
            $this->render('fetch.user');
        }
    }

}

?>
