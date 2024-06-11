<?php
    error_reporting(0);
    session_start();
    if (!$_SESSION['user']) {
        header('Location: login_page.php');
    }
    require_once '../db.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset ="UTF-8">
    <title>Создайте новую точку</title>
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
    </header>
    <div class = "login-menu" style = "margin-top: 50px; text-align: center; width: 55%">
        <ul class = "autorization" id = "create_menu">
            <li><div class = "autorization-element-label" style = "font-size: 40px; font-weight: bold;">Создайте новую точку</div></li>  
            <li><form action = "create_place.php" method="post" class = "autorization-element-label">Введите название (на англ.)</li>
            <li><input id = "name_location" class = "autorization-element-input" type = "text" name = "name_location"></li>
            <li>Введите дату начала аренды</li>
            <li><input id = "date-start" class = "autorization-element-input" type = "date" name = "date-start"></li>
            <li>Введите дату окончания аренды</li>
            <li><input id = "date-end" class = "autorization-element-input" type = "date" name = "date-end"></li>
            <li><button type = "submit" class = "login-button">Арендовать</button></li></form>
            <li><button type='submit' class="login-button" onclick="window.location.href = 'profile_page.php'">Назад</button></li>
            <li id = "error-registration-pass" class = "error-login">  
                <?php
                if ($_SESSION['message']) {
                    echo '<p> ' . $_SESSION['message'] . ' </p>';
                }
                unset($_SESSION['message']);
                ?>
            </li>
        </l> 
    </div>
</body>
</html>
