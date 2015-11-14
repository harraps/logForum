<?php
require_once('controller/managers/BaseManager.php');
require_once('model/User.php');

class UserManager extends BaseManager{

    private $nbEnt;

    public function __construct( PDO $db, $nbEnt ){
        $nbEnt = (int) $nbEnt;
        parent::__construct($db);
        $this->nbEnt = $nbEnt;
    }

    public function getUser( int $id ){
        $q = $this->getInstance('User','u_id',$id);
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){ // there is only one user for this id at most
            return new User( $data );
        }
    }

    public function getUsers( int $page ){
        $q = $this->getInstancesFrom('User','u_id',0,$page,$this->nbEnt,'u_name',TRUE,TRUE);
        $users = [];
        while( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            $users[] = new User( $data );
        }
        return $users;
    }

    public function getNbPages(){
        return $this->getNbPagesFrom('User','u_id',0,$this->nbEnt,FALSE);
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
