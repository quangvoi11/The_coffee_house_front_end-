<?php
// Kết nối đến cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "the_coffee_house");
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Lấy id từ tham số truyền vào
$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id != '') {
    // Bắt đầu một transaction
    $conn->begin_transaction();

    try {
        // Xóa các bản ghi liên quan từ bảng storage
        $delete_storage_sql = $conn->prepare("DELETE FROM material WHERE warehouse_id = ?");
        $delete_storage_sql->bind_param("i", $id);
        $delete_storage_sql->execute();

        

        // Xóa kho từ bảng warehouses
        $delete_warehouse_sql = $conn->prepare("DELETE FROM warehouses WHERE id = ?");
        $delete_warehouse_sql->bind_param("i", $id);
        $delete_warehouse_sql->execute();

        // Commit transaction
        $conn->commit();

        // Xóa thành công, chuyển hướng về trang danh sách kho
        header("Location: viewWarehouse.php");
        exit();
    } catch (Exception $e) {
        // Rollback transaction nếu có lỗi
        $conn->rollback();
        echo "Lỗi: " . $e->getMessage();
    } finally {
        // Đóng các prepared statements
        $delete_storage_sql->close();
        $delete_expiry_inventory_sql->close();
        $delete_warehouse_sql->close();
    }
} else {
    echo "Không tìm thấy ID để xóa";
}

// Đóng kết nối
$conn->close();
?>
