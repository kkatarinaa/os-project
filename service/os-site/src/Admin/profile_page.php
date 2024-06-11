<?php
    error_reporting(0);
    session_start();
    if (!$_SESSION['user']) {
        header('Location: ../General/login_page.php');
    }
    require_once '../db.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset ="UTF-8">
    <title>Администрирование</title>
    <link rel ="icon" href="../uploads/img/logo.png" />
    <link rel ="stylesheet" href="../style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:ital@1&display=swap" rel="stylesheet">
    <style>
        #menu{
            top: 50%;
            /*right: -22.5%;*/
            position: absolute;
            height: 70%;
            width: 50%;
        }
        .menu-button{
            height: 10%;
            width: 50%;
            background-color: #FFE000;
            color: #373737;
            font-size: 25px;
            border: 1px solid #454545;
            border-radius: 6px;           
        }
    </style>
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
    <div class = "login-menu" id = "menu">
        <ul class = "autorization" id = "create-menu">
            <li style="margin-bottom: -56%; height: 100%"><a href ="all_applications_table.php"><button class = "menu-button">Детальная таблица</button></a></li>
            <li style="margin-bottom: -56%; height: 100%"><a href ="managing_clients.php"><button class = "menu-button">Управление клиентами</button></a></li>
            <li style="margin-bottom: -56%; height: 100%"><a href ="../General/logout.php"><button class = "menu-button">Выйти</button></a></li> 
        </ul>
    </div>
</body>
</html>
