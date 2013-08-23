<?php

App::uses('AppController', 'Controller');

class CreatorController extends AppController {

    public $uses = false;

    public function beforeFilter() {
        $this->Auth->allow();
        parent::beforeFilter();
    }

    public function index() {
        
        $guid = $this->request->query ('id');
        $load = 1;
        
        if (empty ($guid)) {
            $guid = uniqid();
            $load = 0;
        } 
        
        $this->set('canvas_load', $load);
        $this->set('canvas_guid', $guid);
    }

    public function save() {

        if ($this->request->is('ajax') && $this->request->is('post')) {
            $this->autoRender = false;

            if (empty($this->_meta['_identity'])) {
                $this->_error['error'] = 1;
                $this->_error['message'] = "Not logged in yet.";

                exit(json_encode($this->_error));
            }

            $guid = $this->request->query('id');

            if (empty($guid)) {
                $this->_error['error'] = 1;
                $this->_error['message'] = "Invalid canvas.";

                exit(json_encode($this->_error));
            }

            $data = $this->request->data;

            $json = $data['json'];
            $name = $data['name'];
            $product_guid = $data['product'];

            if (empty($json)) {
                $this->_error['error'] = 1;
                $this->_error['message'] = "Invalid json";

                exit(json_encode($this->_error));
            }

            $this->loadModel('Creation');
            $data = $this->Creation->find('first', array("conditions" => array("guid" => $guid)));

            if (!empty($data)) {
                $this->Creation->id = $data['Creation']['id'];
                $this->Creation->set(array("data" => $json, "type" => "progress", "modified" => time()));
                $this->Creation->save();

                $this->_error['error'] = 0;
                $this->_error['data'] = array('guid' => $data['Creation']['guid']);
                exit(json_encode($this->_error));
            }

            $this->Creation->create();

            $guid = uniqid();
            $creation = array(
                "guid" => $guid,
                "user_guid" => $this->_identity['guid'],
                "product_guid" => $product_guid,
                "name" => $name,
                "data" => $json,
                "type" => "progress",
                "created" => time(),
                "modified" => time()
            );

            $this->Creation->save($creation);
            $this->_error['error'] = 0;
            $this->_error['data'] = array('guid' => $guid);
            exit(json_encode($this->_error));
        }
    }

    public function reload() {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            
            if (empty($this->_meta['_identity'])) {
                $this->_error['error'] = 1;
                $this->_error['message'] = "Not logged in yet.";

                exit(json_encode($this->_error));
            }

            $guid = $this->request->data ('guid');
            
            if (empty ($guid)) {
                $this->_error['error'] = 1;
                $this->_error['message'] = "Invalid param.";

                exit(json_encode($this->_error));
            }

            $this->loadModel('Creation');
            $data = $this->Creation->find ('first', array ("conditions" => array ("user_guid" => $this->_identity['guid'], "guid" => $guid)));
            
            if (!empty($data)) {
                
                $this->_error['data']['json'] = $data['Creation']['data'];
                $this->_error['data']['product'] = $data['Creation']['product_guid'];
                $this->_error['data']['name'] = $data['Creation']['name'];
                $this->_error['error'] = 0;
                exit(json_encode($this->_error));
            }

            $this->_error['error'] = 1;
            $this->_error['message'] = "No saved data yet.";
            exit(json_encode($this->_error));
        }
    }

    public function preview() {
        if ($this->request->is('ajax')) {
            $this->layout = false;

            error_reporting(0);
            register_shutdown_function(
                    function () {

                        $last_error = error_get_last();

                        if (!is_null($last_error)) {
                            $this->_error['error'] = 1;
                            $this->_error['message'] = $last_error['message'];
                            exit(json_encode($this->_error));
                        }
                    });

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

            $this->set(array('data' => $data['Product'], 'error' => $this->_error));
            return;
        }
    }

    public function templates() {

        if ($this->request->is('ajax')) {
            $this->layout = false;

            $this->loadModel('Product');
            $data = $this->Product->find("all", array(
                "conditions" => array(
                    "type" => "template"
                ),
                "order" => array(
                    "order ASC",
            )));

            foreach ($data as $key => $value) {
                $value['Product']['image'] = unserialize($value['Product']['image']);
                $value['Product']['foreground'] = $value['Product']['image']['foreground'];
                $value['Product']['background'] = $value['Product']['image']['background'];
                $data[$key] = $value;
            }

            $this->set('data', $data);
            $this->render("templates.ajax");
            return;
            //echo json_encode($data);
        }
    }

    protected function _json($data = array()) {
        return json_encode($data); //, JSON_UNESCAPED_SLASHES);
    }

}