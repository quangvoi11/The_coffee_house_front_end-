<?php
include("db_connection.php");
// Lấy dữ liệu sản phẩm từ bảng products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/fo...in.css" />

    <style>
        .hinhdaidien {
            padding: 0%;
            margin: top;
        }

        /* body {
            font-family: Arial, sans-serif;
            background-color: bisque;
            padding: 20px;
        } */
        /* .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        } */
        h1,
        h2 {
            text-align: center;
            margin: 0;
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
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            padding: 20px;
            background-color: #f2f2f2;
        }

        img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            margin-left: 10px;
            width: 100px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-danger {
            background-color: red;
        }

        .btn-success {
            width: auto;
            background-color: #28a745;
            text-decoration: none;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .btn-cart {
            background-color: #28a745;
            color: yellow;
            padding: 10px 20px;
            border-radius: 4px;
            text-align: center;
            display: block;
            margin: 20px auto;
            text-decoration: none;
        }

        h3 {
            text-align: center;
        }

        th {
            text-align: center;
        }

        a {
            text-decoration: none;
        }


        .btn2:hover {
            border-radius: 20px;
            color: green;
        }

        .ip2 {
            border-radius: 20px;
            padding: 5px;
        }
    </style>
</head>

<body>
    <div class="container_box">

        <div class="container">
            <h1>Danh sách sản phẩm</h1>
            <form method="post" class="name">
                <h3>
                    <input type="text" name="noidung" class="ip2">
                    <button type="submit" name="btn2" class="btn2">Tim kiem</button>
                </h3>
            </form>

            <?php
            $noidung = "";
            if (isset($_POST["btn2"])) {
                $noidung = trim($_POST['noidung']);
                if (empty($noidung)) {
                    echo '<h3>Vui lòng nhập thông tin tìm kiếm sản phẩm!!</h3>';
                } else {

                    $sql = "SELECT * FROM products WHERE Name LIKE '%$noidung%'";
                    $result_search = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result_search) > 0) {
                        echo "<h3>Thông tin Sản phẩm được tìm thấy!</h3>";
            ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Ảnh Sản Phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Mô tả</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stt = 1;
                                while ($row = $result_search->fetch_assoc()) {

                                    echo "<tr>";
                                    echo "<td>" . $stt . "</td>";
                                    echo "<td><img width=200px height=200px src='img/product/" . $row['imageurl'] . "' class='hinhdaidien'></td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['description'] . "</td>";
                                    echo "<td>" . $row['price'] . "</td>";
                                    echo "<td><input type='number' class='form-control' id='quantity_" . $row['id'] . "' name='quantity' min='1' value='1'></td>";


                                    echo    "<td>";
                                    echo "<button class='btn btn-success' onclick='addToCart(" . $row['id'] . ")'>Thêm </button>";
                                    echo "</td>";
                                    echo "</tr>";
                                    $stt++;
                                }
                                ?>
                            </tbody>
                        </table>
            <?php
                    } else {
                        echo "<h3>Không có sản phẩm nào được tìm thấy!<h3>";
                    }
                }
            }
            ?>


            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Ảnh Sản Phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Mô tả</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th colspan="2">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {

                        $stt = 1;
                        while ($row = $result->fetch_assoc()) {

                            echo "<tr>";
                            echo "<td>" . $stt . "</td>";
                            echo "<td><img width=200px height=200px src='img/product/" . $row['image_url'] . "' class='hinhdaidien'></td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['description'] . "</td>";
                            echo "<td>" . $row['price'] . "</td>";
                            echo "<td><input type='number' class='form-control' id='quantity_" . $row['id'] . "' name='quantity' min='1' value='1'></td>";


                            echo    "<td>";
                            echo "<button class='btn btn-success' onclick='addToCart(" . $row['id'] . ")'>Thêm </button>";
                            echo "</td>";
                            echo "</tr>";
                            $stt++;
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align: center;'>Không có sản phẩm nào</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <a href="view_cart.php" class="btn btn-cart">Giỏ hàng của bạn</a>


        </div>


        <script>
            function addToCart(productID) {
                const userId = 1; // Giả sử người dùng đã đăng nhập với ID = 1
                const quantity = document.getElementById(`quantity_${productID}`).value; // Lấy số lượng từ ô nhập

                fetch('add_to_cart.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `user_id=${userId}&product_id=${productID}&quantity=${quantity}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                    });
            }
        </script>
</body>

</html>

<?php $conn->close(); ?>