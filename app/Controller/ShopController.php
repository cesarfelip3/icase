<?php

/*
 * This could be the most complex part of the application
 */


App::uses('AppController', 'Controller');

class ShopController extends AppController {

    public $uses = false;

    public function beforeFilter() {
        $this->Auth->allow();
        parent::beforeFilter();
    }

    //==============================================================
    // checkout - three steps - cart / confirm / final 
    //==============================================================

    public function checkout() {
        $action = $this->request->query("action");

        $this->set('action', $action);

        if ($action == "check") {
            $this->_checkout("check");
        }

        if ($this->request->is('ajax') && $this->request->is('post') && $action == "pay") {

            $deliver = $this->request->data('deliver');
            $bill = $this->request->data('bill');

            require_once APP . 'Vendor' . DS . 'HtmlPurifier/library/HTMLPurifier.auto.php';
            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);

            foreach ($bill as $key => $value) {
                if ($key == 'cc_expired') {
                    continue;
                }
                $bill[$key] = $purifier->purify($value);
            }

            foreach ($deliver as $key => $value) {
                if ($key == 'email') {
                    continue;
                }
                $deliver[$key] = $purifier->purify($value);
            }

            $guids = $this->_checkout($action);

            $this->loadModel('Product');

            $i = 0;
            $data = null;
            $data = array();
            foreach ($guids as $k => $value) {

                if (strpos($k, "-") != false) {
                    $key = explode("-", $k);
                    if (is_array($key)) {
                        $guid = $key[0];
                    }
                } else {
                    $key = $k;
                    $guid = $k;
                }

                $this->Product->begin();
                $data[$i] = $this->Product->findByGuid($guid);

                if (isset($key[1]) && $data[$i]['Product']['type'] == 'template') {
                    $data[$i]['Product']['file'] = $key[1];
                } else {
                    $data[$i]['Product']['file'] = $data[$i]['Product']['image'];
                }

                if ($data[$i]['Product']['quantity'] != 65535 && $data[$i]['Product']['quantity'] >= $value) {
                    $this->Product->id = $data[$i]['Product']['id'];
                    $this->Product->set(array('quantity' => $data[$i]['Product']['quantity'] - $value));
                    $this->Product->save();
                }

                $data[$i]['Product']['_quantity'] = $value;
                $i++;
            }

            $orders = array();
            $i = 0;

            if (!empty($data)) { // always exists
                $amount = 0;
                foreach ($data as $value) {
                    $amount += round($value['Product']['price'] * $value['Product']['_quantity'], 2, PHP_ROUND_HALF_DOWN) + "";
                }

                $payment_data = array(
                    'amount' => $amount,
                    'card' => array(
                        'cc_number' => $bill['cc_number'],
                        "cc_expired" => $bill['cc_expired']
                ));

                $payment_gateway = "AuthorizeNet";
                $payment_result = null;
                $result = $this->_pay($payment_gateway, $payment_data, $payment_result);

                //$result = true;
                if ($result == false) {
                    $this->Product->rollback();
                    exit(json_encode($this->_error));
                } else {
                    $result = array(
                        "transactionId" => $payment_result->transaction_id,
                        "transactionType" => $payment_result->transaction_type
                    );
                }

                // create user - guest
                $user_guid = null;
                $user_guest = false;

                $this->loadModel('User');

                if (empty($this->_identity)) {

                    $user_guest = true;

                    $user_guid = uniqid();
                    $user = array(
                        "guid" => $user_guid,
                        "type" => "guest",
                        "address" => $deliver['address'],
                        "city" => $deliver['city'],
                        "state" => $deliver['state'],
                        "country" => $deliver['country'],
                        "phone" => $deliver['phone'],
                        "email2" => $deliver['email'],
                        "zipcode" => $deliver['zipcode'],
                        "orders" => count($data),
                        "created" => time(),
                        "modified" => time()
                    );

                    $user = array_merge($user, $deliver);

                    $this->User->create();
                    $this->User->save($user);
                } else {
                    $user_guid = $this->_identity['guid'];

                    $user = array(
                        "orders" => ($this->_identity['orders'] + count($data))
                    );

                    $this->User->id = $this->_identity['id'];
                    $this->User->set($user);
                    $this->User->save();
                }

                // deliver info
                $this->loadModel('UserDeliverInfo');

                $this->UserDeliverInfo->create();
                $deliver_guid = uniqid();
                $deliver['guid'] = $deliver_guid;
                $deliver['user_guid'] = $user_guid;
                $this->UserDeliverInfo->save($deliver);

                // bill info
                $this->loadModel('UserBillInfo');
                $this->UserBillInfo->create();
                $bill_guid = uniqid();
                $bill['guid'] = $bill_guid;
                $bill['user_guid'] = $user_guid;
                $this->UserBillInfo->save($bill);

                //
                $media = array();
                $m2o = array();
                $j = 0;

                foreach ($data as $value) {
                    $orders[$i] = array(
                        "guid" => uniqid(),
                        "buyer_guid" => empty($user_guid) ? null : $user_guid,
                        "product_guid" => $value['Product']['guid'],
                        "deliver_guid" => $deliver_guid,
                        "bill_guid" => $bill_guid,
                        "notification_email" => $deliver['email'],
                        "title" => $value['Product']['name'],
                        "type" => $value['Product']['type'],
                        "amount" => round($value['Product']['price'] * $value['Product']['_quantity'], 2, PHP_ROUND_HALF_DOWN),
                        "quantity" => $data[$i]['Product']['_quantity'],
                        "attachement" => $value['Product']['file'],
                        "transaction_id" => $result['transactionId'],
                        "transaction_type" => $result['transactionType'],
                        "payment_gateway" => $payment_gateway,
                        "status" => "paid",
                        "created" => time(),
                        "modified" => time(),
                    );

                    if ($value['Product']['type'] == 'template') {
                        @copy(APP . DS . "webroot" . DS . "uploads" . DS . "preview" . DS . $value['Product']['file'], APP . DS . "webroot" . DS . "uploads" . DS . "user" . DS . $value['Product']['file']);
                    }

                    if ($value['Product']['type'] == 'template' && !$user_guest) {

                        $media_guid = uniqid();
                        $media[$j] = array(
                            "guid" => $media_guid,
                            "filename" => $value['Product']['file'],
                            "type" => "user.creation",
                            "created" => time(),
                            "modified" => time()
                        );

                        $m2o[$j] = array(
                            'media_guid' => $media_guid,
                            "object_guid" => $user_guid,
                            "type" => "user.creation"
                        );

                        $j++;
                    }

                    $i++;
                }

                if (!$user_guest && !empty($media)) {
                    $this->loadModel('Media');
                    $this->Media->create();
                    $this->Media->saveMany($media);

                    $this->loadModel('MediaToObject');
                    $this->MediaToObject->create();
                    $this->MediaToObject->saveMany($m2o);
                }

                $this->loadModel('Order');
                $this->Order->saveMany($orders);

                try {
                    /*
                    $to = $deliver['email'];
                    $subject = "Your Order is Confirmed";
                    $vars = array('deliver' => $deliver, 'bill' => $bill);
                    $content = null;
                    $this->_email("", $to, $subject, $content, "checkout_order_buyer", $vars);
                    
                    
                    $this->loadModel('Admin');
                    $admin = $this->Admin->find('first', array(
                        "conditions" => array(
                            "active" => 1,
                        )
                    ));

                    if (!empty($admin)) {
                        $to = $admin['Admin']['email'];
                    }*/
                    
                    $from = array('sales@beautahfulcreations.com' => 'beautahfulcreations.com');
                    $content = "";
                    $to = "cesarfelip3@gmail.com";
                    $subject = "There new orders come";
                    $var = array('data' => $orders);
                    $this->_email($from, $to, $subject, $content, "checkout_order_seller", $var);
                } catch (Exception $e) {
                    $this->Product->rollback();
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "We can't send email to you, make sure your email is valid. ({$deliver['email']})";// . $e->getMessage()
                    exit(json_encode($this->_error));
                }
                
                $this->Product->commit();
                
                if (isset($_SERVER['HTTP_COOKIE'])) {
                    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                    foreach ($cookies as $cookie) {
                        $parts = explode('=', $cookie);
                        $name = trim($parts[0]);

                        if ($name == 'orders') {
                            setcookie($name, '', time() - 1000, '/');
                        }
                    }
                }
                
                $this->layout = false;
                $this->render("checkout.success");
                return;
            }
        }

