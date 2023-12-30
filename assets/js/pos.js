function populateProductContainer(products) {
  const productContainer = $("#product-container");

  products.forEach((product) => {
    const rowId = `product-row-${product.product_id}`;
    const counterId = `counter-${product.product_id}`;

    const row = $("<div>").addClass("row").attr("id", rowId).html(`
                    <div class="col-md-12">
                      <div class="card mb-1">
                          <div class="d-flex justify-content-evenly align-items-center">
                              <div class="mx-1 p-2" style="width: 80px; height: auto">
                                  <img src="" class="img-fluid rounded" onerror="this.onerror=null; this.src='assets/images/temp-image.jpg';" alt="${product.product_name}">
                              </div>
                              <div class="mx-1 w-25">
                                  <h5 class="text-truncate text-center mb-0">${product.product_name}</h5>
                              </div>
                              <div class="mx-1">
                                  <div class="text-center">${product.price}</div>
                              </div>
                              <div class="mx-1 counter-container">
                                  <button class="btn btn-dark text-center" onclick="decrementCounter('${counterId}')">-</button>
                                  <span class="m-1" id="${counterId}">0</span>
                                  <button class="btn btn-dark text-center" onclick="incrementCounter('${counterId}')">+</button>
                              </div>
                              <div class="mx-1">
                                  <button class="btn btn-primary" type="button" onclick="addToCart('${product.product_id}', '${product.product_name}', '${product.price}', '${counterId}')">Add</button>
                              </div>
                          </div>
                      </div>
                    </div>
                `); 

    productContainer.append(row);
  });
}

let counterValue = 0;

function incrementCounter(counterId) {
  const counterElement = $("#" + counterId);
  let counterValue = parseInt(counterElement.text()) || 0;
  counterValue++;
  counterElement.text(counterValue);
}

function decrementCounter(counterId) {
  const counterElement = $("#" + counterId);
  let counterValue = parseInt(counterElement.text()) || 0;
  if (counterValue > 0) {
    counterValue--;
    counterElement.text(counterValue);
  }
}

function addToCart(productId, productName, price, counterId) {
  const counterElement = $("#" + counterId);
  let counterValue = parseInt(counterElement.text());

  counterValue = counterValue === 0 ? 1 : counterValue;

  const cartData = JSON.parse(localStorage.getItem("cart")) || [];

  const existingProductIndex = cartData.findIndex(
    (item) => item.productId === productId
  );

  if (existingProductIndex !== -1) {
    cartData[existingProductIndex].counter += counterValue;
    cartData[existingProductIndex].subtotal =
      cartData[existingProductIndex].counter *
      parseFloat(cartData[existingProductIndex].price);
  } else {
    const cartItem = {
      productId: productId,
      productName: productName,
      price: price,
      counter: counterValue,
      subtotal: counterValue * parseFloat(price),
    };

    cartData.push(cartItem);
  }

  localStorage.setItem("cart", JSON.stringify(cartData));
  counterElement.text("0");

  displayCartData();
}

function displayCartData() {
  const cartSubTotal = $("#total");
  const cartTableBody = $("#cart-table-body");
  cartTableBody.empty();

  const cartData = JSON.parse(localStorage.getItem("cart")) || [];
  let total = 0;

  cartData.forEach((item) => {
    const row = $("<tr>");
    row.append($("<td>").text(item.productName));
    row.append($("<td>").text(item.counter));
    row.append($("<td>").text(item.price));
    row.append($("<td>").text(calculateSubTotal(item.price, item.counter)));

    const removeColumn = $("<td>");
    const removeButton = $("<button>")
      .addClass("btn btn-danger remove-btn")
      .text("Remove")
      .data("productId", item.productId);
    removeColumn.append(removeButton);
    row.append(removeColumn);

    const subTotal = parseFloat(calculateSubTotal(item.price, item.counter));
    total += subTotal;

    cartTableBody.append(row);
  });

  $(".remove-btn").on("click", function () {
    const productId = $(this).data("productId");
    removeCartItem(productId);

    displayCartData();
  });

  cartSubTotal.text(total.toFixed(2));
}

function removeCartItem(productId) {
  let cartData = JSON.parse(localStorage.getItem("cart")) || [];
  cartData = cartData.filter((item) => item.productId !== productId);
  localStorage.setItem("cart", JSON.stringify(cartData));
}

function calculateSubTotal(Quantity, Price) {
  var cost = Quantity * Price;
  var formattedCost = parseFloat(cost.toFixed(2)).toFixed(2);

  return formattedCost;
}
