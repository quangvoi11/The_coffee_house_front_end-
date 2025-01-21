<?php
// Kết nối đến cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "the_coffee_house");
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Lấy employee_id từ tham số truyền vào
$employee_id = isset($_GET['employee_id']) ? $_GET['employee_id'] : '';

if ($employee_id != '') {
    // Bắt đầu một transaction
    $conn->begin_transaction();

    try {
        // Xóa các bản ghi liên quan từ bảng employee_evaluations
        $delete_evaluations_sql = $conn->prepare("DELETE FROM employee_evaluations WHERE employee_id = ?");
        $delete_evaluations_sql->bind_param("i", $employee_id);
        $delete_evaluations_sql->execute();

        // Xóa các bản ghi liên quan từ bảng employee_work_hours
        $delete_work_hours_sql = $conn->prepare("DELETE FROM employee_work_hours WHERE employee_id = ?");
        $delete_work_hours_sql->bind_param("i", $employee_id);
        $delete_work_hours_sql->execute();

        // Xóa các bản ghi liên quan từ bảng employee_salary
        $delete_salary_sql = $conn->prepare("DELETE FROM employee_salary WHERE employee_id = ?");
        $delete_salary_sql->bind_param("i", $employee_id);
        $delete_salary_sql->execute();

        // Xóa nhân viên từ bảng employees
        $delete_employee_sql = $conn->prepare("DELETE FROM employees WHERE employee_id = ?");
        $delete_employee_sql->bind_param("i", $employee_id);
        $delete_employee_sql->execute();

        // Commit transaction
        $conn->commit();

        // Xóa thành công, chuyển hướng về trang danh sách nhân viên
        header("Location: manage_employees.php");
        exit();
    } catch (Exception $e) {
        // Rollback transaction nếu có lỗi
        $conn->rollback();
        echo "Lỗi: " . $e->getMessage();
    } finally {
        // Đóng các prepared statements
        $delete_evaluations_sql->close();
        $delete_work_hours_sql->close();
        $delete_salary_sql->close();
        $delete_employee_sql->close();
    }
} else {
    echo "Không tìm thấy mã nhân viên để xóa";
}

// Đóng kết nối
$conn->close();
?>
