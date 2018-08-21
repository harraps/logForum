<?php

//require_once($ROOT_DIR.'controller/Controller.php');

abstract class BaseObject {

    protected $id; // int : the id of the object
    
    protected function setId( $id ){ $this->id = (int) $id; }
    
    public abstract function __construct( array $data );
    public abstract function update();
    
    public function getId() : int { return $this->id; }
}
