<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $model = $_POST['model'];
    $type = $_POST['type'];

    // Prepare the SQL DELETE statement
    $sql = "DELETE FROM cars WHERE name = ? AND model = ? AND type = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $model, $type);
    if ($stmt->execute()) {
        // Redirect to main.php with a success parameter
        header("Location: main.php?delete_success=1");
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
