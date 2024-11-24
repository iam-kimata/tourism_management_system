<?php

session_start();
include('db_connection.php');

if(isset($_POST['submit'])){
    $username = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
  
    $sql = "SELECT * FROM users WHERE email = '$username'";
    $query = mysqli_query($conn, $sql);
  
    if(mysqli_num_rows($query) > 0){
       $result = mysqli_fetch_assoc($query);
        
        // Verify the hashed password
        if(password_verify($password, $result['password'])){
            $_SESSION['role'] = $result['role'];
            $_SESSION['user_id'] = $result['user_id'];
  
            if($result['role'] == "admin"){
            header('location: admin_dashboard.php');
            }elseif($result['role'] == "company"){
            header('location: company_dashboard.php');
            }elseif($result['role'] == "tourist"){
            header('location: tourist_dashboard.php');
            }
        }else{
            // Incorrect password
            $_SESSION['message'] = 'Incorrect Username or Password';
            header('location: login.php');
        }
    }else{
       // User not found
       $_SESSION['message'] = 'Incorrect Username or Password';
          header('location: login.php');
    }
 }

?>