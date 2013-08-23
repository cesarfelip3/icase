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
        $data = $this->Creation->find('all', array("order" => "modified DESC", "conditions" => array("user_guid" => $this->_identity['guid'])));

        $guid = $this->_identity['guid'];

        $this->loadModel("Media");
        $data2 = $this->Media->find('all', array(
            'joins' => array(
                array(
                    'table' => 'media_to_object',
                    'alias' => 'MediaToObject',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array("MediaToObject.object_guid = '{$guid}'")
                ),
            ),
            'conditions' => array(
                "MediaToObject.type" => "user.design",
            ),
            'fields' => array("Media.*")
        ));

        $this->set('data2', $data2);
        $this->set('data', $data);
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
            $this->redirect(array ("controller" => "creation", "action" => "index"));
        }
        
        $this->loadModel('Creation');
        $this->Creation->query ("DELETE FROM creations WHERE guid='$guid'");

        $this->redirect(array ("controller" => "creation", "action" => "index"));
    }
    
    public function del()
    {
        $guid = $this->request->query('id');

        if (empty($guid)) {
            $this->redirect(array ("controller" => "creation", "action" => "index"));
        }
        
        $this->loadModel('Media');
        $data = $this->Media->find ('first', array ("conditions" => array ("guid" => $guid)));
        if (!empty ($data)) {
            if (file_exists(APP . DS . "webroot" . DS . "uploads" . DS . "user" . DS . $data['Media']['filename'])) {
                @unlink(APP . DS . "webroot" . DS . "uploads" . DS . "user" . DS . $data['Media']['filename']);
            }
            
            if (file_exists(APP . DS . "webroot" . DS . "uploads" . DS . "preview" . DS . $data['Media']['filename'])) {
                @unlink(APP . DS . "webroot" . DS . "uploads" . DS . "preview" . DS . $data['Media']['filename']);
            }
        }
        
        $this->Media->query ("DELETE FROM creations WHERE guid='$guid'");
        
        $this->loadModel("MediaToObject");
        $this->MediaToObject->query ("DELETE FROM media_to_object WHERE media_guid='$guid'");

        $this->redirect(array ("controller" => "creation", "action" => "index"));        
    }

}