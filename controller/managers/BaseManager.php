<?php
require_once('controller/Controller.php');

abstract class BaseManager {

    protected $db;    // PDO
    protected $nbEnt; // int : number of entries per page
    
    protected function __construct( PDO $db, int $nbEnt ){
        $this->db = $db;
        $this->nbEnt = $nbEnt;
    }
}
