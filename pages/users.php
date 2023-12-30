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
                <div class="col-9">
                    <div class="card border-0">
                        <div class="card-body">
                            <h5 class="card-title">Users</h5>
                            <div class="row">

                                <ul class="nav nav-pills justify-content-center" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                            data-bs-target="#add-user-pane" type="button" role="tab"
                                            aria-controls="add-user-pane" aria-selected="true">Add User</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                            data-bs-target="#edit-user-pane" type="button" role="tab"
                                            aria-controls="edit-user-pane" aria-selected="false">Edit Users</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                            data-bs-target="#remove-user-pane" type="button" role="tab"
                                            aria-controls="remove-user-pane" aria-selected="false">Remove Users</button>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3" id="myTabContent">
                                    <div class="tab-pane fade show active" id="add-user-pane" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-7">
                                                <div class="card">
                                                    <div class="card-body ">
                                                        <h3>List</h3>
                                                        <table class="table table-bordered text-center">
                                                            <thead>
                                                                <th scope="col">User Name</th>
                                                                <th scope="col">Role</th>
                                                            </thead>
                                                            <tbody id="userList"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-5">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h3>Add User</h3>
                                                        <div class="response"></div>
                                                        <form class="mb-0">
                                                            <div class="row my-2">
                                                                <div class="form-group col-lg-12">
                                                                    <label for="inputName">Username</label>
                                                                    <input type="text" class="form-control"
                                                                        id="inputName">
                                                                </div>
                                                            </div>
                                                            <div class="row my-2">
                                                                <div class="form-group col-lg-12">
                                                                    <label for="inputEmail">Email Address</label>
                                                                    <input type="email" class="form-control"
                                                                        id="inputEmail">
                                                                </div>
                                                            </div>
                                                            <div class="row my-2">
                                                                <div class="form-group col-lg-12">
                                                                    <label for="inputRole">User Roles</label>
                                                                    <select class="form-select"
                                                                        aria-label="Default select example"
                                                                        id="inputRole">
                                                                        <option selected></option>
                                                                        <option value="ADMIN">Admin</option>
                                                                        <option value="STAFF">Staff</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row my-2">
                                                                <div class="form-group col-lg-12">
                                                                    <label for="inputPassword">Password</label>
                                                                    <input type="password" class="form-control"
                                                                        id="inputPassword">
                                                                </div>
                                                            </div>
                                                            <div class="row my-2">
                                                                <div class="form-group col-lg-12">
                                                                    <label for="inputConfirmPassword">Confirm
                                                                        Password</label>
                                                                    <input type="password" class="form-control"
                                                                        id="inputConfirmPassword">
                                                                </div>
                                                            </div>

                                                            <button type="button" class="btn btn-primary"
                                                                onclick="register()">Submit</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show " id="edit-user-pane" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-8 my-1">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h3 class="mb-0">User List</h3>
                                                        <div class="overflow-x-scroll">
                                                            <table class="table table-bordered text-center">
                                                                <thead>
                                                                    <th scope="col">Username</th>
                                                                    <th scope="col">Email</th>
                                                                    <th scope="col">Role</th>
                                                                    <th scope="col">Action</th>
                                                                </thead>
                                                                <tbody id="updateList">
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-4 my-1">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h3>Update User Information</h3>
                                                        <form class="mb-0" enctype="multipart/form-data">
                                                            <div class="row my-2">
                                                                <div class="form-group col-lg-12">
                                                                    <label for="updateUserName">User Name</label>
                                                                    <input type="hidden" name="userId" id="userId">
                                                                    <input type="text" class="form-control"
                                                                        id="updateUserName" name="updateUserName">
                                                                </div>
                                                            </div>
                                                            <div class="row my-2">
                                                                <div class="form-group col-lg-12">
                                                                    <label for="updateEmail">Email Address</label>
                                                                    <input type="email" class="form-control"
                                                                        id="updateEmail" name="updateEmail">
                                                                </div>
                                                            </div>
                                                            <div class="row my-2">
                                                                <div class="form-group col-lg-12">
                                                                    <label for="UpdateRole">Role</label>
                                                                    <select class="form-select"
                                                                        aria-label="Default select example"
                                                                        id="UpdateRole" name="UpdateRole">
                                                                        <option selected></option>
                                                                        <option value="ADMIN">Admin</option>
                                                                        <option value="STAFF">Staff</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row my-2">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group my-2">
                                                                        <label for="updatePassword">Password</label>
                                                                        <input type="password" class="form-control"
                                                                            id="updatePassword" name="updatePassword">
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
                                    <div class="tab-pane fade" id="remove-user-pane" role="tabpanel">
                                        <div class="row">
                                            <div class="col">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h3 class="mb-0">User List</h3>
                                                        <div class="overflow-x-auto">
                                                            <table class="table table-bordered text-center">
                                                                <thead>
                                                                    <th scope="col">Username</th>
                                                                    <th scope="col">Email</th>
                                                                    <th scope="col">Role</th>
                                                                    <th scope="col">Action</th>
                                                                </thead>
                                                                <tbody id="removeList">
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
        </div>
    </main>
</body>

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
<script src="../assets/js/user.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>

<!-- Embedded script -->
<script>
    $(document).ready(function () {
        getUserList();
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
            url: "../includes/requests/logout.php",
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    window.location.href = "../index.php";
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