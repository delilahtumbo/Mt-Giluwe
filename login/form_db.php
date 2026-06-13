<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, null, 3306);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
