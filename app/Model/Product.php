<?php

class Product extends AppModel {

    public $useTable = 'products';
    public $primaryKey = 'id';
    public $actsAs = array('Transactional');

    function afterSave($created) {
        clearCache();
    }

    function afterDelete() {
        clearCache();
    }

}