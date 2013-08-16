<?php

App::uses('AppController', 'Controller');

class ShopController extends AppController {

    public $uses = false;
    protected $_error = array(
        "error" => 1,
        "message" => "",
        "files" => array(),
        "data" => array(),
    );

    public function beforeFilter() {
        $this->Auth->allow();
        parent::beforeFilter();
        $this->set('load_shop_cart', true);
    }

    //==============================================================

    public function checkout() {
        $action = $this->request->query("action");

        if (empty($action)) {
            $action = "single";
        }

        if ($action == "single") {
            $checkout_single = true;
            $this->set('checkout_single', $checkout_single);
        }

        $this->set('action', $action);

        $this->_checkout();

        if ($this->request->is('post')) {

            $deliver = $this->request->data('deliver');
            $bill = $this->request->data('bill');

            $orders = $_COOKIE['orders'];
            $data = array();

            if (empty($orders)) {
                $this->set('data', $data);
                return;
            }

            $orders = explode(",", $orders);

            if (empty($orders)) {
                $this->set('data', $data);
                return;
            }

            $guids = array_flip($orders);
            $i = 0;

            foreach ($guids as $key => $value) {
                $guids[$key] = 0;
            }

            foreach ($guids as $key => $value) {
                foreach ($orders as $order) {
                    if ($order == $key) {
                        $guids[$key]++;
                    }
                }
            }

            $this->loadModel("Product");
            $i = 0;

            $this->Product->beginTransaction();

            foreach ($guids as $k => $value) {
                $k = explode("-", $key);
                if (is_array($key)) {
                    $guid = $key[0];
                }

                $data[$i] = $this->Product->findByGuid($guid);
                if (empty($data[$i])) {
                    $data = null;
                    $this->Session->setFlash("Product - " . $data[$i]['Product']['name'] . " - is off shelf, please remove it and try again.");
                    $this->Product->endTransaction();
                    return;
                }

                if ($data[$i]['Product']['quantity'] < $value) {
                    $data = null;
                    $this->Session->setFlash("Product - " . $data[$i]['Product']['name'] . " - is out of stock, please remove it and try again.");
                    $this->Product->endTransaction();
                    return;
                }

                $i++;
            }

            $i = 0;
            foreach ($guids as $k => $value) {

                $k = explode("-", $key);
                if (is_array($key)) {
                    $guid = $key[0];
                }

                $data[$i] = $this->Product->findByGuid($guid);

                if (isset($key[1])) {
                    $data[$i]['Product']['file'] = $key[1];
                } else {
                    $data[$i]['Product']['file'] = $data[$i]['Product']['image'];
                }

                if ($data[$i]['Product']['quantity'] != 65535) {
                    $this->Product->id = $data[$i]['Product']['id'];
                    $this->Product->set(array('quantity' => $data[$i]['Product']['quantity'] - $value));
                    $this->Product->save();
                }

                $data[$i]['Product']['quantity'] = $value;
                $i++;
            }

            $orders = array();
            $i = 0;
            if (!empty($data)) {

                $amount = 0;
                foreach ($data as $value) {
                    $amount += round($value['Product']['price'] * $value['Product']['quantity'], 2, PHP_ROUND_HALF_DOWN) + "";
                }

                require_once APP . DS . 'Vendor' . DS . 'AuthorizeNet/AuthorizeNet.php'; // Make sure this path is correct.
                $transaction = new AuthorizeNetAIM('9c22BSeN', '6333jT7Cc3JmwpUN');
                $transaction->amount = $amount;
                $transaction->card_num = $bill['cc_number'];
                $transaction->exp_date = $bill['cc_expired'];

                $response = $transaction->authorizeAndCapture();

                if ($response->approved) {
                    
                } else {
                    $this->Product->rollTransaction();
                    print_r($response->error_message);
                    exit;

                    $this->Session->setFlash($response->error_message);
                    return;
                }

                // create user - guest
                $user_guid = null;
                $user_guest = false;

                $this->loadModel('User');

                if (empty($this->_identity)) {

                    $user_guest = true;

                    $User_guid = uniqid();
                    $user = array(
                        "guid" => $user_guid,
                        "type" => "guest",
                        "address" => $bill['address'],
                        "city" => $bill['city'],
                        "state" => $bill['state'],
                        "country" => $bill['country'],
                        "phone" => $bill['phone'],
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
                    $this->user->set($user);
                    $this->user->save();
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
                $this->UserBillInfo->save ($bill);

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
                        "title" => $value['Product']['name'],
                        "type" => $value['Product']['type'],
                        "amount" => round($value['Product']['price'] * $value['Product']['quantity'], 2, PHP_ROUND_HALF_DOWN),
                        "quantity" => $data[$i]['Product']['quantity'],
                        "file" => $value['Product']['file'],
                        "transaction_id" => $response->transaction_id,
                        "transaction_type" => $response->transaction_type,
                        "payment_gateway" => "AuthorizeNet",
                        "status" => "paid",
                        "created" => time(),
                        "modified" => time(),
                    );

                    if ($value['Product']['type'] == 'template' && !$user_guest) {

                        $media[$j] = array(
                            "guid" => uniqid(),
                            "filename" => $value['Product']['file'],
                            "type" => "user.design",
                            "created" => time(),
                            "modified" => time()
                        );

                        $m2o[$j] = array(
                            'media_guid' => $media_guid,
                            "object_guid" => $user_guid,
                            "type" => "user.design"
                        );

                        $j++;
                    }

                    $i++;
                }

                $this->loadModel('Order');
                $this->Order->saveMany($orders);

                $this->loadModel('Media');
                $this->Media->create();
                $this->Media->saveMany($media);

                $this->loadModel('MediaToObject');
                $this->MediaToObject->save($m2o);

                $this->Product->commitTransaction();

                if (isset($_SERVER['HTTP_COOKIE'])) {
                    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                    foreach ($cookies as $cookie) {
                        $parts = explode('=', $cookie);
                        $name = trim($parts[0]);
                        setcookie($name, '', time() - 1000, '/');
                    }
                }
                $this->set("paid", true);
            }
        }
    }

