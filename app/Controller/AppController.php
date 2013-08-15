<?php
App::uses('Controller', 'Controller');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class AppController extends Controller {
    
    protected $_sitedomain = "";
    protected $_identity = null;
    
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
        $this->set ("_sitedomain", $this->_sitedomain);
        
        if ($this->Auth->loggedIn()) {
            $user = array (
                'name' => $this->Auth->user ('name'),
                'guid' => $this->Auth->user ('guid'),
                'email' => $this->Auth->user ('email'),
                'firstname' => $this->Auth->user ('firstname'),
                'lastname' => $this->Auth->user ('lastname')        
            );
            
            $this->_identity = $user;
            
            $this->set ('identity', $user);
        }
    }
    
    public function afterFilter () {
    }
}

