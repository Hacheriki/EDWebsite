<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $category = "";
    $maxPrice = "";

    if (isset($_GET['category']) && isset($_GET['maxPrice'])) {
        $category = $_GET['category'];
        $maxPrice = $_GET['maxPrice'];
    }

    $sql = "SELECT p.product_id, p.name, p.price, p.image_url FROM products p WHERE p.quantity > 0 ";
    if ($category || $maxPrice) {
        $sql .= "AND ";
        $conditions = [];

        if ($category) {
            $conditions[] = "p.category_id = ?";
        }

        if ($maxPrice) {
            $conditions[] = "p.price <= ?";
        }

        $sql .= join(" AND ", $conditions);

    }

    $statement = $conn->prepare($sql);

    $paramType = '';
    if ($category) {
        $paramType .= 'i';
    }

    if ($maxPrice) {
        $paramType .= 'd';
    }

    if ($category && $maxPrice) {
        $statement->bind_param($paramType, $category, $maxPrice);
    } elseif ($category) {
        $statement->bind_param($paramType, $category);
    } elseif ($maxPrice) {
        $statement->bind_param($paramType, $maxPrice);
    }


    $statement->execute();
    $result = $statement->get_result();

    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}