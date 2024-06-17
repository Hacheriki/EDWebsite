<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["password"])) {
        exit();
    }

    $password = $_POST["password"];

    $isCorrect = false;
    if ($password == "12345678") {
        $isCorrect = true;
    }

    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);
    echo json_encode([
        "response" => $isCorrect
    ]);
}
