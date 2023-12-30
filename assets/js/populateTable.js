function formatDate(dateString) {
  var options = { year: "numeric", month: "short", day: "numeric" };

  return new Date(dateString).toLocaleDateString("en-US", options);
}

function calculateInventoryCost(inStock, price) {
  var cost = inStock * price;
  var formattedCost = parseFloat(cost.toFixed(2)).toFixed(2);

  return formattedCost;
}

function populateTable(tableId, data) {
  var tableBody = document.getElementById(tableId);

  tableBody.innerHTML = "";

  for (var i = 0; i < data.length; i++) {
    var row = tableBody.insertRow(i);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);

    cell1.innerHTML = data[i].product_name;
    cell2.innerHTML = data[i].in_stock;
    cell3.innerHTML = formatDate(data[i].expiration_date);
  }
}

function populateProductList(data) {
  var tableBody = document.getElementById("productList");

  tableBody.innerHTML = "";

  for (var i = 0; i < data.length; i++) {
    var row = tableBody.insertRow(i);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);

    cell1.innerHTML = data[i].product_name;
    cell2.innerHTML = data[i].in_stock;
    cell3.innerHTML = formatDate(data[i].expiration_date);
  }
}

function populateLowStocks(data) {
  var tableBody = document.getElementById("lowStock");

  tableBody.innerHTML = "";

  for (var i = 0; i < data.length; i++) {
    var row = tableBody.insertRow(i);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);

    cell1.innerHTML = data[i].product_name;
    cell2.innerHTML = data[i].in_stock;
    cell3.innerHTML = formatDate(data[i].expiration_date);
  }
}

var products;

function populateProductTable(tableId, data) {
  var tableBody = document.getElementById(tableId);

  tableBody.innerHTML = "";

  for (var i = 0; i < data.length; i++) {
    var row = tableBody.insertRow(i);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);

    cell1.innerHTML = data[i].product_name;
    cell2.innerHTML = data[i].in_stock;
    cell3.innerHTML = data[i].price;
    cell4.innerHTML = calculateInventoryCost(data[i].in_stock, data[i].price);
    cell5.innerHTML = formatDate(data[i].expiration_date);
  }
}

function populateEditProductTable(tableId, data) {
  var tableBody = document.getElementById(tableId);

  tableBody.innerHTML = "";

  for (var i = 0; i < data.length; i++) {
    var row = tableBody.insertRow(i);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);

    cell1.innerHTML = data[i].product_name;
    cell2.innerHTML = data[i].in_stock;
    cell3.innerHTML = data[i].price;
    cell4.innerHTML = formatDate(data[i].expiration_date);

    var selectButton = document.createElement("button");
    selectButton.innerHTML = "Select";
    selectButton.className = "btn btn-primary";

    selectButton.addEventListener(
      "click",
      (function (product) {
        return function () {
          $("#productId").val(product.product_id);
          $("#updateProductName").val(product.product_name);
          $("#updateIn_Stocks").val(product.in_stock);
          $("#UpdatePrice").val(product.price);
          $("#updateExpirationDate").val(
            new Date(product.expiration_date).toISOString().split("T")[0]
          );
        };
      })(data[i])
    );

    cell5.appendChild(selectButton);
  }
}

function populateRemoveProductTable(tableId, data) {
  var tableBody = document.getElementById(tableId);

  tableBody.innerHTML = "";

  for (var i = 0; i < data.length; i++) {
    var row = tableBody.insertRow(i);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);

    cell1.innerHTML = data[i].product_name;
    cell2.innerHTML = data[i].in_stock;
    cell3.innerHTML = data[i].price;
    cell4.innerHTML = calculateInventoryCost(data[i].in_stock, data[i].price);
    cell5.innerHTML = formatDate(data[i].expiration_date);

    var dangerButton = document.createElement("button");
    dangerButton.innerHTML = "Delete";
    dangerButton.className = "btn btn-danger";

    dangerButton.addEventListener(
      "click",
      (function (product_id) {
        return function () {
          $.ajax({
            type: "POST",
            url: "../includes/requests/deleteProduct.php",
            data: {
              product_id: product_id,
            },
            dataType: "json",
            success: function (response) {
              if (response.success) {
                getproductData();
              } else {
                alert(response.message);
              }
            },
            error: function (error) {
              console.log("Error:", error);
            },
          });
        };
      })(data[i].product_id)
    );

    cell6.appendChild(dangerButton);
  }
}

