<?php

class Industry extends AppModel {

    public $useTable = 'industries';
    public $primaryKey = 'id';

    function afterSave($created) {
        clearCache();
    }

    function afterDelete() {
        clearCache();
    }

}