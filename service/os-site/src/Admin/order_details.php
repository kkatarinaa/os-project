<?php
error_reporting(0);
session_start();
require_once '../db.php';

// Получение параметра ID заказа из URL
$orderId = isset($_GET['id']) ? $_GET['id'] : null;

// Получение данных о заказе из базы данных по его ID (для places)
$sql_places = "SELECT * FROM places WHERE id = $orderId";
$result_places = $connect->query($sql_places);

// Получение данных о заказе из базы данных по его ID (для clients)
$sql_clients = "SELECT places.*, clients.login 
                FROM places 
                JOIN clients ON places.client_id = clients.id 
                WHERE places.id = $orderId";
$result_clients = $connect->query($sql_clients);

if ($result_places->num_rows > 0 && $result_clients->num_rows > 0) {
    $order_places = $result_places->fetch_assoc();
    $order_clients = $result_clients->fetch_assoc();

    // Обработка формы для сохранения изменений
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $date_connection = $_POST['date_connection'];
        $date_shutdown = $_POST['date_shutdown'];
        $date_review = $_POST['date_review'];
        $login = $_POST['login'];
        $status = $_POST['status'];
        $name_location = $_POST['name_location'];

        // Обновление данных в базе данных (для places)
        $sql_update_places = "UPDATE places SET 
                              date_connection = '$date_connection',
                              date_shutdown = '$date_shutdown',
                              status = '$status',
                              name_location = '$name_location'
                              WHERE id = $orderId";
        $connect->query($sql_update_places);

        // Перенаправление обратно на страницу с заказами
        header("Location: all_applications_table.php");
        exit();
    }
} else {
    echo "Order not found";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Детали заказа</title>
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
            background-color: orange; /* Оранжевый цвет для кнопки */
            color: white;
            font-size: 30px;
            text-decoration: none; /* Убирает подчеркивание */
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
        .custom-text {
            margin-top: 50px;
            font-family: "Poppins", sans-serif;
            color: white;
            font-size: 30px;
            margin-bottom: 0px;
        }
        .custom-input {
            margin-top: 0px;
            width: 250px;
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
    <h1 class="title-name" style="font-size: 50px">Детали точки <?php echo htmlspecialchars($order_places['name_location']); ?></h1>
    <form method="post">
        <p class="custom-text">Название: <input type="text" name="name_location" value="<?php echo htmlspecialchars($order_places['name_location']); ?>" class="custom-input"></p>
        <p class="custom-text">Статус:
            <select name="status" class="custom-list">
                <option value="agreed" <?php if ($order_places['status'] == 'agreed') echo 'selected'; ?>>Одобрена</option>
                <option value="active" <?php if ($order_places['status'] == 'active') echo 'selected'; ?>>Активна</option>
                <option value="rejection" <?php if ($order_places['status'] == 'rejection') echo 'selected'; ?>>Отклонена</option>
                <option value="stopped" <?php if ($order_places['status'] == 'stopped') echo 'selected'; ?>>Остановлена</option>
                <option value="time is out" <?php if ($order_places['status'] == 'time is out') echo 'selected'; ?>>Срок аренды истёк</option>
            </select>
        </p>
        <p class="custom-text">Дата начала: <input type="date" name="date_connection" value="<?php echo isset($order_places['date_connection']) ? (new DateTime($order_places['date_connection']))->format('Y-m-d') : ''; ?>" class="custom-input"></p>
        <p class="custom-text">Дата окончания: <input type="date" name="date_shutdown" value="<?php echo isset($order_places['date_shutdown']) ? (new DateTime($order_places['date_shutdown']))->format('Y-m-d') : ''; ?>" class="custom-input"></p>

        <input type="submit" value="Сохранить изменения" class="login-button">

        <p><a href="all_applications_table.php"><button class="login-button">Вернуться к заказам</button></a></p>
    </form>
</div>
</body>
</html>

