<?php
//App::uses('AppController', 'Controller');
App::uses('Controller', 'Controller');
class AdminAppController extends Controller {
    public $components = array(
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'index',
                'action' => 'login'
            ),
            'authError' => 'Did you really think you are allowed to see that?',
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'Admin',
                    'fields' => array('username' => 'email', 'password' => 'password'),
                    'scope' => array('User.active' => 1),
                    'passwordHasher' => array(
                        'className' => 'Simple'
                    )
                )
            )
        )
    );
    public function beforeFilter() {
        $this->layout = "admin";
        $base = $this->base . DS . $this->request->params['plugin'] . DS;
        $this->set ('base', $base);
    }
}
