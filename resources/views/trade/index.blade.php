<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BTC/INR Trading</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        form {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f8f8f8;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        label, select, input, button {
            margin: 10px;
            padding: 10px;
            font-size: 16px;
        }
        button {
            background-color: green;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>BTC/INR Trading</h1>
    <canvas id="tradeChart"></canvas>

    <h3>Place Trade</h3>
    <form action="{{ url('/trade') }}" method="POST">
        @csrf
        <label>Amount:</label>
        <input type="number" name="amount" required>

        <label>Type:</label>
        <select name="type">
            <option value="buy_up">Buy Up</option>
            <option value="buy_down">Buy Down</option>
        </select>

        <label>Duration:</label>
        <select name="duration">
            <option value="180">180 Seconds</option>
            <option value="150">150 Seconds</option>
            <option value="90">90 Seconds</option>
        </select>

        <button type="submit">Trade</button>
    </form>
</div>

<script>
    let ctx = document.getElementById('tradeChart').getContext('2d');
    let tradeChart = new Chart(ctx, {
        type: 'line',
        data: { labels: [], datasets: [{ label: 'BTC/INR', data: [], borderColor: 'green', borderWidth: 2 }] },
        options: { scales: { x: { display: true }, y: { beginAtZero: false } } }
    });

    function fetchTradeData() {
        fetch("{{ url('/trade-chart') }}")
            .then(response => response.json())
            .then(data => {
                let chartData = tradeChart.data;
                chartData.labels.push(data.time);
                chartData.datasets[0].data.push(data.price);
                if (chartData.labels.length > 20) {
                    chartData.labels.shift();
                    chartData.datasets[0].data.shift();
                }
                tradeChart.update();
            });
    }

    setInterval(fetchTradeData, 5000);
</script>

</body>
</html>
