<?php

App::uses('AppController', 'Controller');

class OrderController extends AppController {

    public $uses = false;

    public function beforeFilter() {
        $this->Auth->deny();
        parent::beforeFilter();
    }

    public function index() {
        $guid = $this->_identity['guid'];

        if ($this->request->is('ajax')) {
            $this->layout = false;

            $this->loadModel("Order");
            $data = $this->Order->find('all', array("order" => "modified DESC", "conditions" => array("buyer_guid" => $this->_identity['guid'])));

            $this->set('data', $data);
            $this->render('order_list.ajax');
        }
    }

    public function view() {
        $guid = $this->request->query('id');

        if (empty($guid)) {
            $this->_error['error'] = 1;
            $this->_error['message'] = "Wrong order ID";
            exit(json_encode($this->_error));
        }

        $this->loadModel("Order");
        $order = $this->Order->find("first", array("conditions" => array("guid" => $guid)));

        if (empty($order)) {
            $this->_error['error'] = 1;
            $this->_error['message'] = "Order doesn't exist";
            exit(json_encode($this->_error));
        }
        
        if (!empty($order)) {
            $order = $order['Order'];
            $this->loadModel("UserBillInfo");
            $bill = $this->UserBillInfo->find("first", array("conditions" => array("guid" => $order['bill_guid'])));

            $this->loadModel("UserDeliverInfo");
            $deliver = $this->UserDeliverInfo->find("first", array("conditions" => array("guid" => $order['deliver_guid'])));

            $this->set(array('bill' => $bill, 'deliver' => $deliver));

            if ($order['type'] == 'template') {
                $this->loadModel("Product");
                $data = $this->Product->find('first', array("conditions" => array("guid" => $order['product_guid'])));

                if (!empty($data)) {
                    $png1 = unserialize($data['Product']['image']);
                    $png1 = $png1['foreground'];

                    $jpeg = $order['attachement'];
                    $filename = pathinfo($jpeg, PATHINFO_FILENAME);
                }

                $png1 = APP . "webroot" . DS . "img" . DS . "template" . DS . $png1;
                $jpeg = APP . "webroot" . DS . "uploads" . DS . "preview" . DS . $jpeg;

                try {
                    $this->_overlayImage($png1, $jpeg, $filename . "_user.jpeg");
                    //$this->overlayImage($png2, $jpeg, $filename . "_admin.jpeg");
                } catch (Exception $e) {
                    $this->Session->setFlash($e->getMessage());
                }
            }
        }

        $this->layout = false;
        $this->set('order', $order);
        $this->set('bill', $bill['UserBillInfo']);
        $this->set('deliver', $deliver['UserDeliverInfo']);
        $this->render('view.ajax');
    }
    
    protected function _overlayImage($overlay, $jpeg, $final) {
        
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

        //$image = file_get_contents($final);
        //$image = substr_replace($image, pack("cnn", 1, 300, 300), 13, 5);

        //file_put_contents($final, $image);
    }

}
