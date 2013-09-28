<?php

App::uses('AppController', 'Controller');

class UpgradeController extends AppController {

    public $uses = false;
    public $upgrade = true;
    public $version = 0.1;

    public function beforeFilter() {
        $this->Auth->allow();
        parent::beforeFilter();

        if ($this->upgrade == false) {
            exit;
        }
    }
    
    public function newtemplate () {

        $templates = array(
//            "iphone5" => array(
//                "name" => "iphone5",
//                "description" => "iphone5 case",
//                "price" => "34.99",
//                "image" => array(
//                    "foreground" => "iphone5_fg.png",
//                    "background" => "iphone5_bg.png",
//                ),
//                "type" => "template",
//                "status" => "published",
//                "quantity" => 65535,
//                "order" => 0,
//            ),
//            "iphone4" => array(
//                "name" => "iphone4",
//                "description" => "iphone4 case",
//                "price" => "34.99",
//                "image" => array(
//                    "foreground" => "iphone4_fg.png",
//                    "background" => "iphone4_bg.png",
//                ),
//                "type" => "template",
//                "status" => "published",
//                "quantity" => 65535,
//                "order" => 1
//            ),
//            "samsung galaxy 3" => array(
//                "name" => "samsung galaxy 3",
//                "description" => "iphone5 case",
//                "price" => "34.99",
//                "image" => array(
//                    "foreground" => "samsung galaxy 3-outer.png",
//                    "background" => "samsung galaxy 3-inner.png",
//                ),
//                "type" => "template",
//                "status" => "published",
//                "quantity" => 65535,
//                "order" => 2,
//            ),
//            "samsung galaxy 4" => array(
//                "name" => "samsung galaxy 4",
//                "description" => "samsung galaxy 4",
//                "price" => "34.99",
//                "image" => array(
//                    "foreground" => "samsung galaxy 4-outer.png",
//                    "background" => "samsung galaxy 4-inner.png",
//                ),
//                "type" => "template",
//                "status" => "published",
//                "quantity" => 65535,
//                "order" => 3
//            ),
            "iPad Flip" => array(
                "name" => "iPad Flip",
                "description" => "iPad Flip",
                "price" => "34.99",
                "image" => array(
                    "foreground" => "ipad_flip_fg.png",
                    "background" => "",
                ),
                "type" => "template",
                "status" => "published",
                "quantity" => 65535,
                "order" => 4
            ),
            "iPad Flip Swivel" => array(
                "name" => "iPad Flip Swivel",
                "description" => "iPad Flip Swivel",
                "price" => "34.99",
                "image" => array(
                    "foreground" => "ipad_flip_swivel_fg.png",
                    "background" => "",
                ),
                "type" => "template",
                "status" => "published",
                "quantity" => 65535,
                "order" => 5
            ),
            "Keychain" => array(
                "name" => "Keychain",
                "description" => "Keychain",
                "price" => "34.99",
                "image" => array(
                    "foreground" => "keychain_fg.png",
                    "background" => "",
                ),
                "type" => "template",
                "status" => "published",
                "quantity" => 65535,
                "order" => 6,
            ),
        );

        $this->loadModel("Product");
        //$this->Product->query("DELETE FROM products WHERE type='template'");
        foreach ($templates as $template) {
            $template['guid'] = uniqid();
            $template['created'] = time();
            $template['modified'] = time();
            $template['image'] = serialize($template['image']);
            $this->Product->create();
            $this->Product->save($template);
        }

        $this->autoRender = false;

        //$this->redirect(array("plugin" => "admin", "controller" => "product", "action" => "index"));
        echo "Successfully all templates created";
    }
    
    public function to02() {
        set_time_limit(0);
        exit;

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