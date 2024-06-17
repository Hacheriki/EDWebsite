<?php

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = $_POST['category_name'];

    $sql = "INSERT INTO categories (name) VALUES ('$category_name')";
    $conn->query($sql);


    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);
    echo json_encode([
        "response" => "Категория успешно создана",
    ]);
}