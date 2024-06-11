<?php 

$connect = mysqli_connect('mysql', 'user', 'password', 'project');

if (!$connect){
    die("Connection failed: " . mysqli_connect_error());
} 

?>
