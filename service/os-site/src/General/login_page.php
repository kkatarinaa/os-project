<?php
    error_reporting(0);
    session_start();
    if ($_SESSION['user']) {
        if ($_SESSION['user']['login'] != 'admin'){
            header('Location: ../Client/profile_page.php');
        }
        else{
            header('Location: ../Admin/profile_page.php');
        }

    }
    require_once '../db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset ="UTF-8">
    <title>Вход</title>
    <link rel ="icon" href="../uploads/img/logo.png" />
    <link rel ="stylesheet" href="../style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:ital@1&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class = "conteiner">
            <div class = "title">
                <div class = "title-logo">
                    <?php 
                        if (file_exists('../uploads/img/logo.png')) {
                            echo '<image src = "../uploads/img/logo.png" class = "logo"></image>';
                        }
                    ?>
                </div>
                <div class = "title-name">
                    Мастерская одежды
                </div>
            </div>
        </div>
    </div>
    <div class = "login-menu" style = "margin-top: 1%; width: 40%; height: 60%">
        <ul class = "autorization" id = "create-menu">
            <form action = "login.php" method="post" class = "autorization-element-label">
            <li>Логин</li>
            <li><input id = "login" class = "autorization-element-input" type = "text" name = "login"></li>
            <li>Пароль</li>
            <li><input id = "password" class = "autorization-element-input" type = "password" name = "password"></li>
            <li><button type = "submit" class = "login-button">Войти</button></li></form>
            <li class="error-login">
                <?php
                if ($_SESSION['message']) {
                    echo '<p> ' . $_SESSION['message'] . ' </p>';
                }
                unset($_SESSION['message']);
                ?>
            </li>
            <li><a href = "registration_page.php" id = "new-account-link">Создать новый аккаунт</a></li>
            <!--<li><a href = "forget_password_page.php" id = "new-account-link">Забыли пароль?</a></li>-->
        </ul>
    </div>
</body>
</html>