    protected function _checkout() {
        if ($this->request->is('ajax') && $this->request->is('post')) {

            $deliver = $this->request->data('deliver');

            foreach ($deliver as $key => $value) {
                if (empty($value)) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = $key . " is required";
                    exit(json_encode($this->_error));
                }

                if ($key == "email") {
                    if (preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/i", $value) == false) {
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
                    $this->_error['message'] = "All fields in bill info are required";
                    exit(json_encode($this->_error));
                }
            }

            $orders = $_COOKIE['orders'];
            $data = array();

            if (empty($orders)) {
                $this->_error['error'] = 1;
                $this->_error['message'] = "You have to enable cookie to pay your cart";
                exit(json_encode($this->_error));
            }

            $orders = explode(",", $orders);

            if (empty($orders)) {
                $this->_error['error'] = 1;
                $this->_error['message'] = "You have to enable cookie to pay your cart";
                exit(json_encode($this->_error));
            }

            $guids = array_flip($orders);
            $i = 0;

            foreach ($guids as $key => $value) {
                $guids[$key] = 0;
            }

            foreach ($guids as $key => $value) {
                foreach ($orders as $order) {
                    if ($order == $key) {
                        $guids[$key]++;
                    }
                }
            }

            $this->loadModel("Product");
            $i = 0;

            $this->_error['error'] = 0;

            foreach ($guids as $k => $value) {
                $key = explode("-", $k);
                if (is_array($key)) {
                    $guid = $key[0];
                }

                $data = $this->Product->findByGuid($guid);
                if (empty($data)) {
                    $this->_error['error'] = 1;
                    $this->_error['data'][] = $key;
                    continue;
                }

                if ($data['Product']['quantity'] != 65535 && $data['Product']['quantity'] < 1) {
                    $this->_error['error'] = 1;
                    $this->_error['data'][] = $key;
                    continue;
                }
            }

            exit(json_encode($this->_error));
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

            $orders = $_COOKIE['orders'];

            if ($action == "single") {
                $orders = $_COOKIE['current-product-id'];
            }

            $data = array();
            $orders = explode(",", $orders);

            if (empty($orders)) {
                $this->set('data', $data);
                return;
            }

            $guids = array_flip($orders);
            $i = 0;

            foreach ($guids as $key => $value) {
                $guids[$key] = 0;
            }

            foreach ($guids as $key => $value) {
                foreach ($orders as $order) {
                    if ($order == $key) {
                        $guids[$key]++;
                    }
                }
            }

            $this->loadModel("Product");
            $i = 0;

            foreach ($guids as $key => $value) {
                $key = explode("-", $key);
                if (is_array($key)) {
                    $guid = $key[0];
                }

                $data[$i] = $this->Product->find('first', array("conditions" => array("guid" => $guid)));

                if (empty($data[$i])) {
                    $i = 0;
                    continue;
                }

                if (isset($key[1])) {
                    $data[$i]['Product']['file'] = $key[1];
                } else {
                    $data[$i]['Product']['file'] = "";
                }
                $data[$i]['Product']['quantity'] = $value;
                $i++;
            }

            if ($i == 0 && empty($data[$i])) {
                $data = array();
            }
            $this->set('data', $data);
        }
    }

    /*
     * @function order - deprecated
     */

