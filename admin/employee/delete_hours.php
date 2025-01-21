<?php

$conn = new mysqli("localhost", "root", "", "the_coffee_house");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM employee_work_hours WHERE id = ?");
    $stmt->bind_param("i", $id);

  
    if ($stmt->execute()) {
       
        header("Location: theodoi.php");
        exit(); 
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
