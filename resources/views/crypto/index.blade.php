<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 50 Cryptocurrencies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Styling for the small chart (icon) */
        .small-chart {
            width: 40px;
            height: 40px;
            cursor: pointer;
        }

        /* Popup Modal Styling */
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            width: 100%;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 30px;
            cursor: pointer;
            color: #000;
            font-weight: bold;
            z-index: 2000;
        }

        /* Price label styling */
        .price-up {
            color: green;
            font-weight: bold;
        }

        .price-down {
            color: red;
            font-weight: bold;
        }

        /* Custom table styles */
        /* Custom table styles */
/* Custom table styles */
/* Custom table styles */
table {
    width: 100%;
    border-collapse: collapse;
    border: 2px solid #000; /* Border around the entire table */
    border-radius: 40px; /* Rounded corners for the overall table */
    overflow: hidden; /* Ensure the rounded corners are applied */
    font-family: Arial, sans-serif; /* Set the font */
}

th, td {
    padding: 20px 30px; /* Wider cells */
    text-align: center; /* Horizontal alignment */
    vertical-align: middle; /* Vertical alignment */
    border: none; /* Remove internal cell borders */
    font-size: 16px; /* Increase font size */
}

th {
    background-color: #343a40;
    color: #fff;
    font-size: 18px; /* Larger font size for headers */
    font-weight: bold; /* Make header text bold */
}

tr:nth-child(even) {
    background-color: #f8f9fa;
}

tr:hover {
    background-color: #e2e6ea;
}

td img {
    border-radius: 50%;
    object-fit: cover;
}

/* Border for each row */
tr {
    border-bottom: 2px solid #ddd;
    height: 90px; /* Set row height */
}

/* Optional: Styling for the table rows */
td, th {
    font-size: 18px; /* Larger text size for the rows */
}


    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Top 50 Cryptocurrencies</h1>

        <!-- Table -->
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Logo</th>
                    <th>Name</th>
                    <th>Symbol</th>
                    <th>Current Price (USD)</th>
                    <th>Up/Down</th> <!-- Column for Price Fluctuation -->
                    <th>7-Day Price Trend</th>
                </tr>
            </thead>
            <tbody id="crypto-table-body">
                <!-- Rows will be populated here via JavaScript -->
            </tbody>
        </table>
    </div>

    <!-- Popup Modal -->
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <canvas id="popup-chart" width="400" height="200"></canvas>
        </div>
    </div>

    <script>
        // Placeholder for the crypto data
        const cryptos = @json($cryptos);

        // This will hold the updated prices and last prices for comparison
        const updatedPrices = {};
        const lastPrices = {};

        // Create a chart instance outside the function so we can access and destroy it later
        let chartInstance = null;

        // Function to show the popup with the full graph
        function showPopup(cryptoIndex) {
            const popup = document.getElementById('popup');
            const ctx = document.getElementById('popup-chart').getContext('2d');

            // If a chart already exists, destroy it before creating a new one
            if (chartInstance) {
                chartInstance.destroy();
            }

            // Get the selected crypto
            const selectedCrypto = cryptos[cryptoIndex];

            // Draw the chart on the popup canvas
            chartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: selectedCrypto.sparkline_in_7d.price.map((_, i) => i + 1),  // X-Axis labels (1, 2, 3...)
                    datasets: [{
                        label: `${selectedCrypto.name} Price (Last 7 Days)`,
                        data: selectedCrypto.sparkline_in_7d.price,  // Y-Axis data (price)
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: { title: { display: true, text: 'Days' }},
                        y: { title: { display: true, text: 'Price (USD)' }}
                    }
                }
            });

            // Show the popup
            popup.style.display = 'flex';
        }

        // Function to close the popup
        function closePopup() {
            const popup = document.getElementById('popup');
            popup.style.display = 'none';
        }

        // Function to dynamically create and display rows
        function populateCryptoTable() {
            const tbody = document.getElementById('crypto-table-body');
            cryptos.forEach((crypto, index) => {
                // Create a new row
                const row = document.createElement('tr');
                row.id = `crypto-row-${crypto.id}`;

                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td><img src="${crypto.image}" alt="${crypto.name} logo" style="width: 30px; height: 30px;"></td>
                    <td>${crypto.name}</td>
                    <td>${crypto.symbol.toUpperCase()}</td>
                    <td id="price-${crypto.id}" class="price">${crypto.current_price}</td>
                    <td id="updown-${crypto.id}"></td> <!-- New Up/Down Column -->
                    <td>
                        <img class="small-chart" src="https://via.placeholder.com/40" alt="Graph Icon" onclick="showPopup(${index})">
                    </td>
                `;
                tbody.appendChild(row);

                // Store the initial price and set the last price for fluctuation comparison
                updatedPrices[crypto.id] = crypto.current_price;
                lastPrices[crypto.id] = crypto.current_price;
            });
        }

        // Function to simulate price fluctuations
        function simulatePriceFluctuations() {
            setInterval(() => {
                cryptos.forEach(crypto => {
                    const priceElement = document.getElementById(`price-${crypto.id}`);
                    const updownElement = document.getElementById(`updown-${crypto.id}`);
                    let currentPrice = updatedPrices[crypto.id];

                    // Simulate price change (between -3 and +3 dollars)
                    const priceChange = (Math.random() * 6 - 3).toFixed(2); // Random fluctuation between -3 and 3
                    const newPrice = (parseFloat(currentPrice) + parseFloat(priceChange)).toFixed(2);

                    // Update the price in the table
                    updatedPrices[crypto.id] = newPrice;

                    // Calculate price fluctuation and set Up/Down value in table
                    const priceFluctuation = (parseFloat(newPrice) - parseFloat(currentPrice)).toFixed(2);
                    if (priceFluctuation > 0) {
                        priceElement.innerText = `$${newPrice}`;
                        priceElement.classList.add('price-up');
                        priceElement.classList.remove('price-down');

                        // Show the fluctuation in green (up)
                        updownElement.innerHTML = `<span class="price-up">${priceFluctuation} Up</span>`;
                    } else if (priceFluctuation < 0) {
                        priceElement.innerText = `$${newPrice}`;
                        priceElement.classList.add('price-down');
                        priceElement.classList.remove('price-up');

                        // Show the fluctuation in red (down)
                        updownElement.innerHTML = `<span class="price-down">${Math.abs(priceFluctuation)} Down</span>`;
                    } else {
                        priceElement.innerText = `$${newPrice}`;
                        priceElement.classList.remove('price-up', 'price-down');
                        
                        // Neutral state (no change)
                        updownElement.innerHTML = '';
                    }

                    // Update the last price for next iteration comparison
                    lastPrices[crypto.id] = newPrice;
                });
            }, 5000); // Update every 5 seconds
        }

        // Call functions on page load
        window.onload = () => {
            populateCryptoTable();
            simulatePriceFluctuations();
        };
    </script>
</body>
</html>
