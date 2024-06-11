<?php
    session_start();
    require_once '../db.php';

    $password = $_POST['password'];
    $password_confirm = $_POST['password-confirm'];
    if (!empty($role) || !empty($password)) {
        if ($password === $password_confirm) {
            $password = md5($password);
            mysqli_query($connect, "INSERT INTO `workers` (`id`, `login`, `role`, `pass`) VALUES (NULL, 'Admin', 'Admin', '$password')");
            header('Location: ../Admin/functions_page.php');
        }
        else {
            $_SESSION['message'] = 'Error! Passwords do not match';
            header('Location: registration_admin_page.php');
        }
    } else {
        $_SESSION['message'] = 'Error! All fields must be filled';
        header('Location: registration_admin_page.php');
    }
?>
