<?php
include 'db_connection.php';

// Giả sử người dùng đã đăng nhập với ID = 1
$user_id = 1;

$total_price = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    
    // Lưu thông tin khách hàng vào bảng customers
    $sql = "INSERT INTO customers (name, email, address, phone) VALUES ('$name', '$email', '$address', '$phone') ON DUPLICATE KEY UPDATE name='$name', address='$address', phone='$phone'";
    $result = mysqli_query($conn, $sql);

    // Lấy thông tin giỏ hàng của người dùng trước khi xóa
    $query = "SELECT ci.cart_item_id, p.Name, ci.quantity, ci.price 
              FROM cart_items ci 
              JOIN carts c ON ci.cart_id = c.cart_id 
              JOIN products p ON ci.product_id = p.id
              WHERE c.user_id = $user_id";
    $cart_items = mysqli_query($conn, $query);

    // Tính tổng tiền
    if ($cart_items->num_rows > 0) {
        while ($row = $cart_items->fetch_assoc()) {
            $subtotal = $row['quantity'] * $row['price'];
            $total_price += $subtotal;
        }
    }

    // Chèn thông tin hóa đơn vào bảng doanhthugiohang
    $invoice_sql = "INSERT INTO doanhthugiohang (date_time, total_amount, customer_name) VALUES (NOW(), $total_price, '$name')";
    $invoice_result = mysqli_query($conn, $invoice_sql);

    // Xóa các mục trong giỏ hàng của người dùng
    $conn->query("DELETE ci FROM cart_items ci JOIN carts c ON ci.cart_id = c.cart_id WHERE c.user_id = $user_id");

    // Xác định mức hội viên dựa trên tổng tiền đã chi tiêu
    $membership_level = "Regular"; // Mặc định là Regular
    if ($total_price >= 1000000 && $total_price < 2000000) {
        $membership_level = "Care";
    } elseif ($total_price >= 2000000) {
        $membership_level = "VIP";
    }

    // Cập nhật mức hội viên cho khách hàng
    $update_membership_query = "UPDATE customers SET level = '$membership_level' WHERE email = '$email'";
    if (mysqli_query($conn, $update_membership_query)) {
        echo "<script>alert('Thanh toán thành công và cập nhật mức hội viên!');</script>";
    } else {
        echo "<script>alert('Thanh toán thành công nhưng không thể cập nhật mức hội viên!');</script>";
    }
} else {
    echo "<script>alert('Yêu cầu không hợp lệ'); window.location.href='checkout.php';</script>";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoá đơn thanh toán</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: bisque;
            padding: 20px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        h3 {
            text-align: center;
        }
        .btn-cart {
            background-color: #28a745;
            color: yellow;
            padding: 10px 20px;
            border-radius: 4px;
            text-align: center;
            display: block;
            margin: 20px auto;
            text-decoration: none; 
        }
        .sidebar {
            width: 250px;
            background-color: burlywood;
            color: white;
            height: 100vh;
            position: sticky;
            top: 0;
            margin: 0px;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.8em;
            padding: 10px;
            color: #ecf0f1;
            background-color: #34495e;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            color: white;
            display: block;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #34495e;
        }
        .container_box {
            display: flex;
        }
        .sidebar {
            border-radius: 5px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container_box">
        <div class="sidebar">
            <h2>Manage your Cart</h2>
            <a href="manage.php">Home</a>
            <a href="view_cart.php">Your Cart</a>
            <a href="checkout.php">Check out</a>
            <a href="confirm.php">Payment</a>
            <a href="hienthihoadon.php">View History Bill</a>
        </div>
        <div class="container">
            <h1>Hoá đơn thanh toán</h1>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($cart_items->num_rows > 0) {
                        $stt = 1;
                        // Đặt lại con trỏ của kết quả
                        mysqli_data_seek($cart_items, 0);
                        while ($row = $cart_items->fetch_assoc()) {
                            $subtotal = $row['quantity'] * $row['price'];
                            echo "<tr>";
                            echo "<td>" . $stt . "</td>";
                            echo "<td>" . $row['Name'] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td>" . number_format($row['price'], 2) . " VND</td>";
                            echo "<td>" . number_format($subtotal, 2) . " VND</td>"; 
                            echo "</tr>";
                            $stt++;
                        }
                    } else {
                        echo "<tr><td colspan='5' style='text-align: center;'>Không có sản phẩm trong giỏ hàng</td></tr>";
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Tổng tiền:</strong></td>
                        <td><strong><?php echo number_format($total_price, 2); ?> VND</strong></td>
                    </tr>
                </tfoot>
            </table>    
            <h2>Thông tin khách hàng</h2>
            <?php
            echo "<p><strong>Họ và tên:</strong> $name</p>";
            echo "<p><strong>Email:</strong> $email</p>";
            echo "<p><strong>Địa chỉ:</strong> $address</p>";
            echo "<p><strong>Số điện thoại:</strong> $phone</p>";
            ?>
            <h3>Cảm ơn quý khách đã đặt hàng tại cửa hàng chúng tôi!!</h3>
            <a href="manage.php" class="btn-cart">Quay trở lại shopping!</a>
        </div>
    </div>
</body>
</html>
