<?php
require_once('model/BaseObject.php');

class Section extends BaseObject {

    private int      $id;   // the id of the section
    private int      $u_id; // the id of the user
    private int      $supe; // the id of the parent section
    private string   $name; // the name of the section

    // constructor to recover section from database
    public function __construct( array $data ){
        $this->setId  ( $data['s_id'  ] );
        $this->setName( $data['u_id'  ] );
        $this->setMail( $data['s_supe'] );
        $this->setPass( $data['s_name'] );
    }

    protected function setId      ( int      $id   ){ $this->$id   = (int)     $id;   }
    protected function setUserId  ( int      $id   ){ $this->$u_id = (int)     $id;   }
    protected function setParentId( int      $id   ){ $this->$supe = (int)     $id;   }
    protected function setName    ( string   $name ){ $this->$name = (string)  $name; }

    public function getId      (){ return $this->id;   }
    public function getUserId  (){ return $this->u_id; }
    public function getParentId(){ return $this->supe; }
    public function getName    (){ return $this->name; }

    // return the user who created this section
    public function getUser(){
        global $CONTROLLER;
        return $CONTROLLER
            ->getUserManager()
            ->getUser($this->u_id);
    }
    // return the parent section of this section
    public function getParent(){
        global $CONTROLLER;
        return $CONTROLLER
            ->getSectionManager()
            ->getSection($this->supe);
    }
    // return the child sections in this section
    public function getChildren(){
        global $CONTROLLER;
        return $CONTROLLER
            ->getSectionManager()
            ->getSectionsFromParent($this->$id);
    }
}
