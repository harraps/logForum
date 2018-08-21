<?php
require_once($ROOT_DIR.'model/BaseObject.php');

class Post extends BaseObject{

    private $u_ip; // string   : the ip of the user who posted this message
    private $t_id; // int      : the id of the thread in which the message has been posted
    private $date; // DateTime : the time at which the message has been posted
    private $text; // string   : the text of the message
    
    protected function setUserIp  ( $ip   ){ $this->u_ip = (string) $ip;   }
    protected function setThreadId( $id   ){ $this->t_id = (int)    $id;   }
    protected function setText    ( $text ){ $this->text = (string) $text; }
    protected function setDate( $date ){
        if(is_string($date))
            $this->date = DateTime::createFromFormat("Y-m-d H:i:s",$date);
        else
            $this->date = $date;
    }
    // constructor to recover post from database
    public function __construct( array $data ){
        $this->setId      ( $data['p_id'  ] );
        $this->setUserIp  ( $data['u_ip'  ] );
        $this->setThreadId( $data['t_id'  ] );
        $this->setDate    ( $data['p_date'] );
        $this->setText    ( $data['p_text'] );
    }
    public function update(){
        global $CONTROLLER;
        return $CONTROLLER
            ->getPostManager()
            ->update( $this );
    }
    
    public function getUserIp  () : string   { return $this->u_ip; }
    public function getThreadId() : int      { return $this->t_id; }
    public function getDate    () : DateTime { return $this->date; }
    public function getText    () : string   { return $this->text; }
    
    // return the thread in which this post has been made
    public function getThread() : Thread {
        global $CONTROLLER;
        return $CONTROLLER
            ->getThreadManager()
            ->getThread($this->t_id);
    }
}
