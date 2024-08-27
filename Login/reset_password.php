<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];

    $sql = "UPDATE users SET password='$new_password' WHERE email='$email'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Password reset successful!'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Error resetting password: " . $conn->error . "'); window.location.href='login.php';</script>";
    }
    $conn->close();
} else if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display the password reset form
        ?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
   <link rel="stylesheet" href="restyle.css">
 
</head>
<body>
  
    <div class="container">
    <h2>Reset Password</h2>
    <form method="post">
    
       
        <input type="hidden" name="email" value="<?php echo $email; ?>">
        <label>New Password:</label>
        <input type="password" name="new_password" required><br><br>
       
        <label>Confirm New Password:</label>
        <input type="password" name="confirm_new_password" required><br> <br>
        <input type="submit" value="Reset Password" onclick="return confirm('Are you sure you want to reset your password?');" class="login-btn" >
    </form>
    </div>
</body>
</html>

<?php
    } else {
        echo "No user found with this email!";
    }
    $conn->close();
} else {
    echo "No email provided!";
}
?>
