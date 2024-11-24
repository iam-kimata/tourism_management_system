<?php

session_start();
error_reporting(0);
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('location: login.php');
}

// Variable to track whether any results were found
$resultsFound = false;

if (isset($_POST['search'])) {
    $fullName = mysqli_real_escape_string($conn, $_POST['search']);

    $sql = "SELECT booking.*, users.full_name, 
            CASE WHEN booking.status = 'approved' THEN 'approved' ELSE 'pending' END AS status 
            FROM booking 
            INNER JOIN users ON booking.user_id = users.user_id 
            WHERE users.role = 'tourist' AND users.full_name = '$fullName'
            ORDER BY booking.id DESC";
    $query = mysqli_query($conn, $sql);

    // Check if any results were found
    if (mysqli_num_rows($query) > 0) {
        $resultsFound = true;
    }
} else {
    $sql = "SELECT booking.*, users.full_name, 
            CASE WHEN booking.status = 'approved' THEN 'approved' ELSE 'pending' END AS status 
            FROM booking 
            INNER JOIN users ON booking.user_id = users.user_id 
            WHERE users.role = 'tourist' 
            ORDER BY booking.id DESC";
    $query = mysqli_query($conn, $sql);

    // Check if any results were found
    if (mysqli_num_rows($query) > 0) {
        $resultsFound = true;
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
        <small>Home / Dashboard</small>
    </div>
    <div class="page-content">
        <div class="analytics">
            <div class="card">
                <div class="card-head">
                    <h2><?php  
                        $count = mysqli_query($conn, "SELECT user_id FROM users WHERE role = 'tourist'");
                        $tourist_count = mysqli_num_rows($count);
                        if (empty($tourist_count) >= 0) { ?>                
                        <?php echo $tourist_count ?>
                        <?php } ?>
                    </h2>
                    <span class="bx bx-group"></span>
                </div>
                <div class="card-progress">
                    <small>Total tourists</small>
                    <div class="card-indicator">
                        <div class="indicator one" style="width: 100%"></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-head">
                    <h2><?php  
                        $count = mysqli_query($conn, "SELECT user_id FROM users WHERE role = 'company'");
                        $company_count = mysqli_num_rows($count);
                        if (empty($company_count) >= 0) { ?>                
                        <?php echo $company_count ?>
                        <?php } ?>
                    </h2>
                    <span class="bx bx-building"></span>
                </div>
                <div class="card-progress">
                    <small>Total companies</small>
                    <div class="card-indicator">
                    <div class="indicator four" style="width: 100%"></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-head">
                    <h2><?php  
                        $count = mysqli_query($conn, "SELECT * FROM booking");
                        $booking_count = mysqli_num_rows($count);
                        if (empty($booking_count) >= 0) { ?>                
                        <?php echo $booking_count ?>
                        <?php } ?>
                    </h2>
                    <span class="bx bx-package"></span>
                </div>
                <div class="card-progress">
                    <small>Total booking</small>
                    <div class="card-indicator">
                        <div class="indicator three" style="width: 100%"></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-head">
                    <h2><?php  
                        $count = mysqli_query($conn, "SELECT user_id FROM booking WHERE status = 'approved'");
                        $approved_count = mysqli_num_rows($count);
                        if (empty($approved_count) >= 0) { ?>                
                        <?php echo $approved_count ?>
                        <?php } ?>
                    </h2>
                    <span class="bx bx-badge-check"></span>
                </div>
                <div class="card-progress">
                    <small>Total approved booking</small>
                    <div class="card-indicator">
                        <div class="indicator two" style="width: 100%"></div>
                    </div>
                </div>
           </div>
        </div>

        <div class="records table-responsive">
            <div class="record-header">
                <div class="add">
                    <button>Available Bookings</button>
                </div>

                <div class="browse">
                    <form action="admin_dashboard.php" method="POST">
                        <input type="search" name="search" placeholder="Search" class="record-search">
                        <button type="search"></button>
                    </form>
                </div>
            </div>
        <div>
        <?php
        if (mysqli_num_rows($query) > 0) {
        ?>
        <table width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tourist Name</th>
                    <th>Visit Place</th>
                    <th>No of People</th>
                    <th>Arrival Date</th>
                    <th>Departure Date</th>
                    <th>Booking Date</th>
                    <th>Price</th>
                    <th>Status</th> 
                </tr>
            </thead>
                <tbody>
                <?php
                $count = 1;
                    while($info = mysqli_fetch_assoc($query)){
                        $status_class = $info['status'] == 'approved' ? 'status-approved' : 'status-pending';
                ?>
                    <tr>
                        <td scope="row"><?php echo $count++ ?></td>
                        <td><span><?php echo "{$info['full_name']}" ?></span></td>
                        <td><span><?php echo "{$info['place']}" ?></span></td>
                        <td><span><?php echo "{$info['people']}" ?></span></td>
                        <td><span><?php echo "{$info['arrival']}" ?></span></td>
                        <td><span><?php echo "{$info['departure']}" ?></span></td>
                        <td><span><?php echo "{$info['created_att']}" ?></span></td>
                        <td><span><?php echo "{$info['updated_price']}" ?></span></td>
                        <td><span class="<?php echo $status_class; ?>"><?php echo ucfirst("{$info['status']}") ?></span></td>
                    </tr>
                    <?php
                }
                ?>   
                </tbody>
        </table>
        <?php
        } else {
            echo "<p class='info-message'>No bookings found.</p>";
        }
        ?>
    </div>
</main>
</div>  

</body>
</html>
