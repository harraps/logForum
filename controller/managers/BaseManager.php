<?php
require_once('controller/Controller.php');

abstract class BaseManager {

    protected PDO $db;

    public function __construct( PDO $db ){
        $this->db = $db;
    }

}
