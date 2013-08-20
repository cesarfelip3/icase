<?php
//App::uses('AppController', 'Controller');
App::uses('Controller', 'Controller');
App::uses('Sanitize', 'Utility');

class AdminAppController extends Controller {
    
    protected $_base_plugin;
    
    public $components = array(
        'Auth' => array(
            'loginAction' => array(
                'plugin' => 'admin',
                'controller' => 'index',
                'action' => 'login'
            ),
            'authError' => 'Did you really think you are allowed to see that?',
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'Admin',
                    'fields' => array('username' => 'name', 'password' => 'password'),
                    'scope' => array('Admin.active' => 1),
                    'passwordHasher' => array(
                        'className' => 'Simple'
                    )
                )
            )
        )
    );
    
    public function beforeFilter() {
        $this->layout = "admin";
        $this->_base_plugin = $this->base . DS . $this->request->params['plugin'] . DS;
        $this->set ('base', $this->_base_plugin);
        
        if ($this->Auth->loggedIn()) {
            $user = array (
                'name' => $this->Auth->user ('name'),
                'guid' => $this->Auth->user ('guid'),
                'email' => $this->Auth->user ('email'),
                'id' => $this->Auth->user ('id')
            );
            
            $this->set ('identity', $user);
        } 
    }
}
