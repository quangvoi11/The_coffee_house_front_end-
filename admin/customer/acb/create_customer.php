<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm khách hàng</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <style>
    table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    }

    table, th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
    }

    th {
    background-color: #f2f2f2;
    }

    </style> 
<body>
        <div class="container">
            <div class="sidebar">
                <h3>Customer Management</h3>
                <a href="../quản lý khách hàng/index.php">Customer Information Management</a>
                <a href="../khách hàng hội viên/manage_customers.php">Member Customers</a>
                <a href="../acb/manage_customers.php">Customer </a>
            </div>
        
<!-- <form action="add_customer.php" method="POST"> -->
    <form method="POST">
        <table>
            <tbody>
                <tr>
                    <td>Tên khách hàng:</td>
                    <td>
                        <input type="text" name="txtname">
                    </td>
                </tr>
                <tr>
                    <td>Ghi chú:</td>
                    <td>
                        <input type="text" name="txtnote">
                    </td>
                </tr>
                <tr>
                    <td>Tạo ngày:</td>
                    <td>
                        <input type="datetime-local" name="txtcreated_at" value="<?php echo date('Y-m-d\TH:i', strtotime($created_at)); ?>">
                    </td>
                </tr>
                <tr>
                    <td>Cập nhật ngày:</td>
                    <td>
                        <input type="datetime-local" name="txtupdated_at" value="<?php echo date('Y-m-d\TH:i', strtotime($updated_at)); ?>">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" name="txtSave" value="Ghi dữ liệu">
                        <a href="manage_customers.php">Quay lại</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    </div>
    <?php
    
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $name = $_POST['txtname'];
        $note = $_POST['txtnote'];
        $created_at = $_POST['txtcreated_at'];
        $updated_at = $_POST['txtupdated_at'];
        if (empty($name) || empty($note) || empty($created_at) || empty($updated_at)) {
            echo 'Vui lòng nhập đầy đủ thông tin';
        } else {
            $conn = mysqli_connect("localhost", "root", "", "the_coffee_house");
    
            if (!$conn) {
                echo "Ket noi khong thanh cong" . mysqli_connect_error();
            } else {
                $query = "INSERT INTO customers (name, note, created_at, updated_at) 
                          VALUES ('$name', '$note', '$created_at', '$updated_at')";
    
                $result = mysqli_query($conn, $query);
                if ($result) {
                    echo 'Ghi dữ liệu thành công';
                } else {
                    echo 'Lỗi không ghi được dữ liệu';
                }
            }
            mysqli_close($conn);
        }
    }
    ?>
</body>
</html>