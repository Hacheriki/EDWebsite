<?php

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];
    $image_url = $_POST['image_url'];
    $is_featured = 0;

    if (isset($_POST['is_featured'])) {
        $is_featured = 1;
    }

    $sql = "INSERT INTO products (name, description, price, category_id, quantity, image_url, is_featured) VALUES ('$name', '$description', $price, $category, $quantity, '$image_url', $is_featured)";

    $conn->query($sql);
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);
    echo json_encode([
        "response" => "Товар успешно создан",
    ]);
}
