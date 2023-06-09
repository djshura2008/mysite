<?php

//
//  This application develop by PEPIUOX.
//  Created by : Lab eMotion
//  Author     : PePiuoX
//  Email      : contact@pepiuox.net
//
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION)) {
    session_start();
}

$currentDate = new DateTime();
$connfile = 'config/dbconnection.php';
if (file_exists($connfile)) {
    $page = $_SERVER['PHP_SELF'];

    include 'config/dbconnection.php';
    require 'classes/UserClass.php';
    require 'classes/GetVisitor.php';

    $login = new UserClass();
    $timestamp = $currentDate->format('Y-m-d H:i:s');
    $visitor = new GetVisitor($timestamp);

    include 'start.php';
} else {
    $_SESSION['PathInstall'] = "http://{$_SERVER['HTTP_HOST']}/";
    header('Location: installer/install.php');
    exit();
}
?>
