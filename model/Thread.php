<?php
require_once('model/BaseObject.php');

class Thread extends BaseObject{

    private int    $u_id; // the id of the user who created this thread
    private int    $s_id; // the id of the section in which the thread has been created
    private string $name; // the name of the thread
    private int    $stat; // the state of the thread following a mask

    // constructor to recover thread from database
    public function __construct( array $data ){
        $this->setId       ( $data['t_id'  ] );
        $this->setUserId   ( $data['u_id'  ] );
        $this->setSectionId( $data['s_id'  ] );
        $this->setName     ( $data['t_name'] );
        $this->setState    ( $data['t_stat'] );
    }

    protected function setUserId   ( int      $id    ){ $this->$u_id = (int)     $id;   }
    protected function setSectionId( int      $id    ){ $this->$s_id = (int)     $id;   }
    protected function setName     ( string   $name  ){ $this->$name = (string)  $name; }
    protected function setState    ( int      $state ){ $this->$stat = (int)     $stat; }

    public function getUserId   (){ return $this->u_id; }
    public function getSectionId(){ return $this->s_id; }
    public function getName     (){ return $this->name; }
    public function getState    (){ return $this->stat; }

    // return the user who created this thread
    public function getUser(){
        global $CONTROLLER;
        return $CONTROLLER
            ->getUserManager()
            ->getUser($this->u_id);
    }
    // return the section in which this thread has been created
    public function getSection(){
        global $CONTROLLER;
        return $CONTROLLER
            ->getSectionManager()
            ->getSection($this->s_id);
    }

}
