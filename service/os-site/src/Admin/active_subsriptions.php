<?php
    error_reporting(0);
    session_start();
    require_once '../db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset ="UTF-8">
    <title>Show all applications page</title>
    <link rel ="icon" href="../uploads/img/logo.png" />
    <link rel ="stylesheet" href="../style.css" />
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

        .subscription {
            margin-top: 50px;
            font-family: 'Source Code Pro';
            font-size: 30px;
        }

        h1 {
            margin-top: 0px;
            font-family: 'Source Code Pro';
            font-size: 35px;
            font-style: italic;
        }

        li {
            margin-top: 10px;
            font-family: 'Source Code Pro';
            font-size: 30px;
        }

        p {
            margin-top: 0px;
            font-family: 'Source Code Pro';
            font-size: 30px;
            text-align: center;
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
                    Clothes crafting
                </div>
            </div>
        </div>
</header>
<button type='submit' class="button-back" onclick="window.location.href = 'profile_page.php'">Exit</button>
<h1>List of active subsriptions for today:</h1>
<?php
$sql = "SELECT places.name_location, clients.login, places.date_connection, places.date_shutdown
FROM places 
INNER JOIN clients ON places.client_id = clients.id 
WHERE  places.status LIKE 'active'";

$result = $connect->query($sql);
if ($result->num_rows > 0) {
    // Выводим список действующих аренд
    echo "<div class='subscription-list'>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='subscription'>";
        echo "<li><strong>Place:</strong> " . $row["name_location"] . "</li>";
        echo "<li><strong>Client:</strong> " . $row["login"] . "</li>";
        echo "<li><strong>Subscription Start Date:</strong> " . $row["date_connection"] . "</li>";
        echo "<li><strong>Subscription End Date:</strong> " . $row["date_shutdown"] . "</li>";
        echo "</div>";
        echo "<br>";
        echo "<br>";
    }
    echo "</div>";
} else {
    echo "<p>There is no active subscriptions for today</p>";
}
?>
