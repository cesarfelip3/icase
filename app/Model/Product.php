<?php

class Product extends AppModel {
    public $useTable = 'products';
    public $primaryKey = 'id';
    
    public $actsAs = array('Transactional');
    
}