<?php
App::uses('AppController', 'Controller');

class CatalogueController extends AppController {

    public $uses = false;
    protected $_error = array(
        "error" => 1,
        "message" => "",
        "files" => array(),
    );
    protected $_stripe = array(
        "secret_key" => "sk_test_t2e5s3XGtntC5eoUU7HNICa1",
        "publishable_key" => "pk_test_wjgM6MXjzv0GNOBeUVFIOVKf"
    );

    public function beforeFilter() {
        $this->Auth->allow();
        parent::beforeFilter();
    }

    public function product() {
        
    }

    public function category($slug) {

        $this->loadModel('Category');
        $guid = $this->Category->findBySlug($slug, array('guid'));

        if (empty($guid)) {
            $this->redirect("/");
            exit;
        }

        if (count($guid) > 1) {
            $guid = $guid[0]['Category']['guid'];
        } else {
            $guid = $guid['Category']['guid'];
        }

        if ($this->request->is('ajax')) {
            $this->layout = false;
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
            
            foreach ($return as $key => $value) {
                if ($value['Category']['guid'] == $guid) {
                    $value['Category']['_active'] = true;
                    $return[$key] = $value;
                    break;
                }
            }
            $this->set ('slug', $slug);
            $this->set ('data', $return);
            $this->render ("category.ajax");
            return;
        }

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
            'conditions' => array(
                "CategoryToObject.category_guid" => $guid
            ),
            'fields' => array("Product.*")
        ));

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $value['Product']['featured'] = unserialize($value['Product']['featured']);
                $data[$key] = $value;
            }
        }

        $this->set ("slug", $slug);
        $this->set("data", $data);
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
}