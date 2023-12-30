<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'inventory_db');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query("SHOW TABLES LIKE 'users'")->num_rows) {
    $conn->query($sql_users);
}

$sql_userroles = "CREATE TABLE IF NOT EXISTS roles (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED,
    role VARCHAR(255) NOT NULL,
    created_at DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query("SHOW TABLES LIKE 'roles'")->num_rows) {
    $conn->query($sql_userroles);
}

$sql_products = "CREATE TABLE IF NOT EXISTS products (
    product_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(50) NOT NULL,
    category VARCHAR(50),
    product_img VARCHAR(50) NOT NULL,
    in_stock INT(5) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    expiration_date DATETIME(6) NOT NULL,
    created_at DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query("SHOW TABLES LIKE 'products'")->num_rows) {
    $conn->query($sql_products);

    $result = $conn->query("SELECT COUNT(*) as count FROM products");
    $row = $result->fetch_assoc();
    $rowCount = $row['count'];

    if ($rowCount == 0) {
        $conn->query("INSERT INTO products (product_img, product_name, category, in_stock, price, expiration_date) VALUES
                    ('assets/images/food1.jpg', 'Organic Quinoa', 'Grains', 50, 7.99, '2024-12-31 00:00:00'),
                    ('assets/images/food2.jpg', 'Grass-Fed Beef', 'Meat', 30, 12.99, '2024-12-31 00:00:00'),
                    ('assets/images/food3.jpg', 'Avocado Oil', 'Cooking Oil', 40, 9.99, '2024-12-31 00:00:00'),
                    ('assets/images/food4.jpg', 'Wild-caught Salmon', 'Seafood', 25, 14.99, '2024-12-31 00:00:00'),
                    ('assets/images/food5.jpg', 'Organic Spinach', 'Vegetables', 60, 3.99, '2024-12-31 00:00:00'),
                    ('assets/images/food6.jpg', 'Whole Grain Pasta', 'Pasta', 45, 2.99, '2024-12-31 00:00:00'),
                    ('assets/images/food7.jpg', 'Almond Butter', 'Nut Butter', 55, 8.99, '2024-12-31 00:00:00'),
                    ('assets/images/food8.jpg', 'Greek Yogurt', 'Dairy', 70, 4.99, '2024-12-31 00:00:00'),
                    ('assets/images/food9.jpg', 'Organic Blueberries', 'Berries', 20, 6.99, '2024-12-31 00:00:00'),
                    ('assets/images/food10.jpg', 'Honeycrisp Apples', 'Fruits', 65, 1.99, '2024-12-31 00:00:00'),
                    ('assets/images/food11.jpg', 'Organic Almonds', 'Nuts', 40, 10.99, '2024-12-31 00:00:00'),
                    ('assets/images/food12.jpg', 'Quinoa Salad Mix', 'Salad', 30, 5.99, '2024-12-31 00:00:00'),
                    ('assets/images/food13.jpg', 'Free-range Eggs', 'Eggs', 50, 4.49, '2024-12-31 00:00:00'),
                    ('assets/images/food14.jpg', 'Gluten-Free Oatmeal', 'Cereal', 25, 7.49, '2024-12-31 00:00:00'),
                    ('assets/images/food15.jpg', 'Sweet Potato Chips', 'Snacks', 35, 3.99, '2024-12-31 00:00:00'),
                    ('assets/images/food16.jpg', 'Organic Tomato Sauce', 'Canned Goods', 40, 2.49, '2024-12-31 00:00:00'),
                    ('assets/images/food17.jpg', 'Brown Rice', 'Grains', 60, 1.99, '2024-12-31 00:00:00'),
                    ('assets/images/food18.jpg', 'Extra Virgin Olive Oil', 'Cooking Oil', 55, 9.99, '2024-12-31 00:00:00'),
                    ('assets/images/food19.jpg', 'Chia Seeds', 'Seeds', 30, 6.99, '2024-12-31 00:00:00'),
                    ('assets/images/food20.jpg', 'Coconut Milk', 'Dairy', 40, 2.99, '2024-12-31 00:00:00'),
                    ('assets/images/food21.jpg', 'Wildflower Honey', 'Sweeteners', 25, 5.99, '2024-12-31 00:00:00'),
                    ('assets/images/food22.jpg', 'Cage-Free Chicken', 'Poultry', 45, 11.99, '2024-12-31 00:00:00'),
                    ('assets/images/food23.jpg', 'Organic Broccoli', 'Vegetables', 35, 3.49, '2024-12-31 00:00:00'),
                    ('assets/images/food24.jpg', 'Salmon Fillets', 'Seafood', 20, 13.99, '2024-12-31 00:00:00'),
                    ('assets/images/food25.jpg', 'Gluten-Free Bread', 'Bakery', 50, 4.99, '2024-12-31 00:00:00'),
                    ('assets/images/food26.jpg', 'Protein Bars', 'Snacks', 40, 7.99, '2024-12-31 00:00:00'),
                    ('assets/images/food27.jpg', 'Organic Green Tea', 'Beverages', 30, 5.49, '2024-12-31 00:00:00'),
                    ('assets/images/food28.jpg', 'Vegetarian Burger Patties', 'Frozen', 25, 8.99, '2024-12-31 00:00:00'),
                    ('assets/images/food29.jpg', 'Sweet Chili Sauce', 'Condiments', 55, 3.99, '2024-12-31 00:00:00'),
                    ('assets/images/food30.jpg', 'Quinoa Flour', 'Flour', 15, 6.49, '2024-12-31 00:00:00'),
                    ('assets/images/food31.jpg', 'Dark Chocolate Bars', 'Chocolate', 70, 2.99, '2024-12-31 00:00:00'),
                    ('assets/images/food32.jpg', 'Organic Cucumber', 'Vegetables', 40, 1.99, '2024-12-31 00:00:00'),
                    ('assets/images/food33.jpg', 'Garlic Infused Olive Oil', 'Cooking Oil', 25, 7.99, '2024-12-31 00:00:00'),
                    ('assets/images/food34.jpg', 'Mixed Berry Jam', 'Condiments', 30, 4.49, '2024-12-31 00:00:00'),
                    ('assets/images/food35.jpg', 'Almond Milk', 'Dairy', 60, 2.99, '2024-12-31 00:00:00'),
                    ('assets/images/food36.jpg', 'Organic Black Beans', 'Canned Goods', 50, 1.49, '2024-12-31 00:00:00'),
                    ('assets/images/food37.jpg', 'Kale Chips', 'Snacks', 25, 3.99, '2024-12-31 00:00:00'),
                    ('assets/images/food38.jpg', 'Gluten-Free Pancake Mix', 'Bakery', 35, 5.99, '2024-12-31 00:00:00'),
                    ('assets/images/food39.jpg', 'Cashew Butter', 'Nut Butter', 45, 8.99, '2024-12-31 00:00:00'),
                    ('assets/images/food40.jpg', 'Cauliflower Rice', 'Frozen', 20, 4.99, '2024-12-31 00:00:00'),
                    ('assets/images/food41.jpg', 'Organic Red Quinoa', 'Grains', 15, 6.99, '2024-12-31 00:00:00'),
                    ('assets/images/food42.jpg', 'Maple Syrup', 'Sweeteners', 30, 9.49, '2024-12-31 00:00:00'),
                    ('assets/images/food43.jpg', 'Dried Mango Slices', 'Snacks', 40, 7.99, '2024-12-31 00:00:00'),
                    ('assets/images/food44.jpg', 'Pumpkin Seeds', 'Seeds', 55, 3.99, '2024-12-31 00:00:00'),
                    ('assets/images/food45.jpg', 'Sesame Oil', 'Cooking Oil', 35, 5.99, '2024-12-31 00:00:00'),
                    ('assets/images/food46.jpg', 'Organic Raspberries', 'Berries', 25, 12.99, '2024-12-31 00:00:00'),
                    ('assets/images/food47.jpg', 'Soy Milk', 'Dairy', 50, 2.49, '2024-12-31 00:00:00'),
                    ('assets/images/food48.jpg', 'Balsamic Vinegar', 'Condiments', 45, 8.99, '2024-12-31 00:00:00'),
                    ('assets/images/food49.jpg', 'Brown Sugar', 'Sweeteners', 65, 1.99, '2024-12-31 00:00:00'),
                    ('assets/images/food50.jpg', 'Organic Chicken Broth', 'Soup', 30, 4.99, '2024-12-31 00:00:00');"
        );
    }
}

