<?php
    session_start();
    if (!$_SESSION['user']) {
        header('Location: ../General/login_page.php');
    }
    require_once('../db.php');
    $check = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM places WHERE client_id = '{$_SESSION['user']['id']}' AND name_location LIKE '{$_GET['value']}'"));
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset ="UTF-8">
    <title><? echo $check["name_location"]; ?></title>
    <link rel ="icon" href="../uploads/img/logo.png" />
    <link rel ="stylesheet" href="../style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:ital@1&display=swap" rel="stylesheet">
    <style>
        #menu{
            top: 0%;
            left: 0%;
            position: absolute;
            height: 85%;
            width: 70%;
        }

        .menu-button{
            height: 65%;
            width: 60%;
            text-decoration: none;
            background-color: #FFE000;
            color: #373737;
            font-size: 25px;
            margin-top: 10px;
            display: inline-block;    
            border: 1px solid #454545;
            border-radius: 3px;             
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
    <div class = "login-menu" id = "profile-menu" style="height: 80%;">
        <ul class = "autorization" id = "menu" > 
            <?php
                $dc = new DateTime($check["date_connection"]);
                $ds = new DateTime($check["date_shutdown"]);
                echo "<div class='subscription-list'>";
                echo "<div class='subscription'>";
                echo "<li>Точка: " . $check["name_location"] . "</li>";
                echo "<li>Статус: " . $check["status"] . "</li>";
                echo "<li>Дата начала аренды: " . $dc->format('Y-m-d'). "</li>";
                echo "<li>Дата окончания аренды: " . $ds->format('Y-m-d'). "</li>";
                $_SESSION["name_location"] = $check["name_location"];
                if ($check["status"] == "active") {

                    echo "<li><a href = '".$check['url']."' style='text-decoration: none;'><button class='menu-button'>Перейти на сайт</button></a><button class = 'login-button' style = 'font-size:15px' onclick=\"copyToClipboard('".$check['url']."')\">Cсылка</button></li>";
                    echo "<li><a href = '".$check['url']."/Service' style='text-decoration: none;'><button class='menu-button'>Перейти на сервис</button></a><button class = 'login-button' style = 'font-size:15px' onclick=\"copyToClipboard('".$check['url']."/Service')\">Cсылка</button></li>";
                    echo "<li><a href = 'change_status.php?value=active' style='text-decoration: none;'><button class='menu-button'>Остановить точку</button></a></li>";   
                }
                else if ($check["status"] == "stopped") {
                    echo "<li><a href = 'change_status.php?value=stopped' style='text-decoration: none;'><button class='menu-button'>Запустить точку</button></a></li>";
                }
                echo "<li><a href = 'renting_page_change.php?value=" . $check["name_location"] . "' style='text-decoration: none;'><button class='menu-button'>Поменять дату аренды</button></a></li>";
                echo "<li><a href = 'delete.php?value=" . $check["name_location"] . "' style='text-decoration: none;'><button class='menu-button'>Удалить эту точку</button></a></li>";
                
                echo "<li><a href = 'profile_page.php'><button class='login-button'>Назад</button></a></li>";
                echo "</div>";
                echo "<br>";
                echo "<br>";
                echo "</div>";
            ?>
        </ul>
    </div>
</body>
<script>
    function copyToClipboard(text) {
        var input = document.createElement('input');
        input.setAttribute('value', text);
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        alert('Вы скопировали ссылку');
    }
</script>
</html>