        if (!empty($this->_identity)) {
            $this->loadModel("User");
            $data = $this->User->find('first', array("conditions" => array("guid" => $this->_identity['guid'])));

            $this->set('deliver', $data['User']);
        }
    }

    protected function _checkout($action) {
        if ($this->request->is('ajax') && $this->request->is('post') && $action == "check") {


            $orders = isset($_COOKIE['orders']) ? $_COOKIE['orders'] : "";
            $data = array();

            if (empty($orders)) {
                $this->_error['error'] = 1;
                $this->_error['message'] = "There are no orders in cart now";
                exit(json_encode($this->_error));
            }

            $orders = json_decode($orders);

            if (empty($orders)) {
                $this->_error['error'] = 1;
                $this->_error['message'] = "There are no orders in cart now";
                exit(json_encode($this->_error));
            }

            $guids = array();
            foreach ($orders as $value) {
                if ($value->quantity <= 0) {
                    continue;
                }
                $guids[$value->id] = $value->quantity;
            }

            $this->loadModel("Product");
            $i = 0;
            $data = array();
            $total = 0;
            $quantity = 0;

            $this->_error['error'] = 0;

            foreach ($guids as $k => $value) {
                if (strpos($k, "-") != false) {
                    $key = explode("-", $k);
                    if (is_array($key)) {
                        $guid = $key[0];
                    }
                } else {
                    $key = $k;
                    $guid = $k;
                }

                $data[$i] = $this->Product->findByGuid($guid);
                if (empty($data[$i])) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "Sorry, this product was just off shelf";
                    $this->_error['data'][] = $key;
                    exit(json_encode($this->_error));
                }

                if ($data[$i]['Product']['quantity'] != 65535 && $data[$i]['Product']['quantity'] == 0) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "Sorry, product(SKU#{$data[$i]['Product']['guid']}) just sold out";
                    $this->_error['data'][] = $key;
                    exit(json_encode($this->_error));
                }

                if ($data[$i]['Product']['quantity'] != 65535 && $data[$i]['Product']['quantity'] < $value) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "Sorry, we only have {$data[$i]['Product']['quantity']} for product(SKU#{$data[$i]['Product']['guid']}), you ordered {$value}";
                    $this->_error['data'][] = $key;
                    exit(json_encode($this->_error));
                }

                //print_r ($value);

                $data[$i]['Product']['quantity'] = $value;
                $data[$i]['Product']['total'] = round($data[$i]['Product']['price'] * $data[$i]['Product']['quantity'], 2, PHP_ROUND_HALF_DOWN);

                $total += $data[$i]['Product']['total'];

                $i++;
            }

            $deliver = $this->request->data('deliver');

            foreach ($deliver as $key => $value) {
                if (empty($value)) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "DELIVER INFO : $key is required";
                    exit(json_encode($this->_error));
                }

                if ($key == "email") {
                    if ($this->_validate('email', $value) == false) {
                        $this->_error['error'] = 1;
                        $this->_error['message'] = "Email format is incorrect";
                        exit(json_encode($this->_error));
                    }
                }
            }

            $bill = $this->request->data('bill');

            foreach ($bill as $key => $value) {
                if (empty($value)) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "BILL INFO : $key is required";
                    exit(json_encode($this->_error));
                }
            }

            require_once APP . 'Vendor' . DS . 'HtmlPurifier/library/HTMLPurifier.auto.php';
            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);

            foreach ($bill as $key => $value) {
                if ($key == 'cc_expired') {
                    continue;
                }
                $bill[$key] = $purifier->purify($value);
            }

            foreach ($deliver as $key => $value) {
                $deliver[$key] = $purifier->purify($value);
            }

            $this->layout = false;
            $this->set("data", $data);
            $this->set("bill", $bill);
            $this->set("total", $total);
            $this->set("deliver", $deliver);
            $this->render("checkout.confirm");
            return;
            //exit(json_encode($this->_error));
        }

        if ($this->request->is('ajax') && $this->request->is('post') && $action == "pay") {
            $deliver = $this->request->data('deliver');
            $bill = $this->request->data('bill');

            $orders = isset($_COOKIE['orders']) ? $_COOKIE['orders'] : "";
            $data = array();

            if (empty($orders)) {
                $this->_error['error'] = 1;
                $this->_error['message'] = "There are no orders in cart now";
                exit(json_encode($this->_error));
            }

            $orders = json_decode($orders);

            if (empty($orders)) {
                $this->_error['error'] = 1;
                $this->_error['message'] = "There are no orders in cart now";
                exit(json_encode($this->_error));
            }

            $guids = array();
            foreach ($orders as $value) {
                if ($value->quantity <= 0) {
                    continue;
                }
                $guids[$value->id] = $value->quantity;
            }

            $this->loadModel("Product");
            $i = 0;

            foreach ($guids as $k => $value) {
                if (strpos($k, "-") != false) {
                    $key = explode("-", $k);
                    if (is_array($key)) {
                        $guid = $key[0];
                    }
                } else {
                    $key = $k;
                    $guid = $k;
                }

                $data[$i] = $this->Product->findByGuid($guid);
                if (empty($data[$i])) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "Product - " . $data[$i]['Product']['name'] . " - is off shelf, please remove it and try again.";
                    exit(json_encode($this->_error));
                }

                if ($data[$i]['Product']['quantity'] != 65535 && $data[$i]['Product']['quantity'] < $value) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "Product - " . $data[$i]['Product']['name'] . " - is out of stock, please change quantity before action, max is {$data[$i]['Product']['quantity']}.";
                    exit(json_encode($this->_error));
                }

                $i++;
            }

            $deliver = $this->request->data('deliver');

            foreach ($deliver as $key => $value) {
                if (empty($value)) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "DELIVER INFO : $key is required";
                    exit(json_encode($this->_error));
                }

                if ($key == "email") {
                    if ($this->_validate('email', $value) == false) {
                        $this->_error['error'] = 1;
                        $this->_error['message'] = "Email format is incorrect";
                        exit(json_encode($this->_error));
                    }
                }
            }

            $bill = $this->request->data('bill');

            foreach ($bill as $key => $value) {
                if (empty($value)) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "BILL INFO : $key is required";
                    exit(json_encode($this->_error));
                }
            }

            $this->autoRender = false;
            return $guids;
        }
    }

    protected function _pay($type, $data, &$result) {

        if ($type == "AuthorizeNet") {

            require_once APP . DS . 'Vendor' . DS . 'AuthorizeNet/AuthorizeNet.php'; // Make sure this path is correct.
            define("AUTHORIZENET_SANDBOX", false);
            $transaction = new AuthorizeNetAIM('9c22BSeN', '752eHX2G6hk9Y36J');
            $transaction->setSandbox(false);
            $transaction->amount = $data['amount'];
            $transaction->card_num = $data['card']['cc_number']; //4007000000027 - 10/16
            $transaction->exp_date = $data['card']['cc_expired']['month'] . "/" . $data['card']['cc_expired']['year'];

            $response = $transaction->authorizeAndCapture();

            if ($response->approved) {
                
            } else {
                $this->autoRender = false;
                $this->_error['error'] = 1;
                $this->_error['message'] = $response->error_message;
                return false;
            }

            $result = $response;
            return true;
        }
    }

    /*
     * @function cart - 2013.07.31 cart is as same as order now...
     */

    public function cart() {

        if ($this->request->is("ajax")) {
            $this->layout = false;
            //$orders = $this->request->data('orders');

            $action = $this->request->query('action');
            $orders = isset($_COOKIE['orders']) ? $_COOKIE['orders'] : "";

            if (empty($orders)) {
                $this->set('data', null);
                return;
            }

            $data = array();
            $orders = json_decode($orders);

            if (empty($orders)) {
                $this->set('data', $data);
                return;
            }

            $guids = array();
            foreach ($orders as $value) {
                if ($value->quantity <= 0) {
                    continue;
                }
                $guids[$value->id] = $value->quantity;
            }

            $this->loadModel("Product");
            $i = 0;


            foreach ($guids as $k => $value) {

                if (strpos($k, "-") != false) {
                    $key = explode("-", $k);
                    if (is_array($key)) {
                        $guid = $key[0];
                    }
                } else {
                    $key = $k;
                    $guid = $key;
                }

                $data[$i] = $this->Product->find('first', array("conditions" => array("guid" => $guid)));

                if (empty($data[$i])) {
                    $i = 0;
                    continue;
                }

                if (is_array($key) && isset($key[1])) {
                    $data[$i]['Product']['file'] = $key[1];
                } else {
                    if (!empty($data[$i]['Product']['featured'])) {
                        $data[$i]['Product']['featured'] = unserialize($data[$i]['Product']['featured']);
                        $data[$i]['Product']['file'] = $data[$i]['Product']['featured']['150w'][0];
                    } else {
                        $data[$i]['Product']['file'] = "";
                    }
                }

                if ($data[$i]['Product']['quantity'] != 65535 && $data[$i]['Product']['quantity'] < $value) {
                    $value = $data[$i]['Product']['quantity'];
                    $data[$i]['Product']['quantity_exceed'] = true;
                }

                $data[$i]['Product']['max'] = $data[$i]['Product']['quantity'];
                $data[$i]['Product']['quantity'] = $value;
                $i++;
            }

            if ($i == 0 && empty($data[$i])) {
                $data = array();
            }
            $this->set('data', $data);
        }
    }

    protected function _json($data = array()) {
        return json_encode($data); //, JSON_UNESCAPED_SLASHES);
    }

}