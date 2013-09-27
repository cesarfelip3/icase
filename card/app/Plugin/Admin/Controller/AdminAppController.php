<?php

//App::uses('AppController', 'Controller');
App::uses('Controller', 'Controller');

class AdminAppController extends Controller {

    protected $_base_plugin;
    protected $_error = array(
        'error' => 0,
        'element' => '',
        'message' => '',
        'data' => '',
        'files' => '',
    );
//    public $components = array(
//        'Session',
//        'Auth' => array(
//            'loginAction' => array(
//                'plugin' => 'admin',
//                'controller' => 'index',
//                'action' => 'login'
//            ),
//            'authError' => 'Did you really think you are allowed to see that?',
//            'authenticate' => array(
//                'Form' => array(
//                    'userModel' => 'Admin',
//                    'fields' => array('username' => 'name', 'password' => 'password'),
//                    'scope' => array('Admin.active' => 1),
//                    'passwordHasher' => array(
//                        'className' => 'Simple'
//                    )
//                )
//            )
//        ),
//        'Admin.Captcha'
//    );
    public $helpers = array('Cache');
    protected $_media_location = array(
        "main" => "uploads/",
        "product" => "uploads/product/",
        "template" => "uploads/template/",
        "order" => "uploads/order/",
        "user" => "uploads/user/",
        "user.uploads" => "uploads/user/uploads/",
    );
    
    protected $_media_size = array(
        "template" => array(
            "small" => 200,
            "medium" => 500,
        )
    );
    
    protected $_basename = "admin";

    public function beforeFilter() {
        $this->layout = "admin";
        $this->_base_plugin = $this->webroot  .  $this->_basename . "/"; 
        $this->set('base', $this->_base_plugin);
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
                $ret = @preg_match("/^[a-z]{1,}[0-9]{0,}$/", $value);
                break;
        }

        return $ret;
    }

}
