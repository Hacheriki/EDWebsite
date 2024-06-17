<?php

session_start();

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (empty($_SESSION['cart'])) {
        sendResponseAndExit(400, "Корзина пуста");
    }

    unset($_SESSION['cart'][$_GET['id']]);

    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);
    $result = [
        "response" => "Успешно удалено",
    ];
    echo json_encode($result);
}