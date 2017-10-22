<?php
require_once('model/BaseObject.php');

class Chat extends BaseObject{
    
    private $u_id; // int      : the id of the user who posted this message
    private $date; // DateTime : the time at which the message has been posted
    private $text; // string   : the text of the message
    
    protected function setUserId  ( $id   ){ $this->u_id = (int)    $id;   }
    protected function setText    ( $text ){ $this->text = (string) $text; }
    protected function setDate( $date ){
        if(is_string($date))
            $this->date = DateTime::createFromFormat("Y-m-d H:i:s",$date);
        else
            $this->date = $date;
    }
    // constructor to recover post from database
    public function __construct( array $data ){
        $this->setId      ( $data['c_id'  ] );
        $this->setUserId  ( $data['u_id'  ] );
        $this->setDate    ( $data['c_date'] );
        $this->setText    ( $data['c_text'] );
    }
    public function update(){
        global $CONTROLLER;
        return $CONTROLLER
            ->getChatManager()
            ->update( $this );
    }
    
    public function getUserId  () : int      { return $this->u_id; }
    public function getDate    () : DateTime { return $this->date; }
    public function getText    () : string   { return $this->text; }

    // return the user who created this post
    public function getUser() : User {
        global $CONTROLLER;
        return $CONTROLLER
            ->getUserManager()
            ->getUser($this->u_id);
    }
}