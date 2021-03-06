<?php

class Category extends AppModel {

    public $useTable = 'categories';
    public $primaryKey = 'id';

    function afterSave($created) {
        clearCache();
    }

    function afterDelete() {
        clearCache();
    }

}