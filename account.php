<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Coffee House - Account</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Global Styles */
        body {
            line-height: 1.6;
            background-color: #EEEEEE;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px 0;
        }

        /* Header Styles */
        .header {
            background-color: #333;
            color: white;
            padding: 10px 0;
            border-bottom: #333 solid 1px;
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
            color: white;
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

        main {
            margin: 0 auto;
            max-width: 80%;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
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
            transition: box-shadow 0.3s ease;
        }

        .product:hover {
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
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
            color: #e67e22;
        }

        .product button {
            padding: 10px 20px;
            background-color: #e67e22;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .product button:hover {
            background-color: #d35400;
        }

        .login-message {
            color: #f00;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        footer p {
            margin: 0;
        }

        .table-container {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        @media (max-width: 768px) {
            .container {
                width: 90%;
            }

            .menu {
                flex-direction: column;
            }

            .menu-item {
                margin: 10px 0;
            }
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


    <main>
        <div class="container">
            <h2>Account Information</h2>
            <?php
            if (isset($_SESSION['username'])) {
                echo "<p>Logged in as: " . $_SESSION['full_name'] . "</p>";
                echo "<div class='table-container'>
                        <h3>User Information</h3>
                        <table>
                            <tr>
                                <th>Username</th>
                                <td>" . $_SESSION['username'] . "</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>" . $_SESSION['email'] . "</td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>" . $_SESSION['role'] . "</td>
                            </tr>
                        </table>
                      </div>";
            } else {
                echo "<p>You are not logged in. Please <a href='login.php'>login</a> or <a href='register.php'>register</a>.</p>";
            }
            ?>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> The Coffee House</p>
    </footer>

    <script src="js/scripts.js"></script>
</body>

</html>