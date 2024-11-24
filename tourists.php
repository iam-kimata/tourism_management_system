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

    $sql = "SELECT * FROM users WHERE role = 'tourist' AND full_name = '$fullName'";
    $query = mysqli_query($conn, $sql);

    // Check if any results were found
    if (mysqli_num_rows($query) > 0) {
        $resultsFound = true;
    }
} else {
    $sql = "SELECT user_id, full_name, phone_number, email FROM users WHERE role = 'tourist' ORDER BY user_id DESC";
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

<body>
    <main>
        <div class="page-header">
            <h1>Dashboard</h1>
            <small>Tourists / Dashboard</small>
        </div>
        <div class="records table-responsive">
            <div class="record-header">       
                <div class="browse">
                    <form action="tourists.php" method="POST">
                        <input type="search" name="search" placeholder="Search" class="record-search">
                        <button type="search"></button>
                    </form>
                </div>
            </div>
            <div>
            <?php
                if ($resultsFound) {
            ?>
            <table width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Action</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $count = 1;
                        while ($info = mysqli_fetch_assoc($query)) {
                    ?>
                    <tr>
                        <td scope="row"><?php echo $count++ ?></td>
                        <td><span><?php echo "{$info['full_name']}" ?></span></td>
                        <td><span><?php echo "{$info['phone_number']}" ?></span></td>
                        <td><span><?php echo "{$info['email']}" ?></span></td>
                        <td><?php echo "<a onclick = \"javascript:return confirm('Are you sure you want to delete');\" class='btn delete-btn' href='delete_tourist.php?user_id={$info['user_id']}'>Delete</a>"; ?></td>
                        <td><?php echo "<a class='btn update-btn' href='update_tourist.php?user_id={$info['user_id']}'>Update</a>"; ?></td>
                    </tr>
                    <?php
                        }
                    ?>  
                </tbody>
            </table>
            <?php
                } else {
                    echo "<p class='info-message'>User not found.</p>";
                }
            ?>
        </div>
    </main>
    </div>  
    
</body>
</html>
