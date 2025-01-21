<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_item_id = $_POST['cart_item_id'];

    $sql = "DELETE FROM cart_items WHERE cart_item_id=$cart_item_id";

    if ($conn->query($sql) === TRUE) {
        echo "Xóa sản phẩm khỏi giỏ hàng thành công!";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

?>