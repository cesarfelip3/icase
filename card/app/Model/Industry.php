<?php

class Industry extends AppModel {

    public $useTable = 'categories';
    public $primaryKey = 'id';

    function afterSave($created) {
        clearCache();
    }

    function afterDelete() {
        clearCache();
    }

}