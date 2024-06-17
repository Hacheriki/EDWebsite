<?php

require 'db.php';

$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

header('Content-Type: application/json; charset=utf-8');
http_response_code(200);
echo json_encode($result->fetch_all(MYSQLI_ASSOC));