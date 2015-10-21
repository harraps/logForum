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
}
