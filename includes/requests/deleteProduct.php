<?php
require_once(__DIR__ . '../../functions.php');
require_once(__DIR__ . '../../../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';

    $result = delete_product($product_id);
    if ($result) {
        $response['success'] = true;
        $response['message'] = 'Deleted successfuly';
    } else {
        $response['success'] = false;
        $response['message'] = 'encountered a problem while deleting';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>