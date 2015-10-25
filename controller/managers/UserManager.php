<?php
require_once('database/DBAccess.php');
require_once('model/User.php');

class UserManager {

    private DBAccess $dbAccess;

    public function __construct( DBAccess $dbAccess ){
        $this->dbAccess = $dbAccess;
    }

    public function getUser ( int $id ){
        $q = $this->getInstance( 'User', 'u_id', $id );
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){ // there is only one user for this id at most
            return new User( $data );
        }
    }

    public function create( string $name, string $mail, string $pass, int $perm ){
        $sql = "INSERT INTO `User` (`u_name`,`u_mail`,`u_pass`)"
            ." VALUES ("
            ."'".$name."',"
            ."'".$mail."',"
            ."'".$pass."');";
        $this->db->exec($sql);
        $q = $this->db->query('SELECT * FROM `User` WHERE `u_id` = LAST_INSERT_ID()');
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            return new User( $data );
        }
    }

    public function update( User $user ){
        $sql = "UPDATE `User`"
            ." SET "
            ."`u_name` = ".$user->getName()."',"
            ."`u_mail` = ".$user->getMail()."',"
            ."`u_pass` = ".$user->getPass()."',"
            ."`u_perm` = ".$user->getPerm()."'"
            ." WHERE "
            ."`u_id`   = '".$user->getId ()."';";
        $this->db->exec($sql);
    }

}
