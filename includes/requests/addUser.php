<?php
require_once(__DIR__ . '../../functions.php');
require_once(__DIR__ . '../../../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';

    $registered = register_user($name, $password, $email, $role);

    if ($registered) {
        $response['success'] = true;
        $response['message'] = 'Registered successfuly';
    } else {
        $response['success'] = false;
        $response['message'] = 'Error occured while registering user';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>