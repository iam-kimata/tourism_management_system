<?php

session_start();
error_reporting(0);
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'company') {
    header('location: login.php');
}

if(isset($_POST['submit'])){
    $userId = $_POST['userId'];
    $image = $_FILES['image']['name'];
    $targetDir = 'image_uploads-2/';
    $targetFile = $targetDir . basename($image);
        
    if(move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)){
        // Successfully uploaded
    } else {
        // Upload failed
    }
        
    $place = htmlspecialchars($_POST['place']);
    $people = htmlspecialchars($_POST['people']);
    $price = htmlspecialchars($_POST['price']);
    $description = htmlspecialchars($_POST['description']);

    $sql = "INSERT INTO attractions(user_id, image, place, people, price, description)
            VALUES('$userId', '$image', '$place', '$people', '$price', '$description')";

    $query = mysqli_query($conn, $sql);

    if($query){
        $_SESSION['success_message'] = "You have successfully added a tourist attraction!";
        header('location: add_attraction.php');
        exit();
    }
}

// Retrieve and clear success message from session
$successMessage = '';
if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

?>

<!DOCTYPE html>
<html lang="en">
<title>Dashboard</title>

<?php include('shared-2/company.html'); ?>

<main>
    <div class="page-header">
        <h1>Dashboard</h1>
        <small>Attractions / Dashboard</small>
    </div>
    <div class="booking"> 
        <div class="container-2">
            <h3 class="form-title">Add Tourist Attraction</h3>
            <?php if (!empty($successMessage)): ?>
                <p class="success-message"><?php echo $successMessage; ?></p>
            <?php endif; ?>
            <form action="add_attraction.php" method="POST" enctype="multipart/form-data">
                <div class="main-user-info">
                    <div class="user-input-box">
                        <input type="hidden" id="userId" name="userId" value="<?php echo $_SESSION['user_id']; ?>">
                    </div>
                    <div class="user-input-box">
                        <label>Image</label>
                        <input type="file" id="image" name="image" required>
                    </div>
                    <div class="user-input-box">
                        <label>Place</label>
                        <input type="text" id="place" name="place" required>
                    </div>
                    <div class="user-input-box">
                        <label>No of People</label>
                        <input type="number" id="people" name="people" required>
                    </div>
                    <div class="user-input-box">
                        <label>Price</label>
                        <input type="number" id="price" name="price" required>
                    </div>
                    <div class="user-input-box">
                        <label>More Info</label>
                        <textarea id="description" name="description" rows="5" required></textarea>
                    </div>
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
