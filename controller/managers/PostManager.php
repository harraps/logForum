<?php
require_once('controller/managers/BaseManager.php');
require_once('model/Post.php');

class PostManager extends BaseManager{

    private $nbEnt_u; // number of posts per page for users
    private $nbEnt_t; // number of posts per page for threads

    public function __construct( PDO $db, $nbEnt_u, $nbEnt_t ){
        $nbEnt_u = (int) $nbEnt_u;
        $nbEnt_t = (int) $nbEnt_t;
        parent::__construct($db);
        $this->nbEnt_u = (int) $nbEnt_u;
        $this->nbEnt_t = (int) $nbEnt_t;
    }

    public function getPost( int $id ){
        $q = $this->getInstance( 'Post', 'p_id', $id );
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){ // there is only one post for this id at most
            return new Post( $data );
        }
    }

    public function getPostsFromUser   ( int $id, int $page ){
        return $this->getPostsFrom('u_id',$id,$page,$this->nbEnt_u);
    }
    public function getPostsFromThread ( int $id, int $page ){
        return $this->getPostsFrom('t_id',$id,$page,$this->nbEnt_t);
    }
    protected function getPostsFrom( string $column, int $id, int $page, int $number ){
        $q = $this->getInstancesFrom('Post',$column,$id,$page,$number,'p_date',TRUE);
        $posts = [];
        while( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            $posts[] = new Post( $data );
        }
        return $posts;
    }

    public function getNbPagesFromUser( int $id ){
        return $this->getNbPagesFrom('Post','u_id',$id,$this->nbEnt_u);
    }
    public function getNbPagesFromThread( int $id ){
        return $this->getNbPagesFrom('Post','t_id',$id,$this->nbEnt_t);
    }

    public function create( int $u_id, int $t_id, string $text ){
        $q = $this->createObject('Post','p_id',[
            'u_id'   => $u_id,
            't_id'   => $t_id,
            'p_text' => $text
        ]);
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            // we update the date of the thread
            $q2 = $this->db->prepare(
                'UPDATE `Thread` SET `t_date` = CURRENT_TIMESTAMP WHERE `t_id` = :t_id ;'
            );
            $q2->bindParam(':t_id', $t_id, PDO::PARAM_INT);
            $q2->execute();
            return new Post( $data );
        }
    }

    public function update( Post $post ){
        $this->updateObject('Post','p_id',$post->getId(),[
            'p_text' => $post->getText()
        ]);
    }
}
