<?php
require_once(__DIR__ . '../../functions.php');
require_once(__DIR__ . '../../../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $in_stock = $_POST['in_stock'];
    $price = $_POST['price'];
    $expiration_date = $_POST['expiration_date'];

    $result = update_product($product_id, $product_name, $in_stock, $price, $expiration_date);

    if ($result) {
        $response['success'] = true;
        $response['message'] = 'Updated successfully';
    } else {
        $response['success'] = false;
        $response['message'] = 'Encountered a problem while updating';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>