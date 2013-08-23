<?php

App::uses('Controller', 'Controller');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
App::uses('CakeEmail', 'Network/Email');

class AppController extends Controller {
    
    protected $_error = array(
        "error" => 1,
        "message" => "",
        "files" => array(),
        "data" => array(),
    );
    
    protected $_identity = null;
    
    protected $_meta = array (
        "_sitedomain" => "",
        "_identity" => "",
        "_title" => "",
        "_description" => ""
    );
    
    public $components = array(
        'Session',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'index',
                'action' => 'signin'
            ),
            'authError' => 'Did you really think you are allowed to see that?',
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'User',
                    'fields' => array('name' => 'name', 'password' => 'password'),
                    'scope' => array('User.active' => 1),
                    'passwordHasher' => array(
                        'className' => 'Simple'
                    )
                )
            )
        )
    );

    public function beforeFilter() {

        $this->_meta['_sitedomain'] = env("SERVER_NAME");
        $this->_meta['_title'] = env("SERVER_NAME") . " | Best mobile phone, iphone, samsung galaxy, mug, bottle online create shop";
        $this->_meta['_description'] = env("SERVER_NAME") . " | Best mobile phone, iphone, samsung galaxy, mug, bottle online create shop";
        $this->_meta['_identity'] = null;

        if ($this->Auth->loggedIn()) {
            $this->_meta['_identity'] = $this->_identity = $this->Auth->user();
        }

        $this->layoutInit();
        $this->set($this->_meta);
    }

    public function layoutInit() {

        if (!($this->request->is('ajax') || $this->request->is ('post'))) {
            $categories = Cache::read("category_top");

            if (empty($categories)) {
                $this->loadModel("Category");
                $categories = $this->Category->find('all', array("conditions" => array("level" => 0), "order" => array("order" => "ASC", "id" => "ASC")));
                Cache::write("category_top", $categories);
            }

            if (!empty($categories)) {
                $this->set("_home_menu", $categories);
            }
        }
    }

    public function afterFilter() {
        
    }

    protected function email($from, $to, $subject, $content, $template, $vars = array()) {
        $Email = new CakeEmail();
        $Email->template($template);
        $Email->viewVars($vars);
        $Email->emailFormat('html');
        $Email->from($from);
        $Email->to($to);
        $Email->subject($subject);
        $Email->send();
    }

}

