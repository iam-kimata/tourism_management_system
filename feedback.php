<?php

session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'tourist') {
    header('location: login.php');
}

$sql = "SELECT * FROM booking WHERE user_id = '$_SESSION[user_id]' AND status = 'approved' ORDER BY id DESC";
$query = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<title>Dashboard</title>

<?php include('shared-2/tourist_sidebar.html'); ?>

    <main>
        <div class="page-header">
            <h1>Dashboard</h1>
            <small>Feedback / Dashboard</small>
        </div>
        <div class="page-content">
            <?php
            if (mysqli_num_rows($query) > 0) {
            ?>
                <table width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Visit Place</th>
                            <th>No of People</th>
                            <th>Arrival Date</th>
                            <th>Departure Date</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        while ($info = mysqli_fetch_assoc($query)) {
                        ?>
                        <tr>
                            <td scope="row"><?php echo $count++ ?></td>
                            <td><span><?php echo "{$info['place']}" ?></span></td>
                            <td><span><?php echo "{$info['people']}" ?></span></td>
                            <td><span><?php echo "{$info['arrival']}" ?></span></td>
                            <td><span><?php echo "{$info['departure']}" ?></span></td>
                            <td><span><?php echo "{$info['updated_price']}" ?></span></td>
                            <td><span><?php echo "{$info['created_att']}" ?></span></td>
                            <td><span class="status-approved"><?php echo ucfirst($info['status']); ?></span></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            <?php
            } else {
                echo "<p class='info-message'>No feedback found.</p>";
            }
            ?>
        </div>
    </main>
    
</body>
</html>
