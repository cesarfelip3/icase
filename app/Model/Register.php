<?php
class Register extends AppModel {

public $useTable = 'users';
public $order = array('nome' => 'ASC', );
public $cacheQueries = true;

}
?>