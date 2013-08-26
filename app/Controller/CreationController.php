<?php

App::uses('AppController', 'Controller');

class CreationController extends AppController {

    public $uses = false;

    public function beforeFilter() {
        $this->Auth->deny();
        parent::beforeFilter();
    }

    public function index() {
        $this->loadModel('Creation');
        $creations = $this->Creation->find('all', array(
            "order" => "modified DESC",
            "conditions" => array(
                "user_guid" => $this->_identity['guid']
        )));

        $guid = $this->_identity['guid'];

        $this->loadModel("Order");

        if (false) {
            $orders = $this->Order->find('all', array(
                "order" => "created DESC",
                "conditions" => array(
                    "buyer_guid" => $this->_identity['guid'],
                    "type" => "template",
            )));

            if (!empty($orders)) {

                foreach ($orders as $order) {
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

                        $png1 = APP . DS . "webroot" . DS . "img" . DS . "template" . DS . $png1;
                        $png2 = APP . DS . "webroot" . DS . "img" . DS . "template" . DS . $png2;

                        $jpeg = APP . DS . "webroot" . DS . "uploads" . DS . "preview" . DS . $jpeg;

                        try {
                            $this->overlayImage($png1, $jpeg, $filename . "_user.jpeg");
                            //$this->overlayImage($png2, $jpeg, $filename . "_admin.jpeg");
                        } catch (Exception $e) {
                            $this->Session->setFlash($e->getMessage());
                        }
                    }
                }
            }
        }
        //$this->set('data2', $orders);
        $this->set('data', $creations);
    }

    protected function overlayImage($overlay, $jpeg, $final) {

        $final = APP . DS . "webroot" . DS . "uploads" . DS . "preview" . DS . $final;
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

    public function view() {
        $guid = $this->request->query('id');

        if (empty($guid)) {
            $this->_error['error'] = 1;
            $this->_error['message'] = "";
            exit(json_encode($this->_error));
        }

        $this->loadModel("Order");
        $data = $this->Order->find("first", array("conditions" => array("guid" => $guid)));

        if (!empty($data)) {
            $this->loadModel("UserBillInfo");
            $bill = $this->UserBillInfo->find("first", array("conditions" => array("guid" => $data['bill_guid'])));

            $this->loadModel("UserDeliverInfo");
            $deliver = $this->UserDeliverInfo->find("first", array("conditions" => array("guid" => $data['deliver_guid'])));

            $this->set(array('bill' => $bill, 'deliver' => $deliver));
        }

        $this->set('data', $data);
    }

    public function delete() {
        $guid = $this->request->query('id');

        if (empty($guid)) {
            $this->redirect(array("controller" => "creation", "action" => "index"));
        }

        $this->loadModel('Creation');
        $this->Creation->query("DELETE FROM creations WHERE guid='$guid'");

        $this->redirect(array("controller" => "creation", "action" => "index"));
    }

    public function del() {
        $guid = $this->request->query('id');

        if (empty($guid)) {
            $this->redirect(array("controller" => "creation", "action" => "index"));
        }

        $this->loadModel('Media');
        $data = $this->Media->find('first', array("conditions" => array("guid" => $guid)));
        if (!empty($data)) {
            if (file_exists(APP . DS . "webroot" . DS . "uploads" . DS . "user" . DS . $data['Media']['filename'])) {
                @unlink(APP . DS . "webroot" . DS . "uploads" . DS . "user" . DS . $data['Media']['filename']);
            }

            if (file_exists(APP . DS . "webroot" . DS . "uploads" . DS . "preview" . DS . $data['Media']['filename'])) {
                @unlink(APP . DS . "webroot" . DS . "uploads" . DS . "preview" . DS . $data['Media']['filename']);
            }
        }

        $this->Media->query("DELETE FROM creations WHERE guid='{$data['Media']['guid']}'");

        $this->loadModel("MediaToObject");
        $this->MediaToObject->query("DELETE FROM media_to_object WHERE media_guid='{$data['Media']['guid']}'");

        $this->redirect(array("controller" => "creation", "action" => "index"));
    }

}