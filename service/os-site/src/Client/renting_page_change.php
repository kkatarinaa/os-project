<?php
    error_reporting(0);
    session_start();
    if (!$_SESSION['user']) {
        header('Location: login_page.php');
    }
    require_once '../db.php';
    $check = mysqli_fetch_assoc(mysqli_query($connect, "SELECT date_connection, date_shutdown FROM places WHERE client_id = '{$_SESSION['user']['id']}' AND name_location LIKE '{$_GET['value']}'"));
    $start = new DateTime($check['date_connection']);
    $end = new DateTime($check['date_shutdown']);
    $_SESSION['location'] = $_GET['value'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset ="UTF-8">
    <title><?php echo $_SESSION['location']; ?></title>
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
    <div class = "login-menu" style = "margin-top: 50px;">
        <ul class = "autorization">
            <li class='data-name'><?php echo $_SESSION['location']; ?> </li>
            <li class='data-name'><?php echo $start->format('d.m.Y'); ?> - <?php echo $end->format('d.m.Y'); ?></li>
            <li><form action = "renting.php" method="post" class = "autorization-element-label">Введите новую дату начала<input id = "date-start" class = "autorization-element-input" type = "date" name = "date-start"></li>
            <li>Введите новую дату окончания<input id = "date-end" class = "autorization-element-input" type = "date" name = "date-end"></li>
            <li><button type = "submit" class = "login-button">Поменять</button></li></form>
            <li><a href = 'profile_page.php'><button class='login-button'>Назад</button></a></li>
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
