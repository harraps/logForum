<?php
require_once('controller/managers/BaseManager.php');
require_once('model/Section.php');

class SectionManager extends BaseManager{

    public function getSection( int $id ){
        $id = (int) $id;
        $q = $this->db->query('SELECT * FROM `Section` WHERE `s_id` = '.$id);
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){ // there is only one section for this id at most
            return new Section( $data );
        }
    }

    public function getSectionsFromUser  ( int $id ){ return $this->getSectionFrom($id,'u_id'  ); }
    public function getSectionsFromParent( int $id ){ return $this->getSectionFrom($id,'s_supe'); }

    protected function getSectionsFrom( int $id, string $column ){
        $id = (int) $id;
        $sections = [];
        $q = $this->db->query('SELECT * FROM `Section` WHERE `'.$column.'` = '.$id);
        while( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            $sections[] = new Section( $data );
        }
        return $sections;
    }

    public function create( int $u_id, int $supe, string $name ){
        $sql = "INSERT INTO `Section` (`u_id`,`s_supe`,`s_name`)"
            ." VALUES ("
            ."'".$u_id."',"
            ."'".$supe."',"
            ."'".$name."');";
        $this->db->exec($sql);
        $q = $this->db->query('SELECT * FROM `Section` WHERE `s_id` = LAST_INSERT_ID()');
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            return new Section( $data );
        }
    }

    public function update( Section $section ){
        $sql = "UPDATE `Section`"
            ." SET "
            ."`s_supe` = ".$section->getParentId()."',"
            ."`s_name` = ".$section->getName    ()."'"
            ." WHERE "
            ."`s_id`   = '".$section->getId     ()."';";
        $this->db->exec($sql);
    }

}
