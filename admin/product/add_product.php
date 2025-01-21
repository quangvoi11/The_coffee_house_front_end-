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
include 'includes_Product/db_product.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image_url = $_FILES['image_url']['name'];
    $target_dir = "images_Product/";
    $target_file = $target_dir . basename($_FILES['image_url']['name']);
    move_uploaded_file($_FILES['image_url']['tmp_name'], $target_file);


    $query = "INSERT INTO products (name, description, price, image_url, category_id) VALUES ( '$name', '$description', '$price', '$image_url', '$category_id')";
    if (mysqli_query($conn, $query)) {
        header('location: viewProduct.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
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
            font-size: 24px;
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
        }

        label {
            margin-bottom: 5px;
        }

        input,
        select,
        textarea {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            background-color: #3498db;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Add New Product</h2>
            <div class="nav-links">
                <a href="viewProduct.php">Product</a>
                <a href="add_product.php">Add Product</a>
            </div>
        </div>
        <form action="add_product.php" method="POST" enctype="multipart/form-data">

            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" required>
                <?php
                include 'includes_Product/db_product.php';
                $query = "SELECT CategoryID, CategoryName FROM Categories";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['CategoryID'] . '">' . $row['CategoryName'] . '</option>';
                }
                ?>
            </select>
            <label for="name">Product Name</label>
            <input type="text" name="name" id="name" required>
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="3"></textarea>
            <label for="price">Price</label>
            <input type="number" name="price" id="price" step="0.5" required>

            <label for="image_url">Image</label>
            <input type="file" name="image_url" id="image_url" accept="image/*" required>
            <button type="submit">Add Product</button>
        </form>

    </div>
</body>

</html>