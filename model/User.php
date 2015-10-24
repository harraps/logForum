<?php
require_once('model/BaseObject.php');

class User extends BaseObject{

    private string   $name; // the name of the user
    private string   $mail; // the email of the user
    private string   $pass; // the crypted password of the user
    private DateTime $date; // the inscription date of the user
    private int      $perm; // the permissions of the user based on a mask

    // constructor to recover user from database
    public function __construct( array $data ){
        $this->setId  ( $data['u_id'  ] );
        $this->setName( $data['u_name'] );
        $this->setMail( $data['u_mail'] );
        $this->setPass( $data['u_pass'] );
        $this->setDate( $data['u_date'] );
        $this->setPerm( $data['u_perm'] );
    }

    protected function setName( string   $name ){ $this->$name = (string)  $name; }
    protected function setMail( string   $mail ){ $this->$mail = (string)  $mail; }
    protected function setPass( string   $pass ){ $this->$pass = (string)  $pass; }
    protected function setDate( DateTime $date ){ $this->$date = (DateTime)$date; }
    protected function setPerm( int      $perm ){ $this->$perm = (int)     $perm; }

    public function getName(){ return $this->name; }
    public function getMail(){ return $this->mail; }
    public function getPass(){ return $this->pass; }
    public function getDate(){ return $this->date; }
    public function getPerm(){ return $this->perm; }

    // return the posts of this user
    public function getPosts(){
        global $CONTROLLER;
        return $CONTROLLER
            ->getPostManager()
            ->getPostsFromUser($this->id);
    }
    // return the threads created by this user
    public function getThreads(){
        global $CONTROLLER;
        return $CONTROLLER
            ->getThreadManager()
            ->getThreadsFromUser($this->id);
    }
    // return the sections created by this user
    public function getSections(){
        global $CONTROLLER;
        return $CONTROLLER
            ->getSectionManager()
            ->getSectionsFromUser($this->id);
    }

}
