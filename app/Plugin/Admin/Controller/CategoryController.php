<?php

class CategoryController extends AdminAppController {

    protected $error = array(
        'error' => 0,
        'element' => '',
        'message' => '',
    );
    public $cacheAction = array(
        'index' => array(
            'callbacks' => true,
            'duration' => 3600000),
        'categoryfilter' => array(
            'callbacks' => true,
            'duration' => 3600000),
        'categorylist' => array(
            'callbacks' => true,
            'duration' => 3600000)
    );

    public function beforeFilter() {
        $this->Auth->deny();
        parent::beforeFilter();
    }

    public function index() {
        
    }

    public function categorylist() {
        if ($this->request->is('ajax')) {

            $this->layout = false;
            $action = $this->request->query('action');
            $id = $this->request->query('id');

            $this->loadModel('Category');
            $categories = $this->Category->find('all', array(
                "conditions" => array('level' => 0),
                "order" => array('order ASC')
            ));

            $return = array();
            if (!empty($categories)) {

                foreach ($categories as $category) {
                    $result = $this->Category->find('all', array(
                        "conditions" => array('parent_guid' => $category['Category']['guid']),
                        "order" => array('order ASC')
                            )
                    );

                    if (!empty($result)) {
                        $return[] = $category;
                        $this->_categoryList($result, $return);
                    } else {
                        $return[] = $category;
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
                $this->loadModel('CategoryToObject');
                $data = $this->CategoryToObject->find('all', array("conditions" => array("object_guid" => $id)));
                foreach ($return as $key => $value) {

                    $value['Category']['selected'] = false;
                    foreach ($data as $category) {
                        if ($value['Category']['guid'] == $category['CategoryToObject']['category_guid']) {
                            $value['Category']['selected'] = true;
                        }
                    }
                    $return[$key] = $value;
                }
            }

            foreach ($return as $key => $value) {

                $id = $value['Category']['id'];

                //print_r ($value['Category']['slug']);

                if (preg_match("/\-C$id/", trim($value['Category']['slug']))) {
                    $value['Category']['slug'] = str_replace("-C" . $value['Category']['id'], "", $value['Category']['slug']);
                }
                $return[$key] = $value;
            }

            //print_r($return);
            //exit;

            $this->set('data', $return);
            $this->layout = "ajax";
        }
    }

    public function categoryfilter() {

        if ($this->request->is('ajax')) {

            $action = $this->request->query('action');
            $id = $this->request->query('id');

            $this->loadModel('Category');
            $categories = $this->Category->find('all', array(
                "conditions" => array('level' => 0),
                "order" => array('order ASC')
            ));

            $return = array();
            if (!empty($categories)) {

                foreach ($categories as $category) {
                    $result = $this->Category->find('all', array(
                        "conditions" => array('parent_guid' => $category['Category']['guid']),
                        "order" => array('order ASC')
                            )
                    );

                    if (!empty($result)) {
                        $return[] = $category;
                        $this->_categoryList($result, $return);
                    } else {
                        $return[] = $category;
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
                $this->loadModel('CategoryToObject');
                $data = $this->CategoryToObject->find('all', array("conditions" => array("object_guid" => $id)));
                foreach ($return as $key => $value) {

                    $value['Category']['selected'] = false;
                    foreach ($data as $category) {
                        if ($value['Category']['guid'] == $category['CategoryToObject']['category_guid']) {
                            $value['Category']['selected'] = true;
                        }
                    }
                    $return[$key] = $value;
                }
            }

            foreach ($return as $key => $value) {

                $id = $value['Category']['id'];

                //print_r ($value['Category']['slug']);

                if (preg_match("/\-C$id/", trim($value['Category']['slug']))) {
                    $value['Category']['slug'] = str_replace("-C" . $value['Category']['id'], "", $value['Category']['slug']);
                }
                $return[$key] = $value;
            }

            //print_r($return);
            //exit;

            //$this->layout = false;
            $this->layout = 'ajax';
            $this->set('data', $return);
            //$this->render('categoryfilter');
        }
    }

    public function add() {
        $data = $this->request->data('category');
        if (empty($data['name'])) {
            $this->error['error'] = 1;
            $this->error['element'] = 'input[name="category[name]"]';
            $this->error['message'] = 'Category name is required';
            exit(json_encode($this->error));
        }

        if (empty($data['slug'])) {
            $this->error['error'] = 1;
            $this->error['element'] = 'input[name="category[name]"]';
            $this->error['message'] = 'URL Key is required';
            exit(json_encode($this->error));
        }

        $this->loadModel('Category');
        $level = 0;
        $group_guid = null;

        if (empty($data['parent_guid'])) {
            $level = 0;
        } else {
            $parent = $this->Category->find("first", array(
                "conditions" => array(
                    "guid" => $data['parent_guid']
                )
            ));

            if (empty($parent)) {
                $level = 0;
            } else {
                $level = $parent['Category']['level'] + 1;
                $group_guid = $parent['Category']['group_guid'];
                $parent['Category']['children'] += 1;
                $this->Category->id = $parent['Category']['id'];
                $this->Category->set('children', $parent['Category']['children']);
                $this->Category->save();
            }
        }

        if ($level == 0) {
            Cache::delete("category_top");
        }

        $this->Category->create();

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

        $this->Category->save($data);
        $id = $this->Category->id;

        $data['slug'] = trim($data['slug'], "-");
        $this->Category->set(array('slug' => $data['slug'] . "-C" . $id));
        $this->Category->save();

        exit(json_encode($this->error));
    }

    public function edit() {
        $data = $this->request->data('category');
        if (empty($data['name'])) {
            $this->error['error'] = 1;
            $this->error['element'] = 'input[name="category[name]"]';
            $this->error['message'] = 'Category name is required';
            exit(json_encode($this->error));
        }

        if (empty($data['slug'])) {
            $this->error['error'] = 1;
            $this->error['element'] = 'input[name="category[name]"]';
            $this->error['message'] = 'URL Key is required';
            exit(json_encode($this->error));
        }

        $data['slug'] = trim($data['slug']);
        $data['name'] = trim($data['name']);
        if (empty($data['slug'])) {
            $data['slug'] = preg_replace("/ +/i", "-", $data['name']);
        } else {
            $data['slug'] = preg_replace("/ +/i", "-", $data['slug']);
        }

        $data['slug'] = @preg_replace("/\/+/i", "-", $data['slug']);

        $this->loadModel('Category');
        $data = $this->request->data('category');

        if ($data['level'] == 0) {
            Cache::delete("category_top");
        }

        $this->Category->id = $data['id'];
        $data['slug'] = trim($data['slug'], "-");
        $data['slug'] = $data['slug'] . "-C" . $data['id'];

        unset($data['id']);
        unset($data['guid']);
        unset($data['parent_guid']);
        unset($data['group_guid']);

        $this->Category->set($data);
        $this->Category->save($data);
        exit(json_encode($this->error));
    }

    public function delete() {
        $this->loadModel('Category');
        $this->loadModel('CategoryToObject');

        $data = $this->request->data('category');

        $parent = $this->Category->find('first', array('conditions' => array("guid" => $data['parent_guid'])));

        if (!empty($parent)) {
            $parent = $parent['Category'];
            $children = $parent['children'] - 1;
            $this->Category->id = $parent['id'];
            $parent = array();
            $parent['children'] = $children;
            $this->Category->set($parent);
            $this->Category->save();
        }

        $this->Category->clear();

        $result = $this->Category->find('all', array("conditions" => array("parent_guid" => $data['guid'])));
        $this->_categoryList($result, $return);
        $result['Category'] = $data;
        $return[] = $result;

        foreach ($return as $value) {
            $this->Category->query("DELETE FROM categories WHERE id={$value['Category']['id']}");
            $this->CategoryToObject->query("DELETE FROM category_to_object WHERE category_guid='{$value['Category']['guid']}'");
        }

        exit(json_encode($this->error));
    }

    public function clean() {
        $this->loadModel('Category');
        $this->Category->query('TRUNCATE TABLE categories;');
        exit(json_encode($this->error));
    }

    protected function _categoryList($data, &$return) {
        if (!empty($data)) {
            foreach ($data as $value) {

                $result = $this->Category->find('all', array(
                    "conditions" => array('parent_guid' => $value['Category']['guid']),
                    "order" => array('order ASC')
                        )
                );

                if (!empty($result)) {
                    $return[] = $value;
                    $this->_categoryList($result, $return);
                } else {
                    $return[] = $value;
                }
            }
        }
    }

}

