<?php
require_once(__DIR__ . '../../functions.php');
require_once(__DIR__ . '../../../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';

    $result = delete_user($user_id);
    
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