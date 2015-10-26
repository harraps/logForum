<?php
require_once('controller/Controller.php');

abstract class BaseManager {

    protected PDO $db;

    protected function __construct( PDO $db ){
        $this->db = $db;
    }

    protected function getInstance(
        string $table,
        string $column,
        int    $id
    ){
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
               $isAscending = FALSE,
               $checkId     = TRUE
    ){
        $id     = (int) $id;
        $page   = (int) $page;
        $number = (int) $number;

        // does we added params to set the order of the results ?
        $hasOrder = ( $order != NULL && $isAscending != NULL );
        $start    = $page * $number;

        $q = $this->db->prepare(
            "SELECT * FROM :table"
            .( $checkId  ? " WHERE :column = :id"     : "" )
            .( $hasOrder ? " ORDER_BY :order :ascend" : "" )
            ." LIMIT :start, :number ;"
        );
        $q->bindParam(':table' , $table , PDO::PARAM_STR);
        $q->bindParam(':start' , $start , PDO::PARAM_INT);
        $q->bindParam(':number', $number, PDO::PARAM_INT);
        if( $checkId ){
            $q->bindParam(':column', $column, PDO::PARAM_STR);
            $q->bindParam(':id'    , $id    , PDO::PARAM_INT);
        }
        if( $hasOrder ){
            $ascend = ( $isAscending ? 'ASC' : 'DESC' );
            $q->bindParam(':order' , $order , PDO::PARAM_STR);
            $q->bindParam(':ascend', $ascend, PDO::PARAM_STR);
        }
        $q->execute();
        return $q;
    }

    protected function getNbPagesFrom (
        string $table,
        string $column,
        int    $id,
        int    $number,
               $checkId = TRUE
    ){
        $id     = (int) $id;
        $number = (int) $number;

        $q = $this->db->prepare(
            "SELECT COUNT(*) AS `count` FROM :table"
            .( $checkId ? " WHERE :column = :id ;" : ";")
        );
        $q->bindParam(':table' , $table , PDO::PARAM_STR);
        if( $checkId ){
            $q->bindParam(':column', $column, PDO::PARAM_STR);
            $q->bindParam(':id'    , $id    , PDO::PARAM_INT);
        }
        $q->execute();
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            return ceil( $data['count'] / $number );
        }
    }

    protected function createObject(
        string $table,
        string $id,
        array  $data
    ){
        reset( $data );
        $first = key( $data );
        $params = "(";
        $values = "(";
        foreach( $data as $key => $value ){
            if( $key === $first ){ // if first, we don't add a comma
                $params .= " :".$key;
                $values .= " :".$value;
            }else{
                $params .= ", :".$key;
                $values .= ", :".$value;
            }
        }
        $params .= " )";
        $values .= " )";

        $q = $this->db->prepare(
            "INSERT INTO :table ".params." VALUES ".$values.";"
        );
        $q->bindParam(':table', $table, PDO::PARAM_STR);
        foreach( $data as $key => $value ){
            $q->bindParam(':'.$key,   $key,  PDO::PARAM_STR);
            $q->bindParam(':'.$value, $value );
        }
        $q->execute();

        // we recover the object we just created
        $q = $this->db->prepare('SELECT * FROM :table WHERE :id = LAST_INSERT_ID()');
        $q->bindParam(':table', $table, PDO::PARAM_STR);
        $q->bindParam(':id'   , $id   , PDO::PARAM_INT);
        $q->execute();
        return $q;
    }

    protected function updateObject(
        string $table,
        string $column,
        int    $id,
        array  $data
    ){
        reset( $data );
        $first = key( $data );
        $values = "";
        foreach( $data as $key => $value ){
            if( $key === $first ){ // if first, we don't add a comma
                $values .= " :".$key." = :".$value;
            }else{
                $values .= ", :".$key." = :".$value;
            }
        }

        $q = $this->db->prepare(
            "UPDATE :table SET ".params." WHERE :column = :id ;"
        );
        $q->bindParam(':table',  $table,  PDO::PARAM_STR);
        $q->bindParam(':column', $column, PDO::PARAM_STR);
        $q->bindParam(':id',     $id,     PDO::PARAM_INT);
        foreach( $data as $key => $value ){
            $q->bindParam(':'.$key,   $key,  PDO::PARAM_STR);
            $q->bindParam(':'.$value, $value );
        }
        $q->execute();
    }
}
