<?php
    error_reporting(0);
    session_start();
    require_once '../db.php';

    $login = $_POST['login'];
    $password = md5($_POST['password']);
    $check_user = mysqli_query($connect, "SELECT * FROM clients WHERE `login` LIKE '$login' AND `pass` = '$password'");
    if (mysqli_num_rows($check_user) != 0) {
        $user = mysqli_fetch_assoc($check_user);

        $_SESSION['user'] = [
            "id" => $user['id'],
            "login" => $user['login'],
        ];

        if ($user['login'] == 'admin')  {
            header('Location: ../Admin/profile_page.php');
        } else {
            header('Location: ../Client/profile_page.php');
        }

    } else {
        $_SESSION['message'] = 'Ошибка! Неверный логин или пароль';
        header('Location: login_page.php');
    }
?>
