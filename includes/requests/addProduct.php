<?php
require_once(__DIR__ . '../../functions.php');
require_once(__DIR__ . '../../../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
    $in_stock = isset($_POST['in_stock']) ? $_POST['in_stock'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $expiration_date = isset($_POST['expiration_date']) ? $_POST['expiration_date'] : '';

    if (isset($_FILES['product_img']) && $_FILES['product_img']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '../../../assets/images/';
        $filename = strtolower(str_replace(' ', '_', $product_name));
        $uploadFile = $uploadDir . $filename . '.' . pathinfo($_FILES['product_img']['name'], PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES['product_img']['tmp_name'], $uploadFile)) {
            $product_img = 'assets/images/' . $filename . '.' . pathinfo($_FILES['product_img']['name'], PATHINFO_EXTENSION);

            $result = add_product($product_name, $product_img, $in_stock, $price, $expiration_date);

            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Added successfully';
            } else {
                $response['success'] = false;
                $response['message'] = 'Encountered a problem while adding';
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Error moving uploaded file';
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'No file uploaded or file upload error';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>