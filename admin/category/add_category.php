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
    <title>Add Category</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
        }

        .container {
            width: 50%;
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

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        label {
            font-size: 16px;
            color: #333;
        }

        input[type="text"],
        input[type="submit"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #3498db;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Add Category</h1>
            <div class="nav-links">
                <a href="manage_categories.php">Category</a>
                <a href="add_category.php">Add category</a>
            </div>
        </div>
        <form action="add_category.php" method="POST">
            <label for="CategoryName">Category Name</label>
            <input type="text" id="CategoryName" name="CategoryName" required>
            <input type="submit" value="Add Category">
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Kết nối tới cơ sở dữ liệu
            include "includes_Category/db.php";

            // Lấy dữ liệu từ form
            $categoryName = mysqli_real_escape_string($conn, $_POST['CategoryName']);

            // Thêm danh mục vào cơ sở dữ liệu
            $query = "INSERT INTO categories (CategoryName) VALUES ('$categoryName')";
            if (mysqli_query($conn, $query)) {
                header("Location: manage_categories.php");
            } else {
                echo "<p>Error: " . mysqli_error($conn) . "</p>";
            }

            // Đóng kết nối
            mysqli_close($conn);
        }
        ?>
    </div>
</body>

</html>