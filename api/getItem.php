<?php

require 'db.php';

$itemId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($itemId <= 0) {
    die("Неверный id товара");
}

$sql = "SELECT * FROM products WHERE product_id = $itemId";
$result = $conn->query($sql);

if ($result->num_rows <= 0) {
    die("Товар не найден");
}

$item = $result->fetch_assoc();

header('Content-Type: application/json; charset=utf-8');
http_response_code(200);
echo json_encode($item);