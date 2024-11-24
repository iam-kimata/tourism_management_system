<?php

session_start();
error_reporting(0);
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'tourist') {
    header('location: login.php');
}

// Get the parameters from the URL
$userId = $_SESSION['user_id'];
$companyUserId = $_GET['company_user_id'];
$place = $_GET['place'];
$price = $_GET['price'];

$bookingSuccess = false;

if(isset($_POST['submit'])){
    $people = htmlspecialchars($_POST['people']);
    $arrival = htmlspecialchars($_POST['arrival']);
    $departure = htmlspecialchars($_POST['departure']);

    // Calculate the updated price
    $updatedPrice = $people * $price;

    $sql = "INSERT INTO booking (user_id, company_user_id, place, people, arrival, departure, price, updated_price, created_att) 
            VALUES ('$userId', '$companyUserId', '$place', '$people', '$arrival', '$departure', '$price', '$updatedPrice', NOW())";

    $query = mysqli_query($conn, $sql);

    if($query){
        $bookingSuccess = true;
    } else {
        $errorMessage = "Error: " . mysqli_error($conn);
    }
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
    <div class="booking"> 
        <div class="container-2">
            <h3 class="form-title">Booking Here</h3>
            <?php if ($bookingSuccess): ?>
                <p class="success-message">You have successfully booked.</p>
            <?php endif; ?>
            <?php if (isset($errorMessage)): ?>
                <p class="error-message"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
            <form action="booking_company.php?company_user_id=<?php echo $companyUserId; ?>&place=<?php echo $place; ?>&price=<?php echo $price; ?>" method="POST">
                <div class="main-user-info">
                    <div class="user-input-box">
                        <label>Number of People</label>
                        <input type="number" id="people" name="people" oninput="updatePrice()" required>
                    </div>
                    <div class="user-input-box">
                        <label>Arrival Date</label>
                        <input type="date" id="arrival" name="arrival" required>
                    </div>
                    <div class="user-input-box">
                        <label>Departure Date</label>
                        <input type="date" id="departure" name="departure" required>
                    </div>
                    <div class="form-submit-btn">
                        <input type="submit" name="submit" value="Submit">
                    </div>
                </div>
                <a class="btn" href="view_more.php?company_user_id=<?php echo $companyUserId; ?>">Go Back</a>        
            </form>
        </div>
    </div>
</main>
</div>   

</body>
</html>
