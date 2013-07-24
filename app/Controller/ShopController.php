<?php

App::uses('AppController', 'Controller');
class ShopController extends AppController {
    
    public $uses = false;
    protected $_error = array(
        "error" => 1,
        "message" => "",
        "files" => array(),
    );
    
    public function beforeFilter() {
        $this->Auth->allow();
	parent::beforeFilter();
    }
    
    public function preview ()
    {
	if ($this->request->is('ajax')) {
	    $this->layout = false;
	    
	    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	    header("Cache-Control: no-store, no-cache, must-revalidate");
	    header("Cache-Control: post-check=0, pre-check=0", false);
	    header("Pragma: no-cache");
	    
	    
	    $product = $this->request->data ('product');
	    $data = array ();
	    if (empty ($product)) {
		$this->set ('data', $data);
		return;
	    }
    
	    $targetDir = $this->_targetDir = ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'uploads';
    
	    $cleanupTargetDir = true; // Remove old files
	    $maxFileAge = 5 * 3600; // Temp file age in seconds
	    @set_time_limit(0);
	    
	    $imageData = $_POST['image-data'];
	    $extension = $_POST['image-extension'];
	    
	    $imageData = str_replace ("data:image/" . $extension . ";base64,", "", $imageData);
	    
	    $filename = uniqid () . "." . $extension;
	    $file = base64_encode ($imageData);
	    $out = @fopen( $targetDir . DIRECTORY_SEPARATOR . $filename, "wb" );
	    
	    if ($out) {
		fwrite ($out, base64_decode($imageData));
		@fclose ($out);
	    } else {
		$this->_error['error'] = 1;
		$this->_error['message'] = 'open write handler faild';
		$this->set (array ('data' => $data, 'image' => $this->_error));
	    }
	    
	    $this->_error['error'] = 0;
	    $this->_error['message'] = 'success';
	    $this->_error['files'] = array(
		'original' => "",
		'target' => $filename,
		'url' => "uploads/" . $filename,
		'extension' => $extension,
		//'mime' => $mime
	    );
	    
	    $size = getimagesize($targetDir . DIRECTORY_SEPARATOR . $filename);
	    
	    $current_width = $size[0];
	    $current_height = $size[1];
	    
	    $left = 100;
	    $top = 5;
	     
	    $crop_width = 248;
	    $crop_height = 437;
	     
	    // Resample the image
	    $canvas = imagecreatetruecolor($crop_width, $crop_height);
	    $current_image = imagecreatefromjpeg($targetDir . DIRECTORY_SEPARATOR . $filename);
	    imagecopy($canvas, $current_image, 0, 0, $left, $top, $current_width, $current_height);
	    imagejpeg($canvas, $targetDir . DIRECTORY_SEPARATOR . $filename, 100);
	    
	    $path = $targetDir . DIRECTORY_SEPARATOR . $filename;
	    $image = file_get_contents($targetDir . DIRECTORY_SEPARATOR . $filename);
    
	    $image = substr_replace($image, pack("cnn", 1, 300, 300), 13, 5);
	    
	    file_put_contents ($targetDir . DIRECTORY_SEPARATOR . $filename, $image);
	    
	    $this->loadModel ('Product');
	    $data = $this->Product->find ('first',
		array (
		    'conditions' => array ('guid' => $product, 'type' => 'template')
		)
	    );
	    
	    if (empty ($data)) {
		$this->_error['error'] = 1;
	    }
	    
	    $this->set (array ('data' => $data, 'error' => $this->_error));
	    return;
	}
    }
    
    public function cart () {
        
	if ($this->request->is ("ajax")) {
	    $this->layout = false;
	    $orders = $this->request->data['orders'];
	    $data = array ();
	    
	    if (empty ($orders)) {
		$this->set ('data', $data);
		return;
	    }
	    
	    $orders = explode (",", $orders);
	    
	    if (empty ($orders)) {
		$this->set ('data', $data);
		return;
	    }	    
	    
	    $guids = array_flip ($orders);
	    $i = 0;
	    
	    foreach ($guids as $key => $value) {
		$guids[$key] = 0;
	    }
	    
	    foreach ($guids as $key => $value) {
		foreach ($orders as $order) {
		    if ($order == $key) {
			$guids[$key]++;
		    }
		}
	    }
	    
	    $this->loadModel ("Product");
	    $i = 0;
	    
	    foreach ($guids as $key => $value) {
		$key = explode ("-", $key);
		if (is_array ($key)) {
		    $guid = $key[0];
		}
		
		$data[$i] = $this->Product->findByGuid ($guid);
		if (empty ($data[$i])) {
		    $data = null;
		    break;
		}
		
		if (isset ($key[1])) {
		    $data[$i]['Product']['file'] = $key[1];
		} else {
		    $data[$i]['Product']['file'] = "";
		}
		$data[$i]['Product']['quantity'] = $value;
		$i++;
	    }
	    
	    $this->set ('data', $data);
	}
    }
    
