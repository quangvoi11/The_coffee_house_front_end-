<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tính bảng lương nhân viên</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
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

        .table-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .table-container h3 {
            font-size: 2em;
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow-x: auto;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
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

        .add-button {
            background-color: #2c3e50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 1em;
            margin-top: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .add-button:hover {
            background-color: #34495e;
        }

        .assign-links {
            display: block;
            margin: 10px 0;
            font-size: 1.1em;
            color: #2c3e50;
            text-decoration: none;
        }

        .assign-links:hover {
            text-decoration: underline;
        }


        form.inline {
            display: inline;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            font-size: 1em;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        input, select, button {
            padding: 12px;
            margin-bottom: 20px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fafafa;
            transition: border-color 0.3s ease;
            display: block;
            width: 100%;
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
    
    <div class="content">
    <div class="header">
            <h2>Bảng lương nhân viên</h2>
            <div class="nav-links">
            <a href="viewEmployee.php">Quản lý nhân viên</a>
            <a href="/the_coffee_house/admin/employee/theodoi.php">Theo dõi giờ làm</a>
            <a href="/the_coffee_house/admin/employee/danhgia.php">Đánh giá hiệu suất</a>
            <a href="/the_coffee_house/admin/employee/bangluong.php">Bảng lương nhân viên</a>
            </div>
         </div>
       
        <div class="table-container">
            <h3>Danh sách bảng lương</h3>
            <table>
                <thead>
                    <tr>
                        <th>Mã nhân viên</th>
                        <th>Họ và tên</th>
                        <th>Ngày </th>
                        <th>Lương cơ bản</th>
                        <th>Giờ làm</th>
                        <th>Lương</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                
                    $conn = new mysqli("localhost", "root", "", "the_coffee_house");
                    if ($conn->connect_error) {
                        die("Kết nối không thành công: " . $conn->connect_error);
                    }

                    $sql = "SELECT employee_id, name, date, salary, hours_worked, total_salary FROM employee_salary";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>
                                    <td>' . $row["employee_id"] . '</td>
                                    <td>' . $row["name"] . '</td>
                                    <td>' . $row["date"] . '</td>
                                    <td>' . $row["salary"] . '</td>
                                    <td>' . $row["hours_worked"] . '</td>
                                    <td>' . $row["total_salary"] . '</td>
                                </tr>';
                        }
                    } else {
                        echo "<tr><td colspan='6'>Không có dữ liệu</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
