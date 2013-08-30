<?php

App::uses('AppController', 'Controller');

class BugFixController extends AppController {

    public $uses = false;

    public function beforeFilter() {
        $this->Auth->allow();
        parent::beforeFilter();
    }

    public function fix() {

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

        foreach ($images as $img) {
            print_r($img . "<br/>");
            if (preg_match("/\_500\./i", $img)) {
                print_r($img . "<br/>");

                //$image_500 = str_replace(".", "_500.", $img);
                $image_500 = $img;

                print_r($dir . $image_500 . "<br/>");

                if (file_exists($dir . $image_500)) {

                    $width = array();
                    $path = $dir . $image_500;

                    try {
                        $width = getimagesize($path);
                    } catch (Exception $e) {
                        print_r($e->getMessage());
                    }

                    //print_r ($width);
                    //exit;


                    $w = $width[0];
                    $h = $width[1];

                    //print_r ($width);
                    //exit;
                    //$png = imagecreatefrompng(APP . 'webroot/img/background/500.png');
                    //$source = null;

                    $ext = pathinfo($image_500, PATHINFO_EXTENSION);

                    //print_r($ext);
                    //print_r ($dir . $image_500);
                    //print_r ($source);
                    //exit;

                    if (strtolower($ext) == 'jpg' || strtolower($ext) == 'jpeg') {
                        $source = imagecreatefromjpeg($dir . $image_500);
                        //continue;
                    }


                    if (strtolower($ext) == 'png') {
                        //$source = imagecreatefrompng($dir . $image_500);
                        continue;
                    }

                    //exit;
                    //print_r ($source);
                    //exit;

                    $dst_y = 500 - $h;
                    if ($dst_y > 0) {
                        //$out = imagecreatetruecolor(500, 500);
                        $dst_y = ceil($dst_y / 2);

                        $out = imagecreatetruecolor(500, 500);
                        //$red = imagecolorallocate($im, 255, 0, 0);
                        $black = imagecolorallocate($out, 0, 0, 0);
                        imagecolortransparent($out, $black);

                        //imagecopyresampled($out, $png, 0, 0, 0, 0, 500, 500, 500, 500);
                        imagecopyresampled($out, $source, 0, $dst_y, 0, 0, $w, $h, $w, $h);
                        imagepng($out, $dir . $image_500, 0);
                        print_r($image_500);
                        //exit;
                    }
                }
            }
        }

        exit;
    }

}