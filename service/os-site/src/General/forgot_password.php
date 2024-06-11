<?php
    error_reporting(0);
    session_start();
    require_once '../db.php';

    $login = $_POST['login'];
    $check_user = mysqli_query($connect, "SELECT * FROM clients WHERE `login` LIKE '$login'");
    if (mysqli_num_rows($check_user) != 0) {
        $user = mysqli_fetch_assoc($check_user);
        $email = $user['email'];
        $subject = 'Восстановление пароля';
        $message = 'Ваш пароль от Мастерской одежды: ' . $user['pass'];
        $header = 'svsergeev04@mail.ru';
        mail($to, $subject, $message, $headers);
        $_SESSION['message'] = 'Письмо успешно отправлено';
        header('Location: login_page.php');
    } else {
        $_SESSION['message'] = 'Ошибка! Неверный логин';
        header('Location: forget_password_page.php');
    }
?>
