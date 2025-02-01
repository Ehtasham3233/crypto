<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cryptocurrency List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .crypto-card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 15px;
            margin: 10px 0;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .crypto-card h5 {
            margin: 0;
            font-weight: bold;
        }
        .crypto-chart {
            width: 100%;
            height: 200px;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center">Cryptocurrency List</h1>
        <div id="crypto-list" class="mt-4">
            <!-- List will be dynamically populated -->
        </div>
    </div>

    <script>
        async function fetchCryptos() {
            try {
                const response = await axios.get('/cryptos');
                const cryptos = response.data.data;

                const cryptoList = document.getElementById('crypto-list');
                cryptos.forEach(crypto => {
                    const card = document.createElement('div');
                    card.className = 'crypto-card';

                    card.innerHTML = `
                        <h5>${crypto.name} (${crypto.symbol})</h5>
                        <p>Price: $${crypto.price}</p>
                        <canvas class="crypto-chart" id="chart-${crypto.symbol}"></canvas>
                    `;

                    cryptoList.appendChild(card);

                    renderChart(`chart-${crypto.symbol}`, crypto.priceHistory);
                });
            } catch (error) {
                console.error('Error fetching cryptocurrencies:', error);
            }
        }

        function renderChart(chartId, priceHistory) {
            const ctx = document.getElementById(chartId).getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: priceHistory.map((_, index) => `T-${index}`), // Example labels
                    datasets: [{
                        label: 'Price History',
                        data: priceHistory,
                        borderColor: '#007bff',
                        borderWidth: 2,
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { display: false },
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        // Fetch cryptos on page load
        fetchCryptos();
    </script>
</body>
</html>
