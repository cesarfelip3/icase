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

                            $jpeg = $order['Order']['attachement'];
                            $filename = pathinfo($jpeg, PATHINFO_FILENAME);
                        }

                        $png1 = APP . DS . "webroot" . DS . "img" . DS . "template" . DS . $png1;
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
        if (empty($data)) {
            $this->redirect(array("controller"=>"creation", "action"=>"index"));
        }

        $this->Media->query("DELETE FROM creations WHERE guid='{$data['Media']['guid']}'");

        $this->loadModel("MediaToObject");
        $this->MediaToObject->query("DELETE FROM media_to_object WHERE media_guid='{$data['Media']['guid']}'");

        $this->redirect(array("controller" => "creation", "action" => "index"));
    }

}
