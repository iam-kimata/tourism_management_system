<?php

session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'tourist') {
    header('location: login.php');
}

$sql = "SELECT user_id AS company_user_id, company_name, company_location FROM users WHERE role = 'company'";
$query = mysqli_query($conn, $sql);

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
    <div class="page-content">
        <table width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Company Name</th>
                    <th>Company Location</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $count = 1;
                while($info = mysqli_fetch_assoc($query)){
            ?>
                <tr>
                    <td scope="row"><?php echo $count++ ?></td>
                    <td><span><?php echo "{$info['company_name']}" ?></span></td>
                    <td><span><?php echo "{$info['company_location']}" ?></span></td>
                    <td>
                        <a class="btn" href="view_more.php?company_user_id=<?php echo "{$info['company_user_id']}" ?>">View More</a>
                    </td>
                </tr>
                <?php
                }
            ?>
            </tbody>
        </table>
    </div>
</main>
</div>

</body>
</html>
