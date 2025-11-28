<?php

session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('location: login.php');
}

if(isset($_POST["submit"])){
    $userId = $_GET['user_id']; 
    $fullName = htmlspecialchars($_POST['fullName']); 
    $phoneNumber = htmlspecialchars($_POST['phoneNumber']);
    $email = htmlspecialchars($_POST['email']);

    $sql ="UPDATE users SET full_name='$fullName', phone_number='$phoneNumber', email='$email' WHERE user_id ='$userId'";
    $query = mysqli_query($conn, $sql);

    if($query){
       header('location: tourists.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<title>Dashboard</title>

<?php include('shared-2/admin_sidebar.html'); ?>

    <main>
        <div class="page-header">
            <h1>Dashboard</h1>
            <small>Tourists / Dashboard</small>
        </div>
        <div class="booking"> 
        <div class="container-2">
            <h3 class="form-title">Update User Info</h3>
            <form action="#" method="POST">
                <?php 
                    $selectTourist = "SELECT * FROM users WHERE user_id = '".$_GET['user_id']."'";
                    $result = mysqli_query($conn, $selectTourist);

                    if(mysqli_num_rows($result) >0){
                        while($row = mysqli_fetch_assoc($result)){ 
                ?>
                <div class="main-user-info">
                    <div class="user-input-box">
                        <label>Full Name</label>
                        <input type="text" id="fullName" name="fullName" value="<?php echo $row['full_name']; ?>">
                    </div>
                    <div class="user-input-box">
                        <label>Phone Number</label>
                        <input type="text" id="phoneNumber" name="phoneNumber" value="<?php echo $row['phone_number']; ?>">
                    </div>
                    <div class="user-input-box">
                        <label>Email</label>
                        <input type="text" id="email" name="email" value="<?php echo $row['email']; ?>">
                    </div>
                </div>
                <?php
                    }
                }
                ?>
                    <div class="form-submit-btn">
                        <input type="submit" name="submit" value="Submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
</div>  

</body>
</html>