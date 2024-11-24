<?php

session_start();
error_reporting(0);
include('db_connection.php');
 
// Displaying validate message
$errors = array('userCategory'=>'', 'fullName'=>'', 'phoneNumber'=>'', 'email'=>'', 'companyName'=>'', 'companyLocation'=>'', 'licenseNumber'=>'', 'password'=>'', 'confirmPassword'=>'');

// Maintain corrent values after displaying validate message
$userCategory = $fullName = $phoneNumber = $email = $companyName = $companyLocation = $licenseNumber = $password = $confirmPassword = '';

if(isset($_POST['submit'])){

    // Check for User Category
    if(empty($_POST['userCategory'])){
        $errors['userCategory'] = 'A Category is required <br />';
    }else{
        $userCategory = $_POST['userCategory'];
    }
    
    // Check for Full Name
    if(empty($_POST['fullName'])){
        $fullName = NULL;
    }else{
        $fullName = $_POST['fullName'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $fullName)){
            $errors['fullName'] = 'Full Name must be letters and space only';
        }
    }
    
    // Check for Phone Number
    if(empty($_POST['phoneNumber'])){
        $phoneNumber = NULL;
    }else{
        $phoneNumber = $_POST['phoneNumber'];
        if(!preg_match('/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/', $phoneNumber)){
            $errors['phoneNumber'] = 'Phone Number must be a valid';
        }
    }
    
    // Check for Email
    if(empty($_POST['email'])){
        $errors['email'] = 'An Email is required <br />';
    }else{
        $email = $_POST['email'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Email must be a valid email address';
        }
    }

    // Check for Company Name
    if(empty($_POST['companyName'])){
        $companyName = NULL;
    }else{
        $companyName = $_POST['companyName'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $companyName)){
            $errors['companyName'] = 'Company Name must be letters and space only';
        }
    }

    // Check for Company Location
    if(empty($_POST['companyLocation'])){
        $companyLocation = NULL;
    }else{
        $companyLocation = $_POST['companyLocation'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $companyLocation)){
            $errors['companyLocation'] = 'Company Location must be letters and space only';
        }
    }

    // Check for Company License Number
    if(empty($_POST['licenseNumber'])){
        $licenseNumber = NULL;
    }else{
        $licenseNumber = $_POST['licenseNumber'];
        if(!preg_match('/^[A-Za-z0-9]+$/', $licenseNumber)){
            $errors['licenseNumber'] = 'License Number must be letters and numbers only';
        }
    }
      
    // Check for Password
    if(empty($_POST['password'])){
        $errors['password'] = 'A Password is required <br />';
    }else{
        $password = $_POST['password'];
        if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{8,20}$/', $password)){
            $errors['password'] = 'Password must include at least one number, upper, lower and special character';
        }
    }
    
    // Check for Confirm Password
    if(empty($_POST['confirmPassword'])){
        $errors['confirmPassword'] = 'A Confirm Password is required <br />';
    }else{
        $confirmPassword = $_POST['confirmPassword'];
        if($password != $confirmPassword){
            $errors['confirmPassword'] = 'Password must be match';
        }else{           
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        }    
    }

    if(array_filter($errors)){
    }else{
        $sql = "INSERT INTO users (role, full_name, phone_number, email, company_name, company_location, license_number, password, created_at)
                VALUES ('$userCategory', ";

        // Include NULL values for optional fields
        $sql .= empty($fullName) ? "NULL, " : "'$fullName', ";
        $sql .= empty($phoneNumber) ? "NULL, " : "'$phoneNumber', ";
        $sql .= "'$email', ";
        $sql .= empty($companyName) ? "NULL, " : "'$companyName', ";
        $sql .= empty($companyLocation) ? "NULL, " : "'$companyLocation', ";
        $sql .= empty($licenseNumber) ? "NULL, " : "'$licenseNumber', ";
        $sql .= "'$hashedPassword', NOW())";

        $query = mysqli_query($conn, $sql);

        if($query){
            header('location: login.php');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<title>Sign up</title>

<?php include('shared/navbar.html'); ?>

    <div class="sign-up"> 
        <div class="container">
            <h3 class="form-title">Sign Up Here</h3>
            <form action="sign_up.php" method="POST">
                <div class="main-user-info">
                   <div class="user-input-box">
                        <label>Select Category</label>
                        <select id="userCategory" name="userCategory" onchange="toggleField()">
                            <option value="" disabled selected>Select Category</option>
                            <option value="tourist" <?php echo ($userCategory === 'tourist') ? 'selected' : ''; ?> >Tourist</option>
                            <option value="company" <?php echo ($userCategory === 'company') ? 'selected' : ''; ?>>Tourist Company</option>
                        </select>
                        <div class="red-text"><?php echo $errors['userCategory']; ?></div>
                    </div>
                    <div class="user-input-box" id="nameField">
                        <label>Full Name</label>
                        <input type="text" id="fullName" name="fullName" value="<?php echo htmlspecialchars($fullName) ?>">
                        <div class="red-text"><?php echo $errors['fullName']; ?></div>
                    </div>
                    <div class="user-input-box" id="phoneField">
                        <label>Phone Number</label>
                        <input type="text" id="phoneNumber" name="phoneNumber" value="<?php echo htmlspecialchars($phoneNumber) ?>">
                        <div class="red-text"><?php echo $errors['phoneNumber']; ?></div>
                    </div>
                    <div class="user-input-box" id="emailField">
                        <label>Email</label>
                        <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email) ?>">
                        <div class="red-text"><?php echo $errors['email']; ?></div>
                    </div>
                    <div class="user-input-box" id="companyField">
                        <label>Company Name</label>
                        <input type="text" id="companyName" name="companyName" value="<?php echo htmlspecialchars($companyName) ?>">
                        <div class="red-text"><?php echo $errors['companyName']; ?></div>
                    </div>
                    <div class="user-input-box" id="locationField">
                        <label>Company Location</label>
                        <input type="text" id="companyLocation" name="companyLocation" value="<?php echo htmlspecialchars($companyLocation) ?>">
                        <div class="red-text"><?php echo $errors['companyLocation']; ?></div>
                    </div>
                    <div class="user-input-box" id="licenseField">
                        <label>License Number</label>
                        <input type="text" id="licenseNumber" name="licenseNumber" value="<?php echo htmlspecialchars($licenseNumber) ?>">
                        <div class="red-text"><?php echo $errors['licenseNumber']; ?></div>
                    </div>
                    <div class="user-input-box">
                        <label>Password</label>
                        <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($password) ?>">
                        <div class="red-text"><?php echo $errors['password']; ?></div>
                    </div>
                    <div class="user-input-box">
                        <label>Confirm Password</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" value="<?php echo htmlspecialchars($confirmPassword) ?>">
                        <div class="red-text"><?php echo $errors['confirmPassword']; ?></div>
                    </div>     
                    <div class="form-submit-btn">
                        <input type="submit" name="submit" value="Sign up">
                    </div>
                </div>
                <div class="login-link">
                    <p>Already have an account? <a href="login.php">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleField() {
            let userCategory = document.querySelector('#userCategory').value;
            let nameInput = document.querySelector('#nameField');
            let phoneInput = document.querySelector('#phoneField');
            let emailInput = document.querySelector('#emailField');
            let companyInput = document.querySelector('#companyField');
            let locationInput = document.querySelector('#locationField');
            let licenseInput = document.querySelector('#licenseField');

            if (userCategory === 'tourist') {
                nameInput.style.display = 'block';
                phoneInput.style.display = 'block';
                emailInput.style.display = 'block';
                companyInput.style.display = 'none';
                locationInput.style.display = 'none';
                licenseInput.style.display = 'none';
            
            } else if (userCategory === 'company') {
                nameInput.style.display = 'none';
                phoneInput.style.display = 'none';
                emailInput.style.display = 'block';
                companyInput.style.display = 'block';
                locationInput.style.display = 'block';
                licenseInput.style.display = 'block';
            }
        }
    </script>

</html>



                    
