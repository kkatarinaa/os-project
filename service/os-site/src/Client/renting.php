<?php
    error_reporting(0);
    session_start();
    require_once '../db.php';

    $location = $_SESSION['location'];
    $date_start = $_POST['date-start'];
    $date_end = $_POST['date-end'];
    $id = $_SESSION['user']['id'];
    $status = mysqli_fetch_assoc(mysqli_query($connect, "SELECT status FROM places WHERE name_location = '$location' AND client_id = '$id'"));
    if($status == 'active'){
        mysqli_query($connect, "INSERT INTO `places`(`id`, `name_location`, `status`, `date_connection`, `date_shutdown`, `date_review`, `client_id`) VALUES (NULL, '$location', 'request', '$date_start', '$date_end', NULL, '$id'");
    }
    else{
        mysqli_query($connect, "UPDATE places SET date_connection = '".$date_start."', date_shutdown = '".$date_end."' WHERE name_location = '$location' AND client_id = '$id'");
    }
    header('Location: profile_page.php');
?>
