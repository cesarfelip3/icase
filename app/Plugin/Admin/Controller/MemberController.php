<?php

class MemberController extends AdminAppController {
    
        public function beforeFilter() {
        $this->Auth->allow();
        $this->Auth->allow('guest');
        parent::beforeFilter();
    }

    public function index() {

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

        $keyword = $this->request->query('keyword');
        $filter = $this->request->query('filter');

        $start = $this->request->query('start');
        $end = $this->request->query('end');

        $conditions = array();

        if (!empty($start) && !empty($end)) {
            $duration = array(
                "AND" => array(
                    array("created >=" => strtotime($start)),
                    array("created <=" => strtotime($end))
            ));
            $conditions = array_merge($conditions, $duration);
        }

        if (!empty($keyword)) {
            $search = array(
                "OR" => array(
                    array("name LIKE " => "%" . $keyword . "%"),
                    array("description LIKE " => "%" . $keyword . "%"))
            );
            $conditions = array_merge($conditions, $search);
        }

        if (!empty($filter)) {
            $conditions = array($conditions, array($filter));
        }


        //=========================================================
        $this->loadModel('User');
        $total = $this->User->find("count", array("conditions" => $conditions));

        if ($total <= 0) {
            $data = array();
        } else {
            $data = $this->User->find('all', array(
                'limit' => $limit,
                'page' => $page + 1,
                'conditions' => $conditions,
                'fields' => array("User.*")
                    )
            );
            foreach ($data as $key => $value) {

                if ($value['User']['type'] == 'product') {
                    $value['User']['featured'] = unserialize($value['User']['featured']);
                    $value['User']['image'] = count($value['User']['featured']) > 0 ? $value['User']['featured'][0] : "";
                    $data[$key] = $value;
                }
            }
        }

        //=========================================================

        $pages = ceil($total / $limit);

        $filters = array(
            "type='register'" => "Registered",
            "type='guest'" => "Guest",
            "orders > 0" => "Has Orders"
        );

        $this->set(array(
            "data" => $data,
            "page" => $page,
            "limit" => $limit,
            "pages" => $pages,
            "keyword" => $keyword,
            "start" => $start,
            "end" => $end,
            "filter" => $filter,
            "filters" => $filters
        ));
    }

