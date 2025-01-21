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
// Kết nối tới cơ sở dữ liệu
include "includes_Category/db.php";

// Lấy giá trị của ID danh mục từ URL
$categoryId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Kiểm tra nếu ID hợp lệ
if ($categoryId > 0) {
    // Xử lý cập nhật danh mục khi form được submit
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $categoryName = isset($_POST['CategoryName']) ? mysqli_real_escape_string($conn, $_POST['CategoryName']) : '';

        // Cập nhật danh mục trong cơ sở dữ liệu
        $updateQuery = sprintf("UPDATE categories SET CategoryName = '%s' WHERE CategoryID = %d", $categoryName, $categoryId);
        $result = mysqli_query($conn, $updateQuery);

        if ($result) {
            // Chuyển hướng về trang quản lý danh mục
            header("Location: manage_categories.php");
            exit();
        } else {
            echo "<p>Error updating category.</p>";
        }
    }

    // Truy vấn cơ sở dữ liệu để lấy thông tin danh mục sau khi cập nhật
    $query = "SELECT * FROM categories WHERE CategoryID = " . $categoryId;
    $result = mysqli_query($conn, $query);

    // Kiểm tra và lấy dữ liệu danh mục từ kết quả truy vấn
    if ($result && mysqli_num_rows($result) > 0) {
        $category = mysqli_fetch_assoc($result);
    } else {
        echo "<p>Category not found.</p>";
    }

    // Giải phóng kết quả truy vấn
    mysqli_free_result($result);
} else {
    echo "<p>Invalid category ID.</p>";
}

// Đóng kết nối
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
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

        .header h2 {
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
            <h2>Edit Category</h2>
            <div class="nav-links">
                <a href="manage_categories.php">Category</a>
            </div>
        </div>

        <?php if (isset($category)) : ?>
            <form method="POST">
                <label for="CategoryName">Category Name</label>
                <input type="text" id="CategoryName" name="CategoryName" value="<?php echo $category['CategoryName']; ?>" required>
                <input type="submit" value="Update Category">
            </form>
        <?php endif; ?>
    </div>
</body>

</html>