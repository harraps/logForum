<?php
require_once('model/BaseObject.php');

class Thread extends BaseObject{

    private $u_id; // int      : the id of the user who created this thread
    private $s_id; // int      : the id of the section in which the thread has been created
    private $name; // string   : the name of the thread
    private $date; // DateTime : the date of the last post on the thread

    protected function setUserId   ( $id    ){ $this->u_id = (int)    $id;    }
    protected function setSectionId( $id    ){ $this->s_id = (int)    $id;    }
    protected function setName     ( $name  ){ $this->name = (string) $name;  }
    protected function setDate( $date ){
        if(is_string($date))
            $this->date = DateTime::createFromFormat("Y-m-d H:i:s",$date);
        else
            $this->date = $date;
    }
    
    // constructor to recover thread from database
    public function __construct( array $data ){
        $this->setId       ( $data['t_id'  ] );
        $this->setUserId   ( $data['u_ip'  ] );
        $this->setSectionId( $data['s_id'  ] );
        $this->setName     ( $data['t_name'] );
        $this->setDate     ( $data['t_date'] );
    }
    public function update(){
        global $CONTROLLER;
        return $CONTROLLER
            ->getThreadManager()
            ->update( $this );
    }
    
    public function getUserId   () : int      { return $this->u_id; }
    public function getSectionId() : int      { return $this->s_id; }
    public function getName     () : string   { return $this->name; }
    public function getDate     () : DateTime { return $this->date; }

    // return the user who created this thread
    public function getUser() : User {
        global $CONTROLLER;
        $id = $this->u_id ?: -1;
        return $CONTROLLER
            ->getUserManager()
            ->getUser($id);
    }
    // return the section in which this thread has been created
    public function getSection() : Section {
        global $CONTROLLER;
        return $CONTROLLER
            ->getSectionManager()
            ->getSection($this->s_id);
    }
}
