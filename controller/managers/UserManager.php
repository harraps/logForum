<?php
require_once('database/DBAccess.php');
require_once('model/User.php');

class UserManager {

    private DBAccess $dbAccess;

    public function __construct( DBAccess $dbAccess ){
        $this->dbAccess = $dbAccess;
    }

    public function getUser ( int $id ){
        $id = (int) $id;
        $q = $this->db->query('SELECT * FROM `User` WHERE `u_id` = '.$id);
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){ // there is only one user for this id at most
            return new User( $data );
        }
    }
}
