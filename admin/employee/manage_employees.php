<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên</title>
    <style>
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-top: 20px;
        }

        .search-form {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .search-form input[type="text"] {
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
            margin-right: 10px;
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

        .card {
            float: left;
            max-width: 200px;
            margin: 10px;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: white;
            margin-bottom: 20px;
        }

        .card-avatar {
            text-align: center;
        }

        .card-avatar img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 2px solid #2c3e50;
        }

        .avatar-name {
            color: #0b0b96;
            font-size: large;
            margin-top: 10px;
            text-align: center;
        }

        .avatar-info {
            margin-top: 10px;
        }

        .avatar-info p {
            margin: 5px 0;
            color: #333;
            text-align: center;
        }

        .edit-button {
            margin-top: 10px;
            display: flex;
            justify-content: space-around;
        }

        .edit-button a {
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 5px;
            transition: background-color 0.3s ease;
        }

        .edit-button .link {
            background-color: #3498db;
        }

        .edit-button .link:hover {
            background-color: #2980b9;
        }

        .add-button {
            background-color: #2c3e50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 1em;
            margin: 20px auto;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .add-button:hover {
            background-color: #34495e;
        }

        .add-button a {
            text-decoration: none;
            color: white;
        }

        .info-name {
            overflow: hidden;
            text-overflow: ellipsis;
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

        .header h1 {
            margin: 0;
            font-size: 25px;
            color: #333;
        }
    </style>
</head>

<body>

<div class="container">
        <div class="header">
            <h1>Danh sách nhân viên</h1>

            <div class="nav-links">
            <a href="viewEmployee.php">Quản lý nhân viên</a>
            <a href="/the_coffee_house/admin/employee/theodoi.php">Theo dõi giờ làm</a>
            <a href="/the_coffee_house/admin/employee/danhgia.php">Đánh giá hiệu suất</a>
            <a href="/the_coffee_house/admin/employee/bangluong.php">Bảng lương nhân viên</a>
            </div>
        </div>
       
        
        <div class="">
            <div class="search-form">
                <form method="GET" action="manage_employees.php">
                    <input type="text" name="search" placeholder="Tìm kiếm nhân viên..." required>
                    <button type="submit" class="add-button">Tìm kiếm</button>
                    <button class="add-button"><a style="text-decoration: none; color: white;" href="more.php">Thêm mới</a></button>
                </form>
            </div>

            <br>
            </form>
        </div>

        <div class="cards">
            <?php
            //kết nối cơ sở dữ liệu
            $conn = new mysqli("localhost", "root", "", "the_coffee_house");
            if ($conn->connect_error) {
                echo "Kết nối không thành công: " . mysqli_connect_error();
            }
            // kiểm tra xem truy vấn tìm kiếm có được cc hay không và thoát khỏi truy vấn
            $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
            if ($search) {
                $sql = "SELECT employee_id, name, email, phone_number, position,image, salary FROM employees WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR employee_id LIKE '%$search%'";
            } else {
                $sql = "SELECT employee_id, name, email, phone_number, position,image, salary FROM employees";
            }

            // hiển thị thẻ nhân viên
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $imagePath = $row["image"] ? "uploads/" . $row["image"] : "default.png";
                    // truy vấn và lặp tập kết quả để tạo thẻ nhân viên
                    // hiển thị và cc liên kết cập nhật xóa đánh giá nhân viên
                    echo '<div class="card">
                    <div class="card-avatar">
                        <img src="' . $imagePath . '" alt="avatar" />
                        <p class="avatar-name">' . $row["name"] . '</p>
                    </div>
                    <div class="avatar-info">
                        <p class="info-name">' . $row["email"] . '</p>
                        <p class="info-name">' . $row["phone_number"] . '</p>
                        <p class="info-name">' . $row["position"] . '</p>
                    </div>
                    <div class="edit-button">
                        <a class="link" href="update.php?employee_id=' . $row["employee_id"] . '">Sửa</a>
                        <a class="link" onclick="return confirm(\'Bạn có muốn xóa hay không?\')" href="Delete.php?employee_id=' . $row["employee_id"] . '">Xóa</a>
                    </div>
                    <div class="edit-button">
                        <a class="link" href="evaluate.php?employee_id=' . $row["employee_id"] . '&name=' . $row["name"] . '">Đánh giá</a>
                        <a class="link" href="add_hours.php?employee_id=' . $row["employee_id"] . '&name=' . $row["name"] . '">Theo dõi giờ làm</a>
                    </div>
                    
                  </div>';
                }
            }

            $conn->close();

            ?>
        </div>
    </div>
</body>

</html>