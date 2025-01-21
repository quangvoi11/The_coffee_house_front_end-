<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm khách hàng</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
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

</head>
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
                    <td>Email:</td>
                    <td>
                        <input type="text" name="txtemail">
                    </td>
                </tr>
                <tr>
                    <td>Địa chỉ:</td>
                    <td>
                        <input type="text" name="txtaddress">
                    </td>
                </tr>
                <tr>
                    <td>Số điện thoại:</td>
                    <td>
                        <input type="text" name="txtphone">
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
                    <td>Cấp hội viên:</td>
                    <td>
                        <select name="txtlevel">
                            <option value="regular" selected>Regular</option>
                            <option value="vip">VIP</option>
                            <option value="care">Care</option>
                        </select>
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
        $customer_id = $_POST['txtid'];
        $name = $_POST['txtname'];
        $email = $_POST['txtemail'];
        $address = $_POST['txtaddress'];
        $phone = $_POST['txtphone'];
        $created_at = $_POST['txtcreated_at'];
        $updated_at = $_POST['txtupdated_at'];
        $level = $_POST['txtlevel'];
        if (empty($customer_id) || empty($name) || empty($email) || empty($address) || empty($phone) || empty($created_at) || empty($updated_at) || empty($level)) {
            echo 'Vui lòng nhập đầy đủ thông tin';
        } else {
            $conn = mysqli_connect("localhost", "root", "", "the_coffee_house");
    
            if (!$conn) {
                echo "Ket noi khong thanh cong" . mysqli_connect_error();
            } else {
                $query = "INSERT INTO customers (customer_id, name, email, address, phone, created_at, updated_at, level) 
                          VALUES ('$customer_id', '$name', '$email', '$address', '$phone', '$created_at', '$updated_at', '$level')";
    
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