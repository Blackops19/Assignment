<?php include 'connection.php';


if (!isset($_SESSION['username'])) {
    echo '<script>alert("Please Login First"); window.location.href = "index.php";</script>';
    exit;
}

if (isset($_POST['submit'])) {
    $rowsu = $_POST['id'];
    $query = "UPDATE `users` SET `Status` = '0' WHERE `Username` = '$rowsu'";
    $stmts = $conn->prepare($query);
    $stmts->execute();
    header("Location: logout.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logout</title>
</head>
<body>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $_SESSION['username']; ?>">
        <button type="submit" name="submit">LOGOUT</button>
    </form>
</body>
</html>