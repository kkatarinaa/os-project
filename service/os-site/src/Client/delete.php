<?php
    error_reporting(0);
    session_start();
    require_once '../db.php';

    $location = $_GET['value'];
    $id = $_SESSION['user']['id'];
    mysqli_query($connect, "DELETE FROM places WHERE name_location = '$location' AND client_id = '$id'");
    header('Location: profile_page.php');
?>
