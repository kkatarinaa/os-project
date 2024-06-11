<?php
    error_reporting(0);
    session_start();
    require_once '../db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset ="UTF-8">
    <title>Таблица</title>
    <link rel ="icon" href="../uploads/img/logo.png" />
    <link rel ="stylesheet" href="../style_table.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:ital@1&display=swap" rel="stylesheet">
    <style>

        .button-back {
            position: fixed;
            top: 120px;
            right: 10px;
            background-color: #d3d3d3;
            color: white;
            cursor: pointer;
            font-family: 'Source Code Pro', monospace;
            font-size: 30px;
        }

        th a.custom-link {
            color: black; /* Цвет текста черный */
            text-decoration: none; /* Убрать подчеркивание */
        }


        .custom-text {
            margin-top: 35px;
            font-family: 'Source Code Pro', monospace;
            font-size: 30px;
            margin-bottom: 0px;
        }

        .custom-input {
            margin-top: 0px;
            width: 250px;
            height: 30px;
            font-family: 'Source Code Pro', monospace;
            font-size: 30px;
        }

        .custom-list {
            margin-top: 0px;
            width: 250px;
            height: 40px;
            font-family: 'Source Code Pro', monospace;
            font-size: 30px;
        }

        table {
            margin-top: 15px;
            width: 100%;
            border-collapse: collapse; /* Объединение границ ячеек */
            background-color: #d3d3d3;
        }

        th{
            border: 1px solid black; /* Границы ячеек */
            padding: 8px; /* Отступ внутри ячеек */
            font-family: 'Source Code Pro', monospace;
            font-size: 30px;
        }

        td{
            border: 1px solid black; /* Границы ячеек */
            padding: 8px; /* Отступ внутри ячеек */
            font-family: 'Source Code Pro', monospace;
            font-size: 30px;
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


<div class="table">
<form method="get">    
    <div class="custom-text" style="color: black">1</div>
    <div class="custom-text" style="color: black">1</div>
    <input type="text" name="search" id="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" class="custom-input">

    <select name="column" class="custom-list"> <!-- Выпадающий список для выбора столбца -->
        <option value="date_shutdown" <?php echo ($_GET['column'] == 'date_shutdown') ? 'selected' : ''; ?>>Дата окончания</option>
        <option value="date_connection" <?php echo ($_GET['column'] == 'date_connection') ? 'selected' : ''; ?>>Дата начала</option>
        <option value="status" <?php echo ($_GET['column'] == 'status') ? 'selected' : ''; ?>>Статус</option>
        <option value="name_location" <?php echo ($_GET['column'] == 'name_location') ? 'selected' : ''; ?>>Точка</option>
    </select>

    <button type="submit" class="login-button">Найти</button>

    <div> <!-- Блок для первой кнопки -->
        <a href="?show=all"><button type="button" class="login-button">Показать всё</button></a>
    </div>
</form>

    <div>
    <?php

        
        if (!isset($_SESSION['sort']) || $_SESSION['sort'] == '') {
            $_SESSION['sort'] = 'status';
        }

        if (!isset($_SESSION['order']) || $_SESSION['order'] == '') {
            $_SESSION['order'] = 'asc';
        }
        if (isset($_GET['search']) && $_GET['search'] != ''){
            $search = $_GET['search'];
            $_SESSION['search'] = $search;
        }
        else{
            if (isset($_SESSION['search']) && $_SESSION['search'] != '') {
                $search = $_SESSION['search'];
            }
        }

        if($_SESSION['order'] == 'asc'){
            $_SESSION['order'] = 'desc';
        }
        else{
            $_SESSION['order'] = 'asc';
        }
        // Определение столбца для сортировки
        $sortColumn = isset($_GET['sort']) ? $_GET['sort'] : $_SESSION['sort'];
        
        // Определение порядка сортировки
        if (isset($_GET['order'])) {
            $sortOrder = $_GET['order'] == 'asc' ? 'desc' : 'asc';
        }
        


        // Определение условия для отображения всех записей
        $showAll = isset($_GET['show']) && $_GET['show'] == 'all' ? true : false;
        $_SESSION['show'] = $showAll;
        //echo"<div>$sortColumn $sortOrder "/*.$_GET['column'].*/ .$_SESSION['sort']."</div>";

        // Вывод таблицы с кнопками для сортировки
        echo "<table border='1'>";
        echo "<tr>";
        echo "<th><a href='?sort=name_location&order=$sortOrder' class='custom-link'>Точка</a></th>";
        echo "<th><a href='?sort=status&order=$sortOrder' class='custom-link'>Статус</a></th>";
        echo "<th><a href='?sort=date_connection&order=$sortOrder' class='custom-link'>Дата начала</a></th>";
        echo "<th><a href='?sort=date_shutdown&order=$sortOrder' class='custom-link'>Дата окончания</a></th>";
        echo "</tr>";

        // Запрос к базе данных с учетом сортировки, поиска и условия отображения всех записей
        $sql = "SELECT places.*, clients.login FROM places JOIN clients ON places.client_id = clients.id WHERE clients.id = {$_SESSION['user']['id']}";
        
        if (!$showAll) {
            if (isset($_GET['column']) && $search != '') {  
                $selectedColumn = $_GET['column'];
                $_SESSION['column'] = $selectedColumn;
                //echo "<div>$selectedColumn</div>";
                $sql .= " HAVING ".$selectedColumn." LIKE '%$search%'";
            }
            else{
                if (isset($_SESSION['column']) && $search != '') {
                    $selectedColumn = $_SESSION['column'];
                    $sql .= " HAVING ".$selectedColumn." LIKE '%$search%'";
                }
            }
        }
        else{
            $sortColumn = '';
            $sortOrder = '';
            $_SESSION['column'] = '';
            $_SESSION['order'] = '';
            $_SESSION['search'] = '';
            $search = '';
        }
        
        $_SESSION['sort'] = $sortColumn;
        $_SESSION['order'] = $sortOrder;
        if (($sortColumn != '' && $sortOrder != '') || isset($_GET['sort'])) {
            if (!isset($_GET['sort'])){
                $sql .= " ORDER BY ".$sortColumn." ".$sortOrder;
            }
            else {
                if ($_GET['order'] == ''){
                    $_GET['order'] = 'desc';
                }
                $sql .= " ORDER BY ".$_GET['sort']." ".$_GET['order']."";
            }
        }
        $result = $connect->query($sql);
        //echo "<div>$sql</div>";
        

        // Вывод данных в виде HTML-таблицы
        while ($row = $result->fetch_assoc()) {
            if ($row['status'] == 'active') {
                $status = 'Активна';
            }
            elseif ($row['status'] == 'agreed') {
                $status = 'Одобрена';
            }
            elseif ($row['status'] == 'time is out') {
                $status = 'Срок аренды истёк';
            }
            elseif ($row['status'] == 'rejection') {
                $status = 'Отклонена';
            }
            elseif ($row['status'] == 'stopped') {
                $status = 'Остановлена';
            }
            elseif ($row['status'] == 'request') {
                $status = 'Ожидает подтверждения';
            }
            $connection = $row['date_connection'];
            $shutdown = $row['date_shutdown'];
            $connection = new DateTime($connection);
            $shutdown = new DateTime($shutdown);
            echo "<tr>";
            echo "<td>" . $row['name_location'] . "</td>";
            echo "<td>" . $status . "</td>"; 
            echo "<td>" . $connection->format('Y-m-d') . "</td>";
            echo "<td>" . $shutdown->format('Y-m-d') . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        
    ?>
    </div>
    <a href = 'profile_page.php'><button class='login-button'>Назад</button></a>
    
</div>

</body>
</html>
