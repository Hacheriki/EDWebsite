<?php

require "db.php";

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql ="DELETE FROM products WHERE product_id = $id";
    $conn->query($sql);

    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);
    echo json_encode([
        "response" => "Товар успешно удален",
    ]);
}
?>