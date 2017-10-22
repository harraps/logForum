<?php
require_once('controller/managers/BaseManager.php');
require_once('model/Section.php');

class SectionManager extends BaseManager{
    
    // statements to create and destroy entries
    private $stmt_inst;
    private $stmt_inst_all;
    private $stmt_nbpg_all;
    
    private $stmt_last;
    private $stmt_create;
    private $stmt_update;
    
    public function __construct( PDO $db, int $nbEnt ){
        parent::__construct($db, $nbEnt);
        
        // statements initialization
        $this->stmt_inst = $this->db->prepare(
            "SELECT * FROM `Section` WHERE `s_id` = :id ;"
        );
        $this->stmt_inst_all = $db->prepare(
            "SELECT * FROM `Section` ORDER BY `s_name` ASC LIMIT :start , :number ;"
        );
        $this->stmt_nbpg_all= $db->prepare(
            "SELECT COUNT(*) AS `count` FROM `Section` ;"
        );
        
        $this->stmt_last = $db->prepare(
            "SELECT * FROM `Section` WHERE `s_id` = LAST_INSERT_ID();"
        );
        $this->stmt_create = $this->db->prepare(
            "INSERT INTO `Section` (`s_name`,`s_desc`) VALUES ( :name , :desc );"
        );
        $this->stmt_update = $this->db->prepare(
            "UPDATE `Section` SET `s_name` = :name , `s_desc` = :desc WHERE `s_id` = :id ;"
        );
    }

    public function getSection( int $id ){
        $q = $this->stmt_inst;
        $q->bindParam(':id', $id, PDO::PARAM_INT);
        $q->execute();
        
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){ // there is only one section for this id at most
            return new Section( $data );
        }
        return NULL;
    }
    
    public function getSections( int $page ){
        $number = $this->nbEnt;
        $start  = $page * $number;
        
        $q = $this->stmt_inst_all;
        $q->bindParam(':start' , $start , PDO::PARAM_INT);
        $q->bindParam(':number', $number, PDO::PARAM_INT);
        $q->execute();
        
        $sections = [];
        while( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            $sections[] = new Section( $data );
        }
        return $sections;
    }

    public function getNbPages( int $id ){
        $q = $this->stmt_nbpg_all;
        $q->execute();
        
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            return ceil( $data['count'] / $this->nbEnt );
        }
        return 0;
    }

    public function create( string $name, string $desc ){
        $q = $this->stmt_create;
        $q->bindParam(':name', $name, PDO::PARAM_STR);
        $q->bindParam(':desc', $desc, PDO::PARAM_STR);
        
        if( $q->execute() ){ // if insertion successful
            $q = $this->stmt_last;
            $q->execute();
            if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
                return new Section( $data );
            }
        }
        return NULL;
    }

    public function update( Section $section ){
        $q = $this->stmt_update;
        $q->bindParam(':id'  , $section->getId         (), PDO::PARAM_INT);
        $q->bindParam(':name', $section->getName       (), PDO::PARAM_STR);
        $q->bindParam(':desc', $section->getDescription(), PDO::PARAM_STR);
        $q->execute();
    }

}
