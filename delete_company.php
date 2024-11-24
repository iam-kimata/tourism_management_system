<?php

session_start();
include('db_connection.php');

if(isset($_GET['user_id'])){
    $userId = $_GET['user_id'];
    $sql = "DELETE FROM users WHERE user_id ='$userId'";
    $query = mysqli_query($conn, $sql);

    if($query){
        header('location: companies.php');
    }
}

?>