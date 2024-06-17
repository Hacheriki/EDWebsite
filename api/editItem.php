<?php

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $category_id = $_POST['category'];
    $image_url = $_POST['image_url'];
    $is_featured = 0;

    if (isset($_POST['is_featured'])) {
        $is_featured = 1;
    }


    $sql = "UPDATE products SET name = '$name', description = '$description', price = $price, category_id = $category_id, quantity = $quantity, image_url = '$image_url', is_featured = $is_featured WHERE product_id = $product_id";
    $conn->query($sql);

    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);
    echo json_encode([
        "response" => "Товар успешно отредактирован",
    ]);
    exit();
}

