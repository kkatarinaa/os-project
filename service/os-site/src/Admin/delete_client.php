<?php
    error_reporting(0);
    session_start();
    require_once '../db.php';

    if (isset($_POST['button'])) {
        $login = $_POST['login'];
        mysqli_query($connect, "DELETE FROM places WHERE client_id IN (SELECT id FROM clients WHERE login LIKE ".$login.")");
        mysqli_query($connect, "DELETE FROM clients WHERE login = ".$login);
    }

    header('Location: managing_clients.php');

?>
