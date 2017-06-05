<?php
    $ROOT_DIR = ""; // we set the ROOT directory relatively to this file
    $ROOT_URL = ""; // we set the ROOT URL of this project
    require_once('controller/Controller.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta name="author" content="Harraps" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link href="view/css/style.css" rel="stylesheet" />
        <script src="view/js/script.js"></script>
    </head>
    <body>
        <?php

            include_once('view/common/menu.php'); // we add the menu of the website

            // we recover the page the user wants to display
            $VIEW = "home";
            if( isset($_GET['VIEW']) ){
                $VIEW = (string) $_GET['VIEW'];
            }
            $URL = $ROOT_URL."?VIEW=".$VIEW;
            $PAGE = 0;
            if( isset($_GET['PAGE']) ){
                $PAGE = (int) $_GET['PAGE'];
            }
            $ID = 1;
            if( isset($_GET['ID']) ){
                $ID = (int) $_GET['ID'];
            }

            switch( $VIEW ){
                case "home"    : include_once('view/common/home.php'    ); break;
                case "signin"  : include_once('view/identify/signin.php'); break;
                case "login"   : include_once('view/identify/login.php' ); break;
                case "forum"   : include_once('view/forum/forum.php'    ); break;
                case "section" : include_once('view/forum/section.php'  ); break;
                case "thread"  : include_once('view/forum/thread.php'   ); break;
                case "chat"    : include_once('view/forum/chat.php'     ); break;
                default        : include_once('view/common/home.php'    ); break;
            }
        ?>
    </body>
</html>
