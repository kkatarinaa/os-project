<?php
    error_reporting(0);
    require_once '../db.php';
    session_start();
    if ($_GET['value'] == 'stopped') {
        mysqli_query($connect, "UPDATE places SET status = 'active' WHERE client_id = '{$_SESSION['user']['id']}' AND name_location LIKE '{$_SESSION["name_location"]}'");       
    }
    elseif ($_GET['value'] == 'active') {
        mysqli_query($connect, "UPDATE places SET status = 'stopped' WHERE client_id = '{$_SESSION['user']['id']}' AND name_location LIKE '{$_SESSION["name_location"]}'");   
    }
    header("Location: information_page.php?value={$_SESSION["name_location"]}");
?>
