<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header('Location: ../../login.php');
    exit();
}

// Kiểm tra vai trò của người dùng
if ($_SESSION['role'] == 'customer') {
    // Nếu không phải admin, chuyển hướng đến trang không phù hợp
    header('Location: ../../account.php'); // Hoặc trang khác tùy ý
    exit();
}
?>

<?php
include "../includes/db.php";

// Lấy thông tin người dùng từ CSDL dựa trên username
$username = $_SESSION['username'];
$sql = "SELECT full_name, email, role FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();

    // Cập nhật session với thông tin người dùng
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];

    // Kiểm tra vai trò của người dùng
    if ($user['role'] == 'customer') {
        // Nếu là khách hàng, chuyển hướng đến trang tài khoản thông thường
        header('Location: ../account.php');
        exit();
    }
} else {
    // Nếu không tìm thấy thông tin người dùng, đăng xuất và chuyển hướng đến trang đăng nhập
    session_unset();
    session_destroy();
    header('Location: ../login.php');
    exit();
}

$conn->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            background-color: #f0f2f5;
        }

        .sidebar {
            width: 200px;
            background-color: #2c3e50;
            color: white;
            height: 100vh;
            position: sticky;
            top: 0;
            padding: 10px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar h2 {
            text-align: center;
            padding: 10px;
            margin: 0;
            color: #ddd;
            border-bottom: #ddd 1px solid;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: #263544;
        }

        .content h2 {
            text-align: center;
            padding: 10px;
            margin: 0;
            color: #263544;
            border-bottom: #263544 1px solid;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-bottom: 5px;
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            color: white;
            display: block;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
            margin-top: 5px;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background-color: #263544;
        }

        .logout a {
            background-color: #e74c3c;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .logout a:hover {
            background-color: #c0392b;
        }

        .content {
            flex-grow: 1;
            padding: 10px;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .content p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .table-container {
            overflow: scroll;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .table-container h3 {
            font-size: 1.5em;
            margin: 0px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f7f7f7;
            color: #333;
        }

        .logout {
            margin-top: auto;
            padding-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
    <div>
            <h2>Admin Menu</h2>
            <a href="../warehouse/viewWarehouse.php">Manage Warehouse</a>
            <a href="../product/viewProduct.php">Manage Products</a>
            <a href="../cart/viewCart.php">Manage Cart</a>
            <a href="../customer/viewCustomer.php">Manage Customers</a>
            <?php if ($_SESSION['role'] == 'admin') : ?>
                <a href="viewEmployee.php">Manage Employees</a>
                <a href="../user/viewUser.php">Manage Users</a>
                <a href="../cart/viewThongke.php">Statistical</a>

            <?php endif; ?>

        </div>
        <div class="logout">
            <a href="../logout.php">Logout</a>
        </div>
    </div>

    <div class="content">
        <h2>Welcome Admin!</h2>
        <div class="table-container">
            <?php include('manage_employees.php') ?>
        </div>


    </div>
</body>

</html>