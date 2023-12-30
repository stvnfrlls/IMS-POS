<?php
require_once(__DIR__ . '/includes/functions.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . $baseUrl . '/index.php');
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <header class="p-3 text-bg-dark ">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="pos.php" id="home" class="nav-link px-2 text-white">Home</a>
                    </li>
                </ul>
                <div class="text-end d-none d-lg-block">
                    <button type="button" class="btn btn-warning" onclick="logout()">Logout</button>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="container my-2">
            <div class="row">
                <div class="col-lg-7">
                    <div class="overflow-x-hidden" style="height: 100vh" id="product-container"></div>
                </div>
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            <div id="cart-container">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="label">
                                        <h2>Shopping Cart</h2>
                                    </div>
                                    <div class="total-wrapper">
                                        <h5 class="mb-0" id="total"></h5>
                                    </div>
                                </div>
                                <div class="overflow-y-auto" style="height: 71vh">
                                    <table class="table text-center">
                                        <thead class="sticky-top">
                                            <tr>
                                                <td>Product</td>
                                                <td>Quantity</td>
                                                <td>Price</td>
                                                <td>Total</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody id="cart-table-body"></tbody>
                                    </table>
                                </div>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-primary w-100"
                                        onclick="transact()">TRANSACT</button>
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

<script src="assets/js/pos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $.ajax({
            type: 'GET',
            url: 'includes/requests/getProductData.php',
            dataType: 'json',

            success: function (response) {
                populateProductContainer(response.products);
                displayCartData();
            },

            error: function (xhr, status, error) {
                console.error('Error:', status, error);
            }
        });
    });

    function transact() {
        $.ajax({
            type: 'POST',
            url: 'includes/requests/addSale.php',
            dataType: 'json',
            data: localStorage.getItem("cart"),
            success: function (response) {
                localStorage.clear();
                displayCartData();
                alert(response.message);
            },

            error: function (xhr, status, error) {
                console.error('Error:', status, error);
            }
        });
    }

    function logout() {
        $.ajax({
            type: "POST",
            url: "includes/requests/logout.php",
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    window.location.href = "index.php";
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