    public function order() {
        if ($this->request->is("ajax")) {
            $this->layout = false;
            $orders = $this->request->data['orders'];
            $data = array();

            $user = $this->request->data['user'];

            if (empty($orders)) {
                $this->set('data', $data);
                return;
            }

            $orders = explode(",", $orders);

            if (empty($orders)) {
                $this->set('data', $data);
                return;
            }

            $guids = array_flip($orders);
            $i = 0;

            foreach ($guids as $key => $value) {
                $guids[$key] = 0;
            }

            foreach ($guids as $key => $value) {
                foreach ($orders as $order) {
                    if ($order == $key) {
                        $guids[$key]++;
                    }
                }
            }

            $this->loadModel("Product");
            $i = 0;

            foreach ($guids as $key => $value) {
                $key = explode("-", $key);
                if (is_array($key)) {
                    $guid = $key[0];
                }

                $data[$i] = $this->Product->findByGuid($guid);
                if (empty($data[$i])) {
                    $data = null;
                    break;
                }

                if (isset($key[1])) {
                    $data[$i]['Product']['file'] = $key[1];
                } else {
                    $data[$i]['Product']['file'] = $data[$i]['Product']['image'];
                }
                $data[$i]['Product']['quantity'] = $value;
                $i++;
            }

            $orders = array();
            $i = 0;
            if (!empty($data)) {
                foreach ($data as $value) {
                    $orders[$i] = array(
                        "guid" => uniqid(),
                        "buyer_guid" => $user,
                        "created" => time(),
                        "modified" => time(),
                        "amount" => round($value['Product']['price'] * $value['Product']['quantity'], 2, PHP_ROUND_HALF_DOWN),
                        "quantity" => $data[$i]['Product']['quantity'],
                        "file" => $value['Product']['file'] == "" ? $value['Product']['image'] : $value['Product']['file'],
                    );
                    $i++;
                }
            }

            $amount = 0;
            foreach ($orders as $order) {
                $amount += $order['amount'];
            }


            $this->set('stripe_key', $this->_stripe['publishable_key']);
            $this->set(array('data' => $orders, 'amount' => $amount));
        }
    }

    /*
     * @function: preview - generate preview image for designed case
     */

    public function preview() {
        if ($this->request->is('ajax')) {
            $this->layout = false;

            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");

            $product = $this->request->data('product');
            $data = array();
            if (empty($product)) {
                $this->set('data', $data);
                return;
            }

            $targetDir = $this->_targetDir = ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'uploads' . DS . 'preview';

            $cleanupTargetDir = true; // Remove old files
            $maxFileAge = 5 * 3600; // Temp file age in seconds
            @set_time_limit(0);

            $imageData = $_POST['image-data'];
            $extension = $_POST['image-extension'];

            $imageData = str_replace("data:image/" . $extension . ";base64,", "", $imageData);

            $filename = uniqid() . "." . $extension;
            $file = base64_encode($imageData);
            $out = @fopen($targetDir . DIRECTORY_SEPARATOR . $filename, "wb");

            if ($out) {
                fwrite($out, base64_decode($imageData));
                @fclose($out);
            } else {
                $this->_error['error'] = 1;
                $this->_error['message'] = 'open write handler faild';
                $this->set(array('data' => $data, 'image' => $this->_error));
            }

            $this->_error['error'] = 0;
            $this->_error['message'] = 'success';
            $this->_error['files'] = array(
                'original' => "",
                'target' => $filename,
                'url' => "uploads/preview/" . $filename,
                'extension' => $extension,
                    //'mime' => $mime
            );

            /*
              $size = getimagesize($targetDir . DIRECTORY_SEPARATOR . $filename);

              $current_width = $size[0];
              $current_height = $size[1];

              $left = 100;
              $top = 5;

              $crop_width = 248;
              $crop_height = 437;

              $canvas = imagecreatetruecolor($crop_width, $crop_height);
              $current_image = imagecreatefromjpeg($targetDir . DIRECTORY_SEPARATOR . $filename);
              imagecopy($canvas, $current_image, 0, 0, $left, $top, $current_width, $current_height);
              imagejpeg($canvas, $targetDir . DIRECTORY_SEPARATOR . $filename, 100);

              $path = $targetDir . DIRECTORY_SEPARATOR . $filename;
              $image = file_get_contents($targetDir . DIRECTORY_SEPARATOR . $filename);

              $image = substr_replace($image, pack("cnn", 1, 300, 300), 13, 5);

              file_put_contents($targetDir . DIRECTORY_SEPARATOR . $filename, $image);
             */

            $this->loadModel('Product');
            $data = $this->Product->find('first', array(
                'conditions' => array('guid' => $product, 'type' => 'template')
            ));

            if (empty($data)) {
                $this->_error['error'] = 1;
            }

            $this->set(array('data' => $data['Product'], 'error' => $this->_error));
            return;
        }
    }

    /*
     * @function: getTemplates - get all templates 
     */

    public function getTemplates() {

        if ($this->request->is('ajax')) {
            $this->layout = false;

            $this->loadModel('Product');
            $data = $this->Product->find("all", array(
                "conditions" => array(
                    "type" => "template"
                ),
                "order" => array(
                    "created DESC",
                    'id DESC'
            )));

            foreach ($data as $key => $value) {
                $value['Product']['image'] = unserialize($value['Product']['image']);
                $value['Product']['foreground'] = $value['Product']['image']['foreground'];
                $value['Product']['background'] = $value['Product']['image']['background'];
                $data[$key] = $value;
            }

            $this->set('data', $data);
            $this->render("gettemplates.ajax");
            return;
            //echo json_encode($data);
        }
    }

    protected function _json($data = array()) {
        return json_encode($data); //, JSON_UNESCAPED_SLASHES);
    }

}