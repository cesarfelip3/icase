<?php

Router::connect("/admin/*", array("controller" => "index", "action" => "index"));
Router::connect('/dashboard', array(
    'plugin' => 'admin',
    'controller' => 'admin',
    'action' => 'index'
));
Router::connect('/dashboard/:controller', array(
    'plugin' => 'admin',
    'action' => 'index'
));
Router::connect('/dashboard/:controller/:action', array(
    'plugin' => 'admin'
));
?>