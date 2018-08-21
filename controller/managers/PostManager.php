<?php
require_once($ROOT_DIR.'controller/managers/BaseManager.php');
require_once($ROOT_DIR.'model/Post.php');

class PostManager extends BaseManager{
    
    // statements to create and destroy entries
    private $stmt_inst;
    private $stmt_inst_select;
    private $stmt_nbpg_select;
    
    private $stmt_last;
    private $stmt_create;
    private $stmt_update;
    
    private $stmt_up_thread;
    
    public function __construct( PDO $db, int $nbEnt ){
        parent::__construct($db, $nbEnt);
        
        // statements initialization
        $this->stmt_inst = $this->db->prepare(
            "SELECT * FROM `Post` WHERE `p_id`=:id ;"
        );
        $this->stmt_inst_select = $this->db->prepare(
            "SELECT * FROM `Post` WHERE `t_id`=:id ORDER BY `p_date` ASC LIMIT :start,:number;"
        );
        $this->stmt_nbpg_select = $this->db->prepare(
            "SELECT COUNT(*) AS `count` FROM `Post` WHERE `t_id`=:id;"
        );
        
        $this->stmt_last = $this->db->prepare(
            "SELECT * FROM `Post` WHERE `p_id`=LAST_INSERT_ID();"
        );
        $this->stmt_create = $this->db->prepare(
            "INSERT INTO `Post` (`u_ip`,`t_id`,`p_text`) VALUES (:IP,:id,:text);"
        );
        $this->stmt_update = $this->db->prepare(
            "UPDATE `Post` SET `p_text`=:text WHERE `p_id`=:id;"
        );
        
        $this->stmt_up_thread = $this->db->prepare(
            "UPDATE `Thread` SET `t_date`=CURRENT_TIMESTAMP WHERE `t_id`=:id ;"
        );
    }

    public function getPost( int $id ){        
        $q = $this->stmt_inst;
        $q->bindParam(':id', $id, PDO::PARAM_INT);
        $q->execute();
        
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){ // there is only one post for this id at most
            return new Post( $data );
        }
        return NULL;
    }
    
    public function getPostsFromThread( int $id, int $page ){
        $number = $this->nbEnt;
        $start  = $page * $number;
        
        $q = $this->stmt_inst_select;
        $q->bindParam(':id'    , $id    , PDO::PARAM_INT);
        $q->bindParam(':start' , $start , PDO::PARAM_INT);
        $q->bindParam(':number', $number, PDO::PARAM_INT);
        $q->execute();
        
        $posts = [];
        while( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            $posts[] = new Post( $data );
        }
        return $posts;
    }

    public function getNbPagesFromThread( int $id ){
        $q = $this->stmt_nbpg_select;
        $q->bindParam(':id', $id, PDO::PARAM_INT);
        $q->execute();
        
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            return ceil( $data['count'] / $this->nbEnt );
        }
        return 0;
    }

    public function create( string $ip, int $t_id, string $text ){
        $q = $this->stmt_create;
        $q->bindParam(':IP'  , $ip  , PDO::PARAM_STR);
        $q->bindParam(':id'  , $t_id, PDO::PARAM_INT);
        $q->bindParam(':text', $text, PDO::PARAM_STR);
        
        if( $q->execute() ){ // if insertion successful
            // update the date of the thread
            $q = $this->stmt_up_thread;
            $q->bindParam(':id', $t_id, PDO::PARAM_INT);
            $q->execute();
            
            $q = $this->stmt_last;
            $q->execute();
            if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
                return new Post( $data );
            }
        }
        return NULL;
    }

    public function update( Post $post ){
        $q = $this->stmt_update;
        $q->bindParam(':id'  , $thread->getId  (), PDO::PARAM_INT);
        $q->bindParam(':text', $thread->getText(), PDO::PARAM_STR);
        $q->execute();
    }
}
