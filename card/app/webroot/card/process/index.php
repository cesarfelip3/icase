<?php

class MakerController {

    public $uses = false;
    public $_error = array(
        "error" => 0,
        "message" => "",
        "data" => array()
    );

    public function beforeFilter() {
        $this->Auth->allow();
        parent::beforeFilter();
    }

    public function index() {

        $guid = $this->request->query('id');
        $load = 1;

        if (empty($guid)) {
            $guid = uniqid();
            $load = 0;
        }

        $this->set('canvas_load', $load);
        $this->set('canvas_guid', $guid);
    }

    public function save() {

        $filename = dirname(__FILE__) . "/canvas.json";
        file_put_contents($filename, $_POST['json']);

        $this->_error['error'] = 0;
        exit(json_encode($this->_error));

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

        $filename = dirname(__FILE__) . "/canvas.json";
        $json = file_get_contents($filename, $data['json']);
        $this->_error['data']['json'] = $json;

        exit(json_encode($this->_error));

        if ($this->request->is('ajax')) {
            $this->autoRender = false;

            if (empty($this->_meta['_identity'])) {
                $this->_error['error'] = 1;
                $this->_error['message'] = "Not logged in yet.";

                exit(json_encode($this->_error));
            }

            $guid = $this->request->data('guid');

            if (empty($guid)) {
                $this->_error['error'] = 1;
                $this->_error['message'] = "Invalid param.";

                exit(json_encode($this->_error));
            }

            $this->loadModel('Creation');
            $data = $this->Creation->find('first', array("conditions" => array("user_guid" => $this->_identity['guid'], "guid" => $guid)));

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

        if (!defined('WEB_ROOT')) {
            define('WEB_ROOT', realpath(dirname(__FILE__) . "/../../") . "/");
        }
        $targetDir = $this->_targetDir = WEB_ROOT . 'uploads';

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
            'url' => "../uploads/" . $filename,
            'extension' => $extension,
                //'mime' => $mime
        );

        $path = $targetDir . DIRECTORY_SEPARATOR . $filename;
        $image = file_get_contents($targetDir . DIRECTORY_SEPARATOR . $filename);

        $image = substr_replace($image, pack("cnn", 1, 300, 300), 13, 5);

        file_put_contents($targetDir . DIRECTORY_SEPARATOR . $filename, $image);

        /*
          $this->loadModel('Product');
          $data = $this->Product->find('first', array(
          'conditions' => array('guid' => $product, 'type' => 'template')
          ));

          if (empty($data)) {
          $this->_error['error'] = 1;
          } */

        exit(json_encode($this->_error));
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

    // based on pluploader library

    public function upload() {

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

        $this->autoRender = false;
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        if (!defined('WEB_ROOT')) {
            define('WEB_ROOT', realpath(dirname(__FILE__) . "/../../") . "/");
        }
        $targetDir = $this->_targetDir = WEB_ROOT . 'uploads';

        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds
        @set_time_limit(0);

        /*
          chunk_size
          Enables you to chunk the file into smaller pieces for example if your PHP backend has a max post size of 1MB you can chunk a 10MB file into 10 requests. To disable chunking, remove this config option from your setup.
         * 
         * It's a smart idea, commonly PHP will have this limitation/upload
         * As I know, 128MB is maximium value of some web share host
         * 
         * chunk : the index of part of the file
         * chunks : total parts of the file
         */
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
        $fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

        $fileName = preg_replace('/[^\w\._]+/', '_', $fileName);

        if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
            $ext = strrpos($fileName, '.');
            $fileName_a = substr($fileName, 0, $ext);
            $fileName_b = substr($fileName, $ext);

            $count = 1;
            while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
                $count++;

            $fileName = $fileName_a . '_' . $count . $fileName_b;
        }

        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

        if (!file_exists($targetDir))
            @mkdir($targetDir);

        if ($cleanupTargetDir) {
            if (is_dir($targetDir) && ($dir = opendir($targetDir))) {
                while (($file = readdir($dir)) !== false) {
                    $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                    // Remove temp file if it is older than the max age and is not the current file
                    if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part")) {
                        @unlink($tmpfilePath);
                    }
                }
                closedir($dir);
            } else {
                $this->_error['error'] = 1;
                $this->_error['message'] = 'Failed to open temp directory.';
                die($this->_json($this->_error));
            }
        }

        if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
            $contentType = $_SERVER["HTTP_CONTENT_TYPE"];

        if (isset($_SERVER["CONTENT_TYPE"]))
            $contentType = $_SERVER["CONTENT_TYPE"];

        if (strpos($contentType, "multipart") !== false) {
            if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
                // Open temp file
                $out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
                if ($out) {
                    // Read binary input stream and append it to temp file
                    $in = @fopen($_FILES['file']['tmp_name'], "rb");

                    if ($in) {
                        while ($buff = fread($in, 4096))
                            fwrite($out, $buff);
                    } else {
                        $this->_error['error'] = 1;
                        $this->_error['message'] = 'Failed to open input stream.';
                        die($this->_json($this->_error));
                    }

                    @fclose($in);
                    @fclose($out);
                    @unlink($_FILES['file']['tmp_name']);
                } else {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = 'Failed to open output stream.';
                    die($this->_json($this->_error));
                }
            } else {
                $this->_error['error'] = 1;
                $this->_error['message'] = 'Failed to move uploaded file.';
                die($this->_json($this->_error));
            }
        } else {
            // Open temp file
            $out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
            if ($out) {
                // Read binary input stream and append it to temp file
                $in = @fopen("php://input", "rb");

                if ($in) {
                    while ($buff = fread($in, 4096))
                        fwrite($out, $buff);
                } else {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = 'Failed to open input stream.';
                    die($this->_json($this->_error));
                }

                @fclose($in);
                @fclose($out);
            } else {
                $this->_error['error'] = 1;
                $this->_error['message'] = 'Failed to open output stream.';
                die($this->_json($this->_error));
            }
        }

        $name = pathinfo($fileName, PATHINFO_FILENAME);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        $original = $name . "." . $extension;
        $name .= "_" . time() . "." . $extension;

        $target = $targetDir . DIRECTORY_SEPARATOR . $name;

        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off 
            rename("{$filePath}.part", $target);
        }

        //$finfo = finfo_open(FILEINFO_MIME_TYPE);
        // $mime = finfo_file($finfo, $target);
        //finfo_close($finfo);

        $this->_error['error'] = 0;
        $this->_error['message'] = 'Success';
        $this->_error['files'] = array(
            'original' => $original,
            'target' => $name,
            'url' => "../uploads/" . $name,
            'extension' => $extension,
                //'mime' => $mime
        );

        die($this->_json($this->_error));
    }

    protected function _json($data = array()) {
        return json_encode($data); //, JSON_UNESCAPED_SLASHES);
    }

}

$action = null;
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if ($action == 'upload') {
    $controller = new MakerController ();
    $controller->upload();
}

if ($action == "save") {
    $controller = new MakerController ();
    $controller->save();
}

if ($action == "reload") {
    $controller = new MakerController ();
    $controller->reload();
}

if ($action == "preview") {
    $controller = new MakerController ();
    $controller->preview();
}
