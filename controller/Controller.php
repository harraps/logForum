<?php
session_start();

require_once($ROOT_DIR.'controller/managers/PostManager.php'   );
require_once($ROOT_DIR.'controller/managers/ThreadManager.php' );
require_once($ROOT_DIR.'controller/managers/SectionManager.php');

class Controller {

    private $db; // PDO

    private $p_man; // PostManager
    private $t_man; // ThreadManager
    private $s_man; // SectionManager
    //private $c_man; // ChatManager

    public function __construct(){
        global $ROOT_DIR;
        
        // we recover the data in the ini file
        $ini_db = parse_ini_file($ROOT_DIR.'database/php.ini');
        // we create a new PDO based on this data
        $this->db = new PDO(
            $ini_db['access'],
            $ini_db['user'],
            $ini_db['pass']
        );
        
        $this->p_man = new PostManager   ($this->db, 30);
        $this->t_man = new ThreadManager ($this->db, 30);
        $this->s_man = new SectionManager($this->db, 10);
    }

    public function getDB() : PDO { return $this->db; }

    public function getPostManager   () : PostManager    { return $this->p_man; }
    public function getThreadManager () : ThreadManager  { return $this->t_man; }
    public function getSectionManager() : SectionManager { return $this->s_man; }
}

$CONTROLLER = new Controller();
