<?php

//App::uses('AppController', 'Controller');
App::uses('Controller', 'Controller');

class AdminAppController extends Controller {

    protected $_base_plugin;
    protected $_error = array(
        'error' => 0,
        'element' => '',
        'message' => '',
        'data' => ''
    );
    public $components = array(
        'Session',
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
        ),
        'Captcha'
    );
    
    protected $_media_location = array(
        "main" => "uploads/",
        "product" => "uploads/product/",
        "order" => "uploads/order/",
        "user" => "uploads/user/",
        "user.uploads" => "uploads/user/uploads/",
    );
    
    protected $_media_size = array(
        "product" => array(
            "small" => 200,
            "medium" => 500,
        )
    );
    
    protected $_basename = "dashboard";

    public function beforeFilter() {

        AuthComponent::$sessionKey = "Auth.Admin";

        $this->layout = "admin";
        $this->_base_plugin = $this->base . DS . $this->_basename . DS; //$this->request->params['plugin'] . DS;
        $this->set('base', $this->_base_plugin);
        

        if ($this->Auth->loggedIn()) {
            $user = array(
                'name' => $this->Auth->user('name'),
                'guid' => $this->Auth->user('guid'),
                'email' => $this->Auth->user('email'),
                'id' => $this->Auth->user('id'),
                'active' => $this->Auth->user('active')
            );

            $this->set('identity', $user);
        }
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

    protected function _crop($image_file) {
        //load the image

        $extension = pathinfo($image_file, PATHINFO_EXTENSION);
        $extension = trim($extension);
        $extension = strtolower($extension);

        $img = null;
        if ($extension == "jpg" || $extension == "jpeg") {
            $img = imagecreatefromjpeg($image_file);
        }

        if ($extension == "png") {
            $img = imagecreatefrompng($image_file);
        }

        if (empty($img)) {
            return false;
        }

        $b_top = 0;
        $b_btm = 0;
        $b_lft = 0;
        $b_rt = 0;

        for (; $b_top < imagesy($img); ++$b_top) {
            for ($x = 0; $x < imagesx($img); ++$x) {
                if (imagecolorat($img, $x, $b_top) != 0xFFFFFF) {
                    break 2; //out of the 'top' loop
                }
            }
        }

        for (; $b_btm < imagesy($img); ++$b_btm) {
            for ($x = 0; $x < imagesx($img); ++$x) {
                if (imagecolorat($img, $x, imagesy($img) - $b_btm - 1) != 0xFFFFFF) {
                    break 2; //out of the 'bottom' loop
                }
            }
        }

        for (; $b_lft < imagesx($img); ++$b_lft) {
            for ($y = 0; $y < imagesy($img); ++$y) {
                if (imagecolorat($img, $b_lft, $y) != 0xFFFFFF) {
                    break 2; //out of the 'left' loop
                }
            }
        }

        for (; $b_rt < imagesx($img); ++$b_rt) {
            for ($y = 0; $y < imagesy($img); ++$y) {
                if (imagecolorat($img, imagesx($img) - $b_rt - 1, $y) != 0xFFFFFF) {
                    break 2; //out of the 'right' loop
                }
            }
        }

        $newimg = imagecreatetruecolor(
                imagesx($img) - ($b_lft + $b_rt), imagesy($img) - ($b_top + $b_btm));

        imagecopy($newimg, $img, 0, 0, $b_lft, $b_top, imagesx($newimg), imagesy($newimg));
    }

}
