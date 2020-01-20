<?php
    session_start();
    if(!isset($_SESSION['logged'])){
        $_SESSION['logged']=false;
    }
    ob_start();
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
?>