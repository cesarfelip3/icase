<?php

App::uses('AppController', 'Controller');

class CustomToolController extends AdminAppController {

    public $uses = false;

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function reload() {
        $action = $this->request->query('action');
        $id = $this->request->query('id');

        if ($this->request->is('ajax') ) {
            if (empty($id)) {
                $this->_error['error'] = 1;
                $this->_error['message'] = "Invalid ID";
                exit(json_encode($this->_error));
            }

            $this->loadModel ('Template');
            $template = $this->Template->find('first', array(
                "conditions" => array("guid" => $id)
            ));

            if (empty($template)) {
                $this->_error['error'] = 1;
                exit(json_encode($this->_error));
            }

            $template = $template['Template'];

            $this->layout = false;
            $json = unserialize($template['content_json']);
            exit (json_encode($json));
        }


        $this->layout = false;
        $this->_error['error'] = 1;
        exit(json_encode($this->_error));
    }

    public function create() {

        $action = $this->request->query('action');
        $id = $this->request->query('id');

        if ($this->request->is('ajax') && $this->request->is('post')) {
            $this->layout = false;

            if (empty($id)) {
                $this->_error['error'] = 1;
                $this->_error['message'] = "Invalid ID";
                exit(json_encode($this->_error));
            }

            $svg = $_POST['svg'];
            $json = $_POST['json'];
            $images = $_POST['image'];


            $this->loadModel('Template');

            $template = $this->Template->find('first', array(
                "conditions" => array("guid" => $id)
            ));

            if (empty($template)) {
                $this->_error['error'] = 1;
                exit(json_encode($this->_error));
            }

            $template = $template['Template'];

            $data = array();
            $data['content_json'] = serialize($json);
            $data['content_svg'] = $svg;

            $images = $this->_toImage($images, "jpeg");

            foreach ($images as $image) {
                $image = WWW_ROOT . $this->_media_location['template'] . $image;
                $ret = $this->_resizeImage($image, $template['width'], $template['height']);
            }

            if (!$ret) {
                exit(json_encode($this->_error));
            }

            $thumbnails = array();
            $featured = array();

            foreach ($images as $image) {
                $thumbnails[] = str_replace(".jpeg", "_small.png", $image);
                $featured[] = str_replace(".jpeg", "_medium.png", $image);
            }

            $data['featured'] = serialize($featured);
            $data['thumbnails'] = serialize($thumbnails);
            

            $this->Template->clear();
            $this->Template->id = $template['id'];
            $this->Template->save($data);
            $this->_error['error'] = 0;

            exit(json_encode($this->_error));
        }

        if (empty($id)) {
            $this->redirect (array ("plugin"=>"admin", controller=>"custom", action=>"index"));
        }

        $this->loadModel('Product');

        $product = $this->Product->find('first', array(
            "conditions" => array("guid" => $id)
        ));

        if (empty($product)) {
            
        }

        $this->set('product', $product['Product']);
        $this->set('action', $action);
    }

    public function _toImage($images, $extension) {
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

//            $image = new Imagick();
//            $image->readImageBlob($imageData);
//            $image->setImageFormat("png32");
//            $image->resizeImage($width, $height, imagick::FILTER_LANCZOS, 1);
//            $image->writeImage(WWW_ROOT . $this->_media_location['main'] . "svg.png");
//            
//            return;

            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");

            $targetDir = WWW_ROOT . $this->_media_location['template'];

            $cleanupTargetDir = true; // Remove old files
            $maxFileAge = 5 * 3600; // Temp file age in seconds
            @set_time_limit(0);

            $basename = uniqid();
            $result = array();

            foreach ($images as $key => $imageData) {

                $imageData = str_replace("data:image/" . $extension . ";base64,", "", $imageData);

                $filename = $basename . "_" . $key . "." . $extension;
                $file = base64_encode($imageData);
                $out = @fopen($targetDir . DIRECTORY_SEPARATOR . $filename, "wb");

                if ($out) {
                    fwrite($out, base64_decode($imageData));
                    @fclose($out);
                } else {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = 'open write handler faild';
                    exit(json_encode($this->_error));
                }

                $result[$key] = $filename;
            }

            return $result;
        }
    }

    protected function _resizeImage($target, $width, $height) {

        require_once APP . 'Vendor' . DIRECTORY_SEPARATOR . "Zebra/Zebra_Image.php";
        $image = new Zebra_Image();

        $image->source_path = $target;

        $image->jpeg_quality = 100;

        $image->preserve_aspect_ratio = true;
        $image->enlarge_smaller_images = true;
        $image->preserve_time = true;

        $filename = pathinfo($target, PATHINFO_FILENAME);
        $image->target_path = WWW_ROOT . $this->_media_location['template'] . $filename . "_medium.png";

        if (!$image->resize($width * 2, $height * 2, ZEBRA_IMAGE_BOXED, -1)) {
            $this->_error['error'] = 1;
            $this->_error['message'] = "Resize to $width x2 wrong";
            return false;
        }

        $image->target_path = WWW_ROOT . $this->_media_location['template'] . $filename . "_small.png";

        $width = $width;
        $height = $height;

        if (!$image->resize($width, $height, ZEBRA_IMAGE_BOXED, -1)) {
            $this->_error['error'] = 1;
            $this->_error['message'] = "Resize to $width wrong";
            return false;
        }

        return true;
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

        $targetDir = $this->_targetDir = WWW_ROOT . 'uploads';

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
        $this->_error['message'] = '';

        $this->_error['files'] = array(
            'original' => $original,
            'target' => $name,
            'url' => $this->base . "/uploads/" . $name,
            'extension' => $extension,
                //'mime' => $mime
        );

        die($this->_json($this->_error));
    }

    protected function _json($data = array()) {
        return json_encode($data); //, JSON_UNESCAPED_SLASHES);
    }

}
