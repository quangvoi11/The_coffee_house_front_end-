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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
        }

        .container {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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

        .search-container {
            text-align: right;
            margin-top: 10px;
            margin-bottom: 20px;
        }


        .search-container input[type="text"],
        .search-container select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            transition: border-color 0.3s;
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

        /* .actions {} */

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
            <h1>Category Management</h1>
            <div class="nav-links">
                <a href="../product/viewProduct.php">Product</a>
                <a href="manage_categories.php">Category</a>
                <a href="add_category.php">Add category</a>
            </div>
        </div>

        <div class="search-container">
            <form action="manage_categories.php" method="GET">
                <input type="text" name="search" placeholder="Search by category name" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <div class="table-responsive">
            <table>
                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>

                <?php
                // Kết nối tới cơ sở dữ liệu
                include "includes_Category/db.php";

                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $search_query = $search ? "WHERE CategoryName LIKE '%$search%'" : '';

                // Truy vấn danh sách danh mục
                $query = "SELECT * FROM categories";
                $result = mysqli_query($conn, $query);

                // Hiển thị danh sách danh mục
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['CategoryID'] . "</td>";
                    echo "<td>" . $row['CategoryName'] . "</td>";
                    echo '<td class="actions">';
                    echo '<a class="edit" href="edit_category.php?id=' . $row['CategoryID'] . '">Edit</a>';
                    echo '<a class="delete" href="delete_category.php?id=' . $row['CategoryID'] . '" onclick="return confirm(\'Are you sure?\')">Delete</a>'; // Không sử dụng htmlspecialchars ở đây
                    echo '</td>';
                    echo "</tr>";
                }

                // Đóng kết nối
                mysqli_close($conn);
                ?>
            </table>
        </div>
    </div>


</body>

</html>