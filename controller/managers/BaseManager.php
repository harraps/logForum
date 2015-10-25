<?php
require_once('controller/Controller.php');

abstract class BaseManager {

    protected PDO $db;

    public function __construct( PDO $db ){
        $this->db = $db;
    }

    protected function getInstance( string $table, string $column, int $id ){
        $id = (int) $id;
        $q = $this->db->prepare(
            "SELECT * FROM :table WHERE :column = :id ;"
        );
        $q->bindParam(':table',  $table,  PDO::PARAM_STR);
        $q->bindParam(':column', $column, PDO::PARAM_STR);
        $q->bindParam(':id',     $id,     PDO::PARAM_INT);
        $q->execute();
        return $q;
    }

    protected function getInstancesFrom (
        string $table,
        string $column,
        int    $id,
        int    $page,
        int    $number,
        string $order       = NULL,
        bool   $isAscending = NULL
    ){
        $id     = (int) $id;
        $page   = (int) $page;
        $number = (int) $number;

        // does we added params to set the order of the results ?
        $hasOrder = ( $order != NULL && $isAscending != NULL );
        $start    = $page * $number;

        $q = $this->db->prepare(
            "SELECT * FROM :table"
            ." WHERE :column = :id"
            .( $hasOrder ? " ORDER_BY :order :ascend" : "" )
            ." LIMIT :start, :number ;"
        );
        $q->bindParam(':table' , $table , PDO::PARAM_STR);
        $q->bindParam(':column', $column, PDO::PARAM_STR);
        $q->bindParam(':id'    , $id    , PDO::PARAM_INT);
        $q->bindParam(':start' , $start , PDO::PARAM_INT);
        $q->bindParam(':number', $number, PDO::PARAM_INT);
        if( $hasOrder ){
            $ascend = ( $isAscending ? 'ASC' : 'DESC' );
            $q->bindParam(':order' , $order , PDO::PARAM_STR);
            $q->bindParam(':ascend', $ascend, PDO::PARAM_STR);
        }
        $q->execute();
        return $q;
    }

}
