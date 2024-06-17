<?php

require 'db.php';

if (isset($_GET['delete_order'])) {
    $order_id_to_delete = $_GET['delete_order'];
    $sql = "DELETE FROM orders WHERE order_id = $order_id_to_delete";

    $conn->query($sql);

    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);
    echo json_encode([
        "response" => "Заказ успешно удален",
    ]);
    exit();
}