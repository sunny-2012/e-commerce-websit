<?php 
// Include database connection file
include 'connect.php';

if (isset($_POST['signUp'])) 
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Prepare the statement to prevent SQL injection
    $checkEmail = $conn->prepare("SELECT * FROM users WHERE email=?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "Email already exists!";
    } else {
        // Insert new user
        $insertQuery = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $insertQuery->bind_param("sss", $username, $email, $hashed_password);
        
        if ($insertQuery->execute()) {
            header("Location: login.html"); // Redirect to login page
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }

if (isset($_POST['signIn'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Prepare the statement to prevent SQL injection
    $sql = $conn->prepare("SELECT * FROM users WHERE email=?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['email'] = $row['email'];
            header("Location: homepage.php"); // Redirect to homepage
            exit();
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "No account found with this email!";
    }
}
?>
