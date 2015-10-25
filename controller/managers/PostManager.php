<?php
require_once('controller/managers/BaseManager.php');
require_once('model/Post.php');

class PostManager extends BaseManager{

        public function getPost( int $id ){
            $q = $this->getInstance( 'Post', 'p_id', $id );
            if( $data = $q->fetch(PDO::FETCH_ASSOC) ){ // there is only one post for this id at most
                return new Post( $data );
            }
        }

        public function getPostsFromUser   ( int $id, int $page, int $number ){
            return $this->getPostsFrom('u_id',$id,$page,$number);
        }
        public function getPostsFromThread ( int $id, int $page, int $number ){
            return $this->getPostsFrom('t_id',$id,$page,$number);
        }
        protected function getPostsFrom( string $column, int $id, int $page, int $number ){
            $q = $this->getInstancesFrom('Post',$column,$id,$page,$number,'p_date',TRUE);
            $posts = [];
            while( $data = $q->fetch(PDO::FETCH_ASSOC) ){
                $posts[] = new Post( $data );
            }
            return $posts;
        }

        public function create( int $u_id, int $t_id, string $text ){
            $sql = "INSERT INTO `Post` (`u_id`,`t_id`,`text`)"
                ." VALUES ("
                ."'".$u_id."',"
                ."'".$t_id."',"
                ."'".$text."');";
            $this->db->exec($sql);
            $q = $this->db->query('SELECT * FROM `Post` WHERE `p_id` = LAST_INSERT_ID()');
            if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
                return new Post( $data );
            }
        }

        public function update( Post $post ){
            $sql = "UPDATE `Post`"
                ." SET "
                ."`p_text` = '".$post->getText    ()."'"
                ." WHERE "
                ."`p_date` = '".$post->getDate    ()."',"
                ."`u_id`   = '".$post->getUserId  ()."',"
                ."`t_id`   = '".$post->getThreadId()."';";
            $this->db->exec($sql);
        }
}
