<?php
    $ROOT_DIR = "../../"; // we set the ROOT directory relatively to this file
    $ROOT_URL = ""; // we set the ROOT URL of this project
    require_once($ROOT_DIR.'controller/Controller.php');
    require_once($ROOT_DIR.'controller/Util.php');
    
    $IP   = getIP();
    $sid  = $_POST["sid"];
    $name = $_POST["name"];
    
    if (!empty($IP) && !empty($sid) && !empty($name))
        $CONTROLLER->getThreadManager()->create($IP, $sid, $name);

    header('Location: '.$_SERVER['HTTP_REFERER']);
?>