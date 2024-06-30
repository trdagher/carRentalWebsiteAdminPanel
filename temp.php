<?php
include 'db.php';

$email = "tonyrenedagher@gmail.com";
$password = "tony333123";

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO admin (email, password) VALUES ('$email', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo "New user registered successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
