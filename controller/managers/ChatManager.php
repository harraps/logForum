<?php
require_once('controller/Controller.php');
require_once('model/Chat.php');

class ChatManager extends BaseManager{
    
    // statements to create and destroy entries
    private $stmt_inst;
    private $stmt_inst_select;
    private $stmt_nben_select;
    
    private $stmt_last;
    private $stmt_create;
    private $stmt_update;
    
    private $stmt_clean;
    
    public function __construct( PDO $db, int $nbEnt ){
        parent::__construct($db, $nbEnt);
        
        // statements initialization
        $this->stmt_inst = $this->db->prepare(
            "SELECT * FROM `Chat` WHERE `c_id` = :id ;"
        );
        $this->stmt_inst_select = $this->db->prepare(
            "SELECT * FROM `Chat` ORDER BY `c_date` ASC LIMIT :number ;"
        );
        $this->stmt_nben_select = $this->db->prepare(
            "SELECT COUNT(*) AS `count` FROM `Chat` ;"
        );
        
        $this->stmt_last = $this->db->prepare(
            "SELECT * FROM `Chat` WHERE `c_id` = LAST_INSERT_ID();"
        );
        $this->stmt_create = $this->db->prepare(
            "INSERT INTO `Chat` (`u_id`,`c_text`) VALUES ( :userId , :text );"
        );
        $this->stmt_update = $this->db->prepare(
            "UPDATE `Chat` SET `c_text` = :text WHERE `c_id` = :id ;"
        );
        
        $this->stmt_clean = $this->db->prepare(
            "DELETE FROM `Chat` WHERE `c_id` NOT IN ( SELECT `c_id` FROM ".
            "( SELECT `c_id` FROM `Chat` ORDER BY `c_date` DESC LIMIT ".
            " {$nbEnt} ) chat );"
        );
    }

    public function getChatEntry( int $id ) : Chat {        
        $q = $this->stmt_inst;
        $q->bindParam(':id', $id, PDO::PARAM_INT);
        $q->execute();
        
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){ // there is only one post for this id at most
            return new Chat( $data );
        }
        return NULL;
    }
    
    public function getChatEntries() : array {
        $number = $this->nbEnt;
        
        $q = $this->stmt_inst_select;
        $q->bindParam(':number', $number, PDO::PARAM_INT);
        $q->execute();
        
        $chats = [];
        while( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            $chats[] = new Chat( $data );
        }
        return $chats;
    }

    public function getNbChatEntries() : int {
        $q = $this->stmt_nben_select;
        $q->bindParam(':id', $id, PDO::PARAM_INT);
        $q->execute();
        
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            return (int) $data['count'];
        }
        return 0;
    }

    public function create( int $u_id, string $text ) : Chat {
        $q = $this->stmt_create;
        $q->bindParam(':userId'  , $u_id, PDO::PARAM_INT);
        $q->bindParam(':text'    , $text, PDO::PARAM_STR);
        $q->execute();
            
        if( $data = $q->fetch(PDO::FETCH_ASSOC) ){
            return new Chat( $data );
        }
        return NULL;
    }

    public function update( Chat $post ){
        $q = $this->stmt_update;
        $q->bindParam(':id'  , $thread->getId  (), PDO::PARAM_INT);
        $q->bindParam(':text', $thread->getText(), PDO::PARAM_STR);
        $q->execute();
    }
}