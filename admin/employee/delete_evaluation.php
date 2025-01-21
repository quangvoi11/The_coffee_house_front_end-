<?php
// Kiểm tra nếu có yêu cầu GET từ URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Lấy id của đánh giá cần xóa từ URL
    $id = $_GET['id'];

    // Kết nối đến cơ sở dữ liệu
    $conn = new mysqli("localhost", "root", "", "the_coffee_house");

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối không thành công: " . $conn->connect_error);
    }

    // Chuẩn bị câu lệnh SQL để xóa đánh giá
    $sql = "DELETE FROM employee_evaluations WHERE id = $id";

    // Thực thi câu lệnh SQL
    if ($conn->query($sql) === TRUE) {
        // Đóng kết nối
        $conn->close();
        
        // Chuyển hướng về trang danhgia.php sau khi xóa thành công
        header("Location: danhgia.php");
        exit(); // Dừng thực thi script ngay sau khi chuyển hướng
    } else {
        echo "Lỗi khi xóa đánh giá: " . $conn->error;
    }

    // Đóng kết nối
    $conn->close();
} else {
    // Nếu không có id được truyền qua GET, hiển thị thông báo lỗi
    echo "Không tìm thấy đánh giá cần xóa.";
}
?>
