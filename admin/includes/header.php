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

        .container {
            width: 1200px;
            margin: 0 auto;
            padding: 20px 0;
            display: flex;
        }

        /* Header Styles */
        .header {
            background-color: whitesmoke;
            color: black;
            padding: 10px 0;
        }

        .top_head {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            padding: 0 20px;
        }

        .bottom_head {
            display: flex;
            justify-content: space-evenly;
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
            width: 80%;
            padding: 20px 0;
        }


        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .product {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }

        .product img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .product h2 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .product p {
            color: #666;
            margin-bottom: 10px;
        }

        .product .price {
            font-weight: bold;
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
            bottom: 0;
        }

        /* Footer Styles */
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            bottom: 0;
            position: relative;
            width: 100%;
        }

        footer p {
            margin: 0;
        }

        .container {
            width: 1200px;
        }
        .logo {
            text-align: left;
            width: 20%;
        }
    </style>
</head>

<body>

    <header>

        <div class="header">

                <div class="top_head container">
                    <div> <img src="./images/diachi.png" alt="" width="20px"> 129 Cửa hàng khắp cả nước</div>
                    <div> <img src="./images/dienthoai.png" alt="" width="20px"> Đặt hàng: 1800.9999</div>

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