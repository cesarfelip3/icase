<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
Router::connect('/', array('controller' => 'index', 'action' => 'index', 'home'));
// Icases Routes
Router::connect('/create', array('controller' => 'creator', 'action' => 'index'));
Router::connect(
    '/category/:slug', 
    array('controller' => 'catalogue', 'action' => 'category'), 
    array(
        'pass' => array('slug'),
    )
);
Router::connect(
    '/product/:slug', // E.g. /blog/3-CakePHP_Rocks
    array('controller' => 'catalogue', 'action' => 'product'), 
    array(
        'pass' => array('slug'),
    )
);

Router::connect(
    '/search/:keywords', // E.g. /blog/3-CakePHP_Rocks
    array('controller' => 'catalogue', 'action' => 'search'), 
    array(
        'pass' => array('keywords'),
    )
);

Router::connect(
    '/search/*', // E.g. /blog/3-CakePHP_Rocks
    array('controller' => 'catalogue', 'action' => 'search')
);

Router::connect('/signin', array('controller' => 'index', 'action' => 'signin'));
Router::connect('/signup', array('controller' => 'index', 'action' => 'signup'));
Router::connect('/logout', array('controller' => 'index', 'action' => 'logout'));
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes(
);
/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
