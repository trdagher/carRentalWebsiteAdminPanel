<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM admin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password is correct, start a new session
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $user['email'];
            header("Location: main.php");
        } else {
            echo "Invalid password.";
            echo $password;
        }
    } else {
        echo "No user found with that email address.";
    }

    $stmt->close();
}

$conn->close();
