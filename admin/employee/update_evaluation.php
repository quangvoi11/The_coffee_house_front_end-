<?php
// Kiểm tra nếu dữ liệu được gửi từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối tới cơ sở dữ liệu
    $conn = new mysqli("localhost", "root", "", "the_coffee_house");
    
    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối không thành công: " . $conn->connect_error);
    }

    // Lấy và xử lý dữ liệu từ form
    $id = $_POST['id'];
    $performance_score = $_POST['performance_score'];
    $feedback = $_POST['feedback'];

    // Chuẩn bị câu lệnh SQL để cập nhật đánh giá hiệu suất
    $sql = "UPDATE employee_evaluations SET performance_score = '$performance_score', feedback = '$feedback' WHERE id = $id";

    // Thực thi câu lệnh SQL
    if ($conn->query($sql) === TRUE) {
        // Chuyển hướng người dùng về trang danhgia.php sau khi cập nhật thành công
        header("Location: danhgia.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }

    // Đóng kết nối
    $conn->close();
}
?>
