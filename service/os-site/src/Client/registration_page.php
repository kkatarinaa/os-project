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
    <title>Registration page</title>
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
                    Clothes crafting
                </div>
            </div>
        </div>
    </div>
    <div class = "login-menu">
        <ul class = "autorization">
            <li><div class = "autorization-element-label">Registration</div></li>  
            <li><form action = "registration.php" method="post" class = "autorization-element-label">Login<input id = "login" class = "autorization-element-input" type = "text" name = "login"></li>
            <li>Email<input id = "email" class = "autorization-element-input" type = "text" name = "email"></li>
            <li>Password<input id = "password" class = "autorization-element-input" type = "password" name = "password"></li>
            <li>Confirm password<input id = "password-confirm" class = "autorization-element-input" type = "password" name = "password-confirm"></li>
            <li><button type = "submit" class = "login-button">Register</button></li></form>
            <li id = "error-registration-pass" class = "error-registration">  
                <?php
                if ($_SESSION['message']) {
                    echo '<p> ' . $_SESSION['message'] . ' </p>';
                }
                unset($_SESSION['message']);
                ?>
            </li>
            <li><a href = "login_page.php" id = "new-account-link">Have account? Login</a></li>
        </ul> 
    </div>
</body>
</html>
