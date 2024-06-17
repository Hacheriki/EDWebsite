<?php
session_start();

require 'db.php';

function checkAndUpdateQuantity($conn, $productId, $quantityNeeded) {
    $sql = "SELECT quantity FROM products WHERE product_id = $productId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['quantity'] >= $quantityNeeded) {
            $newQuantity = $row['quantity'] - $quantityNeeded;
            $updateSql = "UPDATE products SET quantity = $newQuantity WHERE product_id = $productId";
            $conn->query($updateSql);
            return true;
        }
    }
    return false;
}

function sendResponseAndExit($statusCode, $text) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code($statusCode);
    $result = [
        "response" => $text,
    ];
    echo json_encode($result);
    $_SESSION['cart'] = array();
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_SESSION['cart'])) {
        sendResponseAndExit(400, "Корзина пуста");
    }

    $allProductsAvailable = true;
    foreach ($_SESSION['cart'] as $id => $qty) {
        if (!checkAndUpdateQuantity($conn, $id, $qty)) {
            $allProductsAvailable = false;
            break;
        }
    }

    if (!$allProductsAvailable) {
        sendResponseAndExit(400,"Извините, один из товаров закончился");
    }

    $productIds = json_encode(array_keys($_SESSION['cart']));
    $productCounts = json_encode(array_values($_SESSION['cart']));
    $totalPrice = $_POST['total_price'];
    $clientPhone = $_POST['client_phone'];


    $orderStmt = $conn->prepare("INSERT INTO orders (product_ids, overall_price, client_phone, product_counts) VALUES (?, ?, ?, ?)");
    $orderStmt->bind_param("siss", $productIds, $totalPrice, $clientPhone, $productCounts);
    $orderStmt->execute();
    $newOrderId = $orderStmt->insert_id;

    sendResponseAndExit(200, "Заказ успешно создан! Номер вашего заказа: " . $newOrderId);
}
?>