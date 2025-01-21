<?php
$customer_id = $_GET["id"];
$name = "";
$email = "";
$address = "";
$phone = "";
$created_at = "";
$updated_at = "";
$level = "";
$conn = mysqli_connect("localhost", "root", "", "the_coffee_house");

if (!$conn) {
    echo "Kết nối không thành công: " . mysqli_connect_error();
} else {
    $query = "SELECT * FROM customers WHERE customer_id = '$customer_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $email = $row['email'];
        $address = $row['address'];
        $phone = $row['phone'];
        $created_at = $row['created_at'];
        $updated_at = $row['updated_at'];
        $level = $row['level'];
    } else {
        echo "Không tìm thấy khách hàng có ID là " . $customer_id;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa thông tin khách hàng</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
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
            <h1 align="center">CHỈNH SỬA KHÁCH HÀNG</h1>
        <div class="table-container">
        <form method="POST">
            <table>
                <tbody>
                    <tr>
                        <td>ID:</td>
                        <td>
                            <input type="text" name="txtid" value="<?php echo $customer_id ?>" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td>Tên khách hàng:</td>
                        <td><input type="text" name="txtname" value="<?php echo $name ?>"></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="text" name="txtemail" value="<?php echo $email ?>"></td>
                    </tr>
                    <tr>
                        <td>Địa chỉ:</td>
                        <td><input type="text" name="txtaddress" value="<?php echo $address ?>"></td>
                    </tr>
                    <tr>
                        <td>Số điện thoại:</td>
                        <td><input type="text" name="txtphone" value="<?php echo $phone ?>"></td>
                    </tr>
                    
                    <tr>
                        <td>Cấp hội viên:</td>
                        <td>
                            <select name="txtlevel">
                                <option value="vip" <?php if ($level == 'vip') echo 'selected' ?>>VIP</option>
                                <option value="regular" <?php if ($level == 'regular') echo 'selected' ?>>Regular</option>
                                <option value="care" <?php if ($level == 'care') echo 'selected' ?>>Care</option>
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
        </div>
    </div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['txtname'];
    $email = $_POST['txtemail'];
    $address = $_POST['txtaddress'];
    $phone = $_POST['txtphone'];
    $created_at = $_POST['txtcreated_at'];
    $updated_at = $_POST['txtupdated_at'];
    $level = $_POST['txtlevel'];

    if (empty($name) || empty($email) || empty($address) || empty($phone) || empty($created_at) || empty($updated_at) || empty($level)) {
        echo 'Vui lòng nhập đầy đủ thông tin';
    } else {
        $query = "UPDATE customers SET name='$name', email='$email', address='$address', phone='$phone', created_at='$created_at', updated_at='$updated_at', level='$level' WHERE customer_id='$customer_id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo 'Cập nhật dữ liệu thành công';
        } else {
            echo 'Thay đổi dữ liệu thất bại';
        }
    }
}
?>
