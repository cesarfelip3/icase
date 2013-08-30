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
        
        exit;

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
            print_r ($img);    
            if (preg_match("/[_]500[.]/i", $img)) {
                print_r ($img);
                
                $image_500 = str_replace(".", "_500.", $img);
                $image_500 = $img;
                
                if (file_exists($dir . $image_500)) {
                    $width = getimagesize($dir . $image_500);
                    $w = $width[0];
                    $h = $width[1];

                    $png = imagecreatefrompng(APP . 'webroot/img/background/500.png');
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
                    
                    if (empty ($png)) {
                        print_r ("unknow source");
                        exit;
                    }

                    $dst_y = 500 - $h;
                    if ($dst_y >= 0) {
                        $out = imagecreatetruecolor(500, 500);
                        imagecopyresampled($out, $png, 0, 0, 0, 0, 500, 500, 500, 500);
                        imagecopyresampled($out, $jpeg, 0, $dst_y, 0, 0, $w, $h, $w, $h);
                        imagejpeg($out, $dir . $image_500, 100);
                        print_r ($image_500);
                        exit;
                    }
                    
                }
            }

            exit;
            
            $final = APP . "webroot" . DS . "uploads" . DS . "preview" . DS . $final;
            if (file_exists($final)) {
                return;
            }

            $png = imagecreatefrompng($overlay);
            $jpeg = imagecreatefromjpeg($jpeg);

            //list($width, $height) = getimagesize('./image.jpg');
            //list($newwidth, $newheight) = getimagesize('./mark.png');
            $out = imagecreatetruecolor(500, 500);
            imagecopyresampled($out, $png, 0, 0, 0, 0, 500, 500, 500, 780);
            imagecopyresampled($out, $jpeg, 0, 0, 0, 0, 780, 780, 780, 780);

            imagejpeg($out, $final, 100);
        }

        require_once APP . 'Vendor' . DS . "Zebra/Zebra_Image.php";

        foreach ($images as $img) {
            if (preg_match("/^[0-9a-zA-Z]{1,}$/i", pathinfo($img, PATHINFO_FILENAME))) {
                $image_500 = str_replace(".", "_500.", $img);
                if (!file_exists($dir . $image_500)) {

                    print_r($img);

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