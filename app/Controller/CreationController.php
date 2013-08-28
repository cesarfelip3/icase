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
        
        $this->loadModel("Media");
        $medias = $this->Media->find('all', array(
            'joins' => array(
                array(
                    'table' => 'media_to_object',
                    'alias' => 'MediaToObject',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('MediaToObject.object_guid = Media.guid')
                ),
            ),
            'conditions' => array(
                "MediaToObject.object_guid" => $this->_identity['guid'],
            ),
            'order' => 'modified DESC',
            'limit' => 200,
            'page' => 1,
            'fields' => array("Media.*")
        ));

        $this->set('data2', $medias);
        $this->set('data', $creations);
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