    public function order () {
	if ($this->request->is ("ajax")) {
	    $this->layout = false;
	    $orders = $this->request->data['orders'];
	    $data = array ();
	    
	    $user = $this->request->data['user'];
	    
	    if (empty ($orders)) {
		$this->set ('data', $data);
		return;
	    }
	    
	    $orders = explode (",", $orders);
	    
	    if (empty ($orders)) {
		$this->set ('data', $data);
		return;
	    }	    
	    
	    $guids = array_flip ($orders);
	    $i = 0;
	    
	    foreach ($guids as $key => $value) {
		$guids[$key] = 0;
	    }
	    
	    foreach ($guids as $key => $value) {
		foreach ($orders as $order) {
		    if ($order == $key) {
			$guids[$key]++;
		    }
		}
	    }
	    
	    $this->loadModel ("Product");
	    $i = 0;
	    
	    foreach ($guids as $key => $value) {
		$key = explode ("-", $key);
		if (is_array ($key)) {
		    $guid = $key[0];
		}
		
		$data[$i] = $this->Product->findByGuid ($guid);
		if (empty ($data[$i])) {
		    $data = null;
		    break;
		}
		
		if (isset ($key[1])) {
		    $data[$i]['Product']['file'] = $key[1];
		} else {
		    $data[$i]['Product']['file'] = $data[$i]['Product']['image'];
		}
		$data[$i]['Product']['quantity'] = $value;
		$i++;
	    }
	    
	    $orders = array ();
	    $i = 0;
	    if (!empty ($data)) {
		foreach ($data as $value) {
		    $orders[$i] = array (
			"guid" => uniqid (),
			"buyer_guid" => $user,
			"created" => time (),
			"modified" => time (),
			"amount" => round($value['Product']['price'] * $value['Product']['quantity'], 2, PHP_ROUND_HALF_DOWN),
			"quantity" => $data[$i]['Product']['quantity'],
			"file" => $value['Product']['file'] == "" ? $value['Product']['image'] : $value['Product']['file'],
		    );
		}
	    }
	    
	    $this->loadModel ("Order");
	    $this->Order->saveMany ($orders);
	    
	    $this->set ('data', $orders);
	}	
    }
    
    public function checkout () {
	
	$this->set ('load_shop_cart', true);
    }
    
    public function product () {
	
    }
    
    public function getTemplates () {
	
	if ($this->request->is('ajax')) {
	    $this->autoRender = false;
	    
	    $this->loadModel ('Product');
	    $data = $this->Product->find("all",
		array (
		    "conditions" => array (
			 "active" => 1,
			 "type" => "template"
		     ),
		    "order" => array (
			"created DESC",
			'id DESC'
		    )
		)
	    );
	    
	    foreach ($data as $key => $value) {
		$value['Product']['image'] = $this->base . "/" . $value['Product']['image'];
		$data[$key] = $value;
	    }
	    
	    //print_r ($data);
	    echo json_encode($data);
	}
    }
    
    // for test
    public function create () {
	
	$this->autoRender = false;
	
	$this->loadModel ('Product');
	$data = array (
	    'guid' => uniqid (),
	    'name' => "iphone",
	    "description" => "iphone 5 case description",
	    "price" => 29.32,
	    "tax" => 0,
	    "total" => 100,
	    "status" => "publish",
	    "created" => time (),
	    "modified" => time ()
	);
	
	$bulk = array ();
	for ($i = 0; $i < 3; ++$i) {
	    $data['price'] = 29.32 + rand (1, 100);
	    $data['guid'] = uniqid ();
	    $j = $i + 3;
	    $data['name'] = "iphone" . $j;
	    $data['type'] = 'template';
	    $data['image'] = 'img/template/iphone.png';
	    $bulk[] = $data;
	}
	$this->Product->saveMany ($bulk);
    }
    
    public function template () {
	$this->autoRender = false;
	
	$this->loadModel ('Template');
	$data = array (
	    'name' => "iphone",
	    'image' => "uploads/iphone.png"
	);
	
	$bulk = array ();
	for ($i = 0; $i < 3; ++$i) {
	    $data['guid'] = uniqid ();
	    $bulk[] = $data;
	}
	
	$this->Template->saveMany ($bulk);
    }
    
    protected function _json($data = array()) {
        return json_encode($data); //, JSON_UNESCAPED_SLASHES);
    }
}