<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
</head>
<body>
    <h1>Welcome, you are logged in!</h1>
    <p>Your email: <?php echo $_SESSION['email']; ?></p>
    <a href="logout.php">Logout</a>
</body>
</html>
