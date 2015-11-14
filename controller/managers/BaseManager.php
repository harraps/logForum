<?php
require_once('controller/Controller.php');

abstract class BaseManager {

    protected $db; // PDO

    protected function __construct( PDO $db ){
        $this->db = $db;
    }

    protected function getInstance(
        $table,  // string : the name of the table we want to get the instane from
        $column, // string : the name of the column of the instance id
        $id      // int    : the instance id we want
    ){
        $table  = (string) $table;
        $column = (string) $column;
        $id     = (int)    $id;
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
        $table,  // string : the name of the table we want to get the instance from
        $column, // string : the name of the column of parent id
        $id,     // int    : the parent id we want
        $page,   // int    : the page number of the instances
        $number, // int    : the number of instances per page
        $order       = NULL,  // string : the column we want to order by
        $isAscending = FALSE, // bool   : should we order by ASC ?
        $checkId     = TRUE   // bool   : should we check the parent id
    ){
        $table  = (string) $table;
        $column = (string) $column;
        $id     = (int)    $id;
        $page   = (int)    $page;
        $number = (int)    $number;

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
        $table,  // string : the name of the table we want to get the number of pages from
        $column, // string : the name of the column of parent id
        $id,     // int    : the parent id we want
        $number, // int    : the number of instances per page
        $checkId = TRUE // bool : should we check the parent id ?
    ){
        $table  = (string) $table;
        $column = (string) $column;
        $id     = (int)    $id;
        $number = (int)    $number;

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
        $table,  // string : the table in which we want to create an object
        $column, // string : the column of ids
        array  $data // the data of the object
    ){
        $table  = (string) $table;
        $column = (string) $column;
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
        $q = $this->db->prepare('SELECT * FROM :table WHERE :column = LAST_INSERT_ID()');
        $q->bindParam(':table' , $table , PDO::PARAM_STR);
        $q->bindParam(':column', $column, PDO::PARAM_INT);
        $q->execute();
        return $q;
    }

    protected function updateObject(
        $table,  // string : the table in which we want to update the object
        $column, // string : the column of ids
        $id,     // int    : the id of the object
        array  $data
    ){
        $table  = (string) $table;
        $column = (string) $column;
        $id     = (int)    $id;
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
