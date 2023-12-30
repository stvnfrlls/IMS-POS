<?php
require_once(__DIR__ . '../../functions.php');

if (isset($_SESSION['user_id'])) {

    session_destroy();

    $response['success'] = true;
    $response['message'] = 'Logout successful';
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid request for logout';
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>