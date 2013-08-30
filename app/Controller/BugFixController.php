<?php

App::uses('AppController', 'Controller');

class BugFixController extends AppController {

    public $uses = false;

    public function beforeFilter() {
        $this->Auth->allow();
        parent::beforeFilter();
    }

    public function fix() {

        set_time_limit(0);

        $dir = APP . "webroot/uploads/product/";

        print_r("bugfix.category");

        $images = array();

        if (($handle = opendir($dir . ".")) != false) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $images[] = $entry;
                }
            }
            closedir($handle);
        }

        if (empty($images)) {
            print_r("no images");
            exit;
        }

        //print_r ($images);
        //exit;

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

        require_once APP . 'Vendor' . DS . "Zebra/Zebra_Image.php";
        $image = new Zebra_Image();

        print_r($images);

        foreach ($images as $img) {

            if (!preg_match("/^[0-9a-z]{1,}$/i", pathinfo($dir . $img, PATHINFO_FILENAME))) {
                continue;
            }

            print_r($img);

            $extension = pathinfo($dir . $img, PATHINFO_EXTENSION);
            $filename = pathinfo($dir . $img, PATHINFO_FILENAME);

            $image->source_path = $dir . $img;
            $image->jpeg_quality = 100;

            $image->preserve_aspect_ratio = true;
            $image->enlarge_smaller_images = true;
            $image->preserve_time = true;

            // resize the image to exactly 100x100 pixels by using the "crop from center" method
            // (read more in the overview section or in the documentation)
            //  and if there is an error, check what the error is about

            $size = getimagesize($dir . $img);

            //$_image_500 = "";
            $_image_150 = $filename . "_150.png";
            if (file_exists($dir . $_image_150)) {
                $_size = getimagesize($dir . $_image_150);
                if ($_size[0] == $_size[1]) {
                    continue;
                    ;
                }
            } else {

                $_image_150 = $filename . "_150." . $extension;
                if (file_exists($dir . $_image_150)) {
                    $_size = getimagesize($dir . $_image_150);
                    if ($_size[0] == $_size[1]) {
                        continue;
                        ;
                    }
                }
            }

            $image->target_path = $dir . $filename . "_500." . $extension;

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
                        imagepng($out, $dir . $filename . "_500.png");
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
                        imagepng($out, $dir . $filename . "_500.png");
                    }
                }
            }

            $image->target_path = $dir . $filename . "_150." . $extension;
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
                        imagepng($out, $dir . $filename . "_150.png");
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
                        imagepng($out, $dir . $filename . "_150.png");
                    }
                }
            }
        }

        exit;
    }

}