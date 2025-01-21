<?php
include('db_connection.php');
$this_id = $_GET['this_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn1'])) {
    $cart_item_id = $_POST['cart_item_id'];
    $new_quantity = $_POST['quantity'];
    $update_sql = "UPDATE cart_items SET quantity = '$new_quantity' WHERE cart_item_id = '$cart_item_id'";
    $update_query = mysqli_query($conn, $update_sql);

    if ($update_query) {
        header("Location: view_cart.php");
        exit;  }
}
$sql = "SELECT * FROM cart_items WHERE cart_item_id ='$this_id'";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($query);

if ($row) {
  
    $quantity = $row['quantity'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa số lượng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: bisque;
            padding: 30px;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 10px;
        }
        input[type="number"] {
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Chỉnh sửa số lượng</h2>
        <form action="editViewcart.php" method="POST" >
            <input type="hidden" name="cart_item_id" value="<?php echo $this_id; ?>">
            <label for="quantity">Số lượng:</label>
            <input type="number" id="quantity" name="quantity" value="<?php echo $quantity; ?>" min="1" required>
            <input type="submit" value="Lưu" name="btn1">
        </form>
    </div>
</body>
</html>

<?php
} else {
    // Hiển thị thông báo nếu không tìm thấy mục trong giỏ hàng
    echo "Không tìm thấy mục trong giỏ hàng.";
}

// Đóng kết nối với cơ sở dữ liệu
mysqli_close($conn);
?>
