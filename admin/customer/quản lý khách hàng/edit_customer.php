<?php
$customer_id = $_GET["id"];
$name = "";
$email = "";
$address = "";
$phone = "";
$created_at = "";
$updated_at = "";

$conn = mysqli_connect("localhost", "root", "", "the_coffee_house");

if (!$conn) {
    echo "Kết nối không thành công: " . mysqli_connect_error();
} else {
    $query = "SELECT * FROM customers WHERE customer_id = '" . $customer_id . "'";

    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['name'];
            $email = $row['email'];
            $address = $row['address'];
            $phone = $row['phone'];
            $created_at = $row['created_at'];
            $updated_at = $row['updated_at'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<style>
    .main-content {
        display: flex;
        justify-content: center; /* Căn giữa theo chiều ngang */
        align-items: center; /* Căn giữa theo chiều dọc */
        min-height: 80vh; /* Đảm bảo bảng nằm ở giữa trang */
    }
    .table-container {
        max-width: 800px;
        width: 100%;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Đổ bóng cho bảng */
        border-radius: 8px; /* Bo tròn các góc */
        background-color: #fff; /* Màu nền */
    } 
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    
    table, th, td {
        border: 1px solid black;
    }
    
    th, td {
        padding: 10px;
        text-align: left;
    }
    
    th {
        background-color: #f2f2f2;
    }
    
    form {
        margin-top: 20px;
    }

    .success-message {
        background-color: #dff0d8;
        color: #3c763d;
        border: 1px solid #d6e9c6;
        padding: 10px;
        margin-top: 10px;
        border-radius: 4px;
        text-align: center;
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
        <div class="main-content">
            <h1 align="center">CHỈNH SỬA KHÁCH HÀNG</h1>
            <div class="table-container">
                <form method="POST">
                    <table>
                        <tbody>
                            <tr>
                                <td>Tên khách hàng:</td>
                                <td>
                                    <input type="text" name="txtname" value="<?php echo $name ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td>
                                    <input type="email" name="txtemail" value="<?php echo $email ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>Địa chỉ:</td>
                                <td>
                                    <input type="text" name="txtaddress" value="<?php echo $address ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>Số điện thoại:</td>
                                <td>
                                    <input type="text" name="txtphone" pattern="[0-9]{10}" title="Số điện thoại phải có đúng 10 chữ số" value="<?php echo htmlspecialchars($phone); ?>">
                                </td>
                            </tr>
                            
                            <tr>
                                <td></td>
                                <td>
                                    <input type="submit" name="txtSave" value="Ghi dữ liệu">
                                    <a href="index.php">Quay lại</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $customer_id = $_GET['id'];
                $name = $_POST['txtname'];
                $email = $_POST['txtemail'];
                $address = $_POST['txtaddress'];
                $phone = $_POST['txtphone'];
                $created_at = $_POST['txtcreated_at'];
                $updated_at = $_POST['txtupdated_at'];

                // Kiểm tra điều kiện số điện thoại và email
                if (empty($name) || empty($email) || empty($address) || empty($phone) || empty($created_at) || empty($updated_at)) {
                    echo 'Vui lòng nhập đầy đủ thông tin';
                } elseif (!preg_match('/^\d{10}$/', $phone)) {
                    echo 'Số điện thoại phải có đúng 10 chữ số';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@gmail.com$/', $email)) {
                    echo 'Email không hợp lệ. Yêu cầu sử dụng email có định dạng @gmail.com';
                } else {
                    $conn = mysqli_connect("localhost", "root", "", "the_coffee_house");

                    if (!$conn) {
                        echo "Kết nối không thành công: " . mysqli_connect_error();
                    } else {
                        $query = "UPDATE customers SET name='" . $name . "', email='" . $email . "', address='" . $address . "', phone='" . $phone . "', created_at='" . $created_at . "', updated_at='" . $updated_at . "' WHERE customer_id='" . $customer_id . "'";

                        $result = mysqli_query($conn, $query);
                        if ($result) {
                            echo '<div class="success-message">Dữ liệu đã được cập nhật thành công!</div>';
                        } else {
                            echo 'Thay đổi dữ liệu thất bại';
                        }
                    }
                }
            }
            ?>
        </div>
    </div>
</body>

</html>
