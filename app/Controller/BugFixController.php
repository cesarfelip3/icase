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

        print_r ("bugfix.category");
        
        $data = $this->Category->find('all');

        foreach ($data as $key => $value) {
            print_r ($value['Category']['slug']);
            if (strpos("\/", $value['Category']['slug']) !== false) {
                print_r ($value['Category']['slug']);
                $value['Category']['slug'] = preg_replace("/\/+/i", "-", $value['Category']['slug']);
                //$data[$key] = $value;
                $this->Product->id = $value['Category']['id'];
                $this->Product->save(array('slug' => $value['Category']['slug']));
            }
        }
        
        exit;
    }
}