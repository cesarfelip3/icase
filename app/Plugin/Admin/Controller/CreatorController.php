<?php

class CreatorController extends AdminAppController {

    protected $error = array(
        'error' => 0,
        'element' => '',
        'message' => '',
        'data' => ''
    );

    public function beforeFilter() {
        $this->Auth->deny();
        $this->Auth->allow('install');
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

        $conditions = array("type" => "template");

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
        $this->loadModel('Product');
        $total = $this->Product->find("count", array("conditions" => $conditions));

        if ($total <= 0) {
            $data = array();
        } else {
            $data = $this->Product->find('all', array(
                'limit' => $limit,
                'page' => $page + 1,
                'conditions' => $conditions,
                'fields' => array("Product.*")
                    )
            );
            foreach ($data as $key => $value) {

                if ($value['Product']['type'] == 'product') {
                    $value['Product']['featured'] = unserialize($value['Product']['featured']);
                    $value['Product']['image'] = count($value['Product']['featured']) > 0 ? $value['Product']['featured']['150w'][0] : "";
                    $value['Product']['image'] = $this->webroot . "uploads/product/" . $value['Product']['image'];
                } else {
                    $images = unserialize($value['Product']['image']);
                    $value['Product']['image'] = $this->webroot . "img/template/" . $images['background'];
                }

                $data[$key] = $value;
            }
        }

        //=========================================================

        $pages = ceil($total / $limit);

        $filters = array(
                //"type='template'" => "Template",
                //"type='product'" => "Product",
                //"quantity=0" => "Empty Stocks"
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

        $guid = uniqid();
        $this->set ('guid', $guid);
        
        if ($this->request->is('ajax') && $this->request->is('post')) {
            $this->autoRender = false;

            $data = $this->request->data('product');
            $category = $this->request->data('category');
            $action = $this->request->query('action');

            if (empty($data['name'])) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="product[name]"]';
                $this->error['message'] = 'Product name is required';
                exit(json_encode($this->error));
            }

            if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['price']) == false) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="product[price]"]';
                $this->error['message'] = 'Invalid price number';
                exit(json_encode($this->error));
            }

            if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['tax']) == false) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="product[tax]"]';
                $this->error['message'] = 'Invalid tax number';
                exit(json_encode($this->error));
            }

            if (preg_match("/^[0-9]{1,2}$/i", $data['discount']) == false) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="product[discount]"]';
                $this->error['message'] = 'Invalid discount number';
                exit(json_encode($this->error));
            }

            $is_special = 0;
            if (isset($data['is_special'])) {
                $is_special = 1;
                if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['special_price']) == false) {
                    $this->error['error'] = 1;
                    $this->error['element'] = 'input[name="product[special_price]"]';
                    $this->error['message'] = 'Invalid special price number';
                    exit(json_encode($this->error));
                }
            }

            if (empty($data['slug'])) {
                $data['slug'] = preg_replace("/ +/i", "-", $data['name']);
            } else {
                $data['slug'] = preg_replace("/ +/i", "-", $data['slug']);
            }

            $data['type'] = "template";
            $data['status'] = isset($data['status']) ? $data['status'] : 'draft';
            $data['is_featured'] = 0;

            if (!empty($data['image'])) {
                $data['image'] = serialize($data['image']);
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

            $data['guid'] = $data['guid'];
            $data['created'] = time();
            $data['modified'] = time();

            $this->Product->create();
            $this->Product->save($data);
            
            
            $this->error['data'] = $this->Product->id;
            $this->error['element'] = 'input';
            exit(json_encode($this->error));
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

            if ($data['type'] == 'product') {
                $data['featured'] = unserialize($data['featured']);
                $data['featured2'] = $data['featured'];
                if (!empty($data['featured'])) {
                    $data['featured'] = implode("-", $data['featured']['origin']);
                } else {
                    $data['featured'] = "";
                }
            } else {
                $images = unserialize($data['image']);
                $data['image'] = array ();
                $data['image']['foreground'] = $this->webroot . "img/template/" . $images['foreground'];
                $data['image']['background'] = $this->webroot . "img/template/" . $images['background'];
            }

            $data['created'] = date("F j, Y, g:i a", $data['created']);
            $data['modified'] = date("F j, Y, g:i a", $data['modified']);
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
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="product[name]"]';
                $this->error['message'] = 'Product name is required';
                exit(json_encode($this->error));
            }

            if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['price']) == false) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="product[price]"]';
                $this->error['message'] = 'Invalid price number';
                exit(json_encode($this->error));
            }

            if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['tax']) == false) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="product[tax]"]';
                $this->error['message'] = 'Invalid tax number';
                exit(json_encode($this->error));
            }

            if (preg_match("/^[0-9]{1,2}$/i", $data['discount']) == false) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="product[discount]"]';
                $this->error['message'] = 'Invalid discount number';
                exit(json_encode($this->error));
            }

            $is_special = 0;
            if (isset($data['is_special'])) {
                $is_special = 1;
                if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['special_price']) == false) {
                    $this->error['error'] = 1;
                    $this->error['element'] = 'input[name="product[special_price]"]';
                    $this->error['message'] = 'Invalid special price number';
                    exit(json_encode($this->error));
                }
            }

            if (empty($data['slug'])) {
                $data['slug'] = preg_replace("/ +/i", "-", $data['name']);
            } else {
                $data['slug'] = preg_replace("/ +/i", "-", $data['slug']);
            }

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
            if ($action == "update" && !empty($data['guid'])) {
                $element = $this->Product->find('first', array("conditions" => array("guid" => $data['guid'])));

                $data['featured'] = "";
                unset($data['image']);
                
                if (!empty($element)) {

                    if (!empty($data['featured'])) {
                        $data['featured'] = trim($data['featured'], "-");
                        $images = explode("-", $data['featured']);

                        $data['featured'] = array();
                        $data['featured']['origin'] = $images;

                        $data['featured']['150w'] = array();

                        foreach ($images as $value) {
                            $data['featured']['150w'][] = str_replace(".", "_150.", $value);
                        }

                        $data['featured'] = serialize($data['featured']);

                        if ($data['featured'] == $element['Product']['featured']) {
                            unset($data['featured']);
                        } else {
                            
                        }
                    }


                    $data['modified'] = time();
                    $this->Product->id = $data['id'];
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
                    exit(json_encode($this->error));
                }

                $this->error['error'] = 1;
                $this->error['message'] = "The Product doesn't exist anymore";
                $this->error['element'] = "";
                exit(json_encode($this->error));
            }

            $this->error['error'] = 1;
            $this->error['message'] = "wrong action";
            exit(json_encode($this->error));
        }
    }

    //===========================================================
    //
    //===========================================================

    public function delete() {
        $id = $this->request->query('id');
        $this->loadModel('Product');

        $data = $this->Product->find('first', array("conditions" => array("id" => $id)));
        if (!empty($data)) {
            
            if (!empty($data['Product']['image'])) {
                $images = unserialize($data['Product']['image']);
                
                if (file_exists(APP . 'webroot' . DS . 'img' . DS . "template" . DS . $images['background'])) {
                    @unlink(APP . 'webroot' . DS . 'img' . DS . "template" . DS . $images['background']);
                }
                
                if (file_exists(APP . 'webroot' . DS . 'img' . DS . "template" . DS . $images['foreground'])) {
                    @unlink(APP . 'webroot' . DS . 'img' . DS . "template" . DS . $images['foreground']);
                }
            }
        }

        $this->Product->delete($id);
        exit(json_encode($this->error));
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
            "Bottle 17oz" => array(
                "name" => "Bottle 17oz",
                "description" => "Bottle 17oz Steel",
                "price" => "34.99",
                "image" => array(
                    "foreground" => "bottle17oz_steel_fg.png",
                    "background" => "bottle17oz_steel_bg.png",
                ),
                "type" => "template",
                "status" => "published",
                "quantity" => 65535,
                "order" => 5,
            ),
            "Mug" => array(
                "name" => "Mug",
                "description" => "Mug 11oz Ceramic",
                "price" => "34.99",
                "image" => array(
                    "foreground" => "Mug 11oz Ceramic-outer.png",
                    "background" => "Mug 11oz Ceramic-inner.png",
                ),
                "type" => "template",
                "status" => "published",
                "quantity" => 65535,
                "order" => 6
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

    public function repair() {
        exit;

        $this->loadModel('Product');

        $data = $this->Product->find('all', array("conditions" => array("type" => "product")));

        $image = array();

        //print_r ($data);

        foreach ($data as $value) {

            $value['Product']['featured'] = unserialize($value['Product']['featured']);

            if (!empty($value['Product']['featured'])) {

                $origin = null;
                $w150 = null;

                $origin = array();
                $w150 = array();

                $images = $value['Product']['featured'];

                foreach ($images as $key => $val) {
                    $origin[] = $val;
                    $w150[] = str_replace(".", "_150.", $val);
                }
            }


            $image = array(
                "origin" => $origin,
                "150w" => $w150
            );

            print_r($image);

            $this->Product->id = $value['Product']['id'];
            $this->Product->set(array('featured' => serialize($image)));
            $this->Product->save();

            $image = null;
        }
    }

}

?>
