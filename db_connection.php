<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "tourism_management";

$conn = mysqli_connect($host, $user, $password, $database);

if(!$conn){
    die("mysql connect error");
}

?>