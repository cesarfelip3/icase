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
            'order' => array(
                "modified DESC",
                "group_guid DESC",
            ),
            'conditions' => $conditions,
        ));

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

        //print_r ($data);
        //exit;

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

    public function view() {
        $id = $this->request->query('id');

        if (empty($id)) {
            $this->redirect(array(
                "plugin" => "admin",
                "controller" => "order",
                "action" => "index"
            ));
        }

        $this->loadModel('Order');
        $order = $this->Order->find('first', array('conditions' => array('guid' => $id)));

        if (empty($order)) {
            print_r("This order doesn't exist any more!");
            exit;
        }

        if (empty($order['Order']['group_guid'])) {
            $group = null;
        } else {
            $group = $this->Order->find('all', array(
                "order" => "title DESC",
                "conditions" => array(
                    "group_guid" => $order['Order']['group_guid'],
                )
            ));
        }

        $this->loadModel('UserDeliverInfo');
        $deliver = $this->UserDeliverInfo->find('first', array('conditions' => array('guid' => $order['Order']['deliver_guid'])));

        $this->loadModel('UserBillInfo');
        $bill = $this->UserBillInfo->find('first', array('conditions' => array('guid' => $order['Order']['bill_guid'])));

        $this->loadModel('EmailHistory');
        $emails = $this->EmailHistory->find('all', array(
            "conditions" => array(
                "object_guid" => $order['Order']['group_guid']
            )
        ));

        $this->set(
                array(
                    "emails" => $emails,
                    "group" => $group,
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
                $png1 = $filename . "_user.png";
                $png2 = $filename . "_admin.png";

                $jpeg = $order['Order']['attachement'];
                $filename = pathinfo($jpeg, PATHINFO_FILENAME);
            }

            $png1 = APP . "webroot" . DS . "img" . DS . "template" . DS . $png1;
            $png2 = APP . "webroot" . DS . "img" . DS . "template" . DS . $png2;

            $jpeg = APP . "webroot" . DS . "uploads" . DS . "preview" . DS . $jpeg;

            try {
                $this->_overlayImage($png1, $jpeg, $filename . "_user.jpeg");
                $this->_overlayImage($png2, $jpeg, $filename . "_admin.jpeg");
            } catch (Exception $e) {
                //$this->Session->setFlash($e->getMessage());
                $this->set('error', $e->getMessage());
            }
        }
    }

    protected function _overlayImage($overlay, $jpeg, $final) {

        $final = APP . "webroot" . DS . "uploads" . DS . "preview" . DS . $final;
        
        $basename = pathinfo($jpeg, PATHINFO_FILENAME);
        if (preg_match ("/ipad/i", $basename)) {
            $width = 3700;
            $height = 3700;
        } else {
            $width = 1850;
            $height = 1850;
        }

        $png = imagecreatefrompng($overlay);
        $jpeg = imagecreatefromjpeg($jpeg);

        //list($width, $height) = getimagesize('./image.jpg');
        //list($newwidth, $newheight) = getimagesize('./mark.png');
        $out = imagecreatetruecolor($width, $height);
        imagecopyresampled($out, $jpeg, 0, 0, 0, 0, $width, $height, $width, $height);
        imagecopyresampled($out, $png, 0, 0, 0, 0, $width, $height, $width, $height);

        imagejpeg($out, $final, 100);
        
        $image = file_get_contents($final);
        $image = substr_replace($image, pack("cnn", 1, 300, 300), 13, 5);

        file_put_contents($final, $image);
    }

    public function edit() {

        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $data = $this->request->data('order');
            $this->loadModel('Order');

            if ($this->request->is('post')) {
                $data = $this->request->data('order');


                foreach ($data['status'] as $key => $value) {
                    $this->Order->id = $key;
                    $this->Order->set(array(
                        "status" => $value,
                        'shipment_track' => trim($data['shipment_track']),
                        'shipment_fee' => trim($data['shipment_fee']),
                        'shipment_type' => trim($data['shipment_type']),
                        "shipment_trackurl" => trim($data['shipment_trackurl'])
                    ));
                    $this->Order->save();
                }
            }

            exit(json_encode($this->error));
        }
    }

    public function notify() {

        $guid = $this->request->query('id');

        $this->loadModel('Order');
        $data = $this->Order->find('first', array(
            "conditions" => array(
                "guid" => $guid)
        ));

        if (empty($data)) {
            $this->error['error'] = 1;
            $this->error['message'] = "No orders";
            exit(json_encode($this->error));
        }

        if (empty($data['Order']['group_guid'])) {
            $group = $data;
            $data = array();
            $data[] = $group;
        } else {
            $data = $this->Order->find('all', array(
                "order" => "modified DESC",
                "conditions" => array(
                    "group_guid" => $data['Order']['group_guid'],
                )
            ));
        }

        $email = $this->request->data('email');

        $this->loadModel('UserBillInfo');
        $bill = $this->UserBillInfo->find('first', array(
            "conditions" => array(
                "guid" => $data[0]['Order']['bill_guid'])
        ));

        $this->loadModel('UserDeliverInfo');
        $deliver = $this->UserDeliverInfo->find('first', array(
            "conditions" => array(
                "guid" => $data[0]['Order']['deliver_guid'])
        ));
        $deliver = $deliver['UserDeliverInfo'];

        if (empty($email)) {
            $this->error['error'] = 1;
            $this->error['message'] = "Invalid email";
            exit(json_encode($this->error));
        }

        try {
            if (!empty($data)) {

                $from = array("orders@beautahfulcreations.com" => "beautahfulcreations.com");
                $to = $email['email'];
                $subject = $email['subject'];
                $content = $email['content'];
                $template = "order_status_changed";

                if (!isset($email['with_order'])) {
                    $data = array();
                }

                if (!isset($email['with_deliver'])) {
                    $deliver = array();
                }

                $vars = array("orders" => $data, "bill" => $bill['UserBillInfo'], 'email_content' => $content, 'deliver' => $deliver);
                $this->email($from, $to, $subject, $content, $template, $vars);
            }
        } catch (Exception $e) {
            $this->error['error'] = 1;
            $this->error['message'] = $e->getMessage();
            exit(json_encode($this->error));
        }

        $this->loadModel('EmailHistory');
        $this->EmailHistory->create();
        $this->EmailHistory->save(array(
            "guid" => uniqid(),
            "object_guid" => $data[0]['Order']['group_guid'],
            "from" => serialize($from),
            "to" => $to,
            "subject" => $subject,
            "content" => $content,
            "created" => time(),
        ));

        exit(json_encode($this->error));
    }

    public function delete() {
        $id = $this->request->query('id');
        $action = $this->request->query('action');

        if ($action == "email") {
            $this->loadModel("EmailHistory");
            $this->EmailHistory->id = $id;
            $this->EmailHistory->delete();
        }

        if ($action == "order") {
            $this->loadModel("Order");
            $order = $this->Order->find('first', array(
                "conditions" => array(
                    "id" => $id,
                )
            ));

            if (empty($order)) {
                
            } else {
                $bill = $order['Order']['bill_guid'];
                $deliver = $order['Order']['deliver_guid'];

                $group = $this->Order->find('first', array(
                    "conditions" => array(
                        "group_guid" => $order['Order']['group_guid']
                    )
                ));

                if (count($group) > 1) {
                    exit(json_encode($this->error));
                }

                $this->loadModel('UserBillInfo');
                $this->UserBillInfo->deleteAll(array("guid" => $bill));

                $this->loadModel('UserDeliverInfo');
                $this->UserDeliverInfo->deleteAll(array("guid" => $deliver));

                $this->Order->id = $id;
                $this->Order->delete();

                exit(json_encode($this->error));
            }
        }

        exit(json_encode($this->error));
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

    protected function email($from, $to, $subject, $content, $template, $vars = array(), $debug = false) {
        $Email = new CakeEmail();
        $Email->config('smtp');
        $Email->template($template);
        $Email->viewVars($vars);
        $Email->emailFormat('html');
        $Email->from($from);
        $Email->to($to);
        $Email->subject($subject);
        $Email->send();
    }

}

?>
