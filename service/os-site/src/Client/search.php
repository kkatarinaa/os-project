<?php
    error_reporting(0);
    session_start();
    require_once '../db.php';

    $location = $_POST['name_location'];
    $id = $_SESSION['user']['id'];
    $check_place = mysqli_query($connect, "SELECT * FROM places WHERE client_id = '$id' AND `name_location` = '$location'");
    if (mysqli_num_rows($check_place) != 0) {
        $check_place = mysqli_fetch_assoc($check_place);
        $_SESSION['location'] = $location;
        $_SESSION['date-start'] = $check_place['date_connection'];
        $_SESSION['date-end'] = $check_place['date_shutdown'];
        header('Location: renting_page_change.php');
    } else {
        $_SESSION['message'] = 'Error! Not found this place';
        header('Location: renting_page.php');
    }
?>
