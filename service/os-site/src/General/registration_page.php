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
    <title>Регистрация</title>
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
    <div class = "login-menu" style="top:60%;height:90%;width:45%">
        <ul class = "autorization" id = "create-menu">
            <li><div class = "autorization-element-label" style = "font-size: 40px; font-weight: bold">Регистрация</div></li>  
            <li><form action = "registration.php" method="post" class = "autorization-element-label">Логин</li>
            <li><input id = "reg" class = "autorization-element-input" type = "text" name = "login"></li>
            <li>Электронная почта</li>
            <li><input id = "reg" class = "autorization-element-input" type = "text" name = "email"></li>
            <li>Пароль</li>
            <li><input id = "reg" class = "autorization-element-input" type = "password" name = "password"></li>
            <li>Подтвердите пароль</li>
            <li><input id = "reg" class = "autorization-element-input" type = "password" name = "password-confirm"></li>
            <li><button type = "submit" class = "login-button">Зарегистрироваться</button></li></form>
            <li id = "error-registration-pass" class = "error-registration">  
                <?php
                if ($_SESSION['message']) {
                    echo '<p> ' . $_SESSION['message'] . ' </p>';
                }
                unset($_SESSION['message']);
                ?>
            </li>
            <li><a href = "login_page.php" id = "new-account-link">Есть аккаунт? Войдите</a></li>
        </ul> 
    </div>
</body>
</html>
