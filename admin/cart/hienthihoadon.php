<?php
include 'db_connection.php';

$query = "SELECT * FROM doanhthugiohang";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách hóa đơn</title>
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
        }
        .text-right {
            text-align: right;
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
        <div class="container">
            <h1>Danh sách hóa đơn</h1>
            <table>
                <thead>
                    <tr>
                        <th>Mã hóa đơn</th>
                        <th>Ngày giờ</th>
                        <th>Tổng tiền</th>
                        <th>Họ tên khách hàng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['invoice_id'] . "</td>";
                            echo "<td>" . $row['date_time'] . "</td>";
                            echo "<td>" . number_format($row['total_amount'], 2) . " </td>";
                            echo "<td>" . $row['customer_name'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align: center;'>Không có hóa đơn nào</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <a href="manage.php" class="btn-cart">Quay trở lại trang chính</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
