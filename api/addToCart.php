<?php
session_start();

require 'db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

    if ($productId > 0 && $quantity > 0) {
        if (array_key_exists($productId, $_SESSION['cart'])) {
            $_SESSION['cart'][$productId] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }
    }
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);
    $result = [
        "productId" => $productId,
        "quantity" => $quantity
    ];
    echo json_encode($result);
}