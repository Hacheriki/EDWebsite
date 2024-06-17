<?php

require 'db.php';

$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

header('Content-Type: application/json; charset=utf-8');
http_response_code(200);
echo json_encode($orders);