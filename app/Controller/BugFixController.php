<?php

App::uses('AppController', 'Controller');

class BugFixController extends AppController {

    public $uses = false;

    public function fix() {
        $this->loadModel('Category');

        $data = $this->Category->find('all');

        foreach ($data as $key => $value) {
            if (strpos("/", $value['Category']['slug']) != false) {
                $value['Category']['slug'] = preg_replace("/\/+/i", "-", $value['Category']['slug']);
                //$data[$key] = $value;
                $this->Product->id = $value['Category']['id'];
                $this->Product->save(array('slug' => $value['Category']['slug']));
            }
        }
    }

}

?>