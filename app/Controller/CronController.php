<?php

App::uses('AppController', 'Controller');

class CronController extends AppController {

    public $uses = false;
    public $version = 0.1;

    public function beforeFilter() {
        $this->Auth->allow();
        parent::beforeFilter();
    }

    public function clean() {
        $images = array();

        print_r("Stage 1 : Clean unused images......<br/>");
        //print_r(WWW_ROOT . $this->_media_location['product'] . "<br/>");

        if (($handle = opendir(WWW_ROOT . "uploads/" . ".")) != false) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $images[] = $entry;
                }
            }
            closedir($handle);
        }

        $changes = 0;
        foreach ($images as $image) {
            $file = WWW_ROOT . "uploads/" . $image;

            if (file_exists($file) && is_file($file)) {

                if (preg_match("/.(png|jpg|jpeg)$/i", $image)) {
                    $time = fileatime($file);
                    if ($time + 1000 * 60 * 60 * 24 * 7 >= time()) {
                        //@unlink ($file);
                        print_r($file . "<br/>");
                        $changes++;
                    }
                }
            }
        }
        
        print_r ("$changes unused images found in 7 days and deleted<br/>");
        
        exit;
    }

}
