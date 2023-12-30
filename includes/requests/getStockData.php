<?php
require_once(__DIR__ . '../../functions.php');
require_once(__DIR__ . '../../../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $lowStocksData = fetchData(get_lowstocks());
    $productData = fetchData(get_products());

    $response['stocks'] = $lowStocksData;
    $response['product'] = $productData;

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>