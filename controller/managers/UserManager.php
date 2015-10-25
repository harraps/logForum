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
        $q = $this->createObject('User','u_id',[
            'u_name' => $name,
            'u_mail' => $mail,
            'u_pass' => $pass,
            'u_perm' => $perm
        ]);
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            return new User( $data );
        }
    }

    public function update( User $user ){
        $this->updateObject('User','u_id',$user->getId(),[
            'u_name' => $user->getName(),
            'u_mail' => $user->getMail(),
            'u_pass' => $user->getPass(),
            'u_perm' => $user->getPerm()
        ]);
    }

}
