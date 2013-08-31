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
    protected $_meta = array(
        "_sitedomain" => "",
        "_identity" => "",
        "_title" => "",
        "_description" => ""
    );
    public $components = array(
        'Session',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'auth',
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
        ),
        'Captcha'
    );

    /*
     * Media - when the site is running long time, there are lots of images<flash or else>
     * located on server, but some of them maybe not use any longer. We have to consider the 
     * performance of server, or space usage of server too. The idea is : it's necessary to 
     * delete all these images unused by cron job.
     * 
     * Also all media uploaded to server are random size, for the site, we use smaller size 
     * for thumbnails, and medium size for single snapshot. 
     * 
     * All there values used across front and end, so I put them here.
     * 
     */
    protected $_media_location = array(
        "main" => "uploads/",
        "product" => "uploads/product/",
        "order" => "uploads/order/",
        "user" => "uploads/user/",
        "user.uploads" => "uploads/user/uploads/",
    );
    protected $_media_size = array(
        "small" => 200,
        "medium" => 500,
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

        if (!($this->request->is('ajax') || $this->request->is('post'))) {
            $categories = Cache::read("category_top");

            if (empty($categories)) {
                $this->loadModel("Category");
                $categories = $this->Category->find('all', array(
                    "conditions" => array(
                        "level" => 0),
                    "order" => array("order" => "ASC", "id" => "ASC")
                ));
                Cache::write("category_top", $categories);
            }

            if (!empty($categories)) {
                $this->set("_home_menu", $categories);
            }
        }
    }

    public function afterFilter() {
        
    }

    //=================================================
    // helper functions
    //=================================================
    protected function _email($from, $to, $subject, $content, $template, $vars = array()) {
        $Email = new CakeEmail();
        $Email->config('smtp');
        $Email->template($template);
        $Email->viewVars($vars);
        $Email->emailFormat('html');
        $Email->from($from);
        $Email->to($to);
        $Email->subject($subject);
        $Email->send();
    }

    protected function _validate($type, $value) {
        $ret = false;
        switch ($type) {
            case "email" :
                $ret = @preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/i", $value);
                break;
            case "username" :
                $ret = @preg_match("/^[a-z]{1,}|[a-z]{1,}[0-9]{1,}$/i", $value);
                break;
        }

        return $ret;
    }

}

