<?php

session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('location: login.php');
}

if(isset($_POST["submit"])){
    $userId = $_GET['user_id']; 
    $companyName = htmlspecialchars($_POST['companyName']); 
    $companyLocation = htmlspecialchars($_POST['companyLocation']);
    $licenseNumber = htmlspecialchars($_POST['licenseNumber']);

    $sql ="UPDATE users SET company_name='$companyName', company_location='$companyLocation', license_number='$licenseNumber' WHERE user_id ='$userId'";
    $query = mysqli_query($conn, $sql);

    if($query){
       header('location: companies.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<title>Dashboard</title>

<?php include('shared-2/admin.html'); ?>

    <main>
        <div class="page-header">
            <h1>Dashboard</h1>
            <small>Companies / Dashboard</small>
        </div>
        <div class="booking"> 
        <div class="container-2">
            <h3 class="form-title">Update User Info</h3>
            <form action="#" method="POST">
                <?php 
                    $selectCompany = "SELECT * FROM users WHERE user_id = '".$_GET['user_id']."'";
                    $result = mysqli_query($conn, $selectCompany);

                    if(mysqli_num_rows($result) >0){
                        while($row = mysqli_fetch_assoc($result)){ 
                ?>
                <div class="main-user-info">
                    <div class="user-input-box">
                        <label>Company Name</label>
                        <input type="text" id="companyName" name="companyName" value="<?php echo $row['company_name']; ?>">
                    </div>
                    <div class="user-input-box">
                        <label>Company Location</label>
                        <input type="text" id="companyLocation" name="companyLocation" value="<?php echo $row['company_location']; ?>">
                    </div>
                    <div class="user-input-box">
                        <label>License Number</label>
                        <input type="text" id="licenseNumber" name="licenseNumber" value="<?php echo $row['license_number']; ?>">
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