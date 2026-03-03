<?php

$servername ="localhost:3306";
$username = "root";
$password="";

//Create Connection
$conn=mysqli_connect($servername, $username, $password);

//check connection
if(!$conn)
{
   die("Connection failed: " .mysqli_connect_error()); 
}
//eco "Connected sucessfully";
?>