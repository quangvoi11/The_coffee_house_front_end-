    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add warehouse from supplier</title>
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
            input[type="date"],
            #supplier_id,
            #inventory_id {
                padding: 10px;
                border-radius: 5px;
            }

            input[type="submit"]{
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

            input[type="submit"]:hover,
            .back-button:hover {
                background-color: #2980b9;
            }

            .back-button {
                background-color: #e74c3c;
                margin-left: auto;
                padding: 10px 20px;
                margin-right: auto;
                border-radius: 4px;
                display: block;
                color: #fff;
                width: 100px;
                margin-top: 10px;
                text-align: center;
                text-decoration: none;
            }

            .back-button:hover {
                background-color: #c0392b;
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
            <h2>Add Warehouse From Supplier</h2>
            <?php

            $conn = mysqli_connect("localhost", "root", "", "the_coffee_house");
            if (!$conn) {
                die("Kết nối không thành công: " . mysqli_connect_error());
            }


            $message = "";

            if ($_SERVER['REQUEST_METHOD'] === "POST") {
                $inventory_id = $_POST["inventory_id"];
                $supplier_id = $_POST['supplier_id'];
                $material = $_POST['material'];
                $quantity = $_POST['quantity'];
                $unit = $_POST['unit'];
                $import_money = $_POST['import_money'];
                $import_time = $_POST['import_time'];
                

                // Chuẩn bị câu truy vấn SQL để chèn dữ liệu vào bảng warehouses
                $query = "INSERT INTO warehouses (inventory_id,supplier, material, quantity, unit, import_money, import_time) 
                        VALUES ('$inventory_id','$supplier_id', '$material', '$quantity', '$unit', '$import_money', '$import_time')";

                if (mysqli_query($conn, $query)) {
                    $message = "<span >Nhập kho thành công!</span>";
                } else {
                    $message = "Lỗi: " . mysqli_error($conn);
                }
            }

            // Truy vấn danh sách nhà cung cấp để hiển thị trong dropdown
            $supplier_query = "SELECT id, name FROM suppliers";
            $supplier_result = mysqli_query($conn, $supplier_query);

            $inventory_query = "SELECT id, inventory_name FROM inventory";
            $inventory_result = mysqli_query($conn,$inventory_query);

            // Đóng kết nối
            mysqli_close($conn);
            ?>


            <?php if (!empty($message)) : ?>
                <div class="message">
                    <p><?php echo $message; ?></p>
                </div>
            <?php endif; ?>

            <form method="POST">
                <label for="supplier_id">Chọn nhà cung cấp:</label>
                <select name="supplier_id" id="supplier_id" required>
                    <option value="">Chọn nhà cung cấp</option>
                    <?php while ($row = mysqli_fetch_assoc($supplier_result)) : ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php endwhile; ?>
                </select>

                <label for="material">Tên sản phẩm:</label>
                <input type="text" id="material" name="material" required>

                <label for="quantity">Số lượng:</label>
                <input type="number" id="quantity" name="quantity" required>

                <label for="unit">Đơn vị tính:</label>
                <input type="text" id="unit" name="unit" required>

                <label for="inventory_id">Chọn kho hàng để nhập:</label>
                <select name="inventory_id" id="inventory_id" required>
                    <option value="">Chọn kho hàng để nhập</option>
                    <?php while ($row = mysqli_fetch_assoc($inventory_result)) : ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['inventory_name']; ?></option>
                    <?php endwhile; ?>
                </select>

                <label for="import_money">Giá nhập:</label>
                <input type="number" id="import_money" name="import_money" step="0.01" required>

                <label for="import_time">Ngày nhập kho:</label>
                <input type="date" id="import_time" name="import_time" required>

                

                <input type="submit" value="Nhập Kho">
                <a href="viewWarehouse.php" class="back-button">Quay lại</a>

            </form>
        </div>
    </body>

    </html>