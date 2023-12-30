<?php
require_once(__DIR__ . '../../functions.php');
require_once(__DIR__ . '../../../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $productData = fetchData(get_products());

    $response['products'] = $productData;

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>