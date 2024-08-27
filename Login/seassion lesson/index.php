<?php include 'connection.php';?>
<?php


if (isset($_POST['submit'])) {
    $users = $_POST['user'];
    $passs = $_POST['pass'];
    $sql = "SELECT * FROM `users` WHERE `Username` = ? AND `Password` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $users, $passs);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    session_regenerate_id();
    $_SESSION['username'] = $row['Username'];
    session_write_close();

    if ($row['Status'] == 0) {
        $query = "UPDATE `users` SET `Status` = '1' WHERE `Username` = '$users'";
        $stmts = $conn->prepare($query);
        $stmts->execute();
        header("Location: Dashboard.php");
        exit;
    } else {
        echo '<script>alert("Account is already logged in")</script>';
    }
}
?>
