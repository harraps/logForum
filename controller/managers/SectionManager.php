<?php
require_once('controller/managers/BaseManager.php');
require_once('model/Section.php');

class SectionManager extends BaseManager{

    private $nbEnt_u; // int : number of sections per page for users
    private $nbEnt_s; // int : number of sections per page for parent sections

    public function __construct( PDO $db, $nbEnt_u, $nbEnt_s ){
        $nbEnt_u = (int) $nbEnt_u;
        $nbEnt_s = (int) $nbEnt_s;
        parent::__construct($db);
        $this->nbEnt_u = (int) $nbEnt_u;
        $this->nbEnt_s = (int) $nbEnt_s;
    }

    public function getSection( $id ){
        $id = (int) $id;
        $q = $this->getInstance( 'Section', 's_id', $id );
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){ // there is only one section for this id at most
            return new Section( $data );
        }
    }

    public function getSectionsFromUser  ( $id, $page ){
        $id   = (int) $id;
        $page = (int) $page;
        return $this->getSectionFrom('u_id',$id,$page,$this->nbEnt_u);
    }
    public function getSectionsFromParent( $id, $page ){
        $id   = (int) $id;
        $page = (int) $page;
        return $this->getSectionsFrom('s_supe',$id,$page,$this->nbEnt_s);
    }
    protected function getSectionsFrom( $column, $id, $page, $number ){
        $column = (string) $column;
        $id     = (int)    $id;
        $page   = (int)    $page;
        $number = (int)    $number;
        $q = $this->getInstancesFrom('Section',$column,$id,$page,$number,'s_name',TRUE);
        $sections = [];
        while( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            $sections[] = new Section( $data );
        }
        return $sections;
    }

    public function getNbPagesFromUser( $id ){
        $id = (int) $id;
        return $this->getNbPagesFrom('Section','u_id',$id,$this->nbEnt_u);
    }
    public function getNbPagesFromParent( $id ){
        $id = (int) $id;
        return $this->getNbPagesFrom('Section','s_supe',$id,$this->nbEnt_s);
    }

    public function create( $u_id, $supe, $name ){
        $u_id = (int)    $u_id;
        $supe = (int)    $supe;
        $name = (string) $name;
        $q = $this->createObject('Section','s_id',[
            'u_id'   => $u_id,
            's_supe' => $supe,
            's_name' => $name
        ]);
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            return new Section( $data );
        }
    }

    public function update( Section $section ){
        $this->updateObject('Section','s_id',$section->getId(),[
            'u_id'   => $section->getUserId(),
            's_supe' => $section->getParentId(),
            's_name' => $section->getName()
        ]);
    }

}
