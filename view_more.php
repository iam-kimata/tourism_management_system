<?php

session_start();
error_reporting(0);
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'tourist') {
    header('location: login.php');
}

// Check if the company_user_id is provided in the URL
if(isset($_GET['company_user_id'])) {
    // Get the company_user_id from the URL
    $company_user_id = $_GET['company_user_id'];
    
    // Query to fetch company name based on company_user_id
    $company_query = "SELECT company_name FROM users WHERE user_id = $company_user_id";
    $company_result = mysqli_query($conn, $company_query);

    if(mysqli_num_rows($company_result) > 0) {
        // Fetch company information
        $company_info = mysqli_fetch_assoc($company_result);
        $company_name = $company_info['company_name'];

        // Query to fetch attractions for the specific company based on company_user_id
        $attraction_query = "SELECT * FROM attractions WHERE user_id = $company_user_id";
        $attraction_result = mysqli_query($conn, $attraction_query);
    } else {
        // Redirect if company_user_id is invalid or not found
        header('location: tourist_dashboard.php');
    }
} else {
    // Redirect if company_user_id is not provided in the URL
    header('location: tourist_dashboard.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<title>Dashboard</title>

<?php include('shared-2/tourist.html'); ?>

<main>
    <div class="page-header">
        <h1>Dashboard</h1>
        <small>Home / Dashboard</small>
    </div>
    <section class="tourist">
        <div class="tourist-container container">
            <?php
            if(mysqli_num_rows($attraction_result) > 0) { 
                while($row = mysqli_fetch_assoc($attraction_result)) {
                    echo '<div class="box">';
                    echo '<img src="image_uploads-2/' . $row['image'] . '" alt="">';
                    echo '<h3>' . $row['place'] . '</h3>';
                    echo '<span>' . $row['people'] . ' Person per day</span>';
                    echo '<span>' . $row['price'] . ' Tsh</span>';
                    echo '<div class="action-links">';
                    echo '<a href="booking_company.php?company_user_id=' . $company_user_id . '&place=' . $row['place'] . '&price=' . $row['price'] . '" class="btn-2">Book Now</a>';
                    echo '<a href="more_info.php?attraction_id=' . $row['id'] . '&company_user_id=' . $company_user_id . '" class="more-info">More Info</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<p class='info-message'>No tourist attractions found.</p>";
            }
            ?>
        </div>
    </section>
</main>
</div>

</body>
</html>
