<?php 

$connect = mysqli_connect('mysql', 'user', 'pass', 'project_os');

if (!$connect){
    die("Connection failed: " . mysqli_connect_error());
} 

?>