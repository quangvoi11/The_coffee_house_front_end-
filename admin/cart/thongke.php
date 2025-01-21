<?php
include("db_connection.php");

// Khởi tạo biến lưu kết quả truy vấn
$kq_giohang = null;
$kq_nhaphang = null;
$kq_luong=null;

// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnloc'])) {
    $tg = $_POST['txttg'];

    // Truy vấn tổng tiền từ hóa đơn giỏ hàng
    $sql_giohang = "SELECT SUM(total_amount) as 'Tongtien' FROM `doanhthugiohang` WHERE date_time LIKE '%$tg%'";
    $kq_giohang = mysqli_query($conn, $sql_giohang);

    // Truy vấn tổng tiền từ hóa đơn nhập hàng
    $sql_nhaphang = "SELECT SUM(import_money) as 'Tongtien' FROM `warehouses` WHERE import_time LIKE '%$tg%'";
    $kq_nhaphang = mysqli_query($conn, $sql_nhaphang);
    //truy vấn lươnh từ bảng lương nhân viên
    $sql_luong = "SELECT SUM(total_salary) as 'Tongtien' FROM `employee_salary` WHERE date LIKE '%$tg%'";
    $kq_luong = mysqli_query($conn, $sql_luong);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doanh thu</title>
    <style>

        form {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .hidden {
            display: none;
        }
    </style>
    <script>
        function chon() {
            var method = document.getElementById("filter_method").value;
            if (method == "ngay") {
                document.getElementById("ngay_form").classList.remove('hidden');
                document.getElementById("thang_form").classList.add('hidden');
                document.getElementById("nam_form").classList.add('hidden');
            } else if (method == "thang") {
                document.getElementById("ngay_form").classList.add('hidden');
                document.getElementById("thang_form").classList.remove('hidden');
                document.getElementById("nam_form").classList.add('hidden');
            } else if (method == "nam") {
                document.getElementById("ngay_form").classList.add('hidden');
                document.getElementById("thang_form").classList.add('hidden');
                document.getElementById("nam_form").classList.remove('hidden');
            } else {
                document.getElementById("ngay_form").classList.add('hidden');
                document.getElementById("thang_form").classList.add('hidden');
                document.getElementById("nam_form").classList.add('hidden');
            }
        }
    </script>
</head>
<body>
    <form action="" method="get">
        <select name="filter_method" id="filter_method" onchange="chon()">
            <option value="">---Phương Thức Lọc---</option>
            <option value="ngay">Lọc theo ngày</option>
            <option value="thang">Lọc theo tháng</option>
            <option value="nam">Lọc theo năm</option>
        </select>
    </form>

    <!-- Form lọc theo ngày -->
    <form action="" method="post" id="ngay_form" class="hidden">
        Ngày: <input type="date" name="txttg">
        <input type="submit" name="btnloc" value="Lọc">
    </form>

    <!-- Form lọc theo tháng -->
    <form action="" method="post" id="thang_form" class="hidden">
        Tháng: <input type="month" name="txttg">
        <input type="submit" name="btnloc" value="Lọc">
    </form>

    <!-- Form lọc theo năm -->
    <form action="" method="post" id="nam_form" class="hidden">
        Năm: <input type="text" name="txttg">
        <input type="submit" name="btnloc" value="Lọc">
    </form>
    
    <!-- Bảng hiển thị hóa đơn giỏ hàng -->
    <h3>Hóa đơn giỏ hàng</h3>
    <table>
        <thead>
            <tr>
                <th>Thời Gian</th>
                <th>Tổng Tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($kq_giohang && mysqli_num_rows($kq_giohang) > 0) {
                $row = mysqli_fetch_assoc($kq_giohang);
                echo "<tr>";                  
                echo "<td>" . htmlspecialchars($tg) . "</td>";                  
                echo "<td>" . htmlspecialchars($row['Tongtien']) . "</td>";
                echo "</tr>";
            } else {
                echo "<tr><td colspan='2' style='text-align: center;'>Không có hóa đơn nào</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Bảng hiển thị hóa đơn nhập hàng -->
     <br>
    <h3>Hóa đơn nhập hàng</h3>
    <table>
        <thead>
            <tr>
                <th>Thời Gian</th>
                <th>Tổng Tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($kq_nhaphang && mysqli_num_rows($kq_nhaphang) > 0) {
                $row = mysqli_fetch_assoc($kq_nhaphang);
                echo "<tr>";                  
                echo "<td>" . htmlspecialchars($tg) . "</td>";                  
                echo "<td>" . htmlspecialchars($row['Tongtien']) . "</td>";
                echo "</tr>";
            } else {
                echo "<tr><td colspan='2' style='text-align: center;'>Không có hóa đơn nào</td></tr>";
            }
            ?>
        </tbody>
    </table>
      <!-- Bảng hiển thị lương chi cho nhân viên -->
       <br>
      <h3>Bảng lương Nhân Viên</h3>
    <table>
        <thead>
            <tr>
                <th>Thời Gian</th>
                <th>Tổng Tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($kq_luong && mysqli_num_rows($kq_luong) > 0) {
                $row = mysqli_fetch_assoc($kq_luong);
                echo "<tr>";                  
                echo "<td>" . htmlspecialchars($tg) . "</td>";                  
                echo "<td>" . htmlspecialchars($row['Tongtien']) . "</td>";
                echo "</tr>";
            } else {
                echo "<tr><td colspan='2' style='text-align: center;'>Không có nhân viên nào nhận lương !</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
