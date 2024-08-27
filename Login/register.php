<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $middle_name = isset($_POST['no_middle_name']) ? 'N/A' : $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $target_dir = "upload/";
    $photo = $target_dir . basename($_FILES["photo"]["name"]);
    move_uploaded_file($_FILES["photo"]["tmp_name"], $photo);

    $sql = "INSERT INTO users (name, middle_name, last_name, age, gender, birthday, contact_number, address, photo, email, password, login_attempts) 
            VALUES ('$name', '$middle_name', '$last_name', '$age', '$gender', '$birthday', '$contact_number', '$address', '$photo', '$email', '$password', 0)";

    if ($conn->query($sql) === TRUE) {
        // Automatically log the user in and redirect to the dashboard
        $user_id = $conn->insert_id;
        session_start();
        $_SESSION['user_id'] = $user_id;
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
  <link rel="stylesheet" href="rstyle.css">
   

</head>
<body>

    <div class="container">
    <h2>Reset Password</h2>
    <form method="post" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" required><br>
        
        <label>Middle Name:</label>
        <input type="text" name="middle_name"><br>
      <section class="mname" >
        <input type="checkbox" id="no-middle-name" class="no-middle-name">
        <label for="no-middle-name" class="no-middle-name-label">I don't have a Middle Name</label>
        </section>
        <label>Last Name:</label>
        <input type="text" name="last_name" required><br>
        
        <label>Age:</label>
        <input type="number" name="age" required><br>
        
      
        
        <label>Contact Number:</label>
        <input type="text" name="contact_number" id="contact_number" required
               pattern="\d{11}" maxlength="11" inputmode="numeric"
               oninput="this.value = this.value.replace(/[^0-9]/g, '')"><br>


        <label>Address:</label>
        <textarea name="address" required></textarea><br>
        
        <label>Photo:</label>
        <input type="file" name="photo" class="photo" required><br>
        
        <label>Email:</label>
        <input type="email" name="email" required><br>
        
        <label class="form-label">Password:</label>
<input type="password" name="password" class="form-input" required><br><br>

<label class="form-label">Gender:</label> 
<section class="gname">


<div class="g2name">
    <div class="g1">
<input type="radio" name="gender" value="Male" class="form-radio" required> Male
</div>
<div class="g1">
<input type="radio" name="gender" value="Female" class="form-radio" required> Female
</div>
<div class="g1">
<input type="radio" name="gender" value="Other" class="form-radio" required> Other
</div>
</div>

</section>
        
        <label>Birthday:</label>
        <div class="bname">
        <input type="date" class="b1" name="birthday" required><br>
        </div>
        <input type="submit" value="Register" class="REG">
    </form>
   <section class="no-account-text"><br><br><br><br><br>
    <a href="login.php" class="login-link"> Already have an account?</a>
    </section>
    </div>
   


    <script>
    function toggleMiddleNameField() {
        const middleNameField = document.querySelector('input[name="middle_name"]');
        const noMiddleNameCheckbox = document.querySelector('input[name="no_middle_name"]');

        if (noMiddleNameCheckbox.checked) {
            middleNameField.value = 'N/A';
            middleNameField.disabled = true;
            middleNameField.classList.add('valid');  // Add valid class for the green outline
            middleNameField.classList.remove('invalid');
        } else {
            middleNameField.value = '';
            middleNameField.disabled = false;
            middleNameField.classList.remove('valid');
            middleNameField.classList.remove('invalid');
        }
        validateForm();
    }

    function validateForm() {
        const formElements = document.querySelectorAll('input, textarea');
        let isFormComplete = true;

        formElements.forEach(element => {
            if (element.required && !element.disabled) {
                if (element.value.trim() === '') {
                    element.classList.remove('valid');
                    element.classList.add('invalid');
                    isFormComplete = false;
                } else {
                    element.classList.remove('invalid');
                    element.classList.add('valid');
                }
            } else if (element.disabled && element.value.trim() === 'N/A') {
                element.classList.remove('invalid');
                element.classList.add('valid');
            }
        });

        // Ensure the submit button has the correct state
        document.querySelector('input[type="submit"]').disabled = !isFormComplete;
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Initial form validation
        validateForm();

        // Add event listener for input changes
        document.querySelectorAll('input, textarea').forEach(input => {
            input.addEventListener('input', validateForm);
        });

        // Add event listener for checkbox change
        document.querySelector('input[name="no_middle_name"]').addEventListener('change', toggleMiddleNameField);
    });
</script>

</body>
</html>
