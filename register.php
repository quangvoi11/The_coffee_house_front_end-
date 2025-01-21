<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('includes/db.php');
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];

    $query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<script>alert("Username or Email already exists!");</script>';
    } else {
        $query = "INSERT INTO users (username, password, email, full_name, role, status) VALUES ('$username', '$password', '$email', '$full_name', 'customer', 'active')";
        if (mysqli_query($conn, $query)) {
            header('Location: login.php');
            exit();
        } else {
            echo "<p>Error: " . mysqli_error($conn) . "</p>";
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Coffee House - Register</title>
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

        /* Main Styles */
        main {
            padding: 20px 0;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
            text-align: center;
        }

        .register-form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .register-form h2 {
            font-size: 1.5em;
            margin-bottom: 20px;
            text-align: center;
        }

        .register-form input[type="text"],
        .register-form input[type="password"],
        .register-form input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .register-form button {
            display: block;
            width: 100%;
            padding: 10px 0;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .register-form button:hover {
            background-color: #555;
        }

        /* Footer Styles */
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
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

                <ul class="menu">
                    <?php
                    include "includes/db.php";

                    // Tìm nạp các mục menu cấp cao nhất
                    $queryMenu = "SELECT * FROM tblmenu WHERE ParentMenuId = -1";
                    $resultMenu = mysqli_query($conn, $queryMenu);

                    while ($rowMenu = mysqli_fetch_assoc($resultMenu)) {

                    ?>
                        <li class="menu-item">
                            <a href="<?php echo $rowMenu['UrlControl']; ?>"><?php echo $rowMenu['Name']; ?></a>

                            <?php
                            $queryChild = "SELECT * FROM tblmenu WHERE ParentMenuId =" . $rowMenu['MenuID'];
                            $resultChild = mysqli_query($conn, $queryChild);
                            $isChild = mysqli_num_rows($resultChild) > 0;

                            if ($isChild) { ?>
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
            <div class="register-form">
                <form action="register.php" method="POST">
                    <h2>Register</h2>
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="text" name="full_name" placeholder="Full Name" required>
                    <button type="submit">Register</button>
                </form>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> The Coffee House</p>
    </footer>
    <script src="js/scripts.js"></script>
</body>

</html>