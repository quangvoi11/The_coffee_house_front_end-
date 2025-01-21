<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Warehouse Item  </title>
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
            padding: 60px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            margin-top: 20px;
        }

        label,
        input,
        select {
            display: block;
            margin-bottom: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="text"],
        input[type="number"],
        #expiry_time,
        #import_time {
            padding: 10px;
            border: 1px solid #ccc;
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

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        #back-button:hover {
            background-color: #2980b9;
        }

        #back-button{
            padding: 15px 40px;
            background-color: #e74c3c;
            color: #fff;
            border: none;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            border-radius: 4px;
            margin: 10px 241px; 
        }

        #back-button a {
            text-decoration: none;
            color: #fff;

        }

        .message {
            background-color: #d4edda;
            color: #fff;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Edit Warehouse Item</h2>
        <?php
        // Connect to database
        $conn = mysqli_connect("localhost", "root", "", "the_coffee_house");
        if (!$conn) {
            die("Kết nối không thành công: " . mysqli_connect_error());
        }
        $message = "";

        // Kiểm tra nếu có dữ liệu post từ form sửa
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $material = $_POST['material'];
            $quantity = $_POST['quantity'];
            $unit = $_POST['unit'];
            $import_money = $_POST['import_money'];
            $import_time = $_POST['import_time'];
            

            // Cập nhật dữ liệu vào database
            $query = "UPDATE warehouses SET material='$material', quantity='$quantity', unit='$unit', import_money='$import_money', import_time='$import_time' WHERE id='$id'";
            if (mysqli_query($conn, $query)) {
                $message = '<p >Cập nhật thành công.</p>';
            } else {
                $message =  '<p >Lỗi: ' . mysqli_error($conn) . '</p>';
            }
        }

        // Lấy thông tin sản phẩm từ database để hiển thị lên form
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query = "SELECT * FROM warehouses WHERE id='$id'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
        ?>
                <?php if (!empty($message)) : ?>
                    <div class="message">
                        <p><?php echo $message; ?></p>
                    </div>
                <?php endif; ?>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="form-group">
                        <label for="material">Material:</label>
                        <input type="text" id="material" name="material" value="<?php echo $row['material']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="text" id="quantity" name="quantity" value="<?php echo $row['quantity']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="unit">Unit:</label>
                        <input type="text" id="unit" name="unit" value="<?php echo $row['unit']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="import_money">Import Money:</label>
                        <input type="number" id="import_money" name="import_money" value="<?php echo $row['import_money']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="import_time">Import Time:</label>
                        <input type="datetime-local" id="import_time" name="import_time" value="<?php echo $row['import_time']; ?>" required>
                    </div>
                    

                    <input type="submit" value="UPDATE">


                </form>
        <?php
            } else {
                echo '<p style="color: red;">Không tìm thấy sản phẩm.</p>';
            }
        } else {
            echo '<p style="color: red;">Thiếu thông tin sản phẩm.</p>';
        }

        // Đóng kết nối
        mysqli_close($conn);
        ?>
        
            <a href="viewWarehouse.php" id="back-button">EXIT</a>
        
    </div>

</body>

</html>