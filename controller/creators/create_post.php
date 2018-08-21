<?php
    $ROOT_DIR = "../../"; // we set the ROOT directory relatively to this file
    $ROOT_URL = ""; // we set the ROOT URL of this project
    require_once($ROOT_DIR.'controller/Controller.php');
    require_once($ROOT_DIR.'controller/Util.php');
    
    $IP   = getIP();
    $tid  = $_POST["tid"];
    $text = $_POST["text"];
    
    if (!empty($IP) && !empty($tid) && !empty($text))
        $CONTROLLER->getPostManager()->create($IP, $tid, $text);

    header('Location: '.$_SERVER['HTTP_REFERER']);
?>