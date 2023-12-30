<?php
require_once(dirname(__DIR__) . '/includes/functions.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
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
                <div class="col-lg-2 d-none d-lg-block sidebar">
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
                                    <a class="nav-link" id="dashboardTab" href="../dashboard.php">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="productTab" href="products.php">Products</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="stocksTab" href="stocks.php">Stocks</a>
                                </li>
                            </ul>
                            <div class="mt-3">
                                <h6>Reports and Analytics</h6>
                                <ul class="nav nav-pills flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" id="salesreportTab" href="report/sales.php">Sales Report</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="analysisTab" href="report/inventory.php">Inventory
                                            Analysis</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-3">
                                <h6>User Management</h6>
                                <ul class="nav nav-pills flex-column">
                                    <li class="nav-item"><a class="nav-link" id="userTab" href="users.php">Users</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-9">
                    <div class="card border-0">
                        <div class="card-body">
                            <h5 class="card-title">Products</h5>
                            <ul class="nav nav-pills justify-content-center" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                        data-bs-target="#products-pane" type="button" role="tab"
                                        aria-controls="products-pane" aria-selected="true">Products</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#add-product-pane" type="button" role="tab"
                                        aria-controls="add-product-pane" aria-selected="false">Add Product</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#edit-product-pane" type="button" role="tab"
                                        aria-controls="edit-product-pane" aria-selected="false">Edit Product</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                        data-bs-target="#remove-product-pane" type="button" role="tab"
                                        aria-controls="remove-product-pane" aria-selected="false">Remove
                                        Product</button>
                                </li>
                            </ul>
                            <div class="tab-content mt-3" id="myTabContent">
                                <div class="tab-pane fade show active" id="products-pane" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-8 my-1">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h3>Product List</h3>
                                                    <div class="overflow-x-scroll overflow-y-auto" style="height: 70vh">
                                                        <table class="table table-bordered text-center"
                                                            id='productTable'>
                                                            <thead class="sticky-top">
                                                                <th scope="col">Product Name</th>
                                                                <th scope="col">Stocks</th>
                                                                <th scope="col">Price</th>
                                                                <th scope="col">Inventory Cost</th>
                                                                <th scope="col">Expiration Date</th>
                                                            </thead>
                                                            <tbody id="productList"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 d-none d-md-block my-1">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h3>Seach Filter</h3>
                                                    <form class="mb-0">
                                                        <div class="row my-2">
                                                            <div class="form-group col-lg-12">
                                                                <label for="productName">Product Name</label>
                                                                <input type="text" class="form-control"
                                                                    id="filterproductName"
                                                                    placeholder="Enter product name">
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="form-group col-lg-12">
                                                                <label for="stocks">Stocks</label>
                                                                <input type="number" class="form-control"
                                                                    id="filterstocks"
                                                                    placeholder="Enter stock quantity">
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="form-group col-lg-12">
                                                                <label for="price">Price</label>
                                                                <input type="text" class="form-control" id="filterprice"
                                                                    placeholder="Enter price">
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="col-lg-12">
                                                                <div class="form-group my-2">
                                                                    <label for="expirationDate">Expiration Date</label>
                                                                    <input type="date" class="form-control"
                                                                        id="filterexpirationDate">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="SearchProduct()">Search</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="add-product-pane" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-8 d-none d-md-block my-1">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h3>Product List</h3>
                                                    <div class="overflow-y-auto" style="height: 70vh">
                                                        <table class="table table-bordered text-center"
                                                            id='productTable'>
                                                            <thead class="sticky-top">
                                                                <th scope="col">Product Name</th>
                                                                <th scope="col">Stocks</th>
                                                                <th scope="col">Price</th>
                                                                <th scope="col">Inventory Cost</th>
                                                                <th scope="col">Expiration Date</th>
                                                            </thead>
                                                            <tbody id="addProduct"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-lg-4 my-1">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h3>Add Product</h3>
                                                    <form class="mb-0" enctype="multipart/form-data">
                                                        <div class="row my-2">
                                                            <div class="form-group col-lg-12">
                                                                <label for="productImage">Product Image</label>
                                                                <input type="file" class="form-control-file"
                                                                    id="productImage" name="productImage"
                                                                    accept="image/*">
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="form-group col-lg-12">
                                                                <label for="productName">Product Name</label>
                                                                <input type="text" class="form-control" id="productName"
                                                                    name="productName" placeholder="Enter product name">
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="form-group col-lg-12">
                                                                <label for="stocks">Stocks</label>
                                                                <input type="number" class="form-control" id="in_stocks"
                                                                    name="in_stocks" placeholder="Enter stock quantity">
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="form-group col-lg-12">
                                                                <label for="price">Price</label>
                                                                <input type="text" class="form-control" id="price"
                                                                    name="price" placeholder="Enter price">
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="col-lg-12">
                                                                <div class="form-group my-2">
                                                                    <label for="expirationDate">Expiration Date</label>
                                                                    <input type="date" class="form-control"
                                                                        id="expirationDate" name="expirationDate">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="addProductData()">Submit</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="edit-product-pane" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-8 my-1">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <div class="">
                                                            <h3 class="mb-0">Product List</h3>
                                                        </div>
                                                        <div class="d-none d-md-block">
                                                            <input type="text" placeholder="product name"
                                                                class="form-control" id="searchProduct"
                                                                name="searchProduct">
                                                        </div>
                                                    </div>
                                                    <div class="overflow-y-auto" style="height: 71vh">
                                                        <table class="table table-bordered text-center">
                                                            <thead class="sticky-top">
                                                                <th scope="col">Product Name</th>
                                                                <th scope="col">Stocks</th>
                                                                <th scope="col">Price</th>
                                                                <th scope="col">Expiration Date</th>
                                                                <th scope="col">Action</th>
                                                            </thead>
                                                            <tbody id="editProduct">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-lg-4 my-1">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h3>Update Product</h3>
                                                    <form class="mb-0" enctype="multipart/form-data">
                                                        <div class="row my-2">
                                                            <div class="form-group col-lg-12">
                                                                <label for="updateProductName">Product Name</label>
                                                                <input type="hidden" name="productId" id="productId">
                                                                <input type="text" class="form-control"
                                                                    id="updateProductName" name="updateProductName"
                                                                    placeholder="Enter product name">
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="form-group col-lg-12">
                                                                <label for="updateIn_Stocks">Stocks</label>
                                                                <input type="number" class="form-control"
                                                                    id="updateIn_Stocks" name="updateIn_Stocks"
                                                                    placeholder="Enter stock quantity">
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="form-group col-lg-12">
                                                                <label for="UpdatePrice">Price</label>
                                                                <input type="text" class="form-control" id="UpdatePrice"
                                                                    name="UpdatePrice" placeholder="Enter price">
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="col-lg-12">
                                                                <div class="form-group my-2">
                                                                    <label for="updateExpirationDate">Expiration
                                                                        Date</label>
                                                                    <input type="date" class="form-control"
                                                                        id="updateExpirationDate"
                                                                        name="updateExpirationDate">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="updateProductData()">Update</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="remove-product-pane" role="tabpanel">
                                    <div class="row">
                                        <div class="col">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <div class="">
                                                            <h3 class="mb-0">Product List</h3>
                                                        </div>
                                                        <div class="d-none d-md-block">
                                                            <input type="text" placeholder="product name"
                                                                class="form-control" id="searchProduct"
                                                                name="searchProduct">
                                                        </div>
                                                    </div>
                                                    <div class="overflow-y-auto" style="height: 71vh">
                                                        <table class="table table-bordered text-center">
                                                            <thead class="sticky-top">
                                                                <th scope="col">Product Name</th>
                                                                <th scope="col">Stocks</th>
                                                                <th scope="col">Price</th>
                                                                <th scope="col">Inventory Cost</th>
                                                                <th scope="col">Expiration Date</th>
                                                                <th scope="col">Action</th>
                                                            </thead>
                                                            <tbody id="removeProduct">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
<script src="../assets/js/app.js"></script>
<script src="../assets/js/populateTable.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>

<!-- Embedded script -->
<script>
    $(document).ready(function () {
        getproductData();

        $('#searchProduct').on('blur', searchProductName);
    });

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
            url: "../includes/requests/logout.php",
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