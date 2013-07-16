<?php

App::uses('Controller', 'Controller');

class AdminController extends Controller {
    
    public $components = array(
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'index',
                'action' => 'login',
                'plugin' => 'users'
            ),
            'authError' => 'Did you really think you are allowed to see that?',
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'Admin',
                    'fields' => array('username' => 'email'),
                        'passwordHasher' => array(
                        'className' => 'Simple',
                        'hashType' => 'md5'
                    )
                )
            )
        )
    );
    
    public function beforeFilter() {
        $this->Auth->allow('index', 'view');
    }
}