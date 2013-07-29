<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {
    
    public $components = array(
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'index',
                'action' => 'login'
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
    }
}


/**
 * Before Filter method
 *
 * @return void
 */
function beforeFilter() {
    if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
        $this->layout = 'ActiveAdmin.admin';
        // Auth is used here and checked for a valid user
        if ($user = $this->Auth->user()){
            if(!$this->isAuthorized($user)){
                $this->redirect($this->Auth->logout());
            }
        }
    }else{
        $this->Auth->allow('*');
    }
}



