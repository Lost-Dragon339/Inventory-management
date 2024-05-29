<?php
$conn = new mysqli("localhost", "root", "harsh@123", "logins");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);


$sql = "INSERT INTO users (username, password,role) VALUES ('$username', '$password','administrator')";

if ($conn->query($sql) === TRUE) {
    echo "Registration successful!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
header("Location: login.html"); 
$conn->close();
?>
