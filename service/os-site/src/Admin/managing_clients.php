<?php
    error_reporting(0);
    session_start();
    if (!$_SESSION['user']) {
        header('Location: ../General/login_page.php');
    }
    require_once '../db.php';

    $clients = mysqli_query($connect, "SELECT login, COUNT(places.id) AS count FROM clients LEFT JOIN places ON clients.id  = places.client_id WHERE login NOT LIKE 'admin' GROUP BY login");
   


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset ="UTF-8">
    <title>Управление клиентами</title>
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
    <div class = "login-menu" id = "profile-menu">
        <ul class = "autorization" >
            <?
                while($row = mysqli_fetch_assoc($clients)){
                    echo "<li class='subscription'><strong>Логин:</strong>". $row['login']."</li>";
                    echo "<li class='subscription'><strong>Количество точек:</strong>". $row['count']."</li>";
                    echo "<li><form action = 'delete_client.php' method='post'><button type='submit' class='login-button' name='login' value='login'>Удалить этого клиента</button></form></li>";
                }

            ?>
        </ul>
        <a href = 'profile_page.php'><button class='login-button'>Назад</button></a>
    </div>
</body>
</html>
