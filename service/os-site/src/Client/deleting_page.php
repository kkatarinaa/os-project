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
    <title>Удаление точки</title>
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
                            echo '<image src = "../uploads/img/logo.png" class = "logo"></im age>';
                        }
                    ?>
                </div>
                <div class = "title-name">
                        Мастерская одежды
                </div>
            </div>
        </div>
    </header>
    <button type='submit' class="button-back" onclick="window.location.href = 'profile_page.php'">Назад</button>
    <div class = "login-menu" style = "margin-top: 50px;">
        <ul class = "autorization">
            <li><div class = "autorization-element-label" style = "font-size: 40px; font-weight: bold;">Удаление точки</div></li>  
            <li><form action = "delete.php" method="post" class = "autorization-element-label">Введите название точки<input id = "name_location" class = "autorization-element-input" type = "text" name = "name_location"></li>
            <li><button type = "submit" class = "login-button">Удалить</button></li></form>
            <li id = "error-registration-pass" class = "error-registration">  
                <?php
                if ($_SESSION['message']) {
                    echo '<p> ' . $_SESSION['message'] . ' </p>';
                }
                unset($_SESSION['message']);
                ?>
            </li>
        </ul> 
    </div>
</body>
</html>
