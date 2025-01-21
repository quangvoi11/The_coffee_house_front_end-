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

$search = isset($_GET['search']) ? $_GET['search'] : '';

// Truy vấn danh sách nhà cung cấp
$query = "SELECT * FROM Suppliers WHERE name LIKE '%$search%' OR email LIKE '%$search%'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Suppliers</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
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

        .search-container {
            text-align: right;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .search-container input[type="text"] {
            padding: 10px;
            font-size: 16px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-container button {
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            background-color: #3498db;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
            /* Đảm bảo bảng không bị co lại quá mức */
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            padding: 20px;
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 5px;
        }

        /* .actions {
            display: flex;
            gap: 10px;
        } */

        .actions a {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            color: black;
        }

        .actions a:hover {
            transform: scale(1.1);
            color: #3498db;
        }

        .edit {
            border-bottom: 1px solid #3498db;
            margin-right: 10px;
        }

        .delete {
            border-bottom: 1px solid #3498db;

        }
        
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Manage Suppliers</h1>
            <div class="nav-links">
                <a href="../warehouse/viewWarehouse.php">Warehouse</a>
                <a href="../storage/manage_storage.php">Inventory</a>
                <a href="../material/manage_material.php">Material</a>
                <a href="../supplier/manage_suppliers.php">Supplier</a>
                <a href="add_supplier.php" >Add Supplier</a>
            </div>
        </div>

        <div class="search-container">
            <form action="manage_suppliers.php" method="GET">
                <input type="text" name="search" placeholder="Search by name or email" value="<?php echo $search; ?>">
                <button type="submit">Search</button>
            </form>
        </div>
        <div class="table-responsive">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td>{$row['phone']}</td>";
                    echo "<td>{$row['address']}</td>";
                    echo "<td class='actions'>";
                    echo "<a class='edit' href='edit_supplier.php?id={$row['id']}'>Edit</a> ";
                    echo "<a class='delete' href='delete_supplier.php?id={$row['id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>

<?php
mysqli_close($conn);
?>