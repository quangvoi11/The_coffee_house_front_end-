<?php
$customer_id = $_GET["id"];

// Kiểm tra kết nối đến CSDL
$conn = mysqli_connect("localhost", "root", "", "the_coffee_house");
if (!$conn) {
    echo "Kết nối không thành công" . mysqli_connect_error();
} else {
    // Truy vấn để lấy thông tin của khách hàng cần chỉnh sửa
    $query = "SELECT * FROM customers WHERE customer_id = '$customer_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)){
            $name = $row['name'];
            $note = $row['note'];
            $created_at = $row['created_at'];
            $updated_at = $row['updated_at'];
        }
        

        // Form chỉnh sửa ghi chú của khách hàng
        echo '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Chỉnh sửa ghi chú</title>
                    <link rel="stylesheet" type="text/css" href="styles.css">
                    <style>
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        table, th, td {
                            border: 1px solid black;
                        }
                        th, td {
                            padding: 10px;
                            text-align: left;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="sidebar">
                            <h3>Customer Management</h3>
                            <a href="../quản lý khách hàng/index.php">Customer Information Management</a>
                            <a href="../khách hàng hội viên/manage_customers.php">Member Customers</a>
                            <a href="../acb/manage_customers.php">Customer </a>
                        </div>
                        <div class="main-content">
                            <h1>Chỉnh sửa ghi chú của khách hàng</h1>
                            <form method="POST">
                                <input type="hidden" name="txtid" value="' . $customer_id . '">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>Tên khách hàng:</td>
                                            <td>' . $name . '</td>
                                        </tr>
                                        <tr>
                                            <td>Ghi chú:</td>
                                            <td><textarea name="txtnote" rows="4" cols="50">' . $note . '</textarea></td>
                                        </tr>
                                        

                                        <tr>
                                            <td></td>
                                            <td>
                                                <input type="submit" name="txtSave" value="Lưu ghi chú">
                                                <a href="manage_customers.php">Quay lại</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </body>
                </html>';
    } else {
        echo "Không tìm thấy khách hàng.";
    }
}
?>

<?php
// Xử lý khi người dùng lưu ghi chú mới
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $customer_id = $_POST['txtid'];
    $note = $_POST['txtnote'];

    // Kiểm tra và cập nhật vào CSDL
    $conn = mysqli_connect("localhost", "root", "", "the_coffee_house");
    if (!$conn) {
        echo "Kết nối không thành công" . mysqli_connect_error();
    } else {
        $query = "UPDATE customers SET note = '$note' WHERE customer_id = '$customer_id'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo 'Cập nhật ghi chú thành công.';
        } else {
            echo 'Lỗi khi cập nhật ghi chú.';
        }
    }
}
?>
