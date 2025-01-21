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
include "includes_Product/db_product.php";

// Lấy ID của sản phẩm cần xóa từ tham số trên URL
$product_id = $_GET['id'];

// Xóa sản phẩm khỏi cơ sở dữ liệu
$query_delete = "DELETE FROM products WHERE id = $product_id";
$result_delete = mysqli_query($conn, $query_delete);

// Kiểm tra và thông báo kết quả
if ($result_delete) {
    echo "Product deleted successfully.";
} else {
    echo "Error deleting product: " . mysqli_error($conn);
}

// Đóng kết nối
mysqli_close($conn);

header("location:viewProduct.php");
?>