<?php

App::uses('Controller', 'Controller');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
App::uses('CakeEmail', 'Network/Email');

class AppController extends Controller {

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
}

