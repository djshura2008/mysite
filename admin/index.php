<?php

if (!isset($_SESSION)) {
    session_start();
}
require '../config/dbconnection.php';
require 'Autoload.php';

$login = new UserClass();
$check = new CheckValidUser();
$level = new AccessLevel();
if ($login->isLoggedIn() === true) {

    header('Location: dashboard.php');
} else {
    header('Location: ' . $bases . 'signin/login.php');
}
?>