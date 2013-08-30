<?php

App::uses('AppController', 'Controller');

class BugFixController extends AppController {

    public $uses = false;

    public function beforeFilter() {
        $this->Auth->allow();
        parent::beforeFilter();
    }

    public function fix() {
        //exit;
        //$this->loadModel('Category');

        /*
          print_r("bugfix.category");

          $data = $this->Category->find('all');

          foreach ($data as $key => $value) {
          print_r($value['Category']['slug'] . "<br/>");
          if (preg_match("/\//i", $value['Category']['slug'], $matches)) {
          print_r($value['Category']['slug']);
          $value['Category']['slug'] = preg_replace("/\/+/i", "-", $value['Category']['slug']);
          //$data[$key] = $value;
          $this->Category->id = $value['Category']['id'];
          $this->Category->save(array('slug' => $value['Category']['slug']));
          }
          }

          exit;

         */

        $dir = APP . "webroot/uploads/product/";

        print_r("bugfix.category");

        $images = array();

        //exit;

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

        foreach ($images as $img) {
            print_r($img);
            if (preg_match("/\_500\./i", $img)) {
                print_r($img);

                //$image_500 = str_replace(".", "_500.", $img);
                $image_500 = $img;

                if (file_exists($dir . $image_500)) {
                    $width = getimagesize($dir . $image_500);
                    $w = $width[0];
                    $h = $width[1];

                    //$png = imagecreatefrompng(APP . 'webroot/img/background/500.png');
                    $jpeg = null;

                    if (in_array(pathinfo($img, PATHINFO_EXTENSION), array('jpg', 'jpeg'))) {
                        $jpeg = imagecreatefromjpeg($dir . $image_500);
                    }

                    if (in_array(pathinfo($img, PATHINFO_EXTENSION), array('png'))) {
                        $jpeg = imagecreatefrompng($dir . $image_500);
                    }

                    if (empty($jpeg)) {
                        print_r("unknow extension");
                        exit;
                    }

                    $dst_y = 500 - $h;
                    if ($dst_y > 0) {
                        //$out = imagecreatetruecolor(500, 500);
                        $dst_y = ceil ($dst_y / 2);
                        
                        $out = imagecreatetruecolor(500, 500);
                        imagealphablending($out, false);
                        $col = imagecolorallocatealpha($out, 255, 255, 255, 127);
                        imagefilledrectangle($out, 0, 0, 500, 500, $col);
                        imagealphablending($out, true);

                        //imagecopyresampled($out, $png, 0, 0, 0, 0, 500, 500, 500, 500);
                        imagecopyresampled($out, $jpeg, 0, $dst_y, 0, 0, $w, $h, $w, $h);
                        imagepng($out, $dir . $image_500, 100);
                        print_r($image_500);
                        exit;
                    }
                }
            }
        }
    }

}