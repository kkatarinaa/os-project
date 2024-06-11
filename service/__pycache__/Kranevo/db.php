<?php 

$connect = mysqli_connect('mysql', 'user', 'password', 'Hedg-Kranevo');

if (!$connect){
    die("Connection failed: " . mysqli_connect_error());
} 

?>
