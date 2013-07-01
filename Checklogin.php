<?php
session_start();
include ('restServer/src/Session.class.php');
$s = new Session("./users.json");

if($s->login($_REQUEST["email"],md5($_REQUEST["passwd"]))) {
    echo"Logging in was: ".$log." trying to log in";
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";

}else {
 header('Location: http://localhost:8888/filemanager/index.php?errorLogin=true');
}
