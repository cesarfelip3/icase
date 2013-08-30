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

        foreach ($images as $img) {
            print_r($img . "<br/>");
            if (preg_match("/\_500\./i", $img)) {
                print_r($img . "<br/>");

                //$image_500 = str_replace(".", "_500.", $img);
                $image_500 = $img;

                if (file_exists($dir . $image_500)) {

                    $width = array();
                    $width = getimagesize($dir . $image_500);
                    $w = $width[0];
                    $h = $width[1];

                    //$png = imagecreatefrompng(APP . 'webroot/img/background/500.png');
                    $source = null;

                    $ext = pathinfo($image_500, PATHINFO_EXTENSION);

                    print_r($ext);
                    
                    if (strtolower($ext) == 'jpg' || strtolower($ext) == 'jpeg') {
                        $source = imagecreatefromjpeg($dir . $image_500);
                    }
                    
                    print_r($source);
                    
                    if (strtolower($ext) == 'png') {
                        $source = imagecreatefrompng($dir . $image_500);
                    }
                    
                    $dst_y = 500 - $h;
                    if ($dst_y > 0) {
                        //$out = imagecreatetruecolor(500, 500);
                        $dst_y = ceil($dst_y / 2);

                        $out = imagecreatetruecolor(500, 500);
                        imagealphablending($out, false);
                        $col = imagecolorallocatealpha($out, 255, 255, 255, 127);
                        imagefilledrectangle($out, 0, 0, 500, 500, $col);
                        imagealphablending($out, true);

                        //imagecopyresampled($out, $png, 0, 0, 0, 0, 500, 500, 500, 500);
                        imagecopyresampled($out, $source, 0, $dst_y, 0, 0, $w, $h, $w, $h);
                        imagepng($out, $dir . $image_500, 100);
                        print_r($image_500);
                        exit;
                    }
                }
            }
        }
    }

}