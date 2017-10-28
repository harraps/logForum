<?php
require_once('model/BaseObject.php');

class User extends BaseObject{

    private $name; // string   : the name of the user
    private $desc; // string   : the description of the user
    private $date; // DateTime : the inscription date of the user

    protected function setName( $name ){ $this->name = (string) $name; }
    protected function setDesc( $desc ){ $this->desc = (string) $desc; }
    protected function setDate( $date ){
        if(is_string($date))
            $this->date = DateTime::createFromFormat("Y-m-d H:i:s",$date);
        else
            $this->date = $date;
    }
    
    // constructor to recover user from database
    public function __construct( array $data ){
        $this->setId  ( $data['u_ip'  ] );
        $this->setName( $data['u_name'] );
        $this->setDesc( $data['u_desc'] );
        $this->setDate( $data['u_date'] );
    }
    public function update(){
        global $CONTROLLER;
        return $CONTROLLER
            ->getUserManager()
            ->update( $this );
    }
    
    public function getName() : string   { return $this->name; }
    public function getDesc() : string   { return $this->desc; }
    public function getDate() : DateTime { return $this->date; }
    
    // return the IP of the user in a readable form
    public function getIP() : string {
        $b = unpack("C*", pack("L", $id));
        return sprintf("%d.%d.%d.%d", $b[1],$b[2],$b[3],$b[4]);
    }
    
    // return the posts of this user
    public function getPosts() : array {
        global $CONTROLLER;
        return $CONTROLLER
            ->getPostManager()
            ->getPostsFromUser($this->id);
    }
    // return the threads created by this user
    public function getThreads() : array {
        global $CONTROLLER;
        return $CONTROLLER
            ->getThreadManager()
            ->getThreadsFromUser($this->id);
    }

    

}
