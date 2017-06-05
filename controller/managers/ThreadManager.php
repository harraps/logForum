<?php
require_once('controller/managers/BaseManager.php');
require_once('model/Thread.php');

class ThreadManager extends BaseManager{
    
    // statements to create and destroy entries
    private $stmt_inst;
    private $stmt_inst_select;
    private $stmt_nbpg_select;
    
    private $stmt_last;
    private $stmt_create;
    private $stmt_update;
    
    public function __construct( PDO $db, $nbEnt ){
        parent::__construct($db,$nbEnt);
        
        // statements initialization
        $this->stmt_inst = $this->db->prepare(
            "SELECT * FROM `Thread` WHERE `t_id` = :id ;"
        );
        $this->stmt_inst_select = $this->db->prepare(
            "SELECT * FROM `Thread` WHERE `s_id` = :id ORDER BY `t_date` ASC LIMIT :start , :number ;"
        );
        $this->stmt_nbpg_select = $this->db->prepare(
            "SELECT COUNT(*) AS `count` FROM `Thread` WHERE `s_id` = :id ;"
        );
        
        $this->stmt_last = $this->db->prepare(
            "SELECT * FROM `Thread` WHERE `t_id` = LAST_INSERT_ID();"
        );
        $this->stmt_create = $this->db->prepare(
            "INSERT INTO `Thread` (`u_id`,`t_name`) VALUES ( :userId , :name );"
        );
        $this->stmt_update = $this->db->prepare(
            "UPDATE `Thread` SET `t_name` = :name , `t_stat` = :state WHERE `t_id` = :id ;"
        );
    }

    public function getThread( $id ){
        $id = (int) $id;
        
        $q = $this->stmt_inst;
        $q->bindParam('id', $id, PDO::PARAM_INT);
        $q->execute();
        
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){ // there is only one thread for this id at most
            return new Thread( $data );
        }
        return NULL;
    }

    public function getThreadsFromSection( $id, $page ){
        $id   = (int) $id;
        $page = (int) $page;
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

    public function getNbPagesFromSection( $id ){
        $id = (int) $id;
        
        $q = $this->stmt_nbpg_selected;
        $q->bindParam(':id', $id, PDO::PARAM_INT);
        $q->execute();
        
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            return ceil( $data['count'] / $this->nbEnt );
        }
        return 0;
    }

    public function create( $u_id, $name ){
        $u_id = (int)    $u_id;
        $name = (string) $name;
        
        $q = $this->stmt_create;
        $q->bindParam(':userId', $u_id, PDO::PARAM_INT);
        $q->bindParam(':name'  , $name, PDO::PARAM_STR);
        
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
        $q->bindParam(':state', $thread->getState(), PDO::PARAM_INT);
        $q->execute();
    }
}
