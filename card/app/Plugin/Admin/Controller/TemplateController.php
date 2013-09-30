<?php

class TemplateController extends AdminAppController {

    protected $media_location_main;
    protected $media_location_template;

    public function beforeFilter() {
        parent::beforeFilter();

        $this->media_location_main = WWW_ROOT . $this->_media_location['main'];
        $this->media_location_template = WWW_ROOT . $this->_media_location['template'];
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

        $filter_category = $this->request->query('filter_category');
        $filter_industry = $this->request->query('filter_industry');
        $filter_subcategory = $this->request->query('filter_subcategory');

        $conditions = array("Template.type" => "template_from_store");

        if (!empty($start) && !empty($end)) {
            $duration = array(
                "AND" => array(
                    array("Template.created >=" => strtotime($start)),
                    array("Template.created <=" => strtotime($end))
            ));
            $conditions = array_merge($conditions, $duration);
        }

        if (!empty($keyword)) {
            $search = array(
                "OR" => array(
                    array("Template.name LIKE " => "%" . $keyword . "%"),
                    array("Template.description LIKE " => "%" . $keyword . "%"))
            );
            $conditions = array_merge($conditions, $search);
        }
        
        if (!empty($filter_subcategory)) {
            $filter_category = $filter_subcategory;
        }

        if (!empty($filter_category)) {
            $conditions = array_merge($conditions, array("category_guid" => $filter_category));
        }

        if (!empty($filter_industry)) {
            $conditions = array_merge($conditions, array("industry_guid" => $filter_industry));
        }

        $this->loadModel('Template');

        $data = $this->Template->find('all', array(
            'conditions' => $conditions,
            'order' => 'modified DESC',
            'limit' => $limit,
            'page' => $page + 1,
            'order' => "modified DESC",
            'fields' => array("guid", "category_guid", "industry_guid", "featured", "thumbnails", "type", "status", "created", "modified", "name", "id")
        ));

        //$this->Template->_debug ();

        $total = $this->Template->find('count', array(
            'conditions' => $conditions)
        );

        foreach ($data as $key => $value) {
            if (!empty($value['Template']['thumbnails'])) {
                $value['Template']['thumbnails'] = unserialize($value['Template']['thumbnails']);
                foreach ($value['Template']['thumbnails'] as $k => $image) {
                    $image = $this->webroot . $this->_media_location['template'] . $image;
                    $value['Template']['thumbnails'][$k] = $image;
                }
                $data[$key] = $value;
            }
        }

        $this->loadModel('Industry');
        $industries = $this->Industry->find('all', array(
            "order" => array("order" => "ASC", "id" => "ASC")
        ));

        $filter_industries = $industries;

        $this->loadModel('Category');
        $categories = $this->Category->find('all', array(
            "conditions" => array("level" => 0),
            "order" => array("order" => "ASC", "id" => "ASC")
        ));

        $filter_categories = $categories;

        //=========================================================

        $pages = ceil($total / $limit);

        $filters = array(
            //"type='template'" => "Template",
            //"type='template'" => "Template",
            "quantity=0" => "Empty Stocks"
        );

        $header = array(
            "name" => "Name",
            "thumbnails" => "Front/Reverse",
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
            "filter_categories" => $filter_categories,
            "filter_industries" => $filter_industries,
            "filter_category" => $filter_category,
            "filter_industry" => $filter_industry
        ));
    }

    public function add() {

        if ($this->request->is('ajax') && $this->request->is('post')) {
            $this->autoRender = false;

            $data = $this->request->data('template');
            $category = $this->request->data('category');
            $action = $this->request->query('action');

            if (empty($data['name'])) {
                $this->_error['error'] = 1;
                $this->_error['element'] = 'input[name="template[name]"]';
                $this->_error['message'] = 'Template name is required';
                exit(json_encode($this->_error));
            }

            if (!preg_match("/^[0-9]{1,}$/i", $data['width'])) {
                $this->_error['error'] = 1;
                $this->_error['element'] = 'input[name="template[width]"]';
                $this->_error['message'] = 'Invalid Width';
                exit(json_encode($this->_error));
            }

            if (!preg_match("/^[0-9]{1,}$/i", $data['height'])) {
                $this->_error['error'] = 1;
                $this->_error['element'] = 'input[name="template[height]"]';
                $this->_error['message'] = 'Invalid Height';
                exit(json_encode($this->_error));
            }

            $data['type'] = 'template_from_store';
            $data['status'] = 'draft';
            $data['is_featured'] = isset($data['is_featured']) ? 1 : 0;

            if (empty($data['industry_guid'])) {
                unset($data['industry_guid']);
            }

            if (!empty($category)) {
                $data['category_guid'] = $category[0];
            }

            unset($data['featured']);

            $this->loadModel('Template');

            $data['guid'] = uniqid();
            $data['created'] = time();
            $data['modified'] = time();

            $this->Template->create();
            $this->Template->save($data);

            $this->_error['data'] = $data['guid'];

            $this->_error['element'] = 'input';
            exit(json_encode($this->_error));
        }

        $this->loadModel('Industry');
        $industries = $this->Industry->find('all', array(
            "order" => array("order" => "ASC", "id" => "ASC")
        ));

        $this->set('industries', $industries);
        $this->set('guid', uniqid());
    }

    //================================================================
    // @action: edit
    //================================================================

    public function edit() {

        $guid = $this->request->query('id');

        if (empty($guid)) {
            
        }

        if ($this->request->is('ajax') && $this->request->is('post')) {
            $this->autoRender = false;

            $data = $this->request->data('template');
            $category = $this->request->data('category');
            $action = $this->request->query('action');

            if (empty($data['name'])) {
                $this->_error['error'] = 1;
                $this->_error['element'] = 'input[name="template[name]"]';
                $this->_error['message'] = 'Template name is required';
                exit(json_encode($this->_error));
            }

            if (!preg_match("/^[0-9]{1,}$/i", $data['width'])) {
                $this->_error['error'] = 1;
                $this->_error['element'] = 'input[name="template[width]"]';
                $this->_error['message'] = 'Invalid Width';
                exit(json_encode($this->_error));
            }

            if (!preg_match("/^[0-9]{1,}$/i", $data['height'])) {
                $this->_error['error'] = 1;
                $this->_error['element'] = 'input[name="template[height]"]';
                $this->_error['message'] = 'Invalid Height';
                exit(json_encode($this->_error));
            }

            $data['type'] = 'template_from_store';
            $data['status'] = 'draft';
            $data['is_featured'] = isset($data['is_featured']) ? 1 : 0;

            if (empty($data['industry_guid'])) {
                unset($data['industry_guid']);
            }

            if (!empty($category)) {
                $data['category_guid'] = $category[0];
            }

            unset($data['featured']);

            $this->loadModel('Template');
            $template = $this->Template->find('first', array(
                "conditions" => array("guid" => $guid),
                "fields" => array("id")
            ));

            $data['modified'] = time();

            $this->Template->clear();
            $this->Template->id = $template['Template']['id'];
            $this->Template->save($data);

            $this->_error['data'] = $guid;
            $this->_error['element'] = 'input';
            exit(json_encode($this->_error));
        }

        $this->loadModel('Template');
        $data = $this->Template->find('first', array(
            "conditions" => array("guid" => $guid),
            "fields" => array("id", "name", "description", "is_featured", "industry_guid", "category_guid", "width", "height", "guid")
        ));

        if (!empty($data)) {
            $data = $data['Template'];
        } else {
            
        }

        $this->loadModel('Industry');
        $industries = $this->Industry->find('all', array(
            "order" => array("order" => "ASC", "id" => "ASC")
        ));

        $this->set("data", $data);
        $this->set('industries', $industries);
        $this->set('guid', $data['guid']);
    }

    //===========================================================
    //
    //===========================================================

    public function delete() {
        $id = $this->request->query('id');
        $this->loadModel('Template');

        $data = $this->Template->find('first', array("conditions" => array("id" => $id, 'type' => 'template')));

        $this->Template->delete($id);
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
    
    //=====================================
    //
    //=====================================
    
    function subcategorylist ()
    {
        $id = $this->request->query ('id');
        
        if (empty ($id)) {
            exit ('no');
        }
        
        $this->loadModel('Category');
        $categories = $this->Category->find('all', array(
            "conditions" => array("level" => 1, "parent_guid" => $id),
            "order" => array("order" => "ASC", "id" => "ASC")
        ));
        
        if (empty($categories)) {
            $categories = array ();
            exit ('no');
        }

        $this->layout = 'ajax';
        $this->set ('data', $categories);
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

?>
