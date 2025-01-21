<?php
        $customer_id = $_GET["id"];
        $name = "";
        $note = "";
        $created_at = "";
        $updated_at = "";
    $conn = mysqli_connect("localhost", "root", "", "the_coffee_house");

        if (!$conn) {
            echo "Ket noi khong thanh cong" . mysqli_connect_error();
        } else {
        $query = "SELECT * FROM customers WHERE customer_id = ' . $customer_id . '";

        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0 ) {
            while ($row = mysqli_fetch_assoc($result)){
            $name = $row['name'];
            $note = $row['note'];
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
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Chỉnh sửa</title>
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
                    <td>
                        <input type="text" name="txtname" value="<?php echo $name?>">
                    </td>
                </tr>
                <tr>
                    <td>Ghi chú:</td>
                    <td>
                        <textarea name="txtnote"><?php echo $note ?></textarea>
                    </td>

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
    $note = $_POST['txtnote'];
    $created_at = $_POST['txtcreated_at'];
    $updated_at = $_POST['txtupdated_at'];
    if (empty($name) || empty($note) || empty($created_at) || empty($updated_at)) {
        echo 'Vui lòng nhập đầy đủ thông tin';
    } else {
            $query = "UPDATE customers SET  name='$name', note ='$note', created_at='$created_at', updated_at='$updated_at' WHERE customer_id= '$customer_id'";

            $result = mysqli_query($conn, $query);
            if ($result) {
                echo 'Cập nhật dữ liệu thành công';
            } else {
                echo 'Thay đổi dữ liệu thất bại';
            }
        }
    }
?>