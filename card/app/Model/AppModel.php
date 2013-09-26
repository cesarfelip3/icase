<?php

/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    protected $_datasource;

    public function beginTransaction() {
        $this->_datasource = $this->getDataSource();
        $this->_datasource->begin();
    }

    public function commitTransaction() {
        $this->_datasource = $this->getDataSource();
        $this->_datasource->commit();
    }

    public function rollTransaction() {
        $this->_datasource = $this->getDataSource();
        $this->_datasource->rollback();
    }

    public function _debug () {
        $log = $this->getDataSource()->getLog(false, false);
        print_r ("<textarea style='width:600px;height:300px'>");
        print_r($log);
        print_r ("</textarea>");
    }

}
