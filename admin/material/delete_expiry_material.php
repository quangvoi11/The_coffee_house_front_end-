<?php
$conn = mysqli_connect("localhost", "root", "", "the_coffee_house");
if (!$conn) {
    die("Kết nối không thành công: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM expiry_inventory WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location:manage_expiry_material.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>