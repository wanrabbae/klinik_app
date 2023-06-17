@extends('templating.template_with_sidebar', ['isActiveInfografis' => 'active'])

@section('content')
    <h1>Infografis</h1>
    <div class="separator mb-5"></div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 mb-5">
                            <h4 class="mb-4">Grafik Total Transaksi dalam 1 Tahun</h4>
                            <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                        </div>

                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-12 mb-5">
                            <h4 class="mb-4">Grafik Transaksi Berdasarkan Dokter</h4>
                            <div class="mb-2">
                                <label for="doctor">Pilih Dokter:</label>
                                <select id="doctor" class="form-control">
                                    <option value="" selected>Semua dokter</option>
                                    @foreach ($data_dokter as $item)
                                        <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                    @endforeach

                                    <!-- Add more options for each doctor -->
                                </select>
                            </div>
                            <div class="">
                                <label for="dateMin">Date Range - From:</label>
                                <input type="date" id="dateMin" class="form-control mb-2">
                                <label for="dateMax">To:</label>
                                <input type="date" id="dateMax" class="form-control">
                            </div>
                            <button id="generateChart" class="btn btn-sm btn-success mt-2 mb-3">Generate Chart</button>
                            <div id="chartContainer2" style="height: 300px; width: 100%;"></div>

                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-12 mb-5">
                            <h4 class="mb-4">Grafik Transaksi Berdasarkan Tindakan</h4>
                            <div class="mb-2">
                                <label for="tindakan">Pilih Tindakan:</label>
                                <select id="tindakan" class="form-control">
                                    <option value="" selected>Semua tindakan</option>
                                    @foreach ($data_tindakan as $item)
                                        <option value="{{ $item->nama_tindakan }}">{{ $item->nama_tindakan }}</option>
                                    @endforeach

                                    <!-- Add more options for each doctor -->
                                </select>
                            </div>
                            <div class="">
                                <label for="dateMin">Date Range - From:</label>
                                <input type="date" id="dateMinTindakan" class="form-control mb-2">
                                <label for="dateMax">To:</label>
                                <input type="date" id="dateMaxTindakan" class="form-control">
                            </div>
                            <button id="generateChartTindakan" class="btn btn-sm btn-success mt-2 mb-3">Generate Chart</button>
                            <div id="chartContainer3" style="height: 300px; width: 100%;"></div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        window.onload = function() {
            // Make API request to retrieve data
            fetch('/transaction/chart/yearly') // Replace with your API endpoint URL
                .then(response => response.json())
                .then(data => {
                    // Process the received data
                    const chartData = processData(data);
                    // Create and render the chart
                    renderChart(chartData);
                })
                .catch(error => {
                    console.log(error);
                });

            function processData(data) {
                const monthlyData = {
                    "January": 0,
                    "February": 0,
                    "March": 0,
                    "April": 0,
                    "May": 0,
                    "June": 0,
                    "July": 0,
                    "August": 0,
                    "September": 0,
                    "October": 0,
                    "November": 0,
                    "December": 0
                };

                data.forEach(transaction => {
                    const month = moment(transaction.created_at, "DD-MM-YYYY").format("MMMM");
                    monthlyData[month]++;
                });

                const dataPoints = Object.entries(monthlyData).map(([label, y]) => ({
                    label,
                    y
                }));

                return dataPoints;
            }

            function renderChart(dataPoints) {
                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    theme: "light",
                    axisX: {
                        title: "Bulan"
                    },
                    axisY: {
                        title: "Jumlah"
                    },
                    data: [{
                        type: "column",
                        dataPoints: dataPoints
                    }]
                });
                chart.render();
            }

            // Initialize chart data and options
            let chartData = [];
            let options = {
                animationEnabled: true,
                theme: "light",
                axisX: {
                    title: "Tanggal"
                },
                axisY: {
                    title: "Jumlah"
                },
                data: [{
                    type: "column",
                    dataPoints: chartData
                }]
            };

            // Function to process the data and update the chart
            function processData2(data) {
                let chartData = [];

                // Loop through each date and data in the data object
                for (let date in data) {
                    // Get the transactions for the current date
                    let transactions = data[date];

                    // Get the count of transactions for the current date
                    let count = transactions.length;

                    // Create a new data point object with date and count
                    let dataPoint = {
                        label: date,
                        y: count
                    };

                    // Add the data point to the chart data array
                    chartData.push(dataPoint);
                }

                // Update the chart options with the processed data
                options.data[0].dataPoints = chartData;

                // Render the chart
                const chart = new CanvasJS.Chart("chartContainer2", options);
                chart.render();
            }

            // Fetch data from the API
            fetch('/transaction/chart/dokter')
                .then(response => response.json())
                .then(data => {
                    // Call the processData function with the fetched data
                    processData2(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });


            // Initialize chart data and options
            let chartDataTindakan = [];
            let optionsTindakan = {
                animationEnabled: true,
                theme: "light",
                axisX: {
                    title: "Tanggal"
                },
                axisY: {
                    title: "Jumlah"
                },
                data: [{
                    type: "column",
                    dataPoints: chartDataTindakan
                }]
            };

            // Function to process the data and update the chart
            function processDataTindakan(data) {
                let chartData = [];

                // Loop through each date and data in the data object
                for (let date in data) {
                    // Get the transactions for the current date
                    let transactions = data[date];

                    // Get the count of transactions for the current date
                    let count = transactions.length;

                    // Create a new data point object with date and count
                    let dataPoint = {
                        label: date,
                        y: count
                    };

                    // Add the data point to the chart data array
                    chartData.push(dataPoint);
                }

                // Update the chart options with the processed data
                optionsTindakan.data[0].dataPoints = chartData;

                // Render the chart
                const chart = new CanvasJS.Chart("chartContainer3", optionsTindakan);
                chart.render();
            }

            // Fetch data from the API
            fetch('/transaction/chart/tindakan')
                .then(response => response.json())
                .then(data => {
                    // Call the processData function with the fetched data
                    processDataTindakan(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Initialize chart data and options
        let chartData = [];
        let options = {
            animationEnabled: true,
            theme: "light",
            axisX: {
                title: "Tanggal"
            },
            axisY: {
                title: "Jumlah"
            },
            data: [{
                type: "column",
                dataPoints: chartData
            }]
        };

        // Function to process the data and update the chart
        function processData2(data) {
            let chartData = [];

            // Loop through each date and data in the data object
            for (let date in data) {
                // Get the transactions for the current date
                let transactions = data[date];

                // Get the count of transactions for the current date
                let count = transactions.length;

                // Create a new data point object with date and count
                let dataPoint = {
                    label: date,
                    y: count
                };

                // Add the data point to the chart data array
                chartData.push(dataPoint);
            }

            // Update the chart options with the processed data
            options.data[0].dataPoints = chartData;

            // Render the chart
            const chart = new CanvasJS.Chart("chartContainer2", options);
            chart.render();
        }

        document.getElementById('generateChart').addEventListener('click', function() {
            const selectedDoctor = document.getElementById('doctor').value;
            const dateMin = document.getElementById('dateMin').value;
            const dateMax = document.getElementById('dateMax').value;
            console.log(selectedDoctor, dateMin, dateMax);
            fetch(`/transaction/chart/dokter?dokter=${selectedDoctor}&startDate=${dateMin}&endDate=${dateMax}`) // Replace with your API endpoint
                .then(response => response.json())
                .then(data => {
                    processData2(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });


        // Initialize chart data and options
        let chartDataTindakan = [];
        let optionsTindakan = {
            animationEnabled: true,
            theme: "light",
            axisX: {
                title: "Tanggal"
            },
            axisY: {
                title: "Jumlah"
            },
            data: [{
                type: "column",
                dataPoints: chartDataTindakan
            }]
        };

        // Function to process the data and update the chart
        function processDataTindakan(data) {
            let chartData = [];

            // Loop through each date and data in the data object
            for (let date in data) {
                // Get the transactions for the current date
                let transactions = data[date];

                // Get the count of transactions for the current date
                let count = transactions.length;

                // Create a new data point object with date and count
                let dataPoint = {
                    label: date,
                    y: count
                };

                // Add the data point to the chart data array
                chartData.push(dataPoint);
            }

            // Update the chart options with the processed data
            optionsTindakan.data[0].dataPoints = chartData;

            // Render the chart
            const chart = new CanvasJS.Chart("chartContainer3", optionsTindakan);
            chart.render();
        }

        document.getElementById('generateChartTindakan').addEventListener('click', function() {
            const selectedTindakan = document.getElementById('tindakan').value;
            const dateMin = document.getElementById('dateMinTindakan').value;
            const dateMax = document.getElementById('dateMaxTindakan').value;
            console.log(selectedTindakan, dateMin, dateMax);
            fetch(`/transaction/chart/tindakan?tindakan=${selectedTindakan}&startDate=${dateMin}&endDate=${dateMax}`) // Replace with your API endpoint
                .then(response => response.json())
                .then(data => {
                    processDataTindakan(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>
@endsection
