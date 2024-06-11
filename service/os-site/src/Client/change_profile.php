<?php
    error_reporting(0);
    session_start();
    require_once '../db.php';

    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password-confirm'];
        if ($password === $password_confirm) {
            $check_user = mysqli_query($connect, "SELECT * FROM clients WHERE `login` = '$login'");
                if (mysqli_num_rows($check_user) === 0 || $login === $_SESSION['user']['login']) {
                    if ($password != '_'){
                        $password = md5($password);
                        mysqli_query($connect, "UPDATE clients SET `login` = '$login', `email` = '$email', `pass` = '$password' WHERE `id` = {$_SESSION['user']['id']}");
                        $check_user = mysqli_query($connect, "SELECT * FROM clients WHERE `login` = '$login'");
                        $user = mysqli_fetch_assoc($check_user);
                        $_SESSION['user'] = [
                            "id" => $user['id'],
                            "login" => $user['login'],
                        ];
                        header('Location: ../Client/profile_page.php');
                    } else {
                        mysqli_query($connect, "UPDATE clients SET `login` = '$login', `email` = '$email' WHERE `id` = {$_SESSION['user']['id']}");
                        $check_user = mysqli_query($connect, "SELECT * FROM clients WHERE `login` = '$login'");
                        $user = mysqli_fetch_assoc($check_user);
                        $_SESSION['user'] = [
                            "id" => $user['id'],
                            "login" => $user['login'],
                        ];
                        header('Location: ../Client/profile_page.php');
                    }
            } else {
                $_SESSION['message'] = 'Ошибка! Такой логин уже существует';
                header('Location: config_page.php');
            }   
        } else {
            $_SESSION['message'] = 'Ошибка! Пароли не совпадают';
            header('Location: config_page.php');
        }
?>
