<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Warehouses from supplier</title>
    <style>
        #search {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 25px;
        }

        .box_function1 {
            text-align: center;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto;
            /* Canh giữa box_function1 */
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
        }

        table,
        th,
        td {
            border: solid 2px black;
        }

        th,
        td {
            padding: 15px;
            text-align: center;
        }

        th {
            background-color: #6699CC;
            color: white;
        }

        table a {
            text-decoration: none;
            background-color: #6699CC;
            color: white;
            font-size: large;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .box2 a {
            text-decoration: none;
            background-color: #263544;
            color: white;
            font-size: large;
            padding: 5px 10px;
            border-radius: 5px;
        }

        td a:hover {
            background-color: #6699CC;
            transform: scale(1.1)
        }

        .box1 {
            width: 350px;
            background-color: #263544;
            color: white;
            padding: 20px;
            border-radius: 10px;
            height: 100%;
        }   

        #searchForm{
            margin-bottom: 60px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
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


        #them {
            padding: 15px;
            margin-left: 134px;
            text-align: center;
        }
        #them:hover{
            background-color: #6699CC  ;
            transform: scale(1.1);
        }



        /* h1 {
            color: #263544;
            text-align: center;
            font-size: 40px;
        } */

        h2 {
            text-align: center;
        }


        img {
            border-radius: 5px;
        }

        input[type="text"] {
            padding: 6px;
            font-size: 14px;
            border: 2px solid #263544;
            border-radius: 5px;
            width: 200px;
            margin-right: 10px;
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
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .logout {
            margin-top: auto;
            padding-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
    <h1>Manage Warehouse from supplier</h1>

        <div class="nav-links">
            <a href="viewWarehouse.php">Warehouse</a>
            <a href="../storage/manage_storage.php">Inventory</a>
            <a href="../material/manage_material.php">Material</a>
            <a href="../supplier/manage_suppliers.php">Supplier</a>
        </div>
    </div>

    <div class="box2">
        
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



        


        <a href="add_warehouse.php" id="them">Add Warehouse </a>



        <?php
        // Connect to database
        $conn = mysqli_connect("localhost", "root", "", "the_coffee_house");
        if (!$conn) {
            die("Kết nối không thành công: " . mysqli_connect_error());
        }




        // Function lấy tên nhà cung cấp bởi ID
        function getSupplierName($conn, $id)
        {
            $query = "SELECT name FROM suppliers WHERE id = $id";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                return $row['name'];
            } else {
                return "Unknown";
            }
        }

        function getinventoryName($conn, $id)
        {
            $query = "SELECT inventory_name FROM inventory WHERE id = $id";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                return $row['inventory_name'];
            } else {
                return "Unknown";
            }
        }
        // Function to display products
        function displayProducts($conn, $result)
        {
            if (mysqli_num_rows($result) > 0) {
                echo '<div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>supplier</th>
                            <th>Inventory</th>
                            <th>material</th>
                            <th>quantity</th>
                            <th>unit</th>
                            <th>import_money</th>
                            <th>import_time</th>
                            
                            <th colspan="2">actions</th>
                        </tr>
                    </thead>
                    <tbody>';

                while ($row = mysqli_fetch_assoc($result)) {
                    // Get supplier name
                    $supplier_name = getSupplierName($conn, $row['supplier']);
                    $inventory_name = getinventoryName($conn, $row['inventory_id']);

                    echo '<tr>
                    <td>' . $row["id"] . '</td>
                    <td>' . $supplier_name . '</td>
                    <td>' . $inventory_name . '</td>
                    <td>' . $row["material"] . '</td>
                    <td>' . $row["quantity"] . '</td>
                    <td>' . $row["unit"] . '</td>
                    <td>' . $row["import_money"] . '</td>
                    <td>' . $row["import_time"] . '</td>
                    
                    <td>
                        <a href="edit_warehouse.php?id=' . $row["id"] . '">Sửa</a>
                    </td>
                    <td>
                        <a onclick="return confirm (\'Bạn có muốn xóa hay không?\')" href="delete_warehouse.php?id=' . $row["id"] . '">Xóa</a>
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

        // Default display of all products
        if (!isset($_POST['txtSubmit1']) && !isset($_POST['txtSubmit2'])) {
            $query = "SELECT * FROM warehouses";
            $result = mysqli_query($conn, $query);
            displayProducts($conn, $result);
        }

        // Search functionality
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['txtSubmit1'])) {
                $keyword1 = isset($_POST['txtKeyword1']) ? $_POST['txtKeyword1'] : '';
                $query = "SELECT * FROM warehouses WHERE id LIKE '%$keyword1%'";
            } elseif (isset($_POST['txtSubmit2'])) {
                $keyword = isset($_POST['txtKeyword']) ? $_POST['txtKeyword'] : '';
                $query = "SELECT * FROM warehouses WHERE material LIKE '%$keyword%'";
            }
            $result = mysqli_query($conn, $query);
            displayProducts($conn, $result);
        }

        // Close connection
        mysqli_close($conn);
        ?>


</body>

</html>