<?php
    error_reporting(0);
    session_start();
    if (!$_SESSION['user']) {
        header('Location: ../General/login_page.php');
    }
    require_once('../db.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset ="UTF-8">
    <title>Профиль</title>
    <link rel ="icon" href="../uploads/img/logo.png" />
    <link rel ="stylesheet" href="../style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:ital@1&display=swap" rel="stylesheet">
    <style>
        #menu{
            top: 0%;
            right: -22.5%;
            position: absolute;
            height: 70%;
            width: 50%;
        }

        .menu-button{
            height: 10%;
            width: 50%;
            right: 10%;
            text-decoration: none;
            background-color: #FFE000;
            color: #373737;
            font-size: 20px;
            margin-bottom: 7px;
            display: block;    
            border: 1px solid #454545;
            border-radius: 6px;
            box-shadow: 4px 4px 2px rgba(0, 0, 0, 0.3); 
            transition: transform 0.2s;            
        }

        .menu-button:hover{
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 1px rgba(0, 0, 0, 0.7);   
        }

        .menu-button:active {
            transform: scale(0.95); /* Уменьшение размера кнопки при нажатии */
        }   

    </style>
</head>
<body class="body">
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
            <li class = "data-name">Логин:</li>
            <li class = "data-value"><?= $_SESSION['user']['login'] ?></li>
            <li class = "data-name">Mои точки:</li>
            <form action = "information_page.php">   
            <?php
                $check = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) AS count FROM places WHERE client_id = '{$_SESSION['user']['id']}'"));
                if ($check['count'] != 0){ 
                    $user = mysqli_query($connect, "SELECT * FROM places WHERE client_id = '{$_SESSION['user']['id']}'");
                    while ($row = mysqli_fetch_assoc($user)) {
                        $name = $row['name_location'];
                        echo "<li id='dropdown' class = 'data-value' style = 'font-size: 20px; display: flex;'><div style = 'text-decoration: underline'><a href='information_page.php?value=".$name."' style='text-decoration: none; color: inherit;'>";
                        echo $name."</a></div>";
                        if ($row['status'] == 'active') {
                            echo "<div style = 'padding-left: 15px; color: green;'>Активна</div></li>";
                        } elseif ($row['status'] == 'agreed') {
                            echo "<div style = 'padding-left: 15px; color: #b300d0;'>Одобрена</div></li>";
                        } elseif ($row['status'] == 'rejection') {
                            echo "<div style = 'padding-left: 15px; color: red;'>Отклонена</div></li>";
                        } elseif ($row['status'] == 'request') {
                            echo "<div style = 'padding-left: 15px; color: blue;'>Ожидает подтверждения</div></li>";
                        } elseif ($row['status'] == 'time is out') {
                            echo "<div style = 'padding-left: 15px; color: orange;'>Срок аренды истёк</div></li>";
                        } elseif ($row['status'] == 'stopped') {
                            echo "<div style = 'padding-left: 15px; color: red;'>Остановлена</div></li>";
                        }
                    }
                }
                else {
                    echo "<li class = 'data-value'>У вас нет ни одной точки</li>";
                }
                echo "</form>";
            ?>
        </ul>
        <ul class = "autorization" id = "menu">
            <a href ="creating_new_place.php" style="text-decoration: none"><button class = "menu-button" >Добавить точку</button></a>
            <!-- <li><a href ="renting_page.php"><button class = "login-button">Change period of rent</button></a></li>
            <li><a href ="deleting_page.php"><button class = "login-button">Delete place</button></a></li>  -->
            <a href ="table_page.php" style="text-decoration: none"><button class = "menu-button">Подробная таблица</button></a>
            <a href ="config_page.php" style="text-decoration: none"><button class = "menu-button">Настройка аккаунта</button></a>
            <a href ="../General/logout.php" style="text-decoration: none"><button class = "menu-button">Выйти из аккаунта</button></a>
        </ul>
    </div>
</body>
</html>
