<?php

App::uses('AppController', 'Controller');

class CatalogueController extends AppController {
    
    public $uses = false;

    public function beforeFilter() {
        $this->Auth->allow();
        parent::beforeFilter();
    }

    public function search($keywords) {
        
        $search = $this->request->query ('search');
        if (!empty ($search)) {
            $keywords = $search;
        }
        
        $keywords = trim($keywords);

        if ($this->request->is('ajax')) {
            if (empty($keywords)) {
                $this->_error['error'] = 1;
                $this->_error['message'] = "Your keywords are empty";
                exit(json_encode($this->_error));
            }

            $keywords = @preg_replace("/ +/i", " ", $keywords);
            $keywords = $keywords;
            $keywords = explode(" ", $keywords);

            if (empty($keywords)) {
                $this->_error['error'] = 1;
                $this->_error['message'] = "Your keywords are empty";
                exit(json_encode($this->_error));
            }

            $this->_error['error'] = 0;
            $this->autoRender = false;
            exit(json_encode($this->_error));
        }
        
        $page = $this->request->query ('page');
        if (empty ($page)) {
            $page = 0;
        } else {
            $page = intval ($page);
        }

        $keywords = @preg_replace("/ +/i", " ", $keywords);
        $keywords = $keywords;
        $keywords = explode(" ", $keywords);

        foreach ($keywords as $keyword) {
            $conditions['or'][] = array('name LIKE' => "%{$keyword}%");
            $conditions['or'][] = array('description LIKE' => "%{$keyword}%");
        }

        $cond = array("AND" => array("type" => "product", $conditions));

        $this->loadModel("Product");

        $data = $this->Product->find('all', array(
            "conditions" => $cond,
            "limit" => 24,
            "page" => $page + 1,
            "order" => "created DESC"
                )
        );
        
        $pages = $this->Product->find('count', array ("conditions" => $cond));

        //$log = $this->Product->getDataSource()->getLog(false, false);
        //print_r ($log);

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $value['Product']['featured'] = unserialize($value['Product']['featured']);
                $data[$key] = $value;
            }
        }

        $set = array (
            "data" => $data,
            "page" => $page,
            "pages" => $pages,
            "limit" => 24
        );
                
        $this->set($set);
    }

    public function product($slug) {

        /*
          $log = $this->Product->getDataSource()->getLog(false, false);
          print_r ($log);
         */
        
        $this->loadModel('Product');

        $data = $this->Product->find('first', array("conditions" => array("slug" => $slug)));

        if (empty($data)) {
            $this->redirect(array ("controller" => "index", "action" => "index"));
        }

        $data = $data['Product'];
        
        $data['featured'] = unserialize($data['featured']);

        $this->set("_title", $this->_meta['_title'] . "|" . $slug);
        $this->set("_description", $data['seo_description']);
        $this->set("data", $data);
    }
    
    public function single ()
    {
       /*
          $log = $this->Product->getDataSource()->getLog(false, false);
          print_r ($log);
         */
        
        $guid = $this->request->query ('id');
        if (empty ($guid)) {
            $this->redirect (array ('controller' => "index", "action" => "index"));
        }
        
        $this->loadModel('Product');

        $data = $this->Product->find('first', array("conditions" => array("guid" => $guid)));

        if (empty($data)) {
            $this->redirect(array ("controller" => "index", "action" => "index"));
        }

        $data = $data['Product'];
        
        $data['featured'] = unserialize($data['featured']);

        $this->set("_title", $this->_meta['_title'] . "|" . $data['name']);
        $this->set("_description", $data['seo_description']);
        $this->set("data", $data);       
    }

    public function category($slug) {

        $this->loadModel('Category');

        $data = $this->Category->find('first', array("conditions" => array("slug" => $slug)));

        if (empty($data)) {
            $this->redirect(array ("controller" => "index", "action" => "index"));
            exit;
        }

        $guid = $data['Category']['guid'];
        if (!empty($data) && $data['Category']['level'] > 0) {
            $parent = $this->Category->find('first', array("conditions" => array("guid" => $data['Category']['parent_guid'])));
            $this->set('breadcrumbs', array(
                $parent,
                $data,
            ));
        }

        if ($this->request->is('ajax')) {
            $this->layout = false;


            /*
              $categories = $this->Category->find('all', array(
              "conditions" => array('level' => 0),
              "order" => array('order ASC')
              )); */

            $categories = $this->Category->find('all', array(
                "conditions" => array('parent_guid' => $guid),
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
            $this->set('slug', $slug);
            $this->set('data', $return);
            $this->render("category.ajax");
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
                "CategoryToObject.category_guid" => $guid,
                "Product.type" => "product",
            ),
            'fields' => array("Product.*")
        ));

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $value['Product']['featured'] = unserialize($value['Product']['featured']);
                $data[$key] = $value;
            }
        }

        $this->set("title", env("SERVER_NAME") . " | Best Mobile Case iphone, galaxy | $slug");
        $this->set("slug", $slug);
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