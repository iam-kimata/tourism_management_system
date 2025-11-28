<?php

session_start();
error_reporting(0);
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'tourist') {
    header('location: login.php');
}

// Check if the attraction_id and company_user_id are provided in the URL
if(isset($_GET['attraction_id']) && isset($_GET['company_user_id'])) {
    // Get the attraction_id and company_user_id from the URL
    $attraction_id = $_GET['attraction_id'];
    $company_user_id = $_GET['company_user_id'];
    
    // Query to fetch attraction details based on attraction_id
    $attraction_query = "SELECT * FROM attractions WHERE id = $attraction_id";
    $attraction_result = mysqli_query($conn, $attraction_query);

    if(mysqli_num_rows($attraction_result) > 0) {
        // Fetch attraction information
        $attraction_info = mysqli_fetch_assoc($attraction_result);
        $image = $attraction_info['image'];
        $place = $attraction_info['place'];
        $people = $attraction_info['people'];
        $price = $attraction_info['price'];
        $description = $attraction_info['description']; 
    } else {
        // Redirect if attraction_id is invalid or not found
        header('location: view_company.php?company_user_id=' . $company_user_id);
    }
} else {
    // Redirect if attraction_id or company_user_id is not provided in the URL
    header('location: view_company.php?company_user_id=' . $company_user_id);
}
?>

<!DOCTYPE html>
<html lang="en">
<title>Dashboard</title>

   <style>
    .tourist-container {
        justify-content: center; 
        align-items: center;  
    }

    .btn {
        margin-left: 1100px;
    }
     
   </style>

<?php include('shared-2/tourist_sidebar.html'); ?>

<main>
    <div class="page-header">
        <h1>Dashboard</h1>
        <small>Home / Dashboard</small>
        <a class="btn" href="view_more.php?company_user_id=<?php echo $company_user_id; ?>">Go Back</a> 
    </div>
    <section class="tourist">
        <div class="tourist-container container">
            <?php
            if($attraction_info) {
                echo '<div class="box" style="width: 300px; margin: 20px; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); text-align: center;">';
                echo '<img src="image_uploads-2/' . $image . '" alt="" style="max-width: 100%; height: auto;">';
                echo '<h3>' . $place . '</h3>';
                echo '<span>' . $people . ' Person per day</span>';
                echo '<span>' . $price . ' Tsh</span>';
                echo '<p>' . $description . '</p>';
                echo '</div>';
            } else {
                echo "<p class='info-message'>No information found for this attraction.</p>";
            }
            ?>
        </div>       
    </section>
</main>
</div>

</body>
</html>
