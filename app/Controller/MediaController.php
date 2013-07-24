<?php

class MediaController extends AppController {

    protected $_targetDir = null;
    protected $_error = array(
        "error" => 0,
        "message" => "",
        "files" => array(),
    );
    
    public function beforeFilter() {
        $this->Auth->allow ();
	parent::beforeFilter();
    }

    public function upload() {
        
        error_reporting(-1);
	ini_set('display_errors', 'On');
        
        $this->autoRender = false;
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        $targetDir = $this->_targetDir = ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'uploads';

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
            'url' => $this->base . "/uploads/" . $name,
            'extension' => $extension,
            //'mime' => $mime
        );

        die($this->_json($this->_error));
    }
    
    public function preview ()
    {
        error_reporting(-1);
	ini_set('display_errors', 'On');
        
        $this->autoRender = false;
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        $targetDir = $this->_targetDir = ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'uploads';

        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds
        @set_time_limit(0);
        
        $imageData = $_POST['image-data'];
        $extension = $_POST['image-extension'];
        
        $imageData = str_replace ("data:image/" . $extension . ";base64,", "", $imageData);
        
        $filename = uniqid () . "." . $extension;
        $file = base64_encode ($imageData);
        $out = @fopen( $targetDir . DIRECTORY_SEPARATOR . $filename, "wb" );
        
        if ($out) {
            fwrite ($out, base64_decode($imageData));
            @fclose ($out);
        } else {
            $this->_error['error'] = 1;
            $this->_error['message'] = 'open write handler faild';
            die ($this->_json ($this->_error));
        }
        
        $this->_error['error'] = 0;
        $this->_error['message'] = 'success';
        $this->_error['files'] = array(
            'original' => "",
            'target' => $filename,
            'url' => "uploads/" . $filename,
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
        
        file_put_contents ($targetDir . DIRECTORY_SEPARATOR . $filename, $image);
        
        die ($this->_json($this->_error));
    }

    protected function _json($data = array()) {
        return json_encode($data); //, JSON_UNESCAPED_SLASHES);
    }

}