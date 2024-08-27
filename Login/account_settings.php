<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'database.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_info'])) {
        // Update the user information
        $name = $_POST['name'];
        $middle_name = isset($_POST['no_middle_name']) ? NULL : $_POST['middle_name'];
        $last_name = $_POST['last_name'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $birthday = $_POST['birthday'];
        $contact_number = $_POST['contact_number'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        
        $sql = "UPDATE users SET 
                name='$name', 
                middle_name='$middle_name', 
                last_name='$last_name', 
                age='$age', 
                gender='$gender', 
                birthday='$birthday', 
                contact_number='$contact_number', 
                address='$address', 
                email='$email' 
                WHERE id='$user_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Information updated successfully!";
        } else {
            echo "Error updating information: " . $conn->error;
        }
    } elseif (isset($_POST['delete_account'])) {
        // Fetch the current password from the database
        $sql = "SELECT password FROM users WHERE id='$user_id'";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
        
        // Verify the password
        $password = $_POST['password'];
        
        if ($password === $user['password']) {
            // Password is correct, delete the account
            $sql = "DELETE FROM users WHERE id='$user_id'";
            if ($conn->query($sql) === TRUE) {
                session_destroy();
                header("Location: login.php");
                exit();
            } else {
                echo "Error deleting account: " . $conn->error;
            }
        } else {
            // Password is incorrect
            echo "Incorrect password. Account not deleted.";
        }
    }
}

// Fetch user details to populate the form fields
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Account Settings</title>
   <link rel="stylesheet" href="astyle.css">
</head>
<body>

     <div class="container">
    <h2>Account Settings</h2>

    <form method="post">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name'], ENT_QUOTES); ?>" required><br>
        
        <label>Middle Name:</label><br>
        <input type="text" name="middle_name" value="<?php echo htmlspecialchars($user['middle_name'], ENT_QUOTES); ?>"><br>
        <input type="checkbox" name="no_middle_name" value="1" <?php echo is_null($user['middle_name']) ? 'checked' : ''; ?>> I don't have a Middle Name<br>
        
        <label>Last Name:</label><br>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name'], ENT_QUOTES); ?>" required><br>
        
        <label>Age:</label><br>
        <input type="number" name="age" value="<?php echo htmlspecialchars($user['age'], ENT_QUOTES); ?>" required><br>
        
        <label>Gender:</label><br>
        <input type="radio" name="gender" value="Male" <?php echo $user['gender'] == 'Male' ? 'checked' : ''; ?> required> Male
        <input type="radio" name="gender" value="Female" <?php echo $user['gender'] == 'Female' ? 'checked' : ''; ?> required> Female
        <input type="radio" name="gender" value="Other" <?php echo $user['gender'] == 'Other' ? 'checked' : ''; ?> required> Other<br>
        
        <label>Birthday:</label><br>
        <input type="date" name="birthday" value="<?php echo htmlspecialchars($user['birthday'], ENT_QUOTES); ?>" required><br>
        
       <label>Contact Number:</label><br>
<input type="text" name="contact_number" value="<?php echo htmlspecialchars($user['contact_number'], ENT_QUOTES); ?>" maxlength="11" pattern="\d{11}" required oninput="this.value = this.value.replace(/[^0-9]/g, '');"><br>

        
        <label>Address:</label><br>
        <textarea name="address" required><?php echo htmlspecialchars($user['address'], ENT_QUOTES); ?></textarea><br>
        
        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email'], ENT_QUOTES); ?>" required><br>
        
        <input type="submit" name="update_info" value="Update Information"><br><br>
    </form>
    
    <form method="post" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
        <label>Enter your password to delete your account:</label><br>
        <input type="password" name="password" required><br>
        <input type="submit" name="delete_account" value="Delete My Account">
    </form>
    
    <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
