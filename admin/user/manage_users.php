<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
        }

        /* .container {
            width: 90%;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
             background-color: white;
            padding: 20px;
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

        .search-container input[type="text"] {
            padding: 10px;
            font-size: 16px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f7f7f7;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

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

        }

        .delete {
            border-bottom: 1px solid #3498db;

        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>User Management</h1>
            <div class="nav-links">
                <a href="viewUser.php">User</a>
                <a href="add_user.php">Add user</a>
            </div>
        </div>
        <div class="search-container">
            <form action="" method="GET">
                <input type="text" name="search" placeholder="Search by username or email" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit">Search</button>
            </form>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "includes_User/db.php";

                    $search = isset($_GET['search']) ? $_GET['search'] : '';

                    // Tạo câu truy vấn dựa vào giá trị của $search
                    $query = "SELECT user_id, username, email, full_name, role, status, created_at, updated_at FROM users";
                    if (!empty($search)) {
                        $query .= " WHERE username LIKE '%$search%' OR email LIKE '%$search%'";
                    }

                    $result = mysqli_query($conn, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>" . $row["user_id"] . "</td>
                                    <td>" . $row["username"] . "</td>
                                    <td>" . $row["email"] . "</td>
                                    <td>" . $row["full_name"] . "</td>
                                    <td>" . $row["role"] . "</td>
                                    <td>" . $row["status"] . "</td>
                                    <td>" . $row["created_at"] . "</td>
                                    <td>" . $row["updated_at"] . "</td>
                                    <td class='actions'>
                                        <a class='edit' href='edit_user.php?id=" . $row["user_id"] . "'>Edit</a> 
                                        <a class='delete' href='delete_user.php?id=" . $row["user_id"] . "' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No users found</td></tr>";
                    }

                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>