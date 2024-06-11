<?php
    error_reporting(0);
    session_start();
    require_once '../db.php';
    unset($_SESSION['user']);
    header('Location: login.php');
?>
