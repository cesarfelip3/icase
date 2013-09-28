<?php

class IndustryController extends AdminAppController {

    protected $error = array(
        'error' => 0,
        'element' => '',
        'message' => '',
    );
//    public $cacheAction = array(
//        'index' => array(
//            'callbacks' => true,
//            'duration' => 3600000),
//        'industryfilter' => array(
//            'callbacks' => true,
//            'duration' => 3600000),
//        'industrylist' => array(
//            'callbacks' => true,
//            'duration' => 3600000)
//    );

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {
        
    }

    public function industrylist() {
        if ($this->request->is('ajax')) {

            $this->layout = false;
            $action = $this->request->query('action');
            $id = $this->request->query('id');

            $this->loadModel('Industry');
            $industries = $this->Industry->find('all', array(
                "conditions" => array('level' => 0),
                "order" => array('order ASC')
            ));

            $return = array();
            if (!empty($industries)) {

                foreach ($industries as $industry) {
                    $result = $this->Industry->find('all', array(
                        "conditions" => array('parent_guid' => $industry['Industry']['guid']),
                        "order" => array('order ASC')
                            )
                    );

                    if (!empty($result)) {
                        $return[] = $industry;
                        $this->_industryList($result, $return);
                    } else {
                        $return[] = $industry;
                    }
                }
            }

            if (!empty($action)) {
                switch ($action) {
                    case "checkbox":
                        $this->set('checkbox', true);
                        break;
                }
            }

            if (!empty($id)) {
                $this->loadModel('IndustryToObject');
                $data = $this->IndustryToObject->find('all', array("conditions" => array("object_guid" => $id)));
                foreach ($return as $key => $value) {

                    $value['Industry']['selected'] = false;
                    foreach ($data as $industry) {
                        if ($value['Industry']['guid'] == $industry['IndustryToObject']['industry_guid']) {
                            $value['Industry']['selected'] = true;
                        }
                    }
                    $return[$key] = $value;
                }
            }

            foreach ($return as $key => $value) {

                $id = $value['Industry']['id'];

                //print_r ($value['Industry']['slug']);

                if (preg_match("/\-C$id/", trim($value['Industry']['slug']))) {
                    $value['Industry']['slug'] = str_replace("-C" . $value['Industry']['id'], "", $value['Industry']['slug']);
                }
                $return[$key] = $value;
            }

            //print_r($return);
            //exit;

            $this->set('data', $return);
            $this->layout = "ajax";
        }
    }

    public function industryfilter() {

        if ($this->request->is('ajax')) {

            $action = $this->request->query('action');
            $id = $this->request->query('id');

            $this->loadModel('Industry');
            $industries = $this->Industry->find('all', array(
                "conditions" => array('level' => 0),
                "order" => array('order ASC')
            ));

            $return = array();
            if (!empty($industries)) {

                foreach ($industries as $industry) {
                    $result = $this->Industry->find('all', array(
                        "conditions" => array('parent_guid' => $industry['Industry']['guid']),
                        "order" => array('order ASC')
                            )
                    );

                    if (!empty($result)) {
                        $return[] = $industry;
                        $this->_industryList($result, $return);
                    } else {
                        $return[] = $industry;
                    }
                }
            }

            if (!empty($action)) {
                switch ($action) {
                    case "checkbox":
                        $this->set('checkbox', true);
                        break;
                }
            }


            //print_r($return);
            //exit;

            //$this->layout = false;
            $this->layout = 'ajax';
            $this->set('data', $return);
            //$this->render('industryfilter');
        }
    }

