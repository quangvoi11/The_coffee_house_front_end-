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

        .add-user-button {
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
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
            /* Đảm bảo bảng không bị co lại quá mức */
        }

        table a {
            text-decoration: none;
            background-color: #263544;
            color: white;
            font-size: large;
            padding: 5px 10px;
            border-radius: 5px;
        }

        table a:hover{
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
    </style>

</head>

<body>

    <!-- <div class="box1">
        <div class="banner">
            <img src="img\png-transparent-coffee-icon-coffee-vienna-breakfast-bistro-cafe-symbols-kitchen-food-text.png" alt="Banner">
            <h2>Admin Menu</h2>
        </div>
        <hr>
        <div class="sidebar">
            <a href="../product/manage_products.php">Manage Products</a>
            <a href="../cart/manage_cart.php">Manage Cart</a>
            <a href="../employee/manage_employees.php">Manage Employees</a>
            <a href="../customer/manage_customers.php">Manage Customers</a>
            <a href="../warehouse/manage_warehouses.php">Manage warehouse</a>
            <a href="manage_storage.php">Manage Inventory</a>
            <a href="../material/manage_material.php">Manage Material</a>
        </div>
        <div class="logout">
            <a href="../dashboard.php">Exit</a>
        </div>
    </div> -->
    <div class="container">
        <div class="header">
            <h1>Manage Inventory</h1>
            <div class="nav-links">
                <a href="../warehouse/viewWarehouse.php">Warehouse</a>
                <a href="../storage/manage_storage.php">Inventory</a>
                <a href="../material/manage_material.php">Material</a>
                <a href="../supplier/manage_suppliers.php">Supplier</a>
            </div>
        </div>

        <form method="POST" id="searchForm">
            <div id="search">
                <div>
                    <input type="text" name="txtKeyword1" placeholder="Search By ID meterial...">
                    <input type="submit" name="txtSubmit1" value="search" class="search-button">
                </div>
                <div style="margin-left: 20px;">
                    <input type="text" name="txtKeyword" placeholder="Search By Name meterial...">
                    <input type="submit" name="txtSubmit2" value="search" class="search-button">
                </div>
            </div>
        </form>
        <a href="add_storage.php" id="them">Manage Inventory</a>
        <?php
        $conn = mysqli_connect("localhost", "root", "", "the_coffee_house");
        if (!$conn) {
            die("Kết nối không thành công: " . mysqli_connect_error());
        }

        $search = '';

        // Câu truy vấn SQL với điều kiện lọc theo tên tên nguyên liệu và kết nối với bảng Suppliers và Warehouses để lấy tên nhà cung cấp và tên nguyên liệu
        $query = "SELECT * from inventory ";


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
        $result = mysqli_query($conn, $query);

        // Hàm hiển thị sản phẩm
        function displayProducts($conn, $result)
        {
            if (mysqli_num_rows($result) > 0) {
                echo '<div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name Inventory</th>
                            <th>Address</th>
                            <th colspan="2">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>';

                while ($row = mysqli_fetch_assoc($result)) {
                    // Get supplier name

                    echo '<tr>
                            
                            <td>' . $row['id'] . '</td>
                            <td>' . $row['inventory_name'] . '</td>
                            <td>' . $row['address'] . '</td>
                            <td>
                                <a class="edit" href="edit_storage.php?id=' . $row["id"] . '">Edit</a>
                            </td>
                            <td>
                                <a class="delete" onclick="return confirm(\'Bạn có muốn xóa hay không?\')" href="delete_storage.php?id=' . $row["id"] . '">Delete</a>
                            </td>
                            </tr>';
                }

                echo '</tbody>
                </table>
                </div>';
            } else {
                echo "<p style='text-align: center;'>Không tìm thấy sản phẩm nào.</p>";
            }
        }

        // Hiển thị mặc định tất cả các kho hàng
        if (!isset($_POST['txtSubmit1']) && !isset($_POST['txtSubmit2'])) {
            $query = "SELECT * FROM inventory ";
            $result = mysqli_query($conn, $query);
            displayProducts($conn, $result);
        }

        // Xử lý giá trị nhập từ form để tìm kiếm
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['txtSubmit1'])) {
                $keyword1 = isset($_POST['txtKeyword1']) ? $_POST['txtKeyword1'] : '';
                $query = "SELECT * from inventory where id like '%$keyword1%'";
            } elseif (isset($_POST['txtSubmit2'])) {
                $keyword = isset($_POST['txtKeyword']) ? $_POST['txtKeyword'] : '';
                $query = "SELECT * from inventory where inventory_name like '%$keyword%'";
            }
            $result = mysqli_query($conn, $query);
            displayProducts($conn, $result);
        }

        // Đóng kết nối
        mysqli_close($conn);
        ?>


</body>

</html>