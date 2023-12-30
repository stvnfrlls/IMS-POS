<?php
require_once(__DIR__ . '../../functions.php');
require_once(__DIR__ . '../../../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $recentData = fetchData(get_products());
    $expiringData = fetchData(get_expiredProducts());
    $lowStocksData = fetchData(get_lowstocks());

    $response['recent'] = $recentData;
    $response['expiring'] = $expiringData;
    $response['stock'] = $lowStocksData;

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>