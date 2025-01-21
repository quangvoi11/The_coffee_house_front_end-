<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];


    $result = $conn->query("SELECT * FROM carts WHERE user_id = $user_id");
    if ($result->num_rows == 0) {
        $conn->query("INSERT INTO carts (user_id) VALUES ($user_id)");
        $cart_id = $conn->insert_id;
    } else {
        $row = $result->fetch_assoc();
        $cart_id = $row['cart_id'];
    }

    
    $result = $conn->query("SELECT price FROM products WHERE id = $product_id");
    $row = $result->fetch_assoc();
    $price = $row['price'];

    $stmt = $conn->prepare("INSERT INTO cart_items (cart_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $cart_id, $product_id, $quantity, $price);
    $stmt->execute();

    echo "Đã thêm mới sản phẩm vào giỏ hàng của bạn";
}
?>
