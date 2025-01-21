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
include "includes_Category/db.php";

if (isset($_GET['id'])) {
    $categoryID = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "DELETE FROM categories WHERE CategoryID = $categoryID";
    if (mysqli_query($conn, $query)) {
        echo "<p>Category deleted successfully!</p>";
    } else {
        echo "<p>Error: " . mysqli_error($conn) . "</p>";
    }
}

// Chuyển hướng trở lại trang quản lý danh mục
header("Location: manage_categories.php");
exit();
?>