<?php

App::uses('AppController', 'Controller');

class BugFixController extends AppController {

    public $uses = false;

    public function beforeFilter() {
        $this->Auth->allow();
        parent::beforeFilter();
    }

    public function fix() {
        $this->loadModel('Category');

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

        if ($handle = opendir($dir . ".")) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $images[] = $entry;
                }
            }
            closedir($handle);
        }

        require_once APP . 'Vendor' . DS . "Zebra/Zebra_Image.php";
        foreach ($images as $image) {
            if (preg_match("/^[0-9a-zA-Z]{1,}$/i", $img)) {
                $image_500 = str_replace(".", "_500.", $img);
                if (!file_exists($dir . $image_500)) {
                    
                    print_r ($img);
                    
                    $image = new Zebra_Image();

                    $image->source_path = $dir . $img;
                    $image->target_path = $dir . $image_500;

                    $image->jpeg_quality = 100;

                    $image->preserve_aspect_ratio = true;
                    $image->enlarge_smaller_images = true;
                    $image->preserve_time = true;

                    // resize the image to exactly 100x100 pixels by using the "crop from center" method
                    // (read more in the overview section or in the documentation)
                    //  and if there is an error, check what the error is about
                    if (!$image->resize(500, 0, ZEBRA_IMAGE_CROP_CENTER)) {

                        // if there was an error, let's see what the error is about
                        switch ($image->error) {

                            case 1:
                                //echo 'Source file could not be found!';
                                break;
                            case 2:
                                //echo 'Source file is not readable!';
                                break;
                            case 3:
                                //echo 'Could not write target file!';
                                break;
                            case 4:
                                //echo 'Unsupported source file format!';
                                break;
                            case 5:
                                //echo 'Unsupported target file format!';
                                break;
                            case 6:
                                //echo 'GD library version does not support target file format!';
                                break;
                            case 7:
                                //echo 'GD library is not installed!';
                                break;
                            case 8:
                                //echo '"chmod" command is disabled via configuration!';
                                break;
                        }

                        // if no errors
                    }
                }
            }
        }
    }

}