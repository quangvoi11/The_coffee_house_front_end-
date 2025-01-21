<?php
include 'db_connection.php';

// Giả sử người dùng đã đăng nhập với ID = 1
$user_id = 1;

// Truy vấn để lấy thông tin giỏ hàng của người dùng
$query = "SELECT ci.cart_item_id, p.Name, ci.quantity, ci.price 
          FROM cart_items ci 
          JOIN carts c ON ci.cart_id = c.cart_id 
          JOIN products p ON ci.product_id = p.id
          WHERE c.user_id = $user_id";

$result = mysqli_query($conn, $query);

$total_price = 0;
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
        .btn {
            background-color: #007bff;
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-warning {
            background-color: #ffc107;
        }
        .btn:hover {
            opacity: 0.8;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .button {
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
            <h2>Quản lý giỏ hàng</h2>
            <a href="manage.php">Trang chủ</a>
            <a href="view_cart.php">Giỏ hàng của bạn</a>
            <a href="checkout.php">Thanh toán</a>
            <a href="confirm.php">Xác nhận</a>
            <a href="hienthihoadon.php">Xem lịch sử hóa đơn</a>
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
                    if ($result->num_rows > 0) {
                        $stt = 1;
                        while($row = $result->fetch_assoc()) {
                            $subtotal = $row['quantity'] * $row['price'];
                            $total_price += $subtotal;
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
            <form action="confirm.php" method="post">
                <div class="form-group">
                    <label for="name">Họ và tên</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="membership">Hội viên</label><br>
                    <input type="checkbox" id="membership" name="membership" value="1"> Đăng ký làm hội viên
                </div>
                <button type="submit" class="btn btn-primary" name="btn">Xác nhận thanh toán</button>
            </form>
            <a href="view_cart.php" class="btn btn-warning mt-2"><i class="fa fa-arrow-left"></i> Quay về giỏ hàng</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
