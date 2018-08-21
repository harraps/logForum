<?php
    $ROOT_DIR = "../../"; // we set the ROOT directory relatively to this file
    $ROOT_URL = ""; // we set the ROOT URL of this project
    require_once($ROOT_DIR.'controller/Controller.php');
    require_once($ROOT_DIR.'controller/Util.php');
    
    $IP   = getIP();
    $name = $_POST["name"];
    $desc = $_POST["desc"];
    
    if (!empty($IP) && !empty($name))
        $CONTROLLER->getSectionManager()->create($IP, $name, $desc);

    header('Location: '.$_SERVER['HTTP_REFERER']);
?>
