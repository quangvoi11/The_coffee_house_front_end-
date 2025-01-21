
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* .container {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            min-height: 100vh;
        } */

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
            <h1>Product Management</h1>

            <div class="nav-links">
                <a href="../category/manage_categories.php">Category</a>
                <a href="viewProduct.php">Product</a>
                <a href="add_product.php">Add Product</a>
            </div>
        </div>

        <div class="search-container">
            <form action="" method="GET">
                <input type="text" name="search" placeholder="Search by product name" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <select name="category">
                    <option value="">All Categories</option>
                    <?php
                    include 'includes_Product/db_product.php';
                    $category_query = "SELECT * FROM Categories";
                    $category_result = mysqli_query($conn, $category_query);
                    while ($category_row = mysqli_fetch_assoc($category_result)) {
                        $selected = isset($_GET['category']) && $_GET['category'] == $category_row['CategoryID'] ? 'selected' : '';
                        echo '<option value="' . $category_row['CategoryID'] . '" ' . $selected . '>' . $category_row['CategoryName'] . '</option>';
                    }
                    ?>
                </select>
                <button type="submit">Search</button>
            </form>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    include 'includes_Product/db_product.php';

                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                    $category = isset($_GET['category']) ? $_GET['category'] : '';

                    $search_query = "WHERE 1=1";

                    if ($search) {
                        $search_query .= " AND p.name LIKE '%$search%'";
                    }

                    if ($category) {
                        $search_query .= " AND p.category_id = '$category'";
                    }

                    $query = "SELECT p.*, c.CategoryName 
                              FROM Products p
                              JOIN Categories c ON p.category_id = c.CategoryID
                              $search_query";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td><img src="images_Product/' . $row['image_url'] . '" alt="Product Image"></td>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td>' . $row['description'] . '</td>';
                        echo '<td>' . $row['price'] . '</td>';
                        echo '<td>' . $row['CategoryName'] . '</td>';
                        echo '<td class="actions">
                                <a class="edit" href="edit_product.php?id=' . $row['id'] . '">Edit</a>
                                <a class="delete" href="delete_product.php?id=' . $row['id'] . '">Delete</a>
                              </td>';
                        echo '</tr>';
                    }

                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>