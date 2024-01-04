document.addEventListener('DOMContentLoaded', function () {
    var currentURL = window.location.href;

    var tabMappings = [
        { urlPart: "dashboard", tab: "dashboardTab" },
        { urlPart: "pages/products", tab: "productTab" },
        { urlPart: "pages/stocks", tab: "stocksTab" },
        { urlPart: "report/sales", tab: "salesreportTab" },
        { urlPart: "report/inventory", tab: "analysisTab" },
        { urlPart: "pages/users", tab: "userTab" },
        { urlPart: "pages/roles", tab: "roleTab" }
    ];

    tabMappings.forEach(mapping => {
        var tabElement = document.getElementById(mapping.tab);
        if (currentURL.includes(mapping.urlPart)) {
            tabElement.classList.add("active");
        }
    });
});