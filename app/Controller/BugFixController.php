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

        if ($handle = opendir($dir . ".")) {
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

                $image_500 = str_replace(".", "_500.", $img);
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
}}}}}}