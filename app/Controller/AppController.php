<?php
App::uses('Controller', 'Controller');
class AppController extends Controller {
    
    public $components = array(
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'index',
                'action' => 'signin'
            ),
            'authError' => 'Did you really think you are allowed to see that?',
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'User',
                    'fields' => array('username' => 'email', 'password' => 'password'),
                    'scope' => array ('User.active' => 1),
                    'passwordHasher' => array(
                        'className' => 'Simple'
                    )
                )
            )
        )
    );
    
    public function beforeFilter() {
        //$this->set ("title", env ("SERVER_NAME"));
        $this->set ("load_shop_cart", true);
    }
    
    public function afterFilter () {
    }
}

