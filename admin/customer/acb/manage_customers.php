<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khách hàng thân thiết</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">

            <div class = "main-content">
            <div class = "header1">
                <h1>Ghi chú khách hàng</h1>
                <form method="POST" class="search">
                    <div class="formSearch">
                        <span class="text-search">Tìm kiếm: </span>
                        <input type="text" class="input-search" name="txtKeyword" id="search-input" placeholder="Nhập khách hàng muốn tìm kiếm" />
                    </div>
                    <div>
                        <a style="margin-top: 8px;" href="create_customer.php" class="linkCreate">Thêm mới</a>
                    </div>
                </form>
            </div>        
    <?php
        $conn = mysqli_connect("localhost", "root", "", "the_coffee_house");

        if (!$conn) {
            echo "Ket noi khong thanh cong" . mysqli_connect_error();
        } else {
        $query = "SELECT * FROM customers";
        $result = mysqli_query($conn, $query);
        $num = 1;
        if (mysqli_num_rows($result) > 0) {
            echo '<table id="tbMain">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên khách hàng</th>
                    <th>Ghi chú</th>

                    <th colspan="2">Thao tác</th>
                </tr>
            </thead>
            <tbody>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>
                        <td>' . $row["customer_id"] . '</td>
                        <td>' . $row["name"] . '</td>
                        <td>' . $row["note"] . '</td>

                        <td>
                            <div class="edit-button">
                                <a class="link" href="edit_customer.php?id= ' . $row["customer_id"] . '">Sửa</a>
                                <a class="link" onclick="return confirm (\'Bạn có muốn xóa hay không?\')" href="delete_customer.php?id=' . $row["customer_id"] . '">Xóa</a>
                                <a class = "link" href="note_edit.php?id=' . $row["customer_id"] . '">Thêm ghi chú</a>
                            </div>
                        </td>
                    </tr>';
                }
                echo '</tbody>
                    </table>';
                }
            }
        ?>
        
    <!-- #search -->
    <?php

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $keyword = $_POST['txtKeyword'];
        $conn = mysqli_connect("localhost", "root", "", "the_coffee_house");


        if (!$conn) {
            echo "Ket noi khong thanh cong" . mysqli_connect_error();
        } else {
            $query = "SELECT * FROM customers WHERE name like '%" . $keyword . "%' OR customer_id like '%" . $keyword . "%'";

            $result = mysqli_query($conn, $query);

            $num = 1;
            if (mysqli_num_rows($result) > 0) {
                echo '<table id="tbMain">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên khách hàng</th>
                        <th>Ghi chú</th>

                        <th colspan="2">Thao tác</th>
                    </tr>
                </thead>
                <tbody>';

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<script>
                        var tbMain = document.getElementById(\'tbMain\');
                        tbMain.style.display = \'none\';
                    </script>';

                    echo '<tr>
                        <td>' . $row["customer_id"] . '</td>
                        <td>' . $row["name"] . '</td>
                        <td>' . $row["note"] . '</td>

                        <td>
                            <div class="edit-button">
                                <a class="link" href="edit_customer.php?id= ' . $row["customer_id"] . '">Sửa</a>
                                <a class="link" onclick="return confirm (\'Bạn có muốn xóa hay không?\')" href="delete_customer.php?id=' . $row["customer_id"] . '">Xóa</a>
                                <a class = "link" href="note_edit.php?id=' . $row["customer_id"] . '">Thêm ghi chú</a>
                            </div>
                        </td>
                    </tr>';
                }
                echo '</tbody>
            </table>';
            }
        }
    }

    ?>
        </div>
    </div>
    </body>
</html>