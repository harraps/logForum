<?php
require_once('controller/managers/BaseManager.php');
require_once('model/Thread.php');

class ThreadManager extends BaseManager{

    public function getThread ( int $id ){
        $id = (int) $id;
        $q = $this->db->query('SELECT * FROM `Thread` WHERE `t_id` = '.$id);
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){ // there is only one thread for this id at most
            return new Thread( $data );
        }
    }

    public function getThreadsFromUser     ( int $id ){ return $this->getThreadFrom($id,'u_id'); }
    public function getThreadsFromCategory ( int $id ){ return $this->getThreadFrom($id,'c_id'); }

    protected function getThreadsFrom ( int $id, string $column ){
        $id = (int) $id;
        $threads = [];
        $q = $this->db->query('SELECT * FROM `Thread` WHERE `'.$column.'` = '.$id);
        while( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            $threads[] = new Thread( $data );
        }
        return $threads;
    }
}
