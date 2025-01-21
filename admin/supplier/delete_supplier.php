<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header('Location: ../../login.php');
    exit();
}

// Kiểm tra vai trò của người dùng
if ($_SESSION['role'] == 'customer') {
    // Nếu không phải admin, chuyển hướng đến trang không phù hợp
    header('Location: ../../account.php'); // Hoặc trang khác tùy ý
    exit();
}
?>
<?php
// Kết nối tới cơ sở dữ liệu
include "includes_Supplier/db.php";

// Lấy giá trị của ID nhà cung cấp từ URL
$supplierId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Kiểm tra nếu ID hợp lệ
if ($supplierId > 0) {
    // Xóa nhà cung cấp từ cơ sở dữ liệu
    $query = "DELETE FROM Suppliers WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $supplierId);
        if ($stmt->execute()) {
            echo "<p>Supplier deleted successfully.</p>";
        } else {
            echo "<p>Error deleting supplier.</p>";
        }
        $stmt->close();
    }
} else {
    echo "<p>Invalid supplier ID.</p>";
}

// Đóng kết nối
mysqli_close($conn);

// Chuyển hướng về trang quản lý nhà cung cấp
header("Location: manage_suppliers.php");
exit;
?>