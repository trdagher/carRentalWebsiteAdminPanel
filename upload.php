<?php
session_start();
include 'db.php';

// Retrieve form inputs
$name = $_POST['name'];
$model = $_POST['model'];
$type = $_POST['type'];
$numOfSeats = $_POST['numOfSeats'];
$bagageSpace = $_POST['bagageSpace'];
$transmission = $_POST['transmission'];
$price = $_POST['price'];
$stars = $_POST['stars'];
$specs = $_POST['specs'];
$image = $_FILES['image']['tmp_name'];
$imageData = file_get_contents($image);

if (isset($_POST['submit'])) {
    // Prepare an SQL statement to insert data into the newData table
    $stmt = $conn->prepare("INSERT INTO newData (name, model, type, numOfSeats, bagageSpace, transmission, price, stars, specs, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssissdsss", $name, $model, $type, $numOfSeats, $bagageSpace, $transmission, $price, $stars, $specs, $imageData);

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: main.php?upload_success=1");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
