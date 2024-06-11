<?php
    
    session_start();
    require_once '../db.php';

    $location = $_POST['name_location'];
    $date_start = $_POST['date-start'];
    $date_end = $_POST['date-end'];
    $id = $_SESSION['user']['id'];
    $check_place = mysqli_query($connect, "SELECT * FROM places WHERE `name_location` = '$location'");
    //header('Location: creating_new_place.php');
    if (!preg_match('/[^a-zA-Z0-9]/', $location)) {
        if (mysqli_num_rows($check_place) == 0) {
            if (strtotime($date_start) >= strtotime(date('Y-m-d'))) {
                if (strtotime($date_start) < strtotime($date_end)) {
                    //mysqli_query($connect, "INSERT INTO `places`(`id`, `name_location`, `status`, `date_connection`, `date_shutdown`, `date_review`, `client_id`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]')");
                    mysqli_query($connect, "INSERT INTO places(id, name_location, status, date_connection, date_shutdown, client_id, url) VALUES (NULL, '".$location."', 'agreed', '".$date_start."', '".$date_end."', ".$id.", 'http://localhost:8000/".$_SESSION['user']['login']."/".$location."')");
                    header('Location: profile_page.php');
                }
                else{
                    $_SESSION['message'] = 'Ошибка! Дата окончания меньше даты начала';
                    header('Location: creating_new_place.php');
                }
            }
            else{
                $_SESSION['message'] = 'Ошибка! Дата начала меньше текущей';
                header('Location: creating_new_place.php');
            }
        } else {
            $_SESSION['message'] = 'Ошибка! Такая точка уже существует';
            header('Location: creating_new_place.php');
        }
    } else {
        $_SESSION['message'] = 'Ошибка! Недопустимые символы';
        header('Location: creating_new_place.php');
    }
    //INSERT INTO `places`(`id`, `name_location`, `status`, `date_connection`, `date_shutdown`, `date_review`, `client_id`) VALUES (NULL, 'a', 'req', '2024-01-01', '2024-01-01', NULL, '2');
?>
