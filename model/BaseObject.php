<?php

require_once('controller/Controller.php');

abstract class BaseObject {

    protected int $id; // the id of the object

    public    function __construct( array $data );

    protected function setId( int $id ){ $this->id = (int) $id; }
    public    function getId()         { return $this->id;      }

    public    function update();
}
