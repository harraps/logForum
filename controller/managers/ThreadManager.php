<?php
require_once($ROOT_DIR.'controller/managers/BaseManager.php');
require_once($ROOT_DIR.'model/Thread.php');

class ThreadManager extends BaseManager{
    
    // statements to create and destroy entries
    private $stmt_inst;
    private $stmt_inst_select;
    private $stmt_nbpg_select;
    
    private $stmt_last;
    private $stmt_create;
    private $stmt_update;
    
    public function __construct( PDO $db, int $nbEnt ){
        parent::__construct($db, $nbEnt);
        
        // statements initialization
        $this->stmt_inst = $this->db->prepare(
            "SELECT * FROM `Thread` WHERE `t_id`=:id ;"
        );
        $this->stmt_inst_select = $this->db->prepare(
            "SELECT * FROM `Thread` WHERE `s_id`=:id ORDER BY `t_date` DESC LIMIT :start,:number;"
        );
        $this->stmt_nbpg_select = $this->db->prepare(
            "SELECT COUNT(*) AS `count` FROM `Thread` WHERE `s_id`=:id ;"
        );
        
        $this->stmt_last = $this->db->prepare(
            "SELECT * FROM `Thread` WHERE `t_id`=LAST_INSERT_ID();"
        );
        $this->stmt_create = $this->db->prepare(
            "INSERT INTO `Thread` (`u_ip`,`s_id`,`t_name`) VALUES (:IP,:id,:name);"
        );
        $this->stmt_update = $this->db->prepare(
            "UPDATE `Thread` SET `t_name`=:name WHERE `t_id`=:id;"
        );
    }

    public function getThread( int $id ){
        $q = $this->stmt_inst;
        $q->bindParam('id', $id, PDO::PARAM_INT);
        $q->execute();
        
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){ // there is only one thread for this id at most
            return new Thread( $data );
        }
        return NULL;
    }

    public function getThreadsFromSection( int $id, int $page ){
        $number = $this->nbEnt;
        $start  = $page * $number;
        
        $q = $this->stmt_inst_select;
        $q->bindParam(':id'    , $id    , PDO::PARAM_INT);
        $q->bindParam(':start' , $start , PDO::PARAM_INT);
        $q->bindParam(':number', $number, PDO::PARAM_INT);
        $q->execute();
        
        $threads = [];
        while( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            $threads[] = new Thread( $data );
        }
        return $threads;
    }

    public function getNbPagesFromSection( int $id ){
        $q = $this->stmt_nbpg_select;
        $q->bindParam(':id', $id, PDO::PARAM_INT);
        $q->execute();
        
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            return ceil( $data['count'] / $this->nbEnt );
        }
        return 0;
    }

    public function create( string $ip, int $s_id, string $name ){
        $q = $this->stmt_create;
        $q->bindParam(':IP'  , $ip  , PDO::PARAM_STR);
        $q->bindParam(':id'  , $s_id, PDO::PARAM_INT);
        $q->bindParam(':name', $name, PDO::PARAM_STR);
        
        if( $q->execute() ){ // if insertion successful
            $q = $this->stmt_last;
            $q->execute();
            if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
                return new Thread( $data );
            }
        }
        return NULL;
    }
    
    public function update( Thread $thread ){
        $q = $this->stmt_update;
        $q->bindParam(':id'   , $thread->getId   (), PDO::PARAM_INT);
        $q->bindParam(':name' , $thread->getName (), PDO::PARAM_STR);
        $q->execute();
    }
}
