$(document).ready(function() {
    // Function to fetch data for the selected year
    function fetchYearlyData(year) {
        $.ajax({
            url: "/fetch-yearly-data", // Make sure this route exists in web.php
            type: "GET",
            data: { year: year },
            success: function(response) {
                // Update the chart data dynamically
                chart.updateSeries([
                    // { name: "Consignment", data: response.consignmentData },
                    { name: "Sales", data: response.directSalesData }
                ]);
            },
            error: function() {
                console.log("Error fetching data");
            }
        });
    }

    // Initialize ApexCharts
    var options = {
        chart: {
            height: 500,
            type: "bar",
            stacked: false,
            toolbar: { show: true },
            zoom: { enabled: true }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "40%",
                endingShape: "rounded"
            }
        },
        dataLabels: { enabled: false },
        series: [
            // { name: "Consignment", data: consignmentData },
            { name: "Direct Sales", data: directSalesData }
        ],
        xaxis: {
            categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
        },
        colors: ["#556ee6", "#f46a6a"],
        legend: { position: "bottom" },
        fill: { opacity: 1 }
    };

    var chart = new ApexCharts(document.querySelector("#stacked-column-chart"), options);
    chart.render();

    // Handle year selection change
    $("#yearSelect").change(function() {
        var selectedYear = $(this).val();
        fetchYearlyData(selectedYear);
    });
});
