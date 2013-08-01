<?php

class ProductController extends AdminAppController {

    public function beforeFilter() {
        $this->Auth->allow();
        $this->Auth->allow('guest');
        parent::beforeFilter();
    }

    public function index() {
        
    }

    public function add() {
        $error = array(
            'error' => 0,
            'element' => '',
            'message' => '',
        );

        if ($this->request->is('ajax') && $this->request->is('post')) {
            $this->autoRender = false;
            $data = $this->request->data('product');

            if (empty($data['name'])) {
                $error['error'] = 1;
                $error['element'] = 'input[name="product[name]"]';
                $error['message'] = 'Product name is required';
                exit(json_encode($error));
            }

            if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['price']) == false) {
                $error['error'] = 1;
                $error['element'] = 'input[name="product[price]"]';
                $error['message'] = 'Invalid price number';
                exit(json_encode($error));
            }

            if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['tax']) == false) {
                $error['error'] = 1;
                $error['element'] = 'input[name="product[tax]"]';
                $error['message'] = 'Invalid tax number';
                exit(json_encode($error));
            }

            if (preg_match("/^[0-9]{1,2}$/i", $data['discount']) == false) {
                $error['error'] = 1;
                $error['element'] = 'input[name="product[discount]"]';
                $error['message'] = 'Invalid discount number';
                exit(json_encode($error));
            }

            $error['element'] = 'input';
            exit(json_encode($error));
        }
    }

    public function edit() {
        
    }

    public function delete() {
        
    }

    protected function _categoryList($data, &$return) {
        if (!empty($data)) {
            foreach ($data as $value) {

                if ($value['Category']['children'] > 0) {
                    $result = $this->Category->find('all', array(
                        "conditions" => array('parent_guid' => $value['Category']['guid']),
                        "order" => array('order ASC')
                            )
                    );
                    $return[] = $value;
                    $this->_categoryList($result, $return);
                } else {
                    $return[] = $value;
                }
            }
        }
    }

    public function category() {
        $error = array(
            'error' => 0,
            'element' => '',
            'message' => '',
        );

        if ($this->request->is('ajax')) {

            if (!$this->request->is('post')) {
                $this->layout = false;

                $this->loadModel('Category');
                $categories = $this->Category->find('all', array(
                    "conditions" => array('level' => 0)
                ));

                $return = array();
                if (!empty($categories)) {

                    foreach ($categories as $category) {
                        if ($category['Category']['children'] > 0) {
                            $result = $this->Category->find('all', array(
                                "conditions" => array('parent_guid' => $category['Category']['guid']),
                                "order" => array('order ASC')
                                    )
                            );
                            
                            if (!empty ($result)) {
                                $return[] = $category;
                                $this->_categoryList($result, $return);
                            }
                        } else {
                            $return[] = $category;
                        }
                    }
                }

                $this->set('data', $return);
                $this->render('category.ajax');
            } else {
                $action = $this->request->query('action');

                if (empty($action)) {
                    exit("");
                }
                
                if ($action == "empty") {
                    $this->loadModel('Category');
                    $this->Category->query('TRUNCATE TABLE categories;');
                    exit(json_encode($error));
                }

                if ($action == "add") {
                    $data = $this->request->data('category');

                    if (empty($data['name'])) {
                        $error['error'] = 1;
                        $error['element'] = 'input[name="category[name]"]';
                        $error['message'] = 'Category name is required';
                        exit(json_encode($error));
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

                    $this->Category->create();

                    if (empty($group_guid)) {
                        $group_guid = uniqid();
                    }

                    $category = array(
                        "guid" => uniqid(),
                        "group_guid" => $group_guid,
                        "name" => $data['name'],
                        "description" => $data['description'],
                        "parent_guid" => $data['parent_guid'],
                        "level" => $level
                    );
                    $this->Category->save($category);
                    exit(json_encode($error));
                }
            }
        }
    }

}

?>
