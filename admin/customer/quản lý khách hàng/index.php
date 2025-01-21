<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List</title>
    <style>
        h1 {
            margin: 0;
        }

        .search {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .text-search {
            color: blue;
            font-size: medium;
            font-weight: bold;
            margin: 10px;
        }

        .formSearch {
            display: flex;
            align-items: center;
        }

        .input-search {
            padding: 10px 20px;
            border: 2px solid blue;
            border-radius: 5px;
            font-size: 1em;
            width: 250px;
            transition: border-color 0.3s ease;
        }

        .input-search:focus {
            outline: none;
            border-color: #4169e1;
        }

        .container {
            margin: 0px auto;
            width: 1200px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .edit-button a {
            text-decoration: none;
            color: #007bff;
            margin-right: 10px;
        }

        .link {
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            padding: 8px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .link:hover {
            background-color: #0056b3;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px;
            margin-top: 10px;
            border-radius: 4px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .success-message:hover {
            background-color: #c3e6cb;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 align="center">DANH SÁCH KHÁCH HÀNG</h1>
        <div class="main-content">
            <form method="POST" class="search">
                <div class="formSearch">
                    <span class="text-search">Tìm kiếm: </span>
                    <input type="text" class="input-search" name="txtKeyword" id="search-input" placeholder="Nhập khách hàng muốn tìm kiếm" />
                </div>
            </form>

            <?php
            $conn = mysqli_connect("localhost", "root", "", "the_coffee_house");
            if (!$conn) {
                echo "Ket noi khong thanh cong" . mysqli_connect_error();
            } else {
                $query = "SELECT * FROM customers";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    echo '<table>';
                    echo '<tr><th>ID</th><th>Tên</th><th>Email</th><th>Địa chỉ</th><th>SDT</th><th>Ngày tạo</th><th>Ngày cập nhật</th><th>Hành động</th></tr>';
                    while ($row = mysqli_fetch_assoc($result)) {
                        
                        echo '<tr>';
                        echo '<td>' . $row["customer_id"] . '</td>';
                        echo '<td>' . $row["name"] . '</td>';
                        echo '<td>' . $row["email"] . '</td>';
                        echo '<td>' . $row["address"] . '</td>';
                        echo '<td>' . $row["phone"] . '</td>';
                        echo '<td>' . $row["created_at"] . '</td>';
                        echo '<td>' . $row["updated_at"] . '</td>';
                        echo '<td class="edit-button">';
                        echo '<a class="link" href="edit_customer.php?id=' . $row["customer_id"] . '">Sửa</a>';
                        echo '<a class="link" onclick="return confirm(\'Bạn có muốn xóa hay không?\')" href="delete_customer.php?id=' . $row["customer_id"] . '">Xóa</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                }
            }
            ?>
        </div>
    </div>

    <div class="container">
    <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $keyword = $_POST['txtKeyword'];
            $conn = mysqli_connect("localhost", "root", "", "the_coffee_house");
            if (!$conn) {
                echo "Ket noi khong thanh cong" . mysqli_connect_error();
            } else {
                $query = "SELECT * FROM customers WHERE name like '%" . $keyword . "%' OR customer_id like '%" . $keyword . "%'";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    echo '<table>';
                    echo '<tr><th>ID</th><th>Tên</th><th>Email</th><th>Địa chỉ</th><th>SDT</th><th>Ngày tạo</th><th>Ngày cập nhật</th><th>Hành động</th></tr>';
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<script>
                            var tbMain = document.getElementById(\'tbMain\');
                            tbMain.style.display = \'none\';
                        </script>';
                        echo '<tr>';
                        echo '<td>' . $row["customer_id"] . '</td>';
                        echo '<td>' . $row["name"] . '</td>';
                        echo '<td>' . $row["email"] . '</td>';
                        echo '<td>' . $row["address"] . '</td>';
                        echo '<td>' . $row["phone"] . '</td>';
                        echo '<td>' . $row["created_at"] . '</td>';
                        echo '<td>' . $row["updated_at"] . '</td>';
                        echo '<td class="edit-button">';
                        echo '<a class="link" href="edit_customer.php?id=' . $row["customer_id"] . '">Sửa</a>';
                        echo '<a class="link" onclick="return confirm(\'Bạn có muốn xóa hay không?\')" href="delete_customer.php?id=' . $row["customer_id"] . '">Xóa</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                } else {
                    echo '<div class="success-message">Không tìm thấy khách hàng nào.</div>';
                }
            }
        }
        ?>
    </div>
</body>

</html>