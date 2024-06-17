<?php
require "db.php";

$sql = "SELECT * FROM products WHERE is_featured = 1 AND quantity > 0";
$result = $conn->query($sql)->fetch_all(mode: MYSQLI_ASSOC);

header('Content-Type: application/json; charset=utf-8');
http_response_code(200);
echo json_encode($result);