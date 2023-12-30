<?php
session_start();

require_once(__DIR__ . '/../config/database.php');

function get_user()
{
    global $conn;

    $sql = "SELECT users.id, users.name, users.email, roles.role 
            FROM users
            JOIN roles 
            ON users.id = roles.user_id";
    $result = $conn->query($sql);

    return $result;
}

function login_user($email, $password)
{
    global $conn;

    $email = sanitize_input($email);
    $password = sanitize_input($password);

    $hashedPassword = md5($password);

    $sql = "SELECT users.id, users.name, users.email, roles.role FROM users 
            JOIN roles 
            ON users.id = roles.user_id 
            WHERE 
                email = '$email' AND 
                password = '$hashedPassword'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $userData = $result->fetch_assoc();

        $_SESSION['user_id'] = $userData['id'];

        $result->free_result();
        return $userData;
    } else {
        return null;
    }
}

function register_user($name, $password, $email, $role)
{
    global $conn;

    $name = sanitize_input($name);
    $password = sanitize_input($password);
    $email = sanitize_input($email);

    $hashedPassword = md5($password);

    $sql = "INSERT INTO users (name, password, email) VALUES ('$name', '$hashedPassword', '$email')";
    $result = $conn->query($sql);

    if ($result) {
        $userId = $conn->insert_id;

        $sql = "INSERT INTO roles (user_id, role) VALUES ('$userId', '$role')";
        $result = $conn->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function delete_user($user_id)
{
    global $conn;

    $user_id = sanitize_input($user_id);

    $sql = "DELETE users, roles FROM users
            LEFT JOIN roles ON users.id = roles.user_id
            WHERE users.id = '$user_id'";

    $deleted = $conn->query($sql);

    return $deleted;
}

function get_products()
{
    global $conn;

    $sql = "SELECT * FROM products WHERE in_stock != 10 ORDER BY created_at";
    $productData = $conn->query($sql);

    return $productData;
}

function get_expiredProducts()
{
    global $conn;

    $current_date = date("Y-m-d");

    $sql = "SELECT * FROM products WHERE expiration_date <= '$current_date' OR DATEDIFF(expiration_date, '$current_date') <= 7";
    $productData = $conn->query($sql);

    return $productData;
}

function get_lowstocks()
{
    global $conn;

    $sql = "SELECT * FROM products WHERE in_stock <= 10";
    $lowStocks = $conn->query($sql);

    return $lowStocks;
}

function add_product($product_name, $product_img, $in_stock, $price, $expiration_date)
{
    global $conn;

    $product_name = sanitize_input($product_name);
    $product_img = sanitize_input($product_img);
    $in_stock = sanitize_input($in_stock);
    $price = sanitize_input($price);
    $expiration_date = sanitize_input($expiration_date);

    $sql = "INSERT INTO products (product_name, product_img, in_stock, price, expiration_date) 
            VALUES ('$product_name', '$product_img', '$in_stock', '$price', '$expiration_date')";
    $add = $conn->query($sql);

    return $add;
}

function update_product($product_id, $product_name, $in_stock, $price, $expiration_date)
{
    global $conn;

    $product_name = sanitize_input($product_name);
    $in_stock = sanitize_input($in_stock);
    $price = sanitize_input($price);
    $expiration_date = sanitize_input($expiration_date);

    $sql = "UPDATE products 
            SET 
            product_name = '$product_name', 
            in_stock = '$in_stock', 
            price = '$price', 
            expiration_date = '$expiration_date'
            WHERE product_id = '$product_id'";

    $update = $conn->query($sql);

    return $update;
}

function delete_product($product_id)
{
    global $conn;

    $product_id = sanitize_input($product_id);

    $sql = "DELETE FROM products WHERE product_id = '$product_id'";
    $deleted = $conn->query($sql);

    return $deleted;
}

function record_sales($transactionId, $saleData)
{
    global $conn;

    $productId = sanitize_input(isset($saleData['productId']) ? $saleData['productId'] : '');
    $quantity = sanitize_input(isset($saleData['counter']) ? $saleData['counter'] : '');
    $subtotal = sanitize_input(isset($saleData['subtotal']) ? $saleData['subtotal'] : '');

    $sql = "INSERT INTO sales (transaction_id, product_id, quantity, subtotal) VALUES ('$transactionId', '$productId', '$quantity', '$subtotal')";

    $sqlUpdate = "UPDATE products SET in_stock = in_stock - $quantity WHERE product_id = '$productId'";

    $conn->begin_transaction();

    try {
        $conn->query($sql);
        $conn->query($sqlUpdate);

        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollback();
        return false;
    }
}

function get_stocksPerCategory()
{
    global $conn;

    $sql = "SELECT category AS product_category, SUM(in_stock) as total_stocks FROM products GROUP BY category";
    $stocks_data = $conn->query($sql);

    return $stocks_data;
}

function get_salesPerMonth()
{
    global $conn;

    $sql = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, 
                   MONTHNAME(created_at) AS month_name, 
                   SUM(subtotal) AS total_sales 
            FROM sales 
            GROUP BY month 
            ORDER BY month";

    $sales_data = $conn->query($sql);

    return $sales_data;
}

function sanitize_input($input)
{
    global $conn;
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function fetchData($result)
{
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}