function SearchProduct() {
  var filterProductNameElement = document.getElementById("filterproductName");
  var filterProductName = (
    filterProductNameElement ? filterProductNameElement.value : ""
  ).toLowerCase();

  var filterStocks =
    parseInt(document.getElementById("filterstocks").value) || null;
  var filterPrice =
    parseFloat(document.getElementById("filterprice").value) || null;
  var filterExpirationDate = document.getElementById(
    "filterexpirationDate"
  ).value;

  var filteredProducts = products.filter(function (product) {
    return (
      (filterProductName === "" ||
        product.product_name.toLowerCase().includes(filterProductName)) &&
      (filterStocks === null || product.in_stock === filterStocks) &&
      (filterPrice === null || product.price === filterPrice) &&
      (filterExpirationDate === "" ||
        product.expiration_date === filterExpirationDate)
    );
  });

  if (
    filterProductName === "" &&
    filterStocks === null &&
    filterPrice === null &&
    filterExpirationDate === ""
  ) {
    filteredProducts = products;
  }

  populateProductTable("productList", filteredProducts);
}

function searchProductName() {
  var editProductPane = document.getElementById("edit-product-pane");
  var removeProductPane = document.getElementById("remove-product-pane");

  var filterInput = document
    .getElementById("searchProduct")
    .value.toLowerCase();

  var filteredProducts = products.filter(function (product) {
    var productName = product.product_name
      ? product.product_name.toLowerCase()
      : "";

    return filterInput === "" || productName.includes(filterInput);
  });

  if (filterInput === "") {
    filteredProducts = products;
  }

  if (editProductPane.classList.contains("show")) {
    populateEditProductTable("editProduct", filteredProducts);
  }
  if (removeProductPane.classList.contains("show")) {
    populateRemoveProductTable("removeProduct", filteredProducts);
  }
}

function getproductData() {
  $.ajax({
    type: "GET",
    url: "../includes/requests/getProductData.php",
    dataType: "json",

    success: function (response) {
      products = response.products;

      populateProductTable("productList", products);
      populateProductTable("addProduct", products);
      populateEditProductTable("editProduct", products);
      populateRemoveProductTable("removeProduct", products);
    },

    error: function (xhr, status, error) {
      console.error("Error:", status, error);
    },
  });
}

function addProductData() {
  var formData = new FormData();
  formData.append("product_name", $("#productName").val());
  formData.append("product_img", $("#productImage")[0].files[0]);
  formData.append("in_stock", $("#in_stocks").val());
  formData.append("price", $("#price").val());
  formData.append("expiration_date", $("#expirationDate").val());

  $.ajax({
    type: "POST",
    url: "../includes/requests/addProduct.php",
    data: formData,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      if (response.success) {
        getproductData();

        $("#productName").val(null);
        $("#productImage").val(null);
        $("#in_stocks").val(null);
        $("#price").val(null);
        $("#expirationDate").val(null);
      } else {
        alert(response.message);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error:", status, error);
      // console.log('Response:', xhr.responseText);
    },
  });
}

function updateProductData() {
  var formData = new FormData();
  formData.append("product_id", $("#productId").val());
  formData.append("product_name", $("#updateProductName").val());
  formData.append("in_stock", $("#updateIn_Stocks").val());
  formData.append("price", $("#UpdatePrice").val());
  formData.append("expiration_date", $("#updateExpirationDate").val());

  $.ajax({
    type: "POST",
    url: "../includes/requests/updateProduct.php",
    data: formData,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      if (response.success) {
        getproductData();

        $("#productId").val(null);
        $("#updateProductName").val(null);
        $("#updateIn_Stocks").val(null);
        $("#UpdatePrice").val(null);
        $("#updateExpirationDate").val(null);
      } else {
        alert(response.message);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error:", status, error);
      // console.log('Response:', xhr.responseText);
    },
  });
}
