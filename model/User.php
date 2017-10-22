<?php
require_once('model/BaseObject.php');

class User extends BaseObject{

    private $name; // string   : the name of the user
    private $mail; // string   : the email of the user
    private $pass; // string   : the crypted password of the user
    private $date; // DateTime : the inscription date of the user
    private $perm; // int      : the permissions of the user based on a mask

    protected function setName( $name ){ $this->name = (string) $name; }
    protected function setMail( $mail ){ $this->mail = (string) $mail; }
    protected function setPass( $pass ){ $this->pass = (string) $pass; }
    protected function setPerm( $perm ){ $this->perm = (int)    $perm; }
    protected function setDate( $date ){
        if(is_string($date))
            $this->date = DateTime::createFromFormat("Y-m-d H:i:s",$date);
        else
            $this->date = $date;
    }
    
    // constructor to recover user from database
    public function __construct( array $data ){
        $this->setId  ( $data['u_id'  ] );
        $this->setName( $data['u_name'] );
        $this->setMail( $data['u_mail'] );
        $this->setPass( $data['u_pass'] );
        $this->setDate( $data['u_date'] );
        $this->setPerm( $data['u_perm'] );
    }
    public function update(){
        global $CONTROLLER;
        return $CONTROLLER
            ->getUserManager()
            ->update( $this );
    }
    
    public function getName() : string   { return $this->name; }
    public function getMail() : string   { return $this->mail; }
    public function getPass() : string   { return $this->pass; }
    public function getDate() : DateTime { return $this->date; }
    public function getPerm() : int      { return $this->perm; }

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
    // return the sections created by this user
    public function getSections() : array {
        global $CONTROLLER;
        return $CONTROLLER
            ->getSectionManager()
            ->getSectionsFromUser($this->id);
    }

    

}
