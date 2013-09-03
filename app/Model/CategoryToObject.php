<?php

class CategoryToObject extends AppModel {
    public $useTable = 'category_to_object';
    public $primaryKey = 'id';
    
    function afterSave($created) {
        clearCache();
    }

    function afterDelete() {
        clearCache();
    }
    
}