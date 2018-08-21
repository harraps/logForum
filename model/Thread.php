<?php
require_once($ROOT_DIR.'model/BaseObject.php');

class Thread extends BaseObject{

    private $u_ip; // int      : the ip of the user who created this thread
    private $s_id; // int      : the id of the section in which the thread has been created
    private $name; // string   : the name of the thread
    private $date; // DateTime : the date of the last post on the thread

    protected function setUserIp   ( $ip    ){ $this->u_ip = (string) $ip;    }
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
        $this->setUserIp   ( $data['u_ip'  ] );
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
    
    public function getUserIp   () : string   { return $this->u_ip; }
    public function getSectionId() : int      { return $this->s_id; }
    public function getName     () : string   { return $this->name; }
    public function getDate     () : DateTime { return $this->date; }

    // return the section in which this thread has been created
    public function getSection() : Section {
        global $CONTROLLER;
        return $CONTROLLER
            ->getSectionManager()
            ->getSection($this->s_id);
    }
}
