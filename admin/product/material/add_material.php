<?php
$conn = mysqli_connect("localhost", "root", "", "the_coffee_house");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // Lấy danh sách các kho hàng
    $warehouse_query = "SELECT id, material, quantity FROM warehouses";
    $warehouse_result = mysqli_query($conn, $warehouse_query);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $warehouse_id = $_POST['warehouse_id'];
        $quantity = $_POST['quantity'];
        $expiry_time = $_POST['expiry_time'];

        // Lấy số lượng hiện có và đơn vị của kho hàng đã chọn
        $check_quantity_query = "SELECT quantity, unit FROM warehouses WHERE id = ?";
        $stmt = $conn->prepare($check_quantity_query);
        $stmt->bind_param("i", $warehouse_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $available_quantity = $row['quantity'];
            $unit = $row['unit'];

            if ($quantity > $available_quantity) {
                $message = "Số lượng nhập vượt quá số lượng có sẵn!";
            } else {
                // Bắt đầu transaction
                mysqli_begin_transaction($conn);

                try {
                    // Chèn vào bảng material
                    $query = "INSERT INTO material (quantity, unit, warehouse_id, expiry_time) 
                              VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("isis", $quantity, $unit, $warehouse_id, $expiry_time);
                    if ($stmt->execute()) {
                        $message = "Thêm hàng thành công!";
                        
                        // Cập nhật số lượng trong bảng warehouses
                        $update_query = "UPDATE warehouses SET quantity = quantity - ? WHERE id = ?";
                        $stmt = $conn->prepare($update_query);
                        $stmt->bind_param("ii", $quantity, $warehouse_id);
                        $stmt->execute();
                    } else {
                        $message = "Lỗi: " . mysqli_error($conn);
                    }

                    // Commit transaction
                    mysqli_commit($conn);
                    
                } catch (Exception $e) {
                    // Rollback transaction
                    mysqli_rollback($conn);
                    $message = $e->getMessage();
                }
            }
        } else {
            $message = "Không tìm thấy kho hàng!";
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm hàng tồn kho</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 600px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            margin-top: 20px;
        }

        label,
        input,
        select,
        textarea {
            display: block;
            margin-bottom: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="text"],
        input[type="number"],
        #expiry_time {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        select {
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            text-align: center;
            border-radius: 4px;
        }

        #back-button {
            padding: 10px 20px;
            background-color: #e74c3c;
            color: #fff;
            border: none;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            border-radius: 4px;
            margin: 10px 271px;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        #back-button:hover {
            background-color: #800000;
        }

        .message {
            background-color: #d4edda;
            color: #155724;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Thêm hàng tồn kho</h1>
        <?php if (!empty($message)) : ?>
        <div class="<?php echo strpos($message, 'Thêm hàng thành công!') !== false ? 'message' : 'error-message'; ?>">
            <p><?php echo $message; ?></p>
        </div>
        <?php endif; ?>
        <form action="add_material.php" method="POST">
            <div class="form-group">
                <label for="warehouse_id">Kho hàng</label>
                <select name="warehouse_id" id="warehouse_id" required>
                    <?php
                    while ($row = mysqli_fetch_assoc($warehouse_result)) {
                        echo '<option value="' . $row['id'] . '">' . $row['material'] . ' (Còn lại: ' . $row['quantity'] . ')</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Số lượng</label>
                <input type="number" name="quantity" id="quantity" required>
            </div>
            <div class="form-group">
                <label for="expiry_time">Hạn sử dụng</label>
                <input type="datetime-local" name="expiry_time" id="expiry_time" required>
            </div>
            <input type="submit" value="Thêm hàng">
        </form>
        <a href="manage_material.php" id="back-button">Thoát</a>
    </div>
</body>
</html>
