<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Redirect to the reset password page
        header("Location: reset_password.php?email=$email");
        exit();
    } else {
      

      echo "<script>alert('No user found with this email! " . $conn->error . "'); window.location.href='forgot_password.php';</script>";
        
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="fstyle.css">
   
</head>
<body>
<div class="container">
    <h2>Forgot Password</h2>
    <form method="post">
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        <section>
  <div class="no-account-text"><a class="register-link" href="register.php">No Account Yet?</a></div> 
  <div class="forgot-password"><a class="forgot-password-link" href="forgot_password.php">Forgot Password?</a></div>
</section>
        <input type="submit"    class="login-btn" value="Continue" >
    </form>

    </div>
</body>
</html>
