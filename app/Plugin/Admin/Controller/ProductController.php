<?php

class ProductController extends AdminAppController {

    public function beforeFilter() {
        $this->Auth->allow();
        $this->Auth->allow('guest');
        parent::beforeFilter();
    }

    public function index() {
        $this->loadModel('Product');

        $page = $this->request->query('page');
        $limit = $this->request->query('limit');
        
        if (empty($limit)) {
            $limit = 25;
        }

        if (empty($page)) {
            $page = 0;
        }

        if ($page < 0) {
            $page = 0;
        }

        $conditions = array();
        if ($this->request->is('post')) {
            $keyword = $this->request->data('keyword');
            $filter = $this->request->data('filter');

            $start = $this->request->data('start');
            $end = $this->request->data('end');


            if (!empty($start) && !empty($end)) {
                $duration = array("created >=" => strtotime($start), "created <=" => strtotime($end));
                $conditions = array("AND" => $duration);
            }

            if (!empty($keyword)) {
                $search = array("name LIKE" => "%" . Sanitize::escape($keyword) . "%", "description LIKE" => "%" . Sanitize::escape($keyword) . "%");
                $conditions = array_merge($conditions, array("OR" => $search));
            }
        }
        
        $this->Product->create ();
        $data = $this->Product->find('all', array(
            'limit' => $limit,
            'page' => $page + 1,
            'conditions' => $conditions,
                )
        );
        
        $total = $this->Product->find('count', array('conditions' => $conditions));
        $pages = ceil($total / $limit);

        //$log = $this->Product->getDataSource()->getLog(false, false);
        //print_r ($log);
        //exit;
        
        $params = array (
            "data" => $data,
            "page" => $page,
            "limit" => $limit,
            "pages" => $pages,
        );
        
        $this->set ($params);
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
            $category = $this->request->data('category');

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

            $is_special = 0;
            if (isset($data['is_special'])) {
                $is_special = 1;
                if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['special_price']) == false) {
                    $error['error'] = 1;
                    $error['element'] = 'input[name="product[special_price]"]';
                    $error['message'] = 'Invalid special price number';
                    exit(json_encode($error));
                }
            }

            $type = "";
            if (!isset($data['type'])) {
                $type = "product";
            } else {
                $type = $data['type'];
            }

            $status = 'draft';
            if (!empty($action)) {
                if ($action == 'publish') {
                    $status = 'published';
                }
            }

            $this->loadModel('Product');
            $product_guid = uniqid();

            if (!empty($data['featured'])) {
                $data['featured'] = trim($data['featured'], "-");
                $data['featured'] = serialize(explode("-", $data['featured']));
            }

            $product = array(
                "guid" => $product_guid,
                "name" => $data['name'],
                "description" => $data['description'],
                "image" => trim($data['image']),
                "featured" => $data['featured'],
                "type" => $type,
                "price" => $data['price'],
                "tax" => $data['tax'],
                "quantity" => $data['quantity'],
                "status" => $status,
                "created" => time(),
                "modified" => time()
            );

            if ($is_special == 1) {
                $product = array_merge(
                        $product, array(
                    "is_special" => 1,
                    "special_price" => $data['special_price'],
                    "special_start" => strtotime($data['special_start']),
                    "special_end" => strtotime($data['special_end'])
                        )
                );
            }

            $this->Product->create();
            $this->Product->save($product);

            if (!empty($category)) {

                $this->loadModel('CategoryToObject');

                $data = array();
                foreach ($category as $value) {
                    $data[] = array(
                        "category_guid" => $value,
                        "object_guid" => $product_guid
                    );
                }

                $this->CategoryToObject->create();
                $this->CategoryToObject->saveMany($data);
            }

            //print_r ($this->request->data);
            //print_r ($product);
            //exit;

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

        $action = $this->request->query('action');
        if ($this->request->is('ajax')) {

            if (!$this->request->is('post')) {
                $this->layout = false;

                $this->loadModel('Category');
                $categories = $this->Category->find('all', array(
                    "conditions" => array('level' => 0),
                    "order" => array('order ASC')
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

                            if (!empty($result)) {
                                $return[] = $category;
                                $this->_categoryList($result, $return);
                            }
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

                $this->set('data', $return);
                $this->render('category.ajax');
            } else {

                if (empty($action)) {
                    exit("");
                }

                if ($action == "empty") {
                    $this->loadModel('Category');
                    $this->Category->query('TRUNCATE TABLE categories;');
                    exit(json_encode($error));
                }

                if ($action == "update") {
                    $this->loadModel('Category');
                    $data = $this->request->data('category');
                    $data = $data['edit'];

                    $update = array(
                        'name' => "'" . Sanitize::escape($data['name']) . "'",
                        'order' => Sanitize::escape($data['order'])
                    );

                    $guid = $data['guid'];
                    $this->Category->updateAll($update, array("guid" => $guid));
                    exit(json_encode($error));
                }

                if ($action == "delete") {
                    $this->loadModel('Category');
                    $data = $this->request->data('category');
                    $guid = $data['parent_guid'];

                    //$guid = $this->request->data('category[parent_guid]');
                    $this->Category->deleteAll(array("guid" => $guid));
                    $this->Category->deleteAll(array("parent_guid" => $guid));

                    if ($this->Category->find('count') == 0) {
                        $error['error'] = 1;
                    }
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
                        "slug" => preg_replace ("/ +/i", "-", $data['name']),
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
