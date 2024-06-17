<?php
session_start();
require 'db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$productDetails = array();
$totalPrice = 0;

foreach (array_keys($cartItems) as $productId) {
    $sql = "SELECT name, price FROM products WHERE product_id = $productId";
    $result = $conn->query($sql);
    $singleProductDetails = [];
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $singleProductDetails['id'] = $productId;
        $singleProductDetails['quantity'] = $cartItems[$productId];
        $singleProductDetails['totalItemPrice'] = $row['price'] * $cartItems[$productId];
        $singleProductDetails['name'] = $row['name'];
        $singleProductDetails['price'] = $row['price'];
        $productDetails[] = $singleProductDetails;
        $totalPrice += ($row['price'] * $cartItems[$productId]);
    }
}

header('Content-Type: application/json; charset=utf-8');
http_response_code(200);
$result = [
    "totalPrice" => $totalPrice,
    "products" => $productDetails
];
echo json_encode($result);