    public function add() {
        $error = array(
            'error' => 0,
            'element' => '',
            'message' => '',
            'data' => ''
        );

        if ($this->request->is('ajax') && $this->request->is('post')) {
            $this->autoRender = false;

            $data = $this->request->data('product');
            $category = $this->request->data('category');
            $action = $this->request->query('action');

            if (empty($data['name'])) {
                $error['error'] = 1;
                $error['element'] = 'input[name="product[name]"]';
                $error['message'] = 'User name is required';
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

            if (!isset($data['type'])) {
                $data['type'] = "product";
            } else {
                $data['type'] = "template";
            }

            if (isset($data['status'])) {
                $data['status'] = 'published';
            } else {
                $data['status'] = 'draft';
            }

            $this->loadModel('User');

            if (!empty($data['featured'])) {
                $data['featured'] = trim($data['featured'], "-");
                $data['featured'] = serialize(explode("-", $data['featured']));
            }

            if ($is_special == 1) {
                $data = array_merge(
                        $data, array(
                    "is_special" => 1,
                    "special_price" => $data['special_price'],
                    "special_start" => strtotime($data['special_start']),
                    "special_end" => strtotime($data['special_end'])
                        )
                );
            }

            $data['slug'] = preg_replace("/ +/i", "-", $data['name']) . "-" . uniqid();

            if ($action == "update" && !empty($data['guid'])) {
                $count = $this->User->find('count', array("conditions" => array("guid" => $data['guid'])));
                if ($count == 0) {
                    $data['guid'] = uniqid();
                    $data['created'] = time();
                    $data['modified'] = time();
                } else {
                    $data['modified'] = time();
                    $this->User->updateAll(array($product), array("conditions" => array("guid" => $data['guid'])));

                    if (!empty($category)) {
                        $this->loadModel('CategoryToObject');
                        $this->CategoryToObject->deleteAll(array("object_guid" => $data['guid']));

                        $data = array();
                        foreach ($category as $value) {
                            $data[] = array(
                                "category_guid" => $value,
                                "object_guid" => $data['guid']
                            );
                        }

                        $this->CategoryToObject->create();
                        $this->CategoryToObject->saveMany($data);
                    }
                    exit(json_encode($error));
                }
            } else {
                $data['guid'] = uniqid();
                $data['created'] = time();
                $data['modified'] = time();
            }

            $this->User->create();
            $this->User->save($data);
            $error['data'] = $data['guid'];

            if (!empty($category)) {

                $this->loadModel('CategoryToObject');

                foreach ($category as $value) {
                    $categories[] = array(
                        "category_guid" => $value,
                        "object_guid" => $data['guid']
                    );
                }

                $this->CategoryToObject->create();
                $this->CategoryToObject->saveMany($categories);
            }

            $error['element'] = 'input';
            exit(json_encode($error));
        }
    }

    public function edit() {
        $error = array(
            'error' => 0,
            'element' => '',
            'message' => '',
            'data' => ''
        );

        if ($this->request->is('ajax') && $this->request->is('post')) {
            $this->autoRender = false;

            $data = $this->request->data('product');
            $category = $this->request->data('category');
            $action = $this->request->query('action');

            if (empty($data['name'])) {
                $error['error'] = 1;
                $error['element'] = 'input[name="product[name]"]';
                $error['message'] = 'User name is required';
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

            if (!isset($data['type'])) {
                $data['type'] = "product";
            } else {
                $data['type'] = "template";
            }

            if (isset($data['status'])) {
                $data['status'] = 'published';
            } else {
                $data['status'] = 'draft';
            }

            $this->loadModel('User');

            if (!empty($data['featured'])) {
                $data['featured'] = trim($data['featured'], "-");
                $data['featured'] = serialize(explode("-", $data['featured']));
            }

            if ($is_special == 1) {
                $data = array_merge(
                        $data, array(
                    "is_special" => 1,
                    "special_price" => $data['special_price'],
                    "special_start" => strtotime($data['special_start']),
                    "special_end" => strtotime($data['special_end'])
                        )
                );
            }

            if ($action == "update" && !empty($data['guid'])) {
                $count = $this->User->find('count', array("conditions" => array("guid" => $data['guid'])));
                if ($count == 0) {
                    $data['guid'] = uniqid();
                    $data['created'] = time();
                    $data['modified'] = time();
                } else {
                    $data['modified'] = time();
                    $this->User->updateAll(array($product), array("conditions" => array("guid" => $data['guid'])));

                    if (!empty($category)) {
                        $this->loadModel('CategoryToObject');
                        $this->CategoryToObject->deleteAll(array("object_guid" => $data['guid']));

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
                    exit(json_encode($error));
                }
            } else {
                $data['guid'] = uniqid();
                $data['created'] = time();
                $data['modified'] = time();
            }

            $this->User->create();
            $this->User->save($product);
            $error['data'] = $data['guid'];

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

            $error['element'] = 'input';
            exit(json_encode($error));
        }


        $guid = $this->request->query("id");
        if (empty($guid)) {
            $this->set('data', null);
            return;
        }

        $this->loadModel('User');

        $data = $this->User->find('first', array("conditions" => array("guid" => $guid)));
        $data = $data['User'];

        $this->set('data', $data);
    }

    public function delete() {
        $id = $this->request->query('id');
        $this->loadModel('User');

        $data = $this->User->find('first', array("conditions" => array("id" => $id)));
        if (!empty($data)) {

            $data['User']['featured'] = unserialize($data['User']['featured']);
            if (!empty($data['User']['featured'])) {

                foreach ($data['User']['featured'] as $value) {
                    @unlink(ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'uploads' . DS . $value);
                    $value = @preg_replace("/\./i", "_150.", $value);
                    @unlink(ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'uploads' . DS . $value);
                }
            }

            if (!empty($data['User']['image'])) {
                $value = $data['User']['image'];
                @unlink(ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'uploads' . DS . $value);
                $value = @preg_replace("/\./i", "_150.", $value);
                @unlink(ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'uploads' . DS . $value);
            }
        }

        $this->User->delete($id);
        exit;
    }

    
    public function profile () {
        
    }
}
?>
