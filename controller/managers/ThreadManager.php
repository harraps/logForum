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

    public function create( int $u_id, int $t_id, string $name ){
        $q = $this->createObject('Thread','t_id',[
            'u_id'   => $u_id,
            't_id'   => $t_id,
            't_name' => $name
        ]);
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            return new Thread( $data );
        }
    }

    public function update( Thread $thread ){
        $this->updateObject('Thread','t_id',$thread->getId(),[
            'u_id'   => $thread->getUserId   (),
            's_id'   => $thread->getSectionId(),
            't_name' => $thread->getName     (),
            't_date' => $thread->getDate     (),
            't_stat' => $thread->getState    ()
        ]);
    }
}
