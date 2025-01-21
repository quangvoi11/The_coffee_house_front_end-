<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đánh giá hiệu suất nhân viên</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
        }
        
        .content {
            flex-grow: 1;
            padding: 20px;
        }

        .content h2 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .content p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f7f7f7;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .edit-button a {
            text-decoration: none;
            color: white;
            padding: 5px 15px;
            border-radius: 5px;
            margin: 5px;
        }
        .edit-button .link:first-child {
            background-color: green;
        }

        .edit-button .link:nth-child(2) {
            background-color: rgb(232, 122, 20);
        }

        .edit-button .link:last-child {
            background-color: blue;
        }
        .search-form {
            margin-bottom: 20px;
        }

        .search-form input[type="text"] {
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
        }

        .search-form button {
            background-color: #2c3e50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1em;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .search-form button:hover {
            background-color: #34495e;
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

    </style>
</head>

<body>
   
    <div class="content" >

    <div class="header">
            <h2>Bảng đánh giá hiệu suất nhân viên</h2>
            <div class="nav-links">
            <a href="viewEmployee.php">Quản lý nhân viên</a>
            <a href="/the_coffee_house/admin/employee/theodoi.php">Theo dõi giờ làm</a>
            <a href="/the_coffee_house/admin/employee/danhgia.php">Đánh giá hiệu suất</a>
            <a href="/the_coffee_house/admin/employee/bangluong.php">Bảng lương nhân viên</a>
            </div>
         </div>
        
        <div class="search-form">
            <form method="GET" action="danhgia.php">
                <input type="text" name="search" placeholder="Tìm kiếm theo tên nhân viên..." > 
                <button type="submit">Tìm kiếm</button>
            </form>
        </div>

        <div class="container">
            <table>
                <thead>
                    <tr>
                        <th>Mã nhân viên</th>
                        <th>Họ và tên</th>
                        <th>Điểm hiệu suất</th>
                        <th>Nhận xét</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "the_coffee_house");

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $search = isset($_GET['search']) ? $_GET['search'] : '';

                    if (!empty($search)) {
                        $sql = "SELECT id, employee_id, name, performance_score, feedback FROM employee_evaluations WHERE name LIKE '%$search%'";
                    } else {
                        $sql = "SELECT id, employee_id, name, performance_score, feedback FROM employee_evaluations";
                    }

                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["employee_id"] . "</td>
                                    <td>" . $row["name"] . "</td>
                                    <td>" . $row["performance_score"] . "</td>
                                    <td>" . $row["feedback"] . "</td>
                                    <td class='edit-button'>
                                        <a class='link' href='edit_evaluation.php?id=" . $row["id"] . "'>Sửa</a>
                                        <a class='link' href='delete_evaluation.php?id=" . $row["id"] . "' onclick='return confirm(\"Bạn có chắc muốn xóa đánh giá này?\")'>Xóa</a>
                                    </td>
                                   
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Không có đánh giá nào được ghi nhận.</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
