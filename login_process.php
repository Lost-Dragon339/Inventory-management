<?php
session_start();

$conn = new mysqli("localhost", "root", "harsh@123", "logins");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT id, password FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        echo "Login successful!";
        $_SESSION['user_id'] = $row['id'];
        header("Location: main.php"); // Redirect to the main page after successful login
    } else {
        echo "Incorrect password.";
        header("Location: login.html");
    }
} else {
    echo "User not found.";
}

$conn->close();
?>
