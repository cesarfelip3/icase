<?php

class CouponController extends AdminAppController {

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

        $conditions = array("type" => "Coupon");

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
        $this->loadModel('Coupon');
        $total = $this->Coupon->find("count", array("conditions" => $conditions));

        if ($total <= 0) {
            $data = array();
        } else {
            $data = $this->Coupon->find('all', array(
                'limit' => $limit,
                'page' => $page + 1,
                'conditions' => $conditions,
                'fields' => array("Coupon.*")
                    )
            );

            foreach ($data as $key => $value) {

                if ($value['Coupon']['type'] == 'Coupon') {
                    $value['Coupon']['featured'] = unserialize($value['Coupon']['featured']);
                    $value['Coupon']['image'] = count($value['Coupon']['featured']) > 0 ? $value['Coupon']['featured']['150w'][0] : "";
                    $value['Coupon']['image'] = $this->webroot . "uploads/Coupon/" . $value['Coupon']['image'];
                } else {
                    $images = unserialize($value['Coupon']['image']);
                    $value['Coupon']['image'] = $this->webroot . "img/template/" . $images['foreground'];
                }

                $data[$key] = $value;
            }
        }

        //=========================================================

        $pages = ceil($total / $limit);

        $filters = array(
            //"type='template'" => "Template",
            //"type='Coupon'" => "Coupon",
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

            $data = $this->request->data('Coupon');
            $category = $this->request->data('category');
            $action = $this->request->query('action');

            if (empty($data['name'])) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="Coupon[name]"]';
                $this->error['message'] = 'Coupon name is required';
                exit(json_encode($this->error));
            }

            if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['price']) == false) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="Coupon[price]"]';
                $this->error['message'] = 'Invalid price number';
                exit(json_encode($this->error));
            }

            if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['tax']) == false) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="Coupon[tax]"]';
                $this->error['message'] = 'Invalid tax number';
                exit(json_encode($this->error));
            }

            if (preg_match("/^[0-9]{1,2}$/i", $data['discount']) == false) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="Coupon[discount]"]';
                $this->error['message'] = 'Invalid discount number';
                exit(json_encode($this->error));
            }

            $is_special = 0;
            if (isset($data['is_special'])) {
                $is_special = 1;
                if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['special_price']) == false) {
                    $this->error['error'] = 1;
                    $this->error['element'] = 'input[name="Coupon[special_price]"]';
                    $this->error['message'] = 'Invalid special price number';
                    exit(json_encode($this->error));
                }
            }

            if (empty($data['slug'])) {
                $data['slug'] = preg_replace("/ +/i", "-", $data['name']);
            } else {
                $data['slug'] = preg_replace("/ +/i", "-", $data['slug']);
            }

            $data['type'] = isset($data['type']) ? $data['type'] : 'Coupon';
            $data['status'] = isset($data['status']) ? $data['status'] : 'draft';
            $data['is_featured'] = isset($data['is_featured']) ? 1 : 0;

            if (!empty($data['featured'])) {
                $data['featured'] = trim($data['featured'], "-");
                $images = explode("-", $data['featured']);

                $data['featured'] = array();
                $data['featured']['origin'] = $images;
                $data['image'] = $images[0];
                
                $data['featured']['150w'] = array();

                foreach ($images as $value) {
                    $data['featured']['150w'][] = str_replace(".", "_150.", $value);
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

            $this->loadModel('Coupon');

            if ($action == "update" && !empty($data['id'])) {
                $element = $this->Coupon->find('first', array("conditions" => array("id" => $data['id'])));
                if (!empty($element)) {

                    $data['guid'] = $element['Coupon']['guid'];
                    $data['modified'] = time();
                    $this->Coupon->id = $data['id'];
                    $this->Coupon->set($data);
                    $this->Coupon->save();

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
                $this->error['message'] = "The Coupon doesn't exist anymore";
                $this->error['element'] = "";
                exit(json_encode($this->error));
            }

            $data['guid'] = uniqid();
            $data['created'] = time();
            $data['modified'] = time();

            $this->Coupon->create();
            $this->Coupon->save($data);
            $this->error['data'] = $this->Coupon->id;

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

        $this->loadModel('Coupon');
        $this->_edit();

        $guid = $this->request->query("id");
        if (empty($guid)) {
            $this->redirect("/admin/Coupon");
        }

        $data = $this->Coupon->find('first', array("conditions" => array("guid" => $guid)));
        $data = $data['Coupon'];

        if (!empty($data)) {
            $data['featured'] = unserialize($data['featured']);
            $data['featured2'] = $data['featured'];
            if (!empty($data['featured'])) {
                $data['featured'] = implode("-", $data['featured']['origin']);
            } else {
                $data['featured'] = "";
            }

            $data['created'] = date("F j, Y, g:i a", $data['created']);
            $data['modified'] = date("F j, Y, g:i a", $data['modified']);
        }

        $this->set(array('data' => $data));
    }

    protected function _edit() {
        if ($this->request->is('ajax') && $this->request->is('post')) {
            $this->autoRender = false;

            $data = $this->request->data('Coupon');
            $category = $this->request->data('category');
            $action = $this->request->query('action');

            if (empty($data['name'])) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="Coupon[name]"]';
                $this->error['message'] = 'Coupon name is required';
                exit(json_encode($this->error));
            }

            if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['price']) == false) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="Coupon[price]"]';
                $this->error['message'] = 'Invalid price number';
                exit(json_encode($this->error));
            }

            if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['tax']) == false) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="Coupon[tax]"]';
                $this->error['message'] = 'Invalid tax number';
                exit(json_encode($this->error));
            }

            if (preg_match("/^[0-9]{1,2}$/i", $data['discount']) == false) {
                $this->error['error'] = 1;
                $this->error['element'] = 'input[name="Coupon[discount]"]';
                $this->error['message'] = 'Invalid discount number';
                exit(json_encode($this->error));
            }

            $is_special = 0;
            if (isset($data['is_special'])) {
                $is_special = 1;
                if (preg_match("/^[0-9]{1,}\.?[0-9]{0,2}$/i", $data['special_price']) == false) {
                    $this->error['error'] = 1;
                    $this->error['element'] = 'input[name="Coupon[special_price]"]';
                    $this->error['message'] = 'Invalid special price number';
                    exit(json_encode($this->error));
                }
            }

            if (empty($data['slug'])) {
                $data['slug'] = preg_replace("/ +/i", "-", $data['name']);
            } else {
                $data['slug'] = preg_replace("/ +/i", "-", $data['slug']);
            }

            $data['type'] = isset($data['type']) ? $data['type'] : 'Coupon';
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

            $this->loadModel('Coupon');
            if ($action == "update" && !empty($data['guid'])) {
                $element = $this->Coupon->find('first', array("conditions" => array("guid" => $data['guid'])));

                if (!empty($element)) {

                    if (!empty($data['featured'])) {
                        $data['featured'] = trim($data['featured'], "-");
                        $images = explode("-", $data['featured']);

                        $data['featured'] = array();
                        $data['featured']['origin'] = $images;
                        $data['image'] = $images[0];
                        
                        $data['featured']['150w'] = array();

                        foreach ($images as $value) {
                            $data['featured']['150w'][] = str_replace(".", "_150.", $value);
                        }

                        $data['featured'] = serialize($data['featured']);

                        if ($data['featured'] == $element['Coupon']['featured']) {
                            unset($data['featured']);
                        } else {
                            
                        }
                    }


                    $data['modified'] = time();
                    $this->Coupon->id = $data['id'];
                    $this->Coupon->set($data);
                    $this->Coupon->save();

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
                $this->error['message'] = "The Coupon doesn't exist anymore";
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
        $this->loadModel('Coupon');

        $data = $this->Coupon->find('first', array("conditions" => array("id" => $id, 'type' => 'Coupon')));
        if (!empty($data)) {

            if (!empty($data['Coupon']['featured'])) {

                $data['Coupon']['featured'] = unserialize($data['Coupon']['featured']);
                foreach ($data['Coupon']['featured']['origin'] as $value) {
                    if (file_exists(APP . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'uploads' . DS . "Coupon" . DS . $value)) {
                        @unlink(APP . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'uploads' . DS . "Coupon" . DS . $value);
                        $value = @str_replace(".", "_150.", $value);
                        @unlink(APP . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'uploads' . DS . "Coupon" . DS . $value);
                    }
                }
            }
        }

        $this->Coupon->delete($id);
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

        $this->loadModel("Coupon");
        $this->Coupon->query("DELETE FROM Coupons WHERE type='template'");
        foreach ($templates as $template) {
            $template['guid'] = uniqid();
            $template['created'] = time();
            $template['modified'] = time();
            $template['image'] = serialize($template['image']);
            $this->Coupon->create();
            $this->Coupon->save($template);
        }

        $this->autoRender = false;

        $this->redirect(array("plugin" => "admin", "controller" => "Coupon", "action" => "index"));
        echo "Successfully all templates created";
    }

    public function repair() {
        exit;

        $this->loadModel('Coupon');

        $data = $this->Coupon->find('all', array("conditions" => array("type" => "Coupon")));

        $image = array();

        //print_r ($data);

        foreach ($data as $value) {

            $value['Coupon']['featured'] = unserialize($value['Coupon']['featured']);

            if (!empty($value['Coupon']['featured'])) {

                $origin = null;
                $w150 = null;

                $origin = array();
                $w150 = array();

                $images = $value['Coupon']['featured'];

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

            $this->Coupon->id = $value['Coupon']['id'];
            $this->Coupon->set(array('featured' => serialize($image)));
            $this->Coupon->save();

            $image = null;
        }
    }

}

?>
