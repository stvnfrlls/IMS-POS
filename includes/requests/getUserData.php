<?php
require_once(__DIR__ . '../../functions.php');
require_once(__DIR__ . '../../../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userData = fetchData(get_user());

    $response['user'] = $userData;

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>