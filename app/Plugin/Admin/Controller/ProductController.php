<?php

class ProductController extends AdminAppController {

    protected $media_location_main;
    protected $media_location_product;

    public function beforeFilter() {
        $this->Auth->deny();
        $this->Auth->allow('install');
        parent::beforeFilter();

        $this->media_location_main = WWW_ROOT . $this->_media_location['main'];
        $this->media_location_product = WWW_ROOT . $this->_media_location['product'];
    }

    public function index() {

        $page = $this->request->data('page');
        $limit = $this->request->data('limit');

        if (empty($limit)) {
            $limit = 25;
        }

        if (empty($page)) {
            $page = 0;
        }

        if ($page < 0) {
            $page = 0;
        }

        $keyword = $this->request->data('keyword');
        $filter = $this->request->data('filter');

        $start = $this->request->data('start');
        $end = $this->request->data('end');

        $filter_categories = $this->request->data('category');

        $conditions = array("Product.type" => "product");

        if (!empty($start) && !empty($end)) {
            $duration = array(
                "AND" => array(
                    array("Product.created >=" => strtotime($start)),
                    array("Product.created <=" => strtotime($end))
            ));
            $conditions = array_merge($conditions, $duration);
        }

        if (!empty($keyword)) {
            $search = array(
                "OR" => array(
                    array("Product.name LIKE " => "%" . $keyword . "%"),
                    array("Product.description LIKE " => "%" . $keyword . "%"))
            );
            $conditions = array_merge($conditions, $search);
        }

        if (!empty($filter)) {
            $conditions = array($conditions, array($filter));
        }

        $categories = array();

        if (!empty($filter_categories)) {
            $filter_categories = json_decode($filter_categories);
            foreach ($filter_categories as $value) {
                if (!empty($value->id)) {
                    $categories['CategoryToObject.category_guid'][] = $value->id;
                }
            }
        } else {
            $filter_categories = "";
        }

        if (!empty($categories)) {
            $conditions = array_merge($conditions, $categories);

            $this->loadModel('Product');

            $data = $this->Product->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'category_to_object',
                        'alias' => 'CategoryToObject',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('CategoryToObject.object_guid = Product.guid')
                    ),
                ),
                'conditions' => $conditions,
                'order' => 'modified DESC',
                'limit' => $limit,
                'page' => $page + 1,
                'fields' => array("Product.*")
            ));

            //$this->Product->_debug ();

            $total = $this->Product->find('count', array(
                'joins' => array(
                    array(
                        'table' => 'category_to_object',
                        'alias' => 'CategoryToObject',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('CategoryToObject.object_guid = Product.guid')
                    ),
                ),
                'conditions' => $conditions)
            );

            $this->set('filter_categories', $filter_categories);
        } else {
            $this->loadModel('Product');
            $total = $this->Product->find("count", array("conditions" => $conditions));

            if ($total <= 0) {
                $data = array();
            } else {
                $data = $this->Product->find('all', array(
                    'limit' => $limit,
                    'page' => $page + 1,
                    'conditions' => $conditions,
                    'order' => 'modified DESC',
                    'fields' => array("Product.*")
                        )
                );
            }
        }

        foreach ($data as $key => $value) {

            if ($value['Product']['type'] == 'product') {
                $value['Product']['featured'] = unserialize($value['Product']['featured']);
                $value['Product']['image'] = $value['Product']['featured'][0];

                $filename = pathinfo($value['Product']['image'], PATHINFO_FILENAME);
                $small = $filename . "_small.png";
                $value['Product']['image'] = $this->webroot . $this->_media_location['product'] . $small;
            }

            $data[$key] = $value;
        }

        //=========================================================

        $pages = ceil($total / $limit);

        $filters = array(
            //"type='template'" => "Template",
            //"type='product'" => "Product",
            "quantity=0" => "Empty Stocks"
        );

        $header = array(
            "name" => "Name",
            "type" => "Type",
            "image" => "Picture",
            "price" => "Price",
            "quantity" => "Quantity",
            "created" => "Created",
            "modified" => "Modified"
        );

        $this->set(array(
            "header" => $header,
            "data" => $data,
            "page" => $page,
            "limit" => $limit,
            "pages" => $pages,
            "keyword" => $keyword,
            "start" => $start,
            "end" => $end,
            "filter" => $filter,
            "filters" => $filters,
            "filter_categories" => empty ($filter_categories) ? $filter_categories : json_encode($filter_categories),
        ));
    }

    public function add() {

        if ($this->request->is('ajax') && $this->request->is('post')) {
            $this->autoRender = false;

            $data = $this->request->data('product');
            $category = $this->request->data('category');
            $action = $this->request->query('action');

            if (empty($data['name'])) {
                $this->_error['error'] = 1;
                $this->_error['element'] = 'input[name="product[name]"]';
                $this->_error['message'] = 'Product name is required';
                exit(json_encode($this->_error));
            }

            if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['price']) == false) {
                $this->_error['error'] = 1;
                $this->_error['element'] = 'input[name="product[price]"]';
                $this->_error['message'] = 'Invalid price number';
                exit(json_encode($this->_error));
            }

            if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['tax']) == false) {
                $this->_error['error'] = 1;
                $this->_error['element'] = 'input[name="product[tax]"]';
                $this->_error['message'] = 'Invalid tax number';
                exit(json_encode($this->_error));
            }

            if (preg_match("/^[0-9]{1,2}$/i", $data['discount']) == false) {
                $this->_error['error'] = 1;
                $this->_error['element'] = 'input[name="product[discount]"]';
                $this->_error['message'] = 'Invalid discount number';
                exit(json_encode($this->_error));
            }

            $is_special = 0;
            if (isset($data['is_special'])) {
                $is_special = 1;
                if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['special_price']) == false) {
                    $this->_error['error'] = 1;
                    $this->_error['element'] = 'input[name="product[special_price]"]';
                    $this->_error['message'] = 'Invalid special price number';
                    exit(json_encode($this->_error));
                }
            }

            $data['slug'] = trim($data['slug']);
            $data['name'] = trim($data['name']);
            if (empty($data['slug'])) {
                $data['slug'] = preg_replace("/ +/i", "-", $data['name']);
            } else {
                $data['slug'] = preg_replace("/ +/i", "-", $data['slug']);
            }

            $data['slug'] = @preg_replace("/\/+/i", "-", $data['slug']);


            $data['type'] = isset($data['type']) ? $data['type'] : 'product';
            $data['status'] = isset($data['status']) ? $data['status'] : 'draft';
            $data['is_featured'] = isset($data['is_featured']) ? 1 : 0;

            if (!empty($data['featured'])) {
                $data['featured'] = trim($data['featured'], "-");
                $images = explode("-", $data['featured']);

                $data['featured'] = $images;
                $data['image'] = $images[0];

                foreach ($images as $value) {

                    $filename = pathinfo($value, PATHINFO_FILENAME);
                    $small = $filename . "_small.png";
                    $medium = $filename . "_medium.png";

                    @copy($this->media_location_main . $value, $this->media_location_product . $value);
                    @copy($this->media_location_main . $small, $this->media_location_product . $small);
                    @copy($this->media_location_main . $medium, $this->media_location_product . $medium);
                }

                $data['featured'] = serialize($data['featured']);
            }

            if ($is_special == 1) {

                $special = array(
                    "is_special" => 1,
                    "special_price" => $data['special_price'],
                    "special_start" => strtotime($data['special_start']),
                    "special_end" => strtotime($data['special_end'])
                );

                $data = array_merge($data, $special);
            }

            $this->loadModel('Product');

            $data['guid'] = uniqid();
            $data['created'] = time();
            $data['modified'] = time();

            $this->Product->create();
            $this->Product->save($data);
            $id = $this->Product->id;

            $data['slug'] = trim($data['slug'], "-");
            $data['slug'] = $data['slug'] . "-P" . $id;
            $this->Product->set(array("slug" => $data['slug']));
            $this->Product->save();

            $this->_error['data'] = $this->Product->id;

            if (!empty($category)) {

                $this->loadModel('CategoryToObject');

                foreach ($category as $value) {
                    $c[] = array(
                        "category_guid" => $value,
                        "object_guid" => $data['guid']
                    );
                }

                $this->CategoryToObject->create();
                $this->CategoryToObject->saveMany($c);
            }

            $this->_error['element'] = 'input';
            exit(json_encode($this->_error));
        }
    }

    //================================================================
    // @action: edit
    //================================================================

    public function edit() {

        $this->loadModel('Product');
        $this->_edit();

        $guid = $this->request->query("id");
        if (empty($guid)) {
            $this->redirect("/admin/product");
        }

        $data = $this->Product->find('first', array("conditions" => array("guid" => $guid)));
        $data = $data['Product'];

        if (!empty($data)) {
            $data['featured'] = unserialize($data['featured']);
            $data['featured2'] = array();

            foreach ($data['featured'] as $key => $image) {
                $data['featured2'][$key]['image'] = $image;
                $data['featured2'][$key]['url'] = $this->webroot . $this->_media_location['product'] . pathinfo($image, PATHINFO_FILENAME) . "_small.png";
            }

            if (!empty($data['featured'])) {
                $data['featured'] = implode("-", $data['featured']);
            } else {
                $data['featured'] = "";
            }

            $data['created'] = date("F j, Y, g:i a", $data['created']);
            $data['modified'] = date("F j, Y, g:i a", $data['modified']);
        }

        $id = $data['id'];
        if (preg_match("/\-P$id/", trim($data['slug']))) {
            $data['slug'] = str_replace("-P" . $data['id'], "", $data['slug']);
        }

        $this->set(array('data' => $data));
    }

    protected function _edit() {
        if ($this->request->is('ajax') && $this->request->is('post')) {
            $this->autoRender = false;

            $data = $this->request->data('product');
            $category = $this->request->data('category');
            $action = $this->request->query('action');

            if (empty($data['name'])) {
                $this->_error['error'] = 1;
                $this->_error['element'] = 'input[name="product[name]"]';
                $this->_error['message'] = 'Product name is required';
                exit(json_encode($this->_error));
            }

            if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['price']) == false) {
                $this->_error['error'] = 1;
                $this->_error['element'] = 'input[name="product[price]"]';
                $this->_error['message'] = 'Invalid price number';
                exit(json_encode($this->_error));
            }

            if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['tax']) == false) {
                $this->_error['error'] = 1;
                $this->_error['element'] = 'input[name="product[tax]"]';
                $this->_error['message'] = 'Invalid tax number';
                exit(json_encode($this->_error));
            }

            if (preg_match("/^[0-9]{1,2}$/i", $data['discount']) == false) {
                $this->_error['error'] = 1;
                $this->_error['element'] = 'input[name="product[discount]"]';
                $this->_error['message'] = 'Invalid discount number';
                exit(json_encode($this->_error));
            }

            $is_special = 0;
            if (isset($data['is_special'])) {
                $is_special = 1;
                if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['special_price']) == false) {
                    $this->_error['error'] = 1;
                    $this->_error['element'] = 'input[name="product[special_price]"]';
                    $this->_error['message'] = 'Invalid special price number';
                    exit(json_encode($this->_error));
                }
            }

            $data['slug'] = trim($data['slug']);
            $data['name'] = trim($data['name']);
            if (empty($data['slug'])) {
                $data['slug'] = @preg_replace("/ +/i", "-", $data['name']);
            } else {
                $data['slug'] = @preg_replace("/ +/i", "-", $data['slug']);
            }

            $data['slug'] = @preg_replace("/\/+/i", "-", $data['slug']);

            $data['type'] = isset($data['type']) ? $data['type'] : 'product';
            $data['status'] = isset($data['status']) ? $data['status'] : 'draft';
            $data['is_featured'] = isset($data['is_featured']) ? 1 : 0;
            if ($is_special == 1) {

                $special = array(
                    "is_special" => 1,
                    "special_price" => $data['special_price'],
                    "special_start" => strtotime($data['special_start']),
                    "special_end" => strtotime($data['special_end'])
                );

                $data = array_merge($data, $special);
            }

            $this->loadModel('Product');
            if (!empty($data['guid'])) {

                $element = $this->Product->find('first', array("conditions" => array("guid" => $data['guid'])));

                if (!empty($element)) {

                    if (!empty($data['featured'])) {
                        $data['featured'] = trim($data['featured'], "-");
                        $images = explode("-", $data['featured']);

                        if (serialize($images) == $element['featured']) {
                            
                        } else {

                            $data['featured'] = $images;
                            $data['image'] = $images[0];

                            foreach ($images as $value) {

                                $filename = pathinfo($value, PATHINFO_FILENAME);
                                $small = $filename . "_small.png";
                                $medium = $filename . "_medium.png";

                                @copy($this->media_location_main . $value, $this->media_location_product . $value);
                                @copy($this->media_location_main . $small, $this->media_location_product . $small);
                                @copy($this->media_location_main . $medium, $this->media_location_product . $medium);
                            }

                            if (!empty($element['Product']['featured'])) {
                                $images = unserialize($element['Product']['featured']);
                                foreach ($images as $value) {
                                    $this->media_location_product = WWW_ROOT . $this->_media_location['product'];
                                    $filename = pathinfo($value, PATHINFO_FILENAME);
                                    $small = $filename . "_small.png";
                                    $medium = $filename . "_medium.png";

                                    @unlink($this->media_location_product . $value);
                                    @unlink($this->media_location_product . $small);
                                    @unlink($this->media_location_product . $medium);
                                }
                            }

                            $data['featured'] = serialize($data['featured']);
                        }
                    }

                    $data['modified'] = time();
                    $this->Product->id = $data['id'];

                    $data['slug'] = trim($data['slug'], "-");
                    $data['slug'] = $data['slug'] . "-P" . $data['id'];
                    unset($data['id']);
                    $this->Product->set($data);
                    $this->Product->save();

                    if (!empty($category)) {
                        $this->loadModel('CategoryToObject');
                        $this->CategoryToObject->query("DELETE FROM category_to_object WHERE object_guid='{$data['guid']}'");

                        foreach ($category as $value) {
                            $c[] = array(
                                "category_guid" => $value,
                                "object_guid" => $data['guid']
                            );
                        }

                        $this->CategoryToObject->create();
                        $this->CategoryToObject->saveMany($c);
                    } else {
                        $this->loadModel('CategoryToObject');
                        $this->CategoryToObject->query("DELETE FROM category_to_object WHERE object_guid='{$data['guid']}'");
                    }
                    exit(json_encode($this->_error));
                }

                $this->_error['error'] = 1;
                $this->_error['message'] = "The Product doesn't exist anymore";
                $this->_error['element'] = "";
                exit(json_encode($this->_error));
            }

            $this->_error['error'] = 1;
            $this->_error['message'] = "wrong action";
            exit(json_encode($this->_error));
        }
    }

    //===========================================================
    //
    //===========================================================

    public function delete() {
        $id = $this->request->query('id');
        $this->loadModel('Product');

        $data = $this->Product->find('first', array("conditions" => array("id" => $id, 'type' => 'product')));
        if (!empty($data)) {

            if (!empty($data['Product']['featured'])) {

                $data['Product']['featured'] = unserialize($data['Product']['featured']);
                foreach ($data['Product']['featured']['origin'] as $value) {
                    if (file_exists(APP . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'uploads' . DS . "product" . DS . $value)) {
                        @unlink(APP . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'uploads' . DS . "product" . DS . $value);
                        $value = @str_replace(".", "_150.", $value);
                        @unlink(APP . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'uploads' . DS . "product" . DS . $value);
                    }
                }
            }
        }

        $this->Product->delete($id);
        exit(json_encode($this->_error));
    }

    public function categoryfilter() {

        $level = $this->request->query('level');
        $guid = $this->request->query('id');

        $level = intval($level);

        $this->loadModel('Category');

        if ($level == 0) {
            $conditions = array(
                'level' => $level);
        } else {
            $conditions = array(
                'level' => $level,
                'parent_guid' => $guid);
        }

        $data = $this->Category->find('all', array(
            "conditions" => $conditions,
            "order" => array('order ASC')
        ));

        if (empty($data)) {
            exit("");
        }

        $this->layout = false;
        $this->set('level', $level);
        $this->set('data', $data);
        $this->render("categoryfilter.ajax");
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

    //======================================================
    public function install() {

        $templates = array(
            "iphone5" => array(
                "name" => "iphone5",
                "description" => "iphone5 case",
                "price" => "34.99",
                "image" => array(
                    "foreground" => "iphone5_fg.png",
                    "background" => "iphone5_bg.png",
                ),
                "type" => "template",
                "status" => "published",
                "quantity" => 65535,
                "order" => 0,
            ),
            "iphone4" => array(
                "name" => "iphone4",
                "description" => "iphone4 case",
                "price" => "34.99",
                "image" => array(
                    "foreground" => "iphone4_fg.png",
                    "background" => "iphone4_bg.png",
                ),
                "type" => "template",
                "status" => "published",
                "quantity" => 65535,
                "order" => 1
            ),
            "samsung galaxy 3" => array(
                "name" => "samsung galaxy 3",
                "description" => "iphone5 case",
                "price" => "34.99",
                "image" => array(
                    "foreground" => "samsung galaxy 3-outer.png",
                    "background" => "samsung galaxy 3-inner.png",
                ),
                "type" => "template",
                "status" => "published",
                "quantity" => 65535,
                "order" => 2,
            ),
            "samsung galaxy 4" => array(
                "name" => "samsung galaxy 4",
                "description" => "samsung galaxy 4",
                "price" => "34.99",
                "image" => array(
                    "foreground" => "samsung galaxy 4-outer.png",
                    "background" => "samsung galaxy 4-inner.png",
                ),
                "type" => "template",
                "status" => "published",
                "quantity" => 65535,
                "order" => 3
            ),
        );

        $this->loadModel("Product");
        $this->Product->query("DELETE FROM products WHERE type='template'");
        foreach ($templates as $template) {
            $template['guid'] = uniqid();
            $template['created'] = time();
            $template['modified'] = time();
            $template['image'] = serialize($template['image']);
            $this->Product->create();
            $this->Product->save($template);
        }

        $this->autoRender = false;

        $this->redirect(array("plugin" => "admin", "controller" => "product", "action" => "index"));
        echo "Successfully all templates created";
    }

}

?>
