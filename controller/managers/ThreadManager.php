<?php
require_once('controller/managers/BaseManager.php');
require_once('model/Thread.php');

class ThreadManager extends BaseManager{

    public function getThread ( int $id ){
        $q = $this->getInstance( 'Thread', 't_id', $id );
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){ // there is only one thread for this id at most
            return new Thread( $data );
        }
    }

    public function getThreadsFromUser     ( int $id, int $page, int $number ){
        return $this->getThreadFrom('u_id',$id,$page,$number);
    }
    public function getThreadsFromCategory ( int $id, int $page, int $number ){
        return $this->getThreadFrom('c_id',$id,$page,$number);
    }
    protected function getThreadsFrom ( string $column, int $id, int $page, int $number ){
        $q = $this->getInstancesFrom('Thread',$column,$id,$page,$number,'t_date',TRUE);
        $threads = [];
        while( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            $threads[] = new Thread( $data );
        }
        return $threads;
    }

    public function create( int $u_id, int $t_id, string $text ){
        $sql = "INSERT INTO `Thread` (`u_id`,`s_id`,`t_name`)"
            ." VALUES ("
            ."'".$u_id."',"
            ."'".$s_id."',"
            ."'".$name."');";
        $this->db->exec($sql);
        $q = $this->db->query('SELECT * FROM `Thread` WHERE `t_id` = LAST_INSERT_ID()');
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            return new Thread( $data );
        }
    }

    public function update( Thread $thread ){
        $sql = "UPDATE `Thread`"
            ." SET "
            ."`s_id`   = ".$thread->getSectionId()."',"
            ."`t_name` = ".$thread->getName     ()."',"
            ."`t_stat` = ".$thread->getState    ()."'"
            ." WHERE "
            ."`t_id`   = '".$thread->getId      ()."';";
        $this->db->exec($sql);
    }
}
