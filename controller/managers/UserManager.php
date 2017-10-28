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
    
    public function __construct( PDO $db, int $nbEnt ){
        parent::__construct($db, $nbEnt);
        
        // statements initialization
        $this->stmt_inst = $this->db->prepare(
            "SELECT * FROM `User` WHERE `u_ip` = :id ;"
        );
        $this->stmt_inst_all = $this->db->prepare(
            "SELECT * FROM `User` ORDER BY `u_name` ASC LIMIT :start , :number ;"
        );
        $this->stmt_nbpg_all = $this->db->prepare(
            "SELECT COUNT(*) AS `count` FROM `User` ;"
        );
        
        $this->stmt_last = $this->db->prepare(
            "SELECT * FROM `User` WHERE `u_ip` = LAST_INSERT_ID();"
        );
        $this->stmt_create = $this->db->prepare(
            "INSERT INTO `User` (`u_ip`,`u_name`,`u_desc`) VALUES ( :ip , :name , :desc );"
        );
        $this->stmt_update = $this->db->prepare(
            "UPDATE `User` SET `u_name` = :name , `u_desc` = :desc WHERE `u_ip` = :id ;"
        );
    }

    public function getUser( int $id ){
        $q = $this->stmt_inst;
        $q->bindParam(':id', $id, PDO::PARAM_INT);
        $q->execute();
        
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){ // there is only one user for this id at most
            return new User( $data );
        }
        return NULL;
    }

    public function getUsers( int $page ){
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

    public function create( int $id, string $name, string $desc ){
        $q = $this->stmt_create;
        $q->bindParam(':id'  , $id  , PDO::PARAM_INT);
        $q->bindParam(':name', $name, PDO::PARAM_STR);
        $q->bindParam(':mail', $mail, PDO::PARAM_STR);
        
        if( $q->execute() ){ // if insertion successful
            return new User([
                'u_id'   => $id,
                'u_name' => $name,
                'u_desc' => $desc,
                'u_date' => new DateTime()
            ]);
        }
        return NULL;
    }

    public function update( User $user ){
        $q = $this->stmt_update;
        $q->bindParam(':id'  , $thread->getId  (), PDO::PARAM_INT);
        $q->bindParam(':name', $thread->getName(), PDO::PARAM_STR);
        $q->bindParam(':desc', $thread->getDesc(), PDO::PARAM_STR);
        $q->execute();
    }

}
