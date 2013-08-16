<?php

class ProductController extends AdminAppController {

    protected $error = array(
        'error' => 0,
        'element' => '',
        'message' => '',
        'data' => ''
    );

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

        $conditions = array("type" => "product");

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

                    if ($value['Product']['type'] == 'product') {
                        $value['Product']['featured'] = unserialize($value['Product']['featured']);
                        $value['Product']['image'] = count($value['Product']['featured']) > 0 ? $value['Product']['featured'][0] : "";
                        $value['Product']['image'] = "product/" . $value['Product']['image'];
                    } else {
                        $value['Product']['image'] = "template/" . $value['Product']['image'];
                    }

                    $data[$key] = $value;
                }
            }
        }

        //=========================================================

        $pages = ceil($total / $limit);

        $filters = array(
            //"type='template'" => "Template",
            "type='product'" => "Product",
            "quantity=0" => "Empty Stocks"
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

            if (!empty($data['featured'])) {
                $data['featured'] = trim($data['featured'], "-");
                $data['featured'] = serialize(explode("-", $data['featured']));
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

            if ($action == "update" && !empty($data['id'])) {
                $element = $this->Product->find('first', array("conditions" => array("id" => $data['id'])));
                if (!empty($element)) {

                    $data['guid'] = $element['Product']['guid'];
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

            $data['guid'] = uniqid();
            $data['created'] = time();
            $data['modified'] = time();

            $this->Product->create();
            $this->Product->save($data);
            $this->error['data'] = $this->Product->id;

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

            $this->error['element'] = 'input';
            exit(json_encode($this->error));
        }
    }
    
    //================================================================
    // @action: edit
    //================================================================

    public function edit() {
        
        $this->_edit ();  
        
        $guid = $this->request->query("id");
        if (empty($guid)) {
            $this->redirect ("/admin/product");
        }

        $data = $this->Product->find('first', array("conditions" => array("guid" => $guid)));
        $data = $data['Product'];

        if (!empty($data)) {
            $data['featured'] = unserialize($data['featured']);
            $data['featured2'] = $data['featured'];
            if (!empty($data['featured'])) {
                $data['featured'] = implode("-", $data['featured']);
            } else {
                $data['featured'] = "";
            }
            $data['created'] = date("F j, Y, g:i a", $data['created']);
            $data['modified'] = date("F j, Y, g:i a", $data['modified']);
        }

        $this->set(array ('data' => $data));
    }
    
    protected function _edit ()
    {
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

            if (!empty($data['featured'])) {
                $data['featured'] = trim($data['featured'], "-");
                $data['featured'] = serialize(explode("-", $data['featured']));
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
            if ($action == "update" && !empty($data['guid'])) {
                $element = $this->Product->find('first', array("conditions" => array("guid" => $data['guid'])));
              
                if (!empty($element)) {

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

            $data['Product']['featured'] = unserialize($data['Product']['featured']);
            if (!empty($data['Product']['featured'])) {

                foreach ($data['Product']['featured'] as $value) {
                    @unlink(ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'uploads' . DS . "product" . DS . $value);
                    $value = @preg_replace("/\./i", "_150.", $value);
                    @unlink(ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'uploads' . DS . "product" . DS . $value);
                }
            }

            if (!empty($data['Product']['image'])) {
                $value = $data['Product']['image'];
                @unlink(ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'uploads' . DS . "template" . DS . $value);
                $value = @preg_replace("/\./i", "_150.", $value);
                @unlink(ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'uploads' . DS . "template" . DS . $value);
            }
        }

        $this->Product->delete($id);
        exit;
    }
    
    //======================================================
    public function install() {

        $templates = array (
            "iphone5" => array (
                "name" => "iphone5",
                "description" => "iphone5 case",
                "price" => "34.99",
                "image" => array (
                    "foreground" => "iphone5_fg.png",
                    "background" => "iphone5_bg.png",
                ),
                "type" => "template",
                "status" => "published",
                "quantity" => 65535
            )
        );
        
        $this->loadModel("Product");
        $this->Product->query ("DELETE FROM products WHERE type='template'");
        foreach ($templates as $template) {
            $template['guid'] = uniqid();
            $template['created'] = time();
            $template['modified'] = time();
            $template['image'] = serialize($template['image']);
            $this->Product->create ();
            $this->Product->save ($template);
        }
        
        $this->autoRender = false;
                
        $this->redirect (array ("plugin" => "admin", "controller" => "product", "action" => "index"));
        echo "Successfully all templates created";
        
    }

}

?>
