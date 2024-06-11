<?php
    error_reporting(0);
    session_start();
    require_once '../db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Product service page</title>
    <!-- <link rel="icon" href="../uploads/img/logo.png" /> -->
    <link rel="stylesheet" href="../style.css" />
    <style>
        body {
            color: black;
            background-color: white;
            transition: all 1s ease;
        }

        .order-container {
            text-align: center;
            margin-top: 20px;
        }

        .order-box {
            background-color: #d3d3d3;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
        }

        .order-info {
            font-size: 25px;
            margin-bottom: 20px;
        }

        .ready-button {
            background-color: #373737;
            font-family: 'Source Code Pro', monospace;
            color: white;
            cursor: pointer;
            font-size: 24px;
            border: 0px;
            margin-top: 10px;
            padding: 10px 20px;
            border-radius: 8px;
        }


        .function-button, .input-file span {
            background-color: <?php
                $color = '#cc00ad';
                $query = '#808080';
                echo $color;
                ?>;
        }
        
        .title-name,  h1, h2,  p{
            color: #373737;
        }

        
        #sl_ft img:hover{
            box-shadow: 0 0 15px <?php 
                echo $color;
                ?>;
            border: 1px solid <?php 
                echo $color;
                ?>;
        }

        #sd_ft img:hover{
            box-shadow: 0 0 15px <?php 
                echo $color;
                ?>;
            border: 1px solid <?php 
                echo $color;
                ?>;
        }

        .have:hover{
            box-shadow: 0 0 15px <?php 
                echo $color;
                ?>;
            border: 1px solid <?php 
                echo $color;
                ?>;
        }


        .function-button{
            margin-top: 35%;
            transform: translate(0, -50%);
            margin-right: 40px;
            width: 100px;
            height: 40px;
            border-radius: 30px;
            font-size: 30px;
            color: white;
            border: none;
            cursor: pointer;
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
                <!-- ИМЯ САЙТА -->
                <div class = "title-name">Clothes crafting
            </div> 
        </div>
    </header>

    <button type='submit' class="button-back" onclick="window.location.href = 'profile_page.php'">Exit</button>
<div class="order-container">
    <div class="order-box">
        <?php

        function getAllClients($conn) {
            $sql = "SELECT * FROM places WHERE status IN ('request', 'delayed') ORDER BY date_connection ASC";
            $result = $conn->query($sql);
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function updateClientStatus($conn, $client_id, $status, $update_date = false) {
            if ($update_date) {
                $sql = "UPDATE places SET status = ?, date_review = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $date_review = date('Y-m-d'); // Текущая дата
                $stmt->bind_param("ssi", $status, $date_review, $client_id);
            } else {
                $sql = "UPDATE places SET status = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $status, $client_id);
            }
            $stmt->execute();
            $stmt->close();
        }

        if (!isset($_SESSION['clients'])) {
            $_SESSION['clients'] = getAllClients($connect);
            $_SESSION['client_index'] = 0;
        }

        $clients = $_SESSION['clients'];
        $client_index = isset($_SESSION['client_index']) ? $_SESSION['client_index'] : 0;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['refuse'])) {
                $client_id = $_POST['client_id'];
                updateClientStatus($connect, $client_id, 'rejection', true);
                $_SESSION['client_index']++;
            } elseif (isset($_POST['delay'])) {
                $client_id = $_POST['client_id'];
                updateClientStatus($connect, $client_id, 'delayed', true);
                $_SESSION['client_index']++;
            } elseif (isset($_POST['confirm'])) {
                $client_id = $_POST['client_id'];
                updateClientStatus($connect, $client_id, 'agreed', true);
                $_SESSION['client_index']++;
            } elseif (isset($_POST['check'])) {
                $_SESSION['clients'] = getAllClients($connect);
                $_SESSION['client_index'] = 0;
            }
            $clients = $_SESSION['clients'];
            $client_index = $_SESSION['client_index'];
        }

        if ($client_index >= count($clients)) {
            $_SESSION['clients'] = getAllClients($connect);
            $_SESSION['client_index'] = 0;
            $clients = $_SESSION['clients'];
            $client_index = 0;
        }

        if ($client_index < count($clients)) {
            $client = $clients[$client_index];
            echo "<div class='order-container'>";
            echo "<div class='order-box'>";
            echo "<div class='order-info'>ID: " . $client['id'] . "<br>Name Location: " . $client['name_location'] . "<br>Status: " . $client['status'] . "<br>Date Connection: " . $client['date_connection'] . "</div>";
            echo "<form method='POST'>";
            echo "<input type='hidden' name='client_id' value='" . $client['id'] . "'>";
            echo "<button class='ready-button' type='submit' name='refuse'>Refuse</button>";
            echo "<button class='ready-button' type='submit' name='delay'>Delay</button>";
            echo "<button class='ready-button' type='submit' name='confirm'>Confirm</button>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
        } else {
            $_SESSION['clients'] = getAllClients($connect);
            $clients = $_SESSION['clients'];
            if (count($clients) == 0) {
                echo "<div class='order-container'>";
                echo "<div class='order-info'>No orders</div>";
                echo "<form method='POST'>";
                echo "<button class='ready-button' type='submit' name='check'>Check</button>";
                echo "</form>";
                echo "</div>";
            } else {
                $_SESSION['client_index'] = 0;
                $client_index = 0;

                $client = $clients[$client_index];
                echo "<div class='order-container'>";
                echo "<div class='order-box'>";
                echo "<div class='order-info'>ID: " . $client['id'] . "<br>Name Location: " . $client['name_location'] . "<br>Status: " . $client['status'] . "<br>Date Connection: " . $client['date_connection'] . "</div>";
                echo "<form method='POST'>";
                echo "<input type='hidden' name='client_id' value='" . $client['id'] . "'>";
                echo "<button class='ready-button' type='submit' name='refuse'>Refuse</button>";
                echo "<button class='ready-button' type='submit' name='delay'>Delay</button>";
                echo "<button class='ready-button' type='submit' name='confirm'>Confirm</button>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
            }
        }
        ?>
    </div>
</div>

</body>

</html>
