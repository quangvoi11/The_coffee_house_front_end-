<?php
$conn = mysqli_connect("localhost", "root", "", "the_coffee_house");
if (!$conn) {
    die("Kết nối không thành công: " . mysqli_connect_error());
}

$message = "";

$id = $_GET['id'];

// Lấy thông tin hàng tồn kho
$query = "SELECT * FROM material WHERE id = $id";
$result = mysqli_query($conn, $query);
$material = mysqli_fetch_assoc($result);




// Lấy danh sách kho
$warehouse_query = "SELECT id, material FROM warehouses";
$warehouse_result = mysqli_query($conn, $warehouse_query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $warehouse_id = $_POST['warehouse_id'];
    $quantity = $_POST['quantity'];
    $expiry_time = $_POST['expiry_time'];
    $unit = $_POST['unit'];

    // Bắt đầu transaction
    mysqli_begin_transaction($conn);

    try {
        // Cập nhật hàng tồn kho
        $query = "UPDATE material SET  warehouse_id='$warehouse_id', quantity='$quantity', expiry_time='$expiry_time', unit='$unit' WHERE id=$id";
        if (mysqli_query($conn, $query)) {
            $message = '<p>Cập nhật thành công.</p>';
        } else {
            $message = '<p>Lỗi: ' . mysqli_error($conn) . '</p>';
        }

        // Commit transaction
        mysqli_commit($conn);
    } catch (Exception $e) {
        // Rollback transaction
        mysqli_rollback($conn);
        echo $e->getMessage();
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Storage</title>
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
        #import_time,
        textarea {
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
    </style>
</head>

<body>
    <div class="container">
        <h1>Add Inventory</h1>
        <?php if (!empty($message)) : ?>
        <div class="message">
            <p><?php echo $message; ?></p>
        </div>
        <?php endif; ?>
        <form action="add_material.php" method="POST">

            <div class="form-group">
                <label for="warehouse_id">Material</label>
                <select name="warehouse_id" id="warehouse_id" required>
                    <?php
                    while ($row = mysqli_fetch_assoc($warehouse_result)) {
                        $selected = ($row['id'] == $material['warehouse_id']) ? 'selected' : '';
                        echo '<option value="' . $row['id'] . '">' . $row['material'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" value="<?php echo $material['quantity']; ?>" required>
            </div>
            <div class="form-group">
                <label for="unit">Unit</label>
                <input type="text" name="unit" id="unit" value="<?php echo $material['unit']; ?>"required>
            </div>
            
            
            <div class="form-group">
                <label for="expiry_time">Expiry_time</label>
                <input type="datetime-local" name="expiry_time" id="expiry_time" value="<?php echo $material['expiry_time']; ?>" required>
            </div>
            
            <input type="submit" value="Add Material">
            
        </form>
        <a href="manage_material.php" id="back-button">Exit</a>
    </div>

</body>

</html>