$sql_sales = "CREATE TABLE IF NOT EXISTS sales (
    sale_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    transaction_id VARCHAR(50) NOT NULL,
    product_id INT(6) NOT NULL,
    quantity INT(5) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    created_at DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query("SHOW TABLES LIKE 'sales'")->num_rows) {
    $conn->query($sql_sales);
}

$result = $conn->query("SELECT COUNT(*) as count FROM users");
$row = $result->fetch_assoc();
$rowCount = $row['count'];

if ($rowCount == 0) {
    $AdminName = 'Admin Account';
    $AdminHashedPassword = md5('Password');
    $AdminEmail = 'admin@admin.com';

    $AdminSql = "INSERT INTO users (name, password, email) VALUES ('$AdminName', '$AdminHashedPassword', '$AdminEmail')";
    $AdminResult = $conn->query($AdminSql);

    if ($AdminResult) {
        $userId = $conn->insert_id;
        $conn->query("INSERT INTO roles (user_id, role) VALUES ($userId, 'ADMIN');");
    }

    $StaffName = 'Staff Account';
    $StaffHashedPassword = md5('Password');
    $StaffEmail = 'staff@staff.com';

    $StaffSql = "INSERT INTO users (name, password, email) VALUES ('$StaffName', '$StaffHashedPassword', '$StaffEmail')";
    $StaffResult = $conn->query($StaffSql);

    if ($StaffResult) {
        $userId = $conn->insert_id;
        $conn->query("INSERT INTO roles (user_id, role) VALUES ($userId, 'STAFF');");
    }
}



