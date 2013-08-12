<?php

App::uses('AppController', 'Controller');

class ShopController extends AppController {

    public $uses = false;
    protected $_error = array(
        "error" => 1,
        "message" => "",
        "files" => array(),
    );

    public function beforeFilter() {
        $this->Auth->allow();
        parent::beforeFilter();
        $this->set('load_shop_cart', true);
    }

    protected function beforeCheckout() {
        if ($this->request->is('ajax') && $this->request->is('post')) {

            $deliver = $this->request->data('deliver');

            foreach ($deliver as $value) {
                if (empty($value)) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "Deliver Info - All fields required";
                    exit(json_encode($this->_error));
                }
            }

            $signin = $this->request->data('signin');
            $signup = $this->request->data('signup');

            if (empty($signin['name'])) {
                
            }

            if (empty($signin['password'])) {
                $this->_error['error'] = 1;
                $this->_error['message'] = "";
                exit(json_encode($this->_error));
            }

            $passwordHasher = new SimplePasswordHasher();
            $password = $passwordHasher->hash($data['password']);
            
            $conditions = array ();
            if (preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/i", $data['name']) == true) {
                $conditions = array ("email" => $data['name'], "password" => $password);
            } else {
                $conditions = array ("name" => $data['name'], "password" => $password);
            }
            
            $this->loadModel("User");
            $user = $this->find('first', array("conditions" => $conditions));
            
            if (!empty ($user['User'])) {
                $this->Auth->login($user['User']);
            } else {
                $this->_error['error'] = 1;
                $this->_error['message'] = "Your Login Information isn't correct";
                exit(json_encode($this->_error));
            }

            exit(json_encode($this->_error));
        }
    }

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

        $this->beforeCheckout();

        if ($this->request->is('post')) {

            $deliver = $this->request->data('deliver');


            //$signup = $this->request->data('signin');

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
                        "product_guid" => $value['Product']['guid'],
                        "title" => $value['Product']['name'] . "-" . $value['Product']['type'],
                        "status" => "paid",
                        "created" => time(),
                        "modified" => time(),
                        "amount" => round($value['Product']['price'] * $value['Product']['quantity'], 2, PHP_ROUND_HALF_DOWN),
                        "quantity" => $data[$i]['Product']['quantity'],
                        "file" => $value['Product']['file'] == "" ? $value['Product']['image'] : $value['Product']['file'],
                    );
                    $i++;
                }
            }

            $this->loadModel('UserDeliverInfo');

            $this->UserDeliverInfo->create();
            $deliver_guid = uniqid();
            $deliver['guid'] = $deliver_guid;

            $this->UserDeliverInfo->save($deliver);

            $this->loadModel('Order');

            foreach ($orders as $key => $order) {
                $order['deliver_guid'] = $deliver_guid;
                $orders[$key] = $order;
            }

            if (isset($_SERVER['HTTP_COOKIE'])) {
                $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                foreach ($cookies as $cookie) {
                    $parts = explode('=', $cookie);
                    $name = trim($parts[0]);
                    setcookie($name, '', time() - 1000, '/');
                }
            }
            $this->Order->saveMany($orders);
            $this->set("paid", true);
        }
    }

    /*
     * @function cart - 2013.07.31 cart is as same as order now...
     */

    public function cart() {

        if ($this->request->is("ajax")) {
            $this->layout = false;
            //$orders = $this->request->data('orders');
            
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

            foreach ($guids as $key => $value) {
                $key = explode("-", $key);
                if (is_array($key)) {
                    $guid = $key[0];
                }

                $data[$i] = $this->Product->find('first', array ("conditions" => array ("guid" => $guid)));
                
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
            
            if ($i == 0 && empty ($data[$i])) {
                $data = array ();
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

            $size = getimagesize($targetDir . DIRECTORY_SEPARATOR . $filename);

            $current_width = $size[0];
            $current_height = $size[1];

            $left = 100;
            $top = 5;

            $crop_width = 248;
            $crop_height = 437;

// Resample the image
            $canvas = imagecreatetruecolor($crop_width, $crop_height);
            $current_image = imagecreatefromjpeg($targetDir . DIRECTORY_SEPARATOR . $filename);
            imagecopy($canvas, $current_image, 0, 0, $left, $top, $current_width, $current_height);
            imagejpeg($canvas, $targetDir . DIRECTORY_SEPARATOR . $filename, 100);

            $path = $targetDir . DIRECTORY_SEPARATOR . $filename;
            $image = file_get_contents($targetDir . DIRECTORY_SEPARATOR . $filename);

            $image = substr_replace($image, pack("cnn", 1, 300, 300), 13, 5);

            file_put_contents($targetDir . DIRECTORY_SEPARATOR . $filename, $image);

            $this->loadModel('Product');
            $data = $this->Product->find('first', array(
                'conditions' => array('guid' => $product, 'type' => 'template')
            ));

            if (empty($data)) {
                $this->_error['error'] = 1;
            }

            $this->set(array('data' => $data, 'error' => $this->_error));
            return;
        }
    }

    /*
     * @function: getTemplates - get all templates 
     */

    public function getTemplates() {

        if ($this->request->is('ajax')) {
            $this->autoRender = false;

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
                $value['Product']['image'] = $this->base . "/uploads/template/" . $value['Product']['image'];
                $data[$key] = $value;
            }



            echo json_encode($data);
        }
    }

    protected function _json($data = array()) {
        return json_encode($data); //, JSON_UNESCAPED_SLASHES);
    }

}