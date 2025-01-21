<?php
// Kiểm tra nếu không có id được truyền qua GET
if (!isset($_GET['id'])) {
    header('Location: admin_dashboard.php'); // Chuyển hướng về trang quản lý nếu không có id
    exit();
}

$id = $_GET['id'];

include "includes_User/db.php";

// Xóa người dùng từ cơ sở dữ liệu dựa trên id
$sql = "DELETE FROM users WHERE user_id = $id";

if ($conn->query($sql) === TRUE) {
    echo "User deleted successfully";
} else {
    echo "Error deleting user: " . $conn->error;
}

// Đóng kết nối
$conn->close();

header("location:viewUser.php");
?>