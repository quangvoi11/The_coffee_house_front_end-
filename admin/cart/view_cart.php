<?php
include('db_connection.php');

$user_id = 1; // Giả sử người dùng đã đăng nhập với ID = 1

$result = $conn->query("SELECT ci.cart_item_id, p.Name, ci.quantity, ci.price 
                        FROM cart_items ci 
                        JOIN carts c ON ci.cart_id = c.cart_id 
                        JOIN products p ON ci.product_id = p.id
                        WHERE c.user_id = $user_id");
$total_price = 0;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng của bạn</title>
    <link
			rel="stylesheet"
			href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/fo...in.css"
		/>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: bisque;
            padding: 30px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
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
            text-align: center;
        }
        .btn {
            background-color: #007bff;
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-success {
            background-color: #28a745;
        }
        .btn-primary {
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
        }
        .btn:hover {
            opacity: 0.8;
        }
        .text-right {
            text-align: right;
            margin-top: 20px;
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
        a {
            text-decoration: none;
            color: inherit; /* Sử dụng màu chữ mặc định của thẻ a */
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
        .container_box{
            display: flex;
        }
        .sidebar{
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
       <a href="hienthihoadon.php">ViewhistoryBill</a> 
    </div>
    <div class="container" >
        <h1>Giỏ hàng của bạn</h1>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th colspan="2">Hành động</th>
                </tr>
            </thead>
            
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $stt = 1;
                    while($row = $result->fetch_assoc()) {
                        $total_price += $row['quantity'] * $row['price'];
                        echo "<tr>";
                        echo "<td>" . $stt . "</td>";
                        echo "<td>" . $row['Name'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . $row['price'] . "</td>";
                        echo "<td>";
                        echo "<button class='btn btn-danger' onclick='removeFromCart(" . $row['cart_item_id'] . ")'>Xóa</button>";
                        echo "</td>";
                        echo "<td>";
                        echo "<a href='editViewcart.php?this_id=" . $row['cart_item_id'] . "' class='btn btn-success'>Sửa</a>";
                        echo "</td>";
                        echo "</tr>";
                        $stt++;
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align: center;'>Giỏ hàng trống</td></tr>";
                }
                
                ?>
            </tbody>
        </table>
        <a href="manage.php" class="btn btn-cart">Quay trở lại shopping!</a>
        <div class="text-right">
            <h4>Tổng tiền: <span id="total-price"><?php echo number_format($total_price, 2); ?> VND</span></h4>
            <a href="checkout.php" class="btn btn-primary">Tiếp tục thanh toán</a>
        </div>
        </div>
   

    <script>
        function removeFromCart(cartItemId) {
            fetch('remove_from_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `cart_item_id=${cartItemId}`
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            });
        }
    </script>
     </div>
</body>
</html>

<?php $conn->close(); ?>
