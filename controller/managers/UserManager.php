<?php
require_once('controller/managers/BaseManager.php');
require_once('model/User.php');

class UserManager extends BaseManager{
    
    // statements to create and destroy entries
    private $stmt_inst;
    private $stmt_inst_all;
    private $stmt_nbpg_all;
    
    private $stmt_last;
    private $stmt_create;
    private $stmt_update;
    
    private $stmt_up_permissions;
    
    public function __construct( PDO $db, $nbEnt ){
        parent::__construct($db,$nbEnt);
        
        // statements initialization
        $this->stmt_inst = $this->db->prepare(
            "SELECT * FROM `User` WHERE `u_id` = :id ;"
        );
        $this->stmt_inst_all = $this->db->prepare(
            "SELECT * FROM `User` ORDER BY `u_name` ASC LIMIT :start , :number ;"
        );
        $this->stmt_nbpg_all = $this->db->prepare(
            "SELECT COUNT(*) AS `count` FROM `User` ;"
        );
        
        $this->stmt_last = $this->db->prepare(
            "SELECT * FROM `User` WHERE `u_id` = LAST_INSERT_ID();"
        );
        $this->stmt_create = $this->db->prepare(
            "INSERT INTO `User` (`u_name`,`u_mail`,`u_pass`) VALUES ( :name , :mail , :pass );"
        );
        $this->stmt_update = $this->db->prepare(
            "UPDATE `User` SET `u_name` = :name , `u_mail` = :mail , `u_pass` = :pass WHERE `u_id` = :id ;"
        );
        
        $this->stmt_up_permissions = $this->db->prepare(
            "UPDATE User SET `u_perm` = :perm WHERE `u_id` = :id ;"
        );
    }

    public function getUser( $id ){
        $id = (int) $id;
        
        $q = $this->stmt_inst;
        $q->bindParam(':id', $id, PDO::PARAM_INT);
        $q->execute();
        
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){ // there is only one user for this id at most
            return new User( $data );
        }
        return NULL;
    }

    public function getUsers( $page ){
        $page = (int) $page;
        $number = $this->nbEnt;
        $start  = $page * $number;
        
        $q = $this->stmt_inst_all;
        $q->bindParam(':start' , $start , PDO::PARAM_INT);
        $q->bindParam(':number', $number, PDO::PARAM_INT);
        $q->execute();
        
        $users = [];
        while( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            $users[] = new User( $data );
        }
        return $users;
    }

    public function getNbPages(){
        
        $q = $this->stmt_nbpg_all;
        $q->execute();
        
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            return ceil( $data['count'] / $this->nbEnt );
        }
        return 0;
    }

    public function create( $name, $mail, $pass ){
        $name = (string) $name;
        $mail = (string) $mail;
        $pass = (string) $pass;
        
        $q = $this->stmt_create;
        $q->bindParam(':name', $name, PDO::PARAM_STR);
        $q->bindParam(':mail', $mail, PDO::PARAM_STR);
        $q->bindParam(':pass', $pass, PDO::PARAM_STR);
        
        if( $q->execute() ){ // if insertion successful
            $q = $this->stmt_last;
            $q->execute();
            if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
                return new User( $data );
            }
        }
        return NULL;
    }

    public function update( User $user ){
        $q = $this->stmt_update;
        $q->bindParam(':id'  , $thread->getId  (), PDO::PARAM_INT);
        $q->bindParam(':name', $thread->getName(), PDO::PARAM_STR);
        $q->bindParam(':mail', $thread->getMail(), PDO::PARAM_STR);
        $q->bindParam(':pass', $thread->getPass(), PDO::PARAM_STR);
        $q->execute();
    }
    
    public function updatePermissions( User $user ){
        $q = $this->stmt_up_permissions;
        $q->bindParam(':id'  , $thread->getId  (), PDO::PARAM_INT);
        $q->bindParam(':perm', $thread->getPerm(), PDO::PARAM_INT);
        $q->execute();
    }

}
