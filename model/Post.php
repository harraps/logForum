<?php
require_once('model/BaseObject.php');

class Post extends BaseObject{

    private $u_id; // int      : the id of the user who posted this message
    private $t_id; // int      : the id of the thread in which the message has been posted
    private $date; // DateTime : the time at which the message has been posted
    private $text; // string   : the text of the message

    // constructor to recover post from database
    public function __construct( array $data ){
        $this->setId      ( $data['p_id'  ] );
        $this->setUserId  ( $data['u_id'  ] );
        $this->setThreadId( $data['t_id'  ] );
        $this->setDate    ( $data['p_date'] );
        $this->setText    ( $data['p_text'] );
    }

    protected function setUserId  ( int      $id   ){ $this->$u_id = (int)    $id;   }
    protected function setThreadId( int      $id   ){ $this->$t_id = (int)    $id;   }
    protected function setDate    ( DateTime $date ){ $this->$date =          $date; }
    protected function setText    ( string   $text ){ $this->$text = (string) $text; }

    public function getUserId  (){ return $this->u_id; }
    public function getThreadId(){ return $this->t_id; }
    public function getDate    (){ return $this->date; }
    public function getText    (){ return $this->text; }

    // return the user who created this post
    public function getUser(){
        global $CONTROLLER;
        return $CONTROLLER
            ->getUserManager()
            ->getUser($this->u_id);
    }
    // return the thread in which this post has been made
    public function getThread(){
        global $CONTROLLER;
        return $CONTROLLER
            ->getThreadManager()
            ->getThread($this->t_id);
    }

    public function update(){
        global $CONTROLLER;
        return $CONTROLLER
            ->getPostManager()
            ->update( $this );
    }
}
