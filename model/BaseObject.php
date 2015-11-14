<?php

require_once('controller/Controller.php');

abstract class BaseObject {

    protected $id; // int : the id of the object

    public abstract function __construct( array $data );

    protected function setId( int $id ){ $this->id = (int) $id; }
    public    function getId()         { return $this->id;      }

    public abstract function update();
}
