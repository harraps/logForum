<?php
require_once('controller/managers/BaseManager.php');
require_once('model/Post.php');

class PostManager extends BaseManager{

        public function getPostsFromUser   ( int $id ){ return $this->getPost($id,'u_id'); }
        public function getPostsFromThread ( int $id ){ return $this->getPost($id,'t_id'); }

        protected function getPostsFrom ( int $id, string $column ){
            $id = (int) $id;
            $posts = [];
            $q = $this->db->query('SELECT * FROM `Post` WHERE `'.$column.'` = '.$id);
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
