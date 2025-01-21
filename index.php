<?php
session_start();
include "includes/db.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>The Coffee House</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            line-height: 1.6;
            background-color: #EEEEEE;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            /* Full width container */
            max-width: 1200px;
            /* Limit max width */
            margin: 0 auto;
            padding: 20px 10px;
            /* Adjusted padding for responsiveness */
        }

        /* Header Styles */
        .header {
            background-color: azure;
            color: black;
            padding: 10px 0;
        }

        .top_head {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 20px;
            gap: 100px;
        }

        .bottom_head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .menu {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .menu-item {
            list-style-type: none;
            margin-right: 20px;
        }

        .menu-item a {
            text-decoration: none;
            color: black;
            padding: 10px;
            transition: background-color 0.3s ease;
        }

        .menu-item a:hover {
            background-color: #555;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #333;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: #fff;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .menu-item:hover .dropdown-content {
            display: block;
        }

        /* Main Styles */
        .main {
            margin: 0 auto;
            width: 100%;
            max-width: 1200px;
            padding: 20px 10px;
        }

        .products-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px;
        }

        .product:hover {
            transform: scale(1.05);
        }

        .product {
            width: 265px;
            /* Độ rộng của sản phẩm */
            height: auto;
            min-height: 500px;
            /* Chiều cao tự động, tùy theo nội dung */
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 10px;
            padding: 10px;
            background-color: white;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            position: relative;
            float: left;
            overflow: hidden;
            /* Ẩn phần vượt quá khung */
            flex: 1 0 260px;
            /* Đảm bảo sản phẩm có đủ không gian và không bị tràn lề */
        }

        .product img {
            max-width: 100%;
            /* Chiều rộng hình ảnh tối đa */
            height: auto;
            /* Chiều cao tự động, tùy theo nội dung */
            margin-bottom: 15px;
        }

        .product h2 {
            font-size: 1.2em;
            margin: 10px 0;
            overflow: hidden;
            /* Ẩn phần vượt quá khung */
            text-overflow: ellipsis;
            /* Hiển thị dấu chấm (...) nếu văn bản quá dài */
            /* Ngăn không xuống dòng */
        }

        .product p {
            margin: 5px 0;
            max-height: 80px;
            /* Chiều cao tối đa của mô tả sản phẩm */
            overflow: hidden;
            /* Ẩn phần vượt quá khung */
        }

        .product button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }

        .product button:hover {
            background-color: #555;
        }

        .login-message {
            color: #f00;
            margin-top: 10px;
        }

        .login-cart {
            position: absolute;
            bottom: 15px;
            left: 0;
            right: 0;
        }

        /* Footer Styles */
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            width: 100%;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>

<body>

    <header>

        <div class="header">

            <div class="top_head ">
                <div> <img src="./images/diachi.png" alt="" width="15px"> 129 Stores Nationwide</div>
                <div> <img src="./images/dienthoai.png" alt="" width="15px"> Hotline: 1900.9999</div>

            </div>
            <div class="bottom_head container">
                <div class="logo">
                    <h2>The Coffee House</h2>
                </div>
                <?php
                include "includes/db.php";

                // Fetch top-level menu items
                $queryMenu = "SELECT * FROM tblmenu WHERE ParentMenuId = -1";
                $resultMenu = mysqli_query($conn, $queryMenu);
                ?>


                <ul class="menu">
                    <?php while ($rowMenu = mysqli_fetch_assoc($resultMenu)) {
                        $queryChild = "SELECT * FROM tblmenu WHERE ParentMenuId =" . $rowMenu['MenuID'];
                        $resultChild = mysqli_query($conn, $queryChild);
                        $isChild = mysqli_num_rows($resultChild) > 0;
                    ?>
                        <li class="menu-item">
                            <a href="<?php echo $rowMenu['UrlControl']; ?>"><?php echo $rowMenu['Name']; ?></a>
                            <?php if ($isChild) { ?>
                                <div class="dropdown-content">
                                    <?php while ($rowChild = mysqli_fetch_assoc($resultChild)) { ?>
                                        <a href="<?php echo $rowChild['UrlControl']; ?>"><?php echo $rowChild['Name']; ?></a>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </li>
                    <?php } ?>

                    <?php if (isset($_SESSION['username'])) { ?>
                        <li class="menu-item"><a href="account.php">Account</a></li>
                        <li class="menu-item"><a href="logout.php">Logout</a></li>
                    <?php } else { ?>
                        <li class="menu-item"><a href="login.php">Login</a></li>
                        <li class="menu-item"><a href="register.php">Register</a></li>
                    <?php } ?>
                </ul>

            </div>

        </div>

    </header>

    <?php
    include('includes/banner.php');
    ?>
    <main>
        <div class="main">
            <div class="products-container">
                <!-- <div class="main-product">
                    <img src="images/traicayxay.png" alt="" width="145px">
                </div> -->
                <div class="products">
                    <?php
                    include('includes/db.php');
                    $result = $conn->query("SELECT * FROM products");
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='product'>";
                        echo "<img src='images/" . $row['image_url'] . "' alt='" . $row['name'] . "'>";
                        echo "<h2>" . $row['name'] . "</h2>";
                        echo "<p>" . $row['description'] . "</p>";
                        echo "<p class='price'>$" . $row['price'] . "</p>";
                        echo "<div class='login-cart'>";
                        if (isset($_SESSION['username'])) {
                            echo "<button onclick='addToCart(" . $row['id'] . ")'>Add to Cart</button>";
                        } else {
                            echo "<p class='login-message'>Login required to add to cart</p>";
                        }
                        echo "</div>";

                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> The Coffee House</p>
    </footer>
    <script src="js/scripts.js"></script>
</body>