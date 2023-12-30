<?php
require_once(__DIR__ . '../../functions.php');
require_once(__DIR__ . '../../../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $user = login_user($username, $password);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];

        $response['success'] = true;
        $response['message'] = 'Login successful';

        if ($user['role'] === 'ADMIN') {
            $response['redirect'] = 'dashboard.php';
        } else if ($user['role'] === 'STAFF') {
            $response['redirect'] = 'pos.php';
        } else {
            $response['success'] = false;
            $response['message'] = 'User role is not defined';
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Invalid username or password';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>