<?php
require_once(__DIR__ . '../../functions.php');
require_once(__DIR__ . '../../../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json_data = file_get_contents("php://input");

    $data = json_decode($json_data, true);

    if (is_array($data)) {
        $allSales = [];

        $currentDate = date('Ymd');

        $randomString = bin2hex(random_bytes(10));

        $transactionId = $currentDate . $randomString;

        foreach ($data as $saleData) {
            $sales = record_sales($transactionId, $saleData);

            $allSales[] = $sales;
        }

        if (in_array(false, $allSales, true)) {
            $response['success'] = false;
            $response['message'] = 'Error occurred while processing one or more sales';
        } else {
            $response['success'] = true;
            $response['message'] = 'All sales saved successfully';
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Invalid data format';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>