<?php
$customer_id = $_GET['id'];

$conn = mysqli_connect("localhost", "root", "", "the_coffee_house");

if (!$conn) {
    echo "Ket noi khong thanh cong" . mysqli_connect_error();
} else {
    $query = "DELETE FROM customers WHERE customer_id = '" . $customer_id . "'";

    $result = mysqli_query($conn, $query);
    if ($result) {
        header('location: manage_customers.php');
    } else {
        echo 'Lỗi xóa dữ liệu';
    }
}
?>