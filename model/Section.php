<?php
require_once($ROOT_DIR.'model/BaseObject.php');

class Section extends BaseObject {
    
    private $u_ip; // string : the ip of the user who created this section
    private $name; // string : the name of the section
    private $desc; // string : the description of the section
    
    protected function setUserIp     ( $ip   ){ $this->u_ip = (string) $ip;   }
    protected function setName       ( $name ){ $this->name = (string) $name; }
    protected function setDescription( $desc ){ $this->desc = (string) $desc; }
    
    // constructor to recover section from database
    public function __construct( array $data ){
        $this->setId         ( $data['s_id'  ] );
        $this->setUserIp     ( $data['u_ip'  ] );
        $this->setName       ( $data['s_name'] );
        $this->setDescription( $data['s_desc'] );
    }
    public function update(){
        global $CONTROLLER;
        return $CONTROLLER
            ->getSectionManager()
            ->update( $this );
    }
    
    public function getUserIp     () : string { return $this->u_ip; }
    public function getName       () : string { return $this->name; }
    public function getDescription() : string { return $this->desc; }
    
    // return the child sections in this section
    public function getThreads() : array {
        global $CONTROLLER;
        return $CONTROLLER
            ->getSectionManager()
            ->getSectionsFromParent($this->$id);
    }
}
