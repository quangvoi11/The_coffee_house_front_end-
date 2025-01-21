<?php
$conn = mysqli_connect("localhost", "root", "", "the_coffee_house");
if (!$conn) {
    die("Kết nối không thành công: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $inventory_name = $_POST['inventory_name'];
    $address = $_POST['address'];

    $insert_query = "INSERT INTO inventory (inventory_name, address) VALUES ('$inventory_name', '$address')";

    if (mysqli_query($conn, $insert_query)) {
        $message = '<p >Thêm kho hàng thành công!</p>';
    } else {
        $message =  '<p >Lỗi: ' . mysqli_error($conn) . '</p>';
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Inventory</title>
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
        <form method="POST">
            <label for="inventory_name">Inventory Name:</label>
            <input type="text" id="inventory_name" name="inventory_name" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <input type="submit" value="Add inventory">
        </form>
        <a href="manage_storage.php" id="back-button">Exit</a>
    </div>

</body>

</html>
