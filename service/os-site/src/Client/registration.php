<?php
    error_reporting(0);
    session_start();
    require_once '../db.php';

    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password-confirm'];
    if (!empty($login) || !empty($role) || !empty($password)) {
        if ($password === $password_confirm) {
            $check_user = mysqli_query($connect, "SELECT * FROM clients WHERE `login` = '$login'");
            if (mysqli_num_rows($check_user) === 0) {
                $password = md5($password);
                mysqli_query($connect, "INSERT INTO clients (`id`, `login`, `email`, `pass`) VALUES (NULL, '$login', '$email', '$password')");
                $check_user = mysqli_query($connect, "SELECT * FROM clients WHERE `login` = '$login' AND `pass` = '$password'");
                $user = mysqli_fetch_assoc($check_user);
                $_SESSION['user'] = [
                    "id" => $user['id'],
                    "login" => $user['login'],
                ];
                header('Location: profile_page.php');
            } else {
                $_SESSION['message'] = 'Error! Login is already occupied';
                header('Location: registration_page.php');
            }   
        } else {
            $_SESSION['message'] = 'Error! Passwords do not match';
            header('Location: registration_page.php');
        }
    } else {
        $_SESSION['message'] = 'Error! All fields must be filled';
        header('Location: registration_page.php');
    }
?>
