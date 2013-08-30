<?php

class MediaController extends AdminAppController {

    protected $_targetDir = null;
    protected $_error = array(
        "error" => 0,
        "message" => "",
        "files" => array(),
    );

    public function beforeFilter() {
        $this->Auth->deny();
        parent::beforeFilter();
    }

    public function crop() {

        if ($this->request->is('ajax')) {
            if ($this->request->is('post')) {

                $data = $this->request->data('json');

                if (empty($data)) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = "No data";
                    exit(json_encode($this->_error));
                }

                $data = json_decode($data);
                $param = $data->json;
                $file = $data->file;


                $filename = pathinfo($file, PATHINFO_FILENAME);
                $extension = pathinfo($file, PATHINFO_EXTENSION);

                $targetDir = APP . "webroot/uploads/";

                $action = $this->request->query('action');
                if ($action == 'product_edit') {
                    $targetDir .= "product/";
                }

                require_once APP . 'Vendor' . DS . "Zebra/Zebra_Image.php";
                $image = new Zebra_Image();

                $image->source_path = $targetDir . $filename . "." . $extension;
                $image->target_path = $targetDir . $filename . "_crop." . $extension;

                $image->jpeg_quality = 100;

                $image->preserve_aspect_ratio = true;
                $image->enlarge_smaller_images = true;
                $image->preserve_time = true;

                ;

                // resize the image to exactly 100x100 pixels by using the "crop from center" method
                // (read more in the overview section or in the documentation)
                //  and if there is an error, check what the error is about
                $message = "";

                if (!$image->crop($param->x, $param->y, $param->x + $param->w, $param->y + $param->w)) {

                    // if there was an error, let's see what the error is about
                    switch ($image->error) {

                        case 1:
                            $message = 'Source file could not be found!';
                            break;
                        case 2:
                            $message = 'Source file is not readable!';
                            break;
                        case 3:
                            $message = 'Could not write target file!';
                            break;
                        case 4:
                            $message = 'Unsupported source file format!';
                            break;
                        case 5:
                            $message = 'Unsupported target file format!';
                            break;
                        case 6:
                            $message = 'GD library version does not support target file format!';
                            break;
                        case 7:
                            $message = 'GD library is not installed!';
                            break;
                        case 8:
                            $message = '"chmod" command is disabled via configuration!';
                            break;
                    }

                    // if no errors
                } else {
                    $image->source_path = $targetDir . $filename . "_crop." . $extension;
                    $image->target_path = $targetDir . $filename . "_150." . $extension;
                    if (!$image->resize(150, 0, ZEBRA_IMAGE_CROP_CENTER)) {

                        // if there was an error, let's see what the error is about
                        switch ($image->error) {

                            case 1:
                                $message = 'Source file could not be found!';
                                break;
                            case 2:
                                $message = 'Source file is not readable!';
                                break;
                            case 3:
                                $message = 'Could not write target file!';
                                break;
                            case 4:
                                $message = 'Unsupported source file format!';
                                break;
                            case 5:
                                $message = 'Unsupported target file format!';
                                break;
                            case 6:
                                $message = 'GD library version does not support target file format!';
                                break;
                            case 7:
                                $message = 'GD library is not installed!';
                                break;
                            case 8:
                                $message = '"chmod" command is disabled via configuration!';
                                break;
                        }
                    }


                    $image->target_path = $targetDir . $filename . "_500." . $extension;
                    if (!$image->resize(500, 0, ZEBRA_IMAGE_CROP_CENTER)) {

                        // if there was an error, let's see what the error is about
                        switch ($image->error) {

                            case 1:
                                $message = 'Source file could not be found!';
                                break;
                            case 2:
                                $message = 'Source file is not readable!';
                                break;
                            case 3:
                                $message = 'Could not write target file!';
                                break;
                            case 4:
                                $message = 'Unsupported source file format!';
                                break;
                            case 5:
                                $message = 'Unsupported target file format!';
                                break;
                            case 6:
                                $message = 'GD library version does not support target file format!';
                                break;
                            case 7:
                                $message = 'GD library is not installed!';
                                break;
                            case 8:
                                $message = '"chmod" command is disabled via configuration!';
                                break;
                        }
                    }
                    // if no errors
                }

                if (!empty($message)) {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = $message;
                }

                exit(json_encode($this->_error));
            }
        }
    }

    public function uploadimage() {

        $action = $this->request->query("action");
        if (!empty($action)) {
            if ($action == 'product') {
                $action = "";
            } else {
                $action = DS . $action;
            }
        }

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


        $targetDir = $this->_targetDir = ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'uploads' . $action;

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
                exit($this->_json($this->_error));
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
                        exit($this->_json($this->_error));
                    }

                    @fclose($in);
                    @fclose($out);
                    @unlink($_FILES['file']['tmp_name']);
                } else {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = 'Failed to open output stream.';
                    exit($this->_json($this->_error));
                }
            } else {
                $this->_error['error'] = 1;
                $this->_error['message'] = 'Failed to move uploaded file.';
                exit($this->_json($this->_error));
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
                    exit($this->_json($this->_error));
                }

                @fclose($in);
                @fclose($out);
            } else {
                $this->_error['error'] = 1;
                $this->_error['message'] = 'Failed to open output stream.';
                exit($this->_json($this->_error));
            }
        }

        $filename = pathinfo($fileName, PATHINFO_FILENAME);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        $original = $filename . "." . $extension;

        $filename = uniqid();
        $name = $filename . "." . $extension;

        $target = $targetDir . DIRECTORY_SEPARATOR . $name;

        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off 
            rename("{$filePath}.part", $target);
        }

        $url150 = $this->base . "/uploads/$action/" . $filename . "_150." . $extension;

        $this->_error['error'] = 0;
        $this->_error['message'] = 'Success';
        $this->_error['files'] = array(
            'original' => $original,
            'target' => $name,
            'filename' => $filename,
            'url' => $this->base . "/uploads/$action/" . $name,
            'url150' => "",
            'extension' => $extension,
            "width" => 150,
            "height" => 150,
        );

        $image_size = getimagesize($target);
        $this->_error['files']['width'] = $image_size[0];
        $this->_error['files']['width'] = $image_size[1];


        $resize_500 = false;
        if ($image_size[0] > 500) {
            $resize_500 = true;
        }

        $resize_500 = true;

        require_once APP . 'Vendor' . DS . "Zebra/Zebra_Image.php";
        $image = new Zebra_Image();

        $image->source_path = $target;
        $image->target_path = $targetDir . DIRECTORY_SEPARATOR . $filename . "_150." . $extension;

        $image->jpeg_quality = 100;

        $image->preserve_aspect_ratio = true;
        $image->enlarge_smaller_images = true;
        $image->preserve_time = true;

        // resize the image to exactly 100x100 pixels by using the "crop from center" method
        // (read more in the overview section or in the documentation)
        //  and if there is an error, check what the error is about

        $size = getimagesize($target);

        $image->target_path = $targetDir . DIRECTORY_SEPARATOR . $filename . "_500." . $extension;

        if ($image->resize(500, 0, ZEBRA_IMAGE_CROP_CENTER)) {

            $size = getimagesize($image->target_path);
            $width = $size[0];
            $height = $size[1];

            if ($width == $height) {
                
            } else {

                $height2 = 500 - $height;

                if ($height2 > 0) {
                    $ext = $extension;

                    if (strtolower($ext) == 'jpg' || strtolower($ext) == 'jpeg') {
                        $source = imagecreatefromjpeg($image->target_path);
                    }

                    if (strtolower($ext) == 'png') {
                        $source = imagecreatefrompng($image->target_path);
                        //continue;
                    }

                    $out = imagecreatetruecolor(500, 500);
                    $black = imagecolorallocate($out, 0, 0, 0);
                    imagecolortransparent($out, $black);

                    imagecopyresampled($out, $source, 0, ceil($height2 / 2), 0, 0, $width, $height, $width, $height);
                    imagepng($out, $targetDir . DIRECTORY_SEPARATOR . $filename . "_500.png");
                    imagecolortransparent($out, $black);
                    
                }
                
                if ($height2 < 0) {
                    $ext = $extension;

                    if (strtolower($ext) == 'jpg' || strtolower($ext) == 'jpeg') {
                        $source = imagecreatefromjpeg($image->target_path);
                    }

                    if (strtolower($ext) == 'png') {
                        $source = imagecreatefrompng($image->target_path);
                        //continue;
                    }

                    $out = imagecreatetruecolor($height, $height);
                    $black = imagecolorallocate($out, 0, 0, 0);
                    imagecolortransparent($out, $black);

                    imagecopyresampled($out, $source, ceil(abs($height2) / 2), 0, 0, 0, $width, $height, $width, $height);
                    imagepng($out, $targetDir . DIRECTORY_SEPARATOR . $filename . "_500.png");              
                }
            }
        }
        
        $image->target_path = $targetDir . DIRECTORY_SEPARATOR . $filename . "_150." . $extension;
        if ($image->resize(200, 0, ZEBRA_IMAGE_CROP_CENTER)) {

            $size = getimagesize($image->target_path);
            $width = $size[0];
            $height = $size[1];

            if ($width == $height) {
                
            } else {

                $height2 = 200 - $height;

                if ($height2 > 0) {
                    $ext = $extension;

                    if (strtolower($ext) == 'jpg' || strtolower($ext) == 'jpeg') {
                        $source = imagecreatefromjpeg($image->target_path);
                    }

                    if (strtolower($ext) == 'png') {
                        $source = imagecreatefrompng($image->target_path);
                        //continue;
                    }

                    $out = imagecreatetruecolor(200, 200);
                    $black = imagecolorallocate($out, 0, 0, 0);
                    imagecolortransparent($out, $black);

                    imagecopyresampled($out, $source, 0, ceil($height2 / 2), 0, 0, $width, $height, $width, $height);
                    imagepng($out, $targetDir . DIRECTORY_SEPARATOR . $filename . "_150.png");
                    
                    
                }
                
                if ($height2 < 0) {
                    $ext = $extension;

                    if (strtolower($ext) == 'jpg' || strtolower($ext) == 'jpeg') {
                        $source = imagecreatefromjpeg($image->target_path);
                    }

                    if (strtolower($ext) == 'png') {
                        $source = imagecreatefrompng($image->target_path);
                        //continue;
                    }

                    $out = imagecreatetruecolor($height, $height);
                    $black = imagecolorallocate($out, 0, 0, 0);
                    imagecolortransparent($out, $black);

                    imagecopyresampled($out, $source, ceil(abs($height2) / 2), 0, 0, 0, $width, $height, $width, $height);
                    imagepng($out, $targetDir . DIRECTORY_SEPARATOR . $filename . "_150.png");              
                }
            }
        }

        $this->_error['files']['url150'] = $url150;
        exit($this->_json($this->_error));
    }

    //=======================================================
    // upload for template uploaded
    //=======================================================
    public function uploadimage2() {

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
        $guid = $this->request->query('id');
        $type = $this->request->query('type');
        if (empty($guid)) {
            $this->_error['error'] = 1;
            $this->_error['message'] = "invalid id";
            exit(json_encode($this->_error));
        }

        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        $targetDir = $this->_targetDir = ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'img/template';

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
                exit($this->_json($this->_error));
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
                        exit($this->_json($this->_error));
                    }

                    @fclose($in);
                    @fclose($out);
                    @unlink($_FILES['file']['tmp_name']);
                } else {
                    $this->_error['error'] = 1;
                    $this->_error['message'] = 'Failed to open output stream.';
                    exit($this->_json($this->_error));
                }
            } else {
                $this->_error['error'] = 1;
                $this->_error['message'] = 'Failed to move uploaded file.';
                exit($this->_json($this->_error));
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
                    exit($this->_json($this->_error));
                }

                @fclose($in);
                @fclose($out);
            } else {
                $this->_error['error'] = 1;
                $this->_error['message'] = 'Failed to open output stream.';
                exit($this->_json($this->_error));
            }
        }

        $filename = pathinfo($fileName, PATHINFO_FILENAME);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        $original = $filename . "." . $extension;

        $name = "{$guid}_{$type}." . $extension;

        $target = $targetDir . DIRECTORY_SEPARATOR . $name;

        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off 
            rename("{$filePath}.part", $target);
        }

        $this->_error['error'] = 0;
        $this->_error['message'] = 'Success';
        $this->_error['files'] = array(
            'original' => $original,
            'target' => $name,
            'filename' => $filename,
            'url' => $this->webroot . "img/template/" . $name,
            'url150' => "",
            'extension' => $extension,
        );

        exit($this->_json($this->_error));
    }

    protected function _json($data = array()) {
        return json_encode($data); //, JSON_UNESCAPED_SLASHES);
    }

}