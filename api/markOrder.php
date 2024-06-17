<?php

require 'db.php';

if (isset($_GET['mark_order_done'])) {
    $order_id_to_mark = $_GET['mark_order_done'];
    $sql = "UPDATE orders SET is_done = true WHERE order_id = $order_id_to_mark";
    $conn->query($sql);

    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);
    echo json_encode([
        "response" => "Заказ помечен как выполненный",
    ]);
}