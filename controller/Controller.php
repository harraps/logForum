<?php
session_start();

require_once('controller/managers/UserManager.php'   );
require_once('controller/managers/PostManager.php'   );
require_once('controller/managers/ThreadManager.php' );
require_once('controller/managers/SectionManager.php');

class Controller {

    private PDO $db;

    private UserManager    $u_man;
    private PostManager    $p_man;
    private ThreadManager  $t_man;
    private SectionManager $s_man;

    public function __construct(){
        // we recover the data in the ini file
        $ini_db = parse_ini_file('database/php.ini');
        // we create a new PDO based on this data
        $this->db = new PDO(
            $ini_db['access'],
            $ini_db['user'],
            $ini_db['pass']
        );

        $this->u_man = new UserManager   ($this->db);
        $this->p_man = new PostManager   ($this->db);
        $this->t_man = new ThreadManager ($this->db);
        $this->s_man = new SectionManager($this->db);
    }

    public function getDB(){ return $this->db; }

    public function getUserManager   (){ return $this->u_man; }
    public function getPostManager   (){ return $this->p_man; }
    public function getThreadManager (){ return $this->t_man; }
    public function getSectionManager(){ return $this->s_man; }

}

$CONTROLLER = new Controller();
