<?php
require_once('controller/managers/BaseManager.php');
require_once('model/Thread.php');

class ThreadManager extends BaseManager{

    private $nbEnt_u; // number of threads per page for users
    private $nbEnt_s; // number of threads per page for sections

    public function __construct( PDO $db, $nbEnt_u, $nbEnt_s ){
        $nbEnt_u = (int) $nbEnt_u;
        $nbEnt_s = (int) $nbEnt_s;
        parent::__construct($db);
        $this->nbEnt_u = (int) $nbEnt_u;
        $this->nbEnt_s = (int) $nbEnt_s;
    }

    public function getThread ( int $id ){
        $q = $this->getInstance( 'Thread', 't_id', $id );
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){ // there is only one thread for this id at most
            return new Thread( $data );
        }
    }

    public function getThreadsFromUser    ( int $id, int $page ){
        return $this->getThreadFrom('u_id',$id,$page,$this->nbEnt_u);
    }
    public function getThreadsFromSection ( int $id, int $page ){
        return $this->getThreadFrom('s_id',$id,$page,$this->nbEnt_s);
    }
    protected function getThreadsFrom ( string $column, int $id, int $page, int $number ){
        $q = $this->getInstancesFrom('Thread',$column,$id,$page,$number,'t_date',TRUE);
        $threads = [];
        while( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            $threads[] = new Thread( $data );
        }
        return $threads;
    }

    public function getNbPagesFromUser( int $id ){
        return $this->getNbPagesFrom('Thread','u_id',$id,$this->nbEnt_u);
    }
    public function getNbPagesFromSection( int $id ){
        return $this->getNbPagesFrom('Thread','s_id',$id,$this->nbEnt_s);
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