    public function add() {
        $data = $this->request->data('industry');
        if (empty($data['name'])) {
            $this->error['error'] = 1;
            $this->error['element'] = 'input[name="industry[name]"]';
            $this->error['message'] = 'Industry name is required';
            exit(json_encode($this->error));
        }

//        if (empty($data['slug'])) {
//            $this->error['error'] = 1;
//            $this->error['element'] = 'input[name="industry[name]"]';
//            $this->error['message'] = 'URL Key is required';
//            exit(json_encode($this->error));
//        }

        $this->loadModel('Industry');
        $level = 0;
        $group_guid = null;

        if (empty($data['parent_guid'])) {
            $level = 0;
        } else {
            $parent = $this->Industry->find("first", array(
                "conditions" => array(
                    "guid" => $data['parent_guid']
                )
            ));

            if (empty($parent)) {
                $level = 0;
            } else {
                $level = $parent['Industry']['level'] + 1;
                $group_guid = $parent['Industry']['group_guid'];
                $parent['Industry']['children'] += 1;
                $this->Industry->id = $parent['Industry']['id'];
                $this->Industry->set('children', $parent['Industry']['children']);
                $this->Industry->save();
            }
        }

        if ($level == 0) {
            Cache::delete("industry_top");
        }

        $this->Industry->create();

        if (empty($group_guid)) {
            $group_guid = uniqid();
        }

        $data = array_merge(
                $data, array(
            "guid" => uniqid(),
            "group_guid" => $group_guid,
            "level" => $level,
                )
        );

        $data['slug'] = trim($data['slug']);
        $data['name'] = trim($data['name']);
        if (empty($data['slug'])) {
            $data['slug'] = preg_replace("/ +/i", "-", $data['name']);
        } else {
            $data['slug'] = preg_replace("/ +/i", "-", $data['slug']);
        }

        $data['slug'] = @preg_replace("/\/+/i", "-", $data['slug']);

        $this->Industry->save($data);
        $id = $this->Industry->id;

        $data['slug'] = trim($data['slug'], "-");
        $this->Industry->set(array('slug' => $data['slug'] . "-C" . $id));
        $this->Industry->save();

        exit(json_encode($this->error));
    }

    public function edit() {
        $data = $this->request->data('industry');
        if (empty($data['name'])) {
            $this->error['error'] = 1;
            $this->error['element'] = 'input[name="industry[name]"]';
            $this->error['message'] = 'Industry name is required';
            exit(json_encode($this->error));
        }

//        if (empty($data['slug'])) {
//            $this->error['error'] = 1;
//            $this->error['element'] = 'input[name="industry[name]"]';
//            $this->error['message'] = 'URL Key is required';
//            exit(json_encode($this->error));
//        }

        $data['slug'] = trim($data['slug']);
        $data['name'] = trim($data['name']);
        if (empty($data['slug'])) {
            $data['slug'] = preg_replace("/ +/i", "-", $data['name']);
        } else {
            $data['slug'] = preg_replace("/ +/i", "-", $data['slug']);
        }

        $data['slug'] = @preg_replace("/\/+/i", "-", $data['slug']);

        $this->loadModel('Industry');
        $data = $this->request->data('industry');

        if ($data['level'] == 0) {
            Cache::delete("industry_top");
        }

        $this->Industry->id = $data['id'];
        $data['slug'] = trim($data['slug'], "-");
        $data['slug'] = $data['slug'] . "-C" . $data['id'];

        unset($data['id']);
        unset($data['guid']);
        unset($data['parent_guid']);
        unset($data['group_guid']);

        $this->Industry->set($data);
        $this->Industry->save($data);
        exit(json_encode($this->error));
    }

    public function delete() {
        $this->loadModel('Industry');

        $data = $this->request->data('industry');

        $parent = $this->Industry->find('first', array('conditions' => array("guid" => $data['parent_guid'])));

        if (!empty($parent)) {
            $parent = $parent['Industry'];
            $children = $parent['children'] - 1;
            $this->Industry->id = $parent['id'];
            $parent = array();
            $parent['children'] = $children;
            $this->Industry->set($parent);
            $this->Industry->save();
        }

        $this->Industry->clear();

        $result = $this->Industry->find('all', array("conditions" => array("parent_guid" => $data['guid'])));
        $this->_industryList($result, $return);
        $result['Industry'] = $data;
        $return[] = $result;

        foreach ($return as $value) {
            $this->Industry->query("DELETE FROM pwd_industries WHERE id={$value['Industry']['id']}");
        }

        exit(json_encode($this->error));
    }

    public function clean() {
        $this->loadModel('Industry');
        $this->Industry->query('TRUNCATE TABLE industries;');
        exit(json_encode($this->error));
    }

    protected function _industryList($data, &$return) {
        if (!empty($data)) {
            foreach ($data as $value) {

                $result = $this->Industry->find('all', array(
                    "conditions" => array('parent_guid' => $value['Industry']['guid']),
                    "order" => array('order ASC')
                        )
                );

                if (!empty($result)) {
                    $return[] = $value;
                    $this->_industryList($result, $return);
                } else {
                    $return[] = $value;
                }
            }
        }
    }

}

