function getRandomColor() {
  var letters = "0123456789ABCDEF";
  var color = "#";
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

function createInventoryChart(chartId, type, data) {
  var categories = data.map((item) => item.product_category);
  var stocks = data.map((item) => parseInt(item.total_stocks));

  var backgroundColors = categories.map(() => getRandomColor());
  var borderColors = backgroundColors.map((color) => color.replace("0.2", "1"));

  var myChart = new Chart(chartId, {
    type: type,
    data: {
      labels: categories,
      datasets: [
        {
          data: stocks,
          backgroundColor: backgroundColors,
          borderColor: borderColors,
          borderWidth: 1,
        },
      ],
    },
    options: {
      title: {
        display: true,
        text: "Inventory Overview",
      },
      legend: {
        display: false,
      },
      tooltips: {
        callbacks: {
          label: function (tooltipItem, data) {
            var label = data.labels[tooltipItem.index] || "";
            var value =
              data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
            return "In stock " + value + " item(s)";
          },
        },
      },
    },
  });
}

function createSalesChart(chartId, type, data) {
  var categories = data.map((item) => item.product_category);
  var stocks = data.map((item) => parseInt(item.total_stocks));

  var backgroundColors = categories.map(() => getRandomColor());
  var borderColors = backgroundColors.map((color) => color.replace("0.2", "1"));

  var myChart = new Chart(chartId, {
    type: type,
    data: {
      labels: categories,
      datasets: [
        {
          data: stocks,
          backgroundColor: backgroundColors,
          borderColor: borderColors,
          borderWidth: 1,
        },
      ],
    },
    options: {
      title: {
        display: true,
        text: "Inventory Overview",
      },
    },
  });
}
