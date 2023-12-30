document.addEventListener('DOMContentLoaded', function () {
    // Get the current URL
    var currentURL = window.location.href;

    // Mapping between URLs and corresponding tabs
    var tabMappings = [
        { urlPart: "dashboard", tab: "dashboardTab" },
        { urlPart: "pages/products", tab: "productTab" },
        { urlPart: "pages/stocks", tab: "stocksTab" },
        { urlPart: "report/sales", tab: "salesreportTab" },
        { urlPart: "report/inventory", tab: "analysisTab" },
        { urlPart: "pages/users", tab: "userTab" },
        { urlPart: "pages/roles", tab: "roleTab" }
    ];

    // Check conditions and add class accordingly
    tabMappings.forEach(mapping => {
        var tabElement = document.getElementById(mapping.tab);
        if (currentURL.includes(mapping.urlPart)) {
            tabElement.classList.add("active");
        }
    });
});