<?php

class IndexController extends AppController {

	public function index () {
		
		
		
		$this->loadModel ('Category');
		$categories = $this->Category->find ('all', array (
			"conditions" => array ("level" => 0),
			"order" => "order ASC, id ASC",
		));
		
		$this->loadModel ('Industry');
		$industries = $this->Industry->find ('all', array (
			"conditions" => array ("level" => 0),
			"order" => "order ASC, id ASC"
		));
		
		$this->set ('categories', $categories);
		$this->set ('industries', $industries);
	}

	public function templatelist ()
	{
		if (true || $this->request->js('ajax')) {
			
			$action = $this->request->query ('action');
			$page = $this->request->query ('page');
			
			$limit = 24;
			$page = 0;
			
			$filter_category = $this->request->query ('filter_category');
			$filter_subcategory = $this->request->query ('filter_subcategory');
			$filter_industry = $this->request->query ('filter_industry');
			
			$conditions = array ("type" => "template_from_store", "status" => "publish");
			
			if (!empty ($filter_subcategory)) {
				$filter_category = $filter_subcategory;
			}	
			
			if (!empty ($filter_category)) {
				$conditions = array_merge ($conditions, array ("category_guid" => $filter_category));	
			}
			
			if (!empty ($filter_industry)) {
				$conditions = array_merge ($conditions, array ("industry_guid" => $filter_industry));	
			}
			
			$this->loadModel('Template');
			$data = $this->Template->find ('all', array (
				"conditions" => $conditions,
				"limit" => $limit,
				"page" => $page,
				"order" => "modified DESC",
				'fields' => array("guid", "category_guid", "industry_guid", "featured", "thumbnails", "type", "status", "created", "modified", "name", "id")
			));
			
			$result = array ();
			$total = count($data);
			$each = ceil($total / 4);
			$j = -1;
			
			for ($i = 0; $i < $total; ++$i) {
				
				if ($i % $each == 0) {
					$j++;
				}
				
				if (!empty($data[$i]['Template']['featured'])) {
					$data[$i]['Template']['featured'] = unserialize($data[$i]['Template']['featured']);
					$data[$i]['Template']['thumbnails'] = unserialize($data[$i]['Template']['thumbnails']);
				}
				
				$result[$j][] = $data[$i];
			}
			
			//print_r ($result);
			//exit;
			
			$this->layout = 'ajax';
			$this->set ('data', $result);
			
		}
	}

	public function templatelist2 ()
	{
		if (true || $this->request->js('ajax')) {
			
			$action = $this->request->query ('action');
			$page = $this->request->query ('page');
			
			if (!empty ($page)) {
				$page = intval ($page);
			} else {
				$page = 0;
			}
			
			$limit = 4;
			
			if ($action == 'nextpage') {
				$page = $page + 7;
				$limit = 4;
			}
			
			$filter_category = $this->request->query ('filter_category');
			$filter_subcategory = $this->request->query ('filter_subcategory');
			$filter_industry = $this->request->query ('filter_industry');
			
			$conditions = array ("type" => "template_from_store", "status" => "publish");
			
			if (!empty ($filter_subcategory)) {
				$filter_category = $filter_subcategory;
			}	
			
			if (!empty ($filter_category)) {
				$conditions = array_merge ($conditions, array ("category_guid" => $filter_category));	
			}
			
			if (!empty ($filter_industry)) {
				$conditions = array_merge ($conditions, array ("industry_guid" => $filter_industry));	
			}
			
			$this->loadModel('Template');
			$data = $this->Template->find ('all', array (
				"conditions" => $conditions,
				"limit" => $limit,
				"page" => $page,
				"order" => "modified DESC",
				'fields' => array("guid", "category_guid", "industry_guid", "featured", "thumbnails", "type", "status", "created", "modified", "name", "id")
			));
			
			foreach ($data as $key => $value) {
				$value = $value['Template'];
				if ($value['thumbnails']) {
					$value['thumbnails'] = unserialize($value['thumbnails']);
					foreach ($value['thumbnails'] as $k => $val) {
						$val = $this->webroot . "uploads/template/" . $val;
						$value['thumbnails'][$k] = $val;
					}
				}
				
				if ($value['featured']) {
					$value['featured'] = unserialize($value['featured']);
					foreach ($value['featured'] as $k => $val) {
						$val = $this->webroot . "uploads/template/" . $val;
						$value['featured'][$k] = $val;
					}
				}
				
				$data[$key] = $value;
			}
			
			if (empty($data)) {
				exit ("no");
			}
			exit(json_encode($data));
			
		}		
	}
	
	public function subcategorylist ()
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
	
	public function test ()
	{
		exit;
		print_r ("Adding test data......<br/>");
		$this->loadModel ("Template");
		$data = $this->Template->find ('first', array ("conditions" => array ("type"=>"template_from_store", "id" => 1)));
		$data = $data['Template'];
		unset($data['id']);
		
		$data2 = $data;
		$count = $this->Template->find('count');
		
		for ($i = $count; $i < $count + 10; $i++) {
			$this->Template->clear();
			$this->Template->create();
			$data2['name'] = $data['name'] . ".$i";
			$data2['guid'] = uniqid();
			$this->Template->save($data2);
		}
		print_r ("Done");
		exit;
	}

}
