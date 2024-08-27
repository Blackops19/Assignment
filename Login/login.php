<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password == $row['password']) { // Simplified password check
            $_SESSION['user_id'] = $row['id'];
            header("Location: dashboard.php");
            exit();
        } else {
              echo "<script>alert('Invalid email or password! " . $conn->error . "'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid email or password! " . $conn->error . "'); window.location.href='login.php';</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    
<link rel="stylesheet" href="lstyle.css">

 
</head>
<body>

<header>
      
      <img src="Sfinal.png" alt="">
    
      </header>
  <div class="container">

    <form method="POST" action="login.php">

<input type="email" name="email" required placeholder="Enter your email" class="input-field"><br>
<input type="password" name="password" required placeholder="Enter your password "class="input-field"><br><br>

 <!-- HTML Code -->
 <section>
  <div class="no-account-text"><a class="register-link" href="register.php">No Account Yet?</a></div> 
  <div class="forgot-password"><a class="forgot-password-link" href="forgot_password.php">Forgot Password?</a></div>
</section>
<button type="submit"   class="login-btn">Login</button><br><br>
      
    </form>


    </div>




     <!-- HTML Code -->


    <script>

    </script>

</body>
</html>