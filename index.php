<?php
    $ROOT_DIR = ""; // we set the ROOT directory relatively to this file
    $ROOT_URL = ""; // we set the ROOT URL of this project
    require_once('controller/Controller.php');
    require_once('controller/Util.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta name="author" content="Olivier Schyns" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link  href="css/style.css" rel="stylesheet" />
        <script src="js/script.js"></script>
        
        <link  href="libs/katex/katex.min.css" rel="stylesheet" />
        <script src="libs/katex/katex.min.js"></script>
    </head>
    <body>
        <?php

            include_once('components/menu.php'); // we add the menu of the website

            // we recover the page the user wants to display
            $VIEW = $_GET['VIEW'] ?? "home";
            $PAGE = $_GET['PAGE'] ?? 0;
            $ID = $_GET['ID'] ?? 1;
            $URL = $ROOT_URL."?VIEW=".$VIEW."&ID=".$ID;

            switch( $VIEW ){
                case "home"    : include_once('view/home.php'   ); break;
                case "forum"   : include_once('view/forum.php'  ); break;
                case "section" : include_once('view/section.php'); break;
                case "thread"  : include_once('view/thread.php' ); break;
                case "chat"    : include_once('view/chat.php'   ); break;
                default        : include_once('view/home.php'   ); break;
            }
        ?>
    </body>
</html>
