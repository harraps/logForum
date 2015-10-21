<?php
require_once('model/BaseObject.php');

class Post extends BaseObject{

    private DateTime $date; // the time at which the message has been posted
    private int      $u_id; // the id of the user who posted this message
    private int      $t_id; // the id of the thread in which the message has been posted
    private string   $text; // the text of the message

    // constructor to recover post from database
    public function __construct( array $data ){
        $this->setDate    ( $data['p_date'] );
        $this->setUserId  ( $data['u_id'  ] );
        $this->setThreadId( $data['t_id'  ] );
        $this->setText    ( $data['p_text'] );
    }

    protected function setDate    ( DateTime $date ){ $this->$date = (DateTime)$date; }
    protected function setUserId  ( int      $id   ){ $this->$u_id = (int)     $id;   }
    protected function setThreadId( int      $id   ){ $this->$t_id = (int)     $id;   }
    protected function setText    ( string   $text ){ $this->$text = (string)  $text; }

    public function getDate    (){ return $this->date; }
    public function getUserId  (){ return $this->u_id; }
    public function getThreadId(){ return $this->t_id; }
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
}
