<?php
    $ROOT_DIR = "";            // we set the ROOT directory relatively to this file
    $ROOT_URL = "/MiniForum/"; // we set the ROOT URL of this project
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
            $PAGE = "home";
            if( isset($_GET['PAGE']) ){
                $PAGE = $_GET['PAGE'];
            }

            switch( $PAGE ){
                case "home"     : include_once('view/common/home.php'    ); break;
                case "signin"   : include_once('view/identify/signin.php'); break;
                case "login"    : include_once('view/identify/login.php' ); break;
                case "category" : include_once('view/forum/category.php' ); break;
                case "thread"   : include_once('view/forum/thread.php'   ); break;
                default         : include_once('view/common/home.php'    ); break;
            }
        ?>
    </body>
</html>
