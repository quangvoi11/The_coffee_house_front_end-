 <!-- <?php
$noidung="";
include"db_connection.php";
if(isset($_POST["btn1"])){
    $noidung = trim($_POST['noidung']);
   if(empty($noidung)){
    echo 'Vui lòng nhập thông tin tìm kiếm sản phẩm!! ';
   }
   else {
    $sql = "SELECT * FROM products WHERE Name LIKE '%$noidung%' ";
   $result= mysqli_query($conn, $sql);
   if(mysqli_num_rows($result) > 0){
    if ($result->num_rows > 0) {
        echo"Thong tin san pham tim kiem";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><img width=200px height=200px src='img/product/" . $row['ImageURL'] . "' class='hinhdaidien'></td>";
            echo "<td>" . $row['Name'] . "</td>";
            echo "<td>" . $row['Description'] . "</td>";
            echo "<td>" . $row['Price'] . "</td>";
            echo "<td><input type='number' class='form-control' id='quantity_" . $row['ProductID'] . "' name='quantity' min='1' value='1'></td>";
            echo "<td>";
            echo "<a href='manage.php?this_id=" . $row['ProductID'] . "' class='btn btn-danger'>Xóa</a> ";
            echo "<button class='btn btn-success' onclick='addToCart(" . $row['ProductID'] . ")'>Thêm vào giỏ hàng</button>";
            echo "</td>";
            echo "</tr>"; 
        }
   }
}
}
}
?> -->