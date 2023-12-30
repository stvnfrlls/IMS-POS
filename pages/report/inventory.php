<?php
require_once(dirname(__DIR__) . '../../includes/functions.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <header class="p-3 text-bg-dark ">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li>
                        <a href="../dashboard.php" id="home" class="nav-link px-2 text-white">
                            Home
                        </a>
                    </li>
                    <li><a href="../pages/products.php" id="products" class="nav-link px-2 text-white">Products</a>
                    </li>
                    <li><a href="../pages/stocks.php" id="stocks" class="nav-link px-2 text-white">Stocks</a>
                    </li>
                    <li><a href="../pages/report/sales.php" id="reports" class="nav-link px-2 text-white">Sales</a></li>
                </ul>
                <div class="text-end d-none d-lg-block">
                    <button type="button" class="btn btn-warning" onclick="logout()">Logout</button>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="row ">
                <div class="col-2 sidebar">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="profile-image mx-auto mb-2"></div>
                                <h5>
                                    <?php echo $_SESSION['user_name'] ?>
                                </h5>
                                <p>
                                    <?php echo $_SESSION['user_email'] ?>
                                </p>
                            </div>
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" id="dashboardTab" href="../../dashboard.php">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="productTab" href="../products.php">Products</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="stocksTab" href="../stocks.php">Stocks</a>
                                </li>
                            </ul>
                            <div class="mt-3">
                                <h6>Reports and Analytics</h6>
                                <ul class="nav nav-pills flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" id="salesreportTab" href="sales.php">Sales Report</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="analysisTab" href="inventory.php">Inventory Analysis</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-3">
                                <h6>User Management</h6>
                                <ul class="nav nav-pills flex-column">
                                    <li class="nav-item"><a class="nav-link" id="userTab" href="../users.php">Users</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="card border-0">
                        <div class="card-body">
                            <h5 class="card-title">Inventory Report</h5>
                            <div class="row">
                                <div class="col-12">
                                    <canvas id="horizontalbarChart" width="400" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>

<style>
    .sidebar {
        height: fit-content;
    }

    .profile-image {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background-color: #343a40;
    }

    .nav-link:hover {
        border-radius: 8px;
        background-color: #343a40;
        color: white;
    }
</style>

<!-- External script -->
<script src="../../assets/js/app.js"></script>
<script src="../../assets/js/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>

<!-- Embedded script -->
<script>
    $(document).ready(function () {
        $.ajax({
            url: '../../includes/requests/getChartData.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                createInventoryChart('horizontalbarChart', 'horizontalBar', data.stocks);
            },
            error: function (error) {
                console.log('Error fetching data: ' + error);
            }
        });
    });

    var currentURL = window.location.href;

    var tabMappings = [
        { urlPart: "/dashboard", tab: "home" },
        { urlPart: "pages/products", tab: "products" },
        { urlPart: "pages/stocks", tab: "stocks" },
        { urlPart: "report/sales", tab: "reports" },
    ];

    tabMappings.forEach(mapping => {
        var tabElement = document.getElementById(mapping.tab);
        if (currentURL.includes(mapping.urlPart)) {
            tabElement.classList.remove("text-white");

            tabElement.classList.add("text-active");
        }
    });

    function logout() {
        $.ajax({
            type: "POST",
            url: "../../includes/requests/logout.php",
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function (error) {
                console.log("Error:", error);
            },
        });
    }
</script>