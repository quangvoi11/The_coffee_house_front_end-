<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header('Location: ../../login.php');
    exit();
}

// Kiểm tra vai trò của người dùng
if ($_SESSION['role'] != 'admin') {
    // Nếu không phải admin, chuyển hướng đến trang không phù hợp
    header('Location: ../../account.php'); // Hoặc trang khác tùy ý
    exit();
}
?>
<?php
// Kết nối tới cơ sở dữ liệu
include "includes_User/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    $query = "UPDATE users SET email='$email', full_name='$full_name', role='$role', status='$status' WHERE user_id=$user_id";

    if (mysqli_query($conn, $query)) {
        header("location:viewUser.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$id = $_GET['id'];
$query = "SELECT * FROM users WHERE user_id = $id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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
        select {
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
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Edit User</h2>
            <div class="nav-links">
                <a href="viewUser.php">User</a>
            </div>
        </div>
        <form action="edit_user.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">

            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" readonly>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>">

            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo $user['full_name']; ?>">

            <label for="role">Role</label>
            <select id="role" name="role">
                <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                <option value="employee" <?php if ($user['role'] == 'employee') echo 'selected'; ?>>Employee</option>
                <option value="customer" <?php if ($user['role'] == 'customer') echo 'selected'; ?>>Customer</option>
            </select>

            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="active" <?php if ($user['status'] == 'active') echo 'selected'; ?>>Active</option>
                <option value="inactive" <?php if ($user['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
            </select>

            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>

</html>