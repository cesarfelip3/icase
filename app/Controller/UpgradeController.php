<?php

App::uses('AppController', 'Controller');

class UpgradeController extends AppController {

    public $uses = false;
    public $upgrade = false;
    public $version = 0.1;

    public function beforeFilter() {
        $this->Auth->allow();
        parent::beforeFilter();

        if ($this->upgrade == false) {
            exit;
        }
    }

    public function to02() {
        set_time_limit(0);

        print_r("Upgrading from 0.1 to 0.2......<br/>");
        print_r("Stage 1 : upgrading images of products on server......<br/>");

        $images = array();

        print_r(WWW_ROOT . $this->_media_location['product'] . "<br/>");

        if (($handle = opendir(WWW_ROOT . $this->_media_location['product'] . ".")) != false) {
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

        $changes = 0;

        foreach ($images as $image) {

            $filename = pathinfo($image, PATHINFO_FILENAME);
            $media_location_product = WWW_ROOT . $this->_media_location['product'];
            $image = $media_location_product . $image;

            $image_150 = $media_location_product . $filename . "_150.png";
            $image_500 = $media_location_product . $filename . "_500.png";

            $image_small = $media_location_product . $filename . "_small.png";
            $image_medium = $media_location_product . $filename . "_medium.png";

            if (file_exists($image) && is_file($image) && preg_match("/^[0-9a-zA-Z]/i", $filename)) {

                if (file_exists($image_150) && !rename($image_150, $image_small)) {
                    print_r("Rename $image_150 wrong.<br/>");
                }

                if (file_exists($image_500) && !rename($image_500, $image_medium)) {
                    print_r("Rename $image_500 wrong.<br/>");
                }
            }
        }

        print_r("Stage 2 : upgrading database/product/featured......<br/>");

        $this->loadModel('Product');
        $count = $this->Product->find('count');

        $changes = 0;

        for ($i = 0; $i < $count; $i += 100) {
            $data = $this->Product->find('all', array(
                "conditions" => array(
                    "type" => "product",
                ),
                "limit" => 100,
                "page" => $i / 100 + 1,
            ));

            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    if (!empty($value['Product']['featured'])) {
                        $images = unserialize($value['Product']['featured']);

                        if (!isset($images['origin'])) {
                            continue;
                        }

                        $value['Product']['featured'] = serialize($images['origin']);
                        $data[$key] = $value;

                        $this->Product->id = $value['Product']['id'];
                        $this->Product->set(array(
                            "featured" => $value['Product']['featured']
                        ));
                        $this->Product->save();
                        $changes++;
                    }
                }
            }
        }

        print_r("$changes records changed!<br/>");
        if ($changes == 0) {
            print_r("Your system is up to date.<br/>");
        }
        print_r("Complete! <br/>");
        exit;
    }

    public function test() {
        exit;

        $dir = APP . "webroot/uploads/product/";
        require_once APP . 'Vendor' . DS . "Zebra/Zebra_Image.php";
        $image = new Zebra_Image();

        $image->source_path = $dir . "52204dc799ab3.png";
        $image->jpeg_quality = 100;

        $image->preserve_aspect_ratio = true;
        $image->enlarge_smaller_images = true;
        $image->preserve_time = true;


        $image->target_path = $dir . "abcd_500.png"; // . $extension;

        if ($image->resize(200, 200, ZEBRA_IMAGE_BOXED, -1)) {
            
        }
    }

    public function fix() {

        exit;

        set_time_limit(0);
        //Cache::delete("category_top");
        //exit;


        $this->loadModel('Product');
        $data = $this->Product->find('all', array("conditions" => array("type" => "product")));

        foreach ($data as $key => $value) {
            $value['Product']['slug'] = trim($value['Product']['slug'], "-P") . "-P" . $value['Product']['id'];
            $this->Product->id = $value['Product']['id'];
            $this->Product->set(array("slug" => $value['Product']['slug']));
            $this->Product->save();
        }

        exit;

        $this->loadModel('Product');

        $data = $this->Product->find('all', array("conditions" => array("type" => "product")));

        foreach ($data as $value) {

            if (!empty($value['Product']['featured'])) {
                $images = unserialize($value['Product']['featured']);
                foreach ($images as $k2 => $image) {

                    if ($k2 == '150w' && is_array($image)) {
                        foreach ($image as $k3 => $i) {
                            $i = pathinfo($i, PATHINFO_FILENAME) . ".png";
                            $image[$k3] = $i;
                        }
                    }

                    $images[$k2] = $image;
                }
                $images = serialize($images);
                $value["Product"]['featured'] = $images;
            }

            $this->Product->id = $value['Product']['id'];
            $this->Product->set(array("featured" => $value['Product']['featured']));
            $this->Product->save();
        }

        exit;

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

        //print_r($images);

        foreach ($images as $img) {

            if (!preg_match("/^[0-9a-z]{1,}$/i", pathinfo($dir . $img, PATHINFO_FILENAME))) {
                continue;
            }

            //print_r($img);

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

            print_r($img . "<br/>");

            $image->target_path = $dir . $filename . "_500.png"; // . $extension;

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

            $image->target_path = $dir . $filename . "_150.png"; // . $extension;
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