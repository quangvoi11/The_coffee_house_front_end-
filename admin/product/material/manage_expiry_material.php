<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Storage</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            background-color: #f0f2f5;
        }

        .container {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            min-height: 100vh;
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

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
            margin-top: 25px;
        }

        table a {
            text-decoration: none;
            background-color: #263544;
            color: white;
            font-size: large;
            padding: 5px 10px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        table a:hover {
            transform: scaleX(1.1);
            background-color: #6699CC;
        }

        th,
        td {
            border: solid 2px black;
            padding: 15px;
            text-align: center;
        }

        th {
            background-color: #6699CC;
            color: white;
        }

        img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 5px;
        }

        .delete {
            border-bottom: 1px solid #3498db;
        }

        #them {
            border-radius: 10px;
            padding: 20px;
            background-color: #263544;
            text-decoration: none;
            color: white;
        }

        #them:hover {
            background-color: #6699CC;
            transform: scale(1.1);
        }

        input[type="text"] {
            padding: 6px;
            font-size: 14px;
            border: 2px solid #263544;
            border-radius: 5px;
            width: 200px;
            margin-right: 10px;
        }

        #search {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 25px;
        }

        .search-button {
            padding: 10px 20px;
            font-size: 14px;
            background-color: #6699CC;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .search-button:hover {
            background-color: #263544;
            transform: scale(1.1);
        }

        #searchForm {
            margin-bottom: 60px;
        }

        #them1,
        #them2 {
            background-color: #263544;
            padding: 15px 201px;
            width: 493px;
            border-radius: 10px;
            text-decoration: none;
            color: white;
            margin-top: 15px;
        }

        #them1:hover,
        #them2:hover {
            background-color: #6699CC;
        }

        .expiry {
            text-align: center;
            margin-top: 25px;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Manage Expiry Material</h1>
            <div class="nav-links">
                <a href="../storage/manage_storage.php">Inventory</a>
                <a href="../warehouse/viewWarehouse.php">Warehouse</a>
                <a href="../material/manage_material.php">Material</a>
                <a href="../supplier/manage_suppliers.php">Supplier</a>
            </div>
        </div>
        <form method="POST" id="searchForm">
            <div id="search">
                <div>
                    <input type="text" name="txtKeyword1" placeholder="Search By ID material...">
                    <input type="submit" name="txtSubmit1" value="search" class="search-button">
                </div>
                <div style="margin-left: 20px;">
                    <input type="text" name="txtKeyword" placeholder="Search By Name material...">
                    <input type="submit" name="txtSubmit2" value="search" class="search-button">
                </div>
            </div>
        </form>

        <div class="expiry">
            <a href="manage_material.php" id="them1">Material</a>
            <a href="manage_expiry_material.php" id="them2">Expiry Material</a>
        </div>

        <?php
        // Kết nối tới cơ sở dữ liệu
        $conn = mysqli_connect("localhost", "root", "", "the_coffee_house");
        if (!$conn) {
            die("Kết nối không thành công: " . mysqli_connect_error());
        }
        function getmaterial($conn, $id)
        {
            $query = "SELECT material FROM warehouses WHERE id = $id";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                return $row['material'];
            } else {
                return "Unknown";
            }
        }

        function displayProducts($conn, $result)
        {
            if (mysqli_num_rows($result) > 0) {
                echo '<div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Material</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Expiry Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';

                while ($row = mysqli_fetch_assoc($result)) {
                    $getmaterial_name = getmaterial($conn, $row['name_material']);

                    echo '<tr>
                            <td>' . $row['id'] . '</td>
                            <td>' . $getmaterial_name . '</td>
                            <td>' . $row['quantity'] . '</td>
                            <td>' . $row['unit'] . '</td>
                            <td>' . $row['expiry_time'] . '</td>
                            <td>
                                <a href="delete_expiry_material.php?id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this item?\')">Delete</a>
                            </td>
                        </tr>';
                }

                echo '</tbody>
                </table>
                </div>';
            } else {
                echo '<p>No expired materials found.</p>';
            }
        }

        // Lấy ngày hiện tại
        function insertExpiredProducts($conn)
        {
            $today = date("Y-m-d");
            $query = "SELECT * FROM material WHERE expiry_time < '$today'";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row["id"];
                $warehouse_id = $row["warehouse_id"];
                $unit = $row["unit"];
                $quantity = $row["quantity"];
                $expiry_time = $row["expiry_time"];

                // Check if the product already exists in expiry_inventory
                $checkQuery = "SELECT * FROM expiry_inventory WHERE id = '$id'";
                $checkResult = mysqli_query($conn, $checkQuery);

                if (mysqli_num_rows($checkResult) == 0) {
                    // Insert into expiry_inventory
                    $insertQuery = "INSERT INTO expiry_inventory (id, name_material, unit, quantity, expiry_time)
                            VALUES ($id, '$warehouse_id', '$unit', '$quantity', '$expiry_time')";
                    mysqli_query($conn, $insertQuery);
                }
            }
        }
        insertExpiredProducts($conn);

        // Truy vấn các mặt hàng đã hết hạn để hiển thị
        if (!isset($_POST['txtSubmit1']) && !isset($_POST['txtSubmit2'])) {
            $query = "SELECT * FROM expiry_inventory";
            $result = mysqli_query($conn, $query);
            displayProducts($conn, $result);
        }

        // Xử lý giá trị nhập từ form để tìm kiếm
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['txtSubmit1'])) {
                $keyword1 = isset($_POST['txtKeyword1']) ? $_POST['txtKeyword1'] : '';
                $query = "SELECT * FROM expiry_inventory WHERE id LIKE '%$keyword1%'";
            } elseif (isset($_POST['txtSubmit2'])) {
                $keyword = isset($_POST['txtKeyword']) ? $_POST['txtKeyword'] : '';
                $query = "SELECT s.*, w.material AS warehouse_id
                          FROM expiry_inventory s
                          JOIN warehouses w ON s.name_material = w.id
                          WHERE w.material LIKE '%$keyword%'";
            }
            $result = mysqli_query($conn, $query);
            displayProducts($conn, $result);
        }

        // Đóng kết nối
        mysqli_close($conn);
        ?>
    </div>
</body>

</html>
