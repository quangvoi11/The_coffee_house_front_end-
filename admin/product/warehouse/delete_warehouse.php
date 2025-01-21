<?php
// Kết nối cơ sở dữ liệu
$conn = mysqli_connect("localhost", "root", "", "the_coffee_house");
if (!$conn) {
    die("Kết nối không thành công: " . mysqli_connect_error());
}

// Kiểm tra nếu có tham số id trong URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Xóa mục khỏi bảng expiry_inventory
    $query = "DELETE FROM warehouses WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        echo "Xóa thành công.";
    } else {
        echo "Lỗi khi xóa: " . mysqli_error($conn);
    }

    // Chuyển hướng về trang quản lý
    header("Location: viewWarehouse.php");
    exit();
} else {
    echo "Không có ID hợp lệ.";
}

// Đóng kết nối cơ sở dữ liệu
mysqli_close($conn);
?>