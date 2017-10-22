<?php
session_start();

require_once('controller/managers/UserManager.php'   );
require_once('controller/managers/PostManager.php'   );
require_once('controller/managers/ThreadManager.php' );
require_once('controller/managers/SectionManager.php');
require_once('controller/managers/ChatManager.php'   );

class Controller {

    private $db; // PDO

    private $u_man; // UserManager
    private $p_man; // PostManager
    private $t_man; // ThreadManager
    private $s_man; // SectionManager
    private $c_man; // ChatManager

    public function __construct(){
        // we recover the data in the ini file
        $ini_db = parse_ini_file('database/php.ini');
        // we create a new PDO based on this data
        $this->db = new PDO(
            $ini_db['access'],
            $ini_db['user'],
            $ini_db['pass']
        );

        $this->u_man = new UserManager   ($this->db, 50);
        $this->p_man = new PostManager   ($this->db, 20);
        $this->t_man = new ThreadManager ($this->db, 30);
        $this->s_man = new SectionManager($this->db, 20);
        $this->c_man = new ChatManager   ($this->db, 10);
    }

    public function getDB() : PDO { return $this->db; }

    public function getUserManager   () : UserManager    { return $this->u_man; }
    public function getPostManager   () : PostManager    { return $this->p_man; }
    public function getThreadManager () : ThreadManager  { return $this->t_man; }
    public function getSectionManager() : SectionManager { return $this->s_man; }
    public function getChatManager   () : ChatManager    { return $this->c_man; }
}

$CONTROLLER = new Controller();
