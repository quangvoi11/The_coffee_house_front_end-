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
include 'includes_Supplier/db.php';

$id = $_GET['id'];

// Lấy thông tin nhà cung cấp hiện tại
$query = "SELECT * FROM Suppliers WHERE id = $id";
$result = mysqli_query($conn, $query);
$supplier = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $query = "UPDATE Suppliers SET name='$name', email='$email', phone='$phone', address='$address' WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        echo "Supplier updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
    header("Location: manage_suppliers.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Supplier</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #3498db;
        }

        .header h1 {
            margin: 0;
            font-size: 25px;
            color: #333;
        }

        .header .nav-links {
            display: flex;
            gap: 10px;
        }

        .header .nav-links a {
            text-decoration: none;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 4px;
            color: #333;
            background-color: #f7f7f7;
            transition: background-color 0.3s ease;
        }

        .header .nav-links a:hover {
            background-color: #e0e0e0;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
        }

        input,
        select,
        textarea {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            background-color: #3498db;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Edit Supplier</h1>
            <div class="nav-links">
                <a href="manage_suppliers.php">Supplier</a>
            </div>
        </div>
        <form action="edit_supplier.php?id=<?php echo $id; ?>" method="POST">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?php echo $supplier['name']; ?>" required>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo $supplier['email']; ?>">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" value="<?php echo $supplier['phone']; ?>">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" value="<?php echo $supplier['address']; ?>">
            <button type="submit">Update Supplier</button>
        </form>
    </div>
</body>

</html>

<?php
mysqli_close($conn);
?>