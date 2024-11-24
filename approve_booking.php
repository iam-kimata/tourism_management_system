<?php

session_start();
include('db_connection.php');

if (isset($_POST['approve'])) {
    $booking_id = $_POST['booking_id'];

    $sql = "UPDATE booking SET status='approved' WHERE id='$booking_id'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Booking approved successfully.";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($conn);
    }
    header('location: company_dashboard.php');
}

?>
