<?php

session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'company') {
    header('location: login.php');
}

$company_user_id = $_SESSION['user_id']; 

$sql = "SELECT * FROM booking INNER JOIN users ON booking.user_id = users.user_id WHERE users.role = 'tourist' AND company_user_id = '$company_user_id' AND booking.status = 'approved' ORDER BY id DESC";
$query = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<title>Dashboard</title>

<?php include('shared-2/company_sidebar.html'); ?>

    <main>
        <div class="page-header">
            <h1>Dashboard</h1>
            <small>Approved / Dashboard</small>
        </div>
        <div class="browse">
            <form action="#" method="POST">
                <input type="search" name="search" placeholder="Search" class="record-search">
                <button type="search"></button>
            </form>
        </div>
        <div class="page-content">
            <?php
            if (mysqli_num_rows($query) > 0) {
            ?>
                <table width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Phone Number</th>
                            <th>Visit Place</th>
                            <th>No of People</th>
                            <th>Arrival Date</th>
                            <th>Departure Date</th>
                            <th>Booking Date</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $count = 1;
                    while($info = mysqli_fetch_assoc($query)){
                    ?>
                        <tr>
                            <td scope="row"><?php echo $count++ ?></td>
                            <td><span><?php echo "{$info['full_name']}" ?></span></td>
                            <td><span><?php echo "{$info['phone_number']}" ?></span></td>
                            <td><span><?php echo "{$info['place']}" ?></span></td>
                            <td><span><?php echo "{$info['people']}" ?></span></td>
                            <td><span><?php echo "{$info['arrival']}" ?></span></td>
                            <td><span><?php echo "{$info['departure']}" ?></span></td>
                            <td><span><?php echo "{$info['created_att']}" ?></span></td>
                            <td><span><?php echo "{$info['updated_price']}" ?></span></td>
                        </tr>
                    <?php
                    }
                    ?>  
                    </tbody>
                </table>
            <?php
            } else {
                echo "<p class='info-message'>No approved bookings found.</p>";
            }
            ?>
        </div>
    </main>
    </div>  
    
</body>
</html>
