<?php

require 'db.php';

$sql = "SELECT products.*, categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.category_id";
$result = $conn->query($sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

header('Content-Type: application/json; charset=utf-8');
http_response_code(200);
echo json_encode($products);