<?php
    error_reporting(0);
    session_start();
    require_once '../db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Настройки профиля</title>
    <link rel="stylesheet" href="style_table.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: black;
            background-size: cover;
            background-position: center;
        }
        .button-back {
            position: fixed;
            top: 120px;
            right: 10px;
            background-color: orange; /* Оранжевый цвет для кнопки */
            color: white;
            cursor: pointer;
            font-family: 'Source Code Pro', monospace;
            font-size: 30px;
            text-decoration: none; /* Убирает подчеркивание */
            padding: 10px 20px; /* Добавляет отступы */
            border-radius: 5px; /* Закругляет углы */
        }
        .custom-text {
            margin-top: 50px;
            font-family: "Poppins", sans-serif;
            color: white;
            font-size: 30px;
            margin-bottom: 0px;
        }
        .custom-input {
            margin-top: 0px;
            height: 30px;
            font-family: "Poppins", sans-serif;
            font-size: 30px;
        }
        .custom-list {
            margin-top: 0px;
            width: 250px;
            height: 40px;
            font-family: "Poppins", sans-serif;
            font-size: 30px;
        }
        table {
            margin-top: 15px;
            width: 100%;
            color: white;
            border-collapse: collapse; /* Объединение границ ячеек */
            border-radius: 50px;
            background-color: rgba(255, 255, 255, 0);
            backdrop-filter: blur(20px);
        }
        th {
            border: 1px solid black; /* Границы ячеек */
            padding: 8px; /* Отступ внутри ячеек */
            background-color: orange;
            font-family: "Poppins", sans-serif;
            font-size: 30px;
        }
        td {
            border: 1px solid black; /* Границы ячеек */
            padding: 8px; /* Отступ внутри ячеек */
            font-family: "Poppins", sans-serif;
            background-color: dimgray;
            font-size: 30px;
        }
        .container {
            background-color: rgba(255, 255, 255, 0); /* Прозрачный фон контейнера (значение альфа канала от 0 до 1) */
            padding: 20px; /* Добавляем отступы вокруг контейнера, чтобы текст не прижимался к краям */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Высота контейнера равна высоте видимой области страницы */
        }
        .title{
            position: absolute;
            width: 100%;
            top: 12%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;

        }

        .title-name{
            color: white;
            font-size: 90px;
            text-align: center;
            margin-left: 20px;
            margin-bottom: 20px;
            font-family: "Poppins", sans-serif;
        }
        .login-button {
            background-color: orange; /* Оранжевый цвет для кнопки */
            display: inline-block;
            color: white;
            cursor: pointer;
            font-family: "Poppins", sans-serif;
            font-size: 30px;
            margin-top: 30px;
            border-radius: 15px;
            height: 40px;
            padding: 0 20px; /* Добавляем отступы внутри кнопки */
            border: none; /* Убираем границу */
        }
    </style>
</head>
<body>
<header>
    <div class="container">
        <div class="title">
            <div class="title-name">
                Мастерская одежды
            </div>
        </div>
    </div>
</header>
<div class="container">
    <h1 class="title-name" style="font-size: 50px">Настройка профиля <? echo $_SESSION['user']['login'];?></h1>
    <?php
        $check = mysqli_fetch_assoc(mysqli_query($connect, "SELECT email FROM clients WHERE login LIKE '{$_SESSION['user']['login']}'"));
    ?>
    <form method="post" action = "change_profile.php">
        <p class="custom-text">Название: <input type="text" name="login" value="<? echo $_SESSION['user']['login']; ?>" class="custom-input"></p>
        <p class="custom-text">Email: <input type="text" name="email" value="<? echo $check['email']; ?>" class="custom-input"></p>
        <p class="custom-text">Новый пароль<input type="text" name="password" value="_" class="custom-input"></p>
        <p class="custom-text">Подтвердите новый пароль: <input type="text" name="password-confirm" value="_" class="custom-input"></p>
        <input type="submit" value="Сохранить изменения" class="login-button">
        
        <p><a href="profile_page.php"><button class="login-button">Вернуться к профилю</button></a></p>
        
    </form>
    <div id = "error-registration-pass" class = "error-registration" style = 'color: red'>  
                <?php
                if ($_SESSION['message']) {
                    echo '<p> ' . $_SESSION['message'] . ' </p>';
                }
                unset($_SESSION['message']);
                ?>
        </div>
</div>
</body>
</html>

