<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Stock Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --light-bg: #f8f9fa;
            --dark-bg: #343a40;
            --text-dark: #212529;
            --text-light: #f8f9fa;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
            padding-top: 20px;
        }

        .dashboard-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .last-update {
            font-size: 0.9rem;
            color: var(--text-light);
            background-color: rgba(0, 0, 0, 0.2);
            padding: 5px 10px;
            border-radius: 20px;
        }

        .stock-card {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            border-left: 4px solid transparent;
        }

        .stock-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .stock-card.positive {
            border-left-color: var(--success-color);
        }

        .stock-card.negative {
            border-left-color: var(--danger-color);
        }

        .stock-card small {
            color: #6c757d;
            font-size: 0.8rem;
        }

        .positive {
            color: var(--success-color);
        }

        .negative {
            color: var(--danger-color);
        }

        .call-badge, .put-badge {
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }

        .call-badge {
            background-color: rgba(46, 204, 113, 0.2);
            color: var(--success-color);
        }

        .put-badge {
            background-color: rgba(231, 76, 60, 0.2);
            color: var(--danger-color);
        }

        .market-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .market-nse { background-color: #3498db; }
        .market-nasdaq { background-color: #e74c3c; }
        .market-xetra { background-color: #9b59b6; }
        .market-lse { background-color: #1abc9c; }
        .market-tse { background-color: #e67e22; }
        .market-nyse { background-color: #2ecc71; }

        .chart-container {
            height: 150px;
            margin-top: 10px;
        }

        .search-container {
            margin-bottom: 20px;
        }

        .loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .loader-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .spinner {
            width: 3rem;
            height: 3rem;
        }

        .notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 5px;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transform: translateY(100px);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
            z-index: 1050;
        }

        .notification.show {
            transform: translateY(0);
            opacity: 1;
        }

        .notification.success {
            background-color: var(--success-color);
        }

        .notification.error {
            background-color: var(--danger-color);
        }

        .notification.warning {
            background-color: var(--warning-color);
        }

        .stock-details-modal .modal-content {
            border-radius: 15px;
        }

        .stock-details-modal .modal-header {
            border-bottom: none;
            padding-bottom: 0;
        }

        .market-summary {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .summary-item {
            text-align: center;
            padding: 10px;
        }

        .summary-item h5 {
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .summary-item p {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            .chart-container {
                height: 120px;
            }
            
            .stock-card {
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="loader" id="loader">
        <div class="loader-content">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Updating stock data...</p>
        </div>
    </div>

    <div class="notification" id="notification"></div>

    <div class="container">
        <div class="dashboard-header d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="fas fa-chart-line me-2"></i>Stock Dashboard</h1>
                <p class="mb-0">Real-time market data at your fingertips</p>
            </div>
            <div class="last-update">
                <i class="fas fa-sync-alt me-1"></i> Last Updated: <span id="lastUpdateTime">N/A</span>
            </div>
        </div>

        <div class="market-summary">
            <div class="row">
                <div class="col-md-3 summary-item">
                    <h5 id="totalStocks">0</h5>
                    <p>Stocks Tracked</p>
                </div>
                <div class="col-md-3 summary-item">
                    <h5 id="upStocks">0</h5>
                    <p>Stocks Up</p>
                </div>
                <div class="col-md-3 summary-item">
                    <h5 id="downStocks">0</h5>
                    <p>Stocks Down</p>
                </div>
                <div class="col-md-3 summary-item">
                    <h5 id="lastRefresh">-</h5>
                    <p>Next Refresh</p>
                </div>
            </div>
        </div>

        <div class="search-container">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" id="stockSearch" class="form-control" placeholder="Search stocks...">
                <button class="btn btn-primary" id="refreshBtn"><i class="fas fa-sync-alt"></i> Refresh</button>
            </div>
        </div>

        <div id="niftyStocks" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4"></div>

        <div class="text-center mt-4">
            <button class="btn btn-outline-primary" id="addStockBtn">
                <i class="fas fa-plus me-2"></i>Add Stock
            </button>
        </div>
    </div>

    <!-- Stock Details Modal -->
    <div class="modal fade" id="stockDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content stock-details-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockModalTitle">Stock Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 id="detailStockName"></h3>
                            <p class="text-muted" id="detailStockSymbol"></p>
                            <div class="d-flex align-items-center mb-3">
                                <h2 class="mb-0 me-3" id="detailStockPrice"></h2>
                                <span id="detailStockChange"></span>
                            </div>
                            <div class="mb-3">
                                <p><strong>Market:</strong> <span id="detailStockMarket"></span></p>
                                <p><strong>Currency:</strong> <span id="detailStockCurrency"></span></p>
                                <p><strong>Last Updated:</strong> <span id="detailStockUpdated"></span></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="chart-container">
                                <canvas id="stockHistoryChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h5>Recent Performance</h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Open</th>
                                        <th>High</th>
                                        <th>Low</th>
                                        <th>Close</th>
                                        <th>Volume</th>
                                    </tr>
                                </thead>
                                <tbody id="stockHistoryTable">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="removeStockBtn">
                        <i class="fas fa-trash-alt me-1"></i>Remove Stock
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Stock Modal -->
    <div class="modal fade" id="addStockModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addStockForm">
                        <div class="mb-3">
                            <label for="newStockSymbol" class="form-label">Stock Symbol</label>
                            <input type="text" class="form-control" id="newStockSymbol" required placeholder="e.g., MSFT">
                            <div class="form-text">Enter the stock symbol (e.g., AAPL for Apple)</div>
                        </div>
                        <div class="mb-3">
                            <label for="newStockName" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="newStockName" required placeholder="e.g., Microsoft Corporation">
                        </div>
                        <div class="mb-3">
                            <label for="newStockMarket" class="form-label">Market</label>
                            <select class="form-select" id="newStockMarket" required>
                                <option value="">Select Market</option>
                                <option value="NSE">NSE (National Stock Exchange, India)</option>
                                <option value="NASDAQ">NASDAQ</option>
                                <option value="NYSE">NYSE (New York Stock Exchange)</option>
                                <option value="BSE">BSE (Bombay Stock Exchange)</option>
                                <option value="XETRA">XETRA (Frankfurt Stock Exchange)</option>
                                <option value="LSE">LSE (London Stock Exchange)</option>
                                <option value="TSE">TSE (Tokyo Stock Exchange)</option>
                                <option value="HKEX">HKEX (Hong Kong Stock Exchange)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="newStockCurrency" class="form-label">Currency</label>
                            <select class="form-select" id="newStockCurrency" required>
                                <option value="">Select Currency</option>
                                <option value="$">USD ($)</option>
                                <option value="₹">INR (₹)</option>
                                <option value="€">EUR (€)</option>
                                <option value="£">GBP (£)</option>
                                <option value="¥">JPY (¥)</option>
                                <option value="HK$">HKD (HK$)</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmAddStockBtn">Add Stock</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@2.4.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.2.0"></script>
    <script>
        // Replace with your actual Alpha Vantage API key
        const API_KEY = 'YOUR_ALPHA_VANTAGE_API_KEY'; 
        const UPDATE_INTERVAL = 300000; // 5 minutes
        let lastUpdateTime = 0;
        let stockCache = {};
        let stockCharts = {};
        let currentModalStock = null;
        const modal = new bootstrap.Modal(document.getElementById('stockDetailsModal'));
        const addStockModal = new bootstrap.Modal(document.getElementById('addStockModal'));

        // Sample initial stocks
        let stocks = {
            'RELIANCE.BSE': { 
                name: 'Reliance Industries', 
                currency: '₹', 
                market: 'BSE',
                history: []
            },
            'TCS.BSE': { 
                name: 'Tata Consultancy', 
                currency: '₹', 
                market: 'BSE',
                history: []
            },
            'AAPL': { 
                name: 'Apple Inc', 
                currency: '$', 
                market: 'NASDAQ',
                history: []
            },
            'TSLA': { 
                name: 'Tesla Inc', 
                currency: '$', 
                market: 'NASDAQ',
                history: []
            }
        };

        let lastApiCallTime = 0;
        const API_CALL_DELAY = 60000 / 5; // 5 requests per minute (Alpha Vantage free tier limit)

        // Initialize the dashboard
        document.addEventListener('DOMContentLoaded', () => {
            updateAllStockPrices();
            setInterval(updateAllStockPrices, UPDATE_INTERVAL);
            updateRefreshTimer();
            
            // Event listeners
            document.getElementById('refreshBtn').addEventListener('click', updateAllStockPrices);
            document.getElementById('stockSearch').addEventListener('input', filterStocks);
            document.getElementById('addStockBtn').addEventListener('click', () => addStockModal.show());
            document.getElementById('confirmAddStockBtn').addEventListener('click', addNewStock);
            document.getElementById('removeStockBtn').addEventListener('click', removeCurrentStock);
        });

        async function fetchRealTimeStockData(symbol) {
            try {
                // Respect Alpha Vantage rate limits
                const now = Date.now();
                const timeSinceLastCall = now - lastApiCallTime;
                if (timeSinceLastCall < API_CALL_DELAY) {
                    await new Promise(resolve => setTimeout(resolve, API_CALL_DELAY - timeSinceLastCall));
                }
                
                const response = await fetch(
                    `https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=${symbol}&apikey=${API_KEY}`
                );
                lastApiCallTime = Date.now();
                
                const data = await response.json();

                if (data['Global Quote']) {
                    const quote = data['Global Quote'];
                    return {
                        price: parseFloat(quote['05. price']),
                        change: parseFloat(quote['09. change']),
                        changePercent: quote['10. change percent'].replace('%', ''),
                        volume: quote['06. volume'] ? parseInt(quote['06. volume']) : 0
                    };
                }
                return null;
            } catch (error) {
                console.error('Error fetching stock data:', error);
                return null;
            }
        }

        async function fetchStockHistory(symbol) {
            try {
                // Respect Alpha Vantage rate limits
                const now = Date.now();
                const timeSinceLastCall = now - lastApiCallTime;
                if (timeSinceLastCall < API_CALL_DELAY) {
                    await new Promise(resolve => setTimeout(resolve, API_CALL_DELAY - timeSinceLastCall));
                }
                
                const response = await fetch(
                    `https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=${symbol}&apikey=${API_KEY}&outputsize=compact`
                );
                lastApiCallTime = Date.now();
                
                const data = await response.json();

                if (data['Time Series (Daily)']) {
                    const timeSeries = data['Time Series (Daily)'];
                    const history = [];
                    let count = 0;
                    
                    for (const date in timeSeries) {
                        if (count >= 7) break; // Limit to last 7 days
                        const dayData = timeSeries[date];
                        history.push({
                            date: date,
                            open: parseFloat(dayData['1. open']),
                            high: parseFloat(dayData['2. high']),
                            low: parseFloat(dayData['3. low']),
                            close: parseFloat(dayData['4. close']),
                            volume: parseInt(dayData['5. volume'])
                        });
                        count++;
                    }
                    
                    // Sort by date ascending
                    return history.sort((a, b) => new Date(a.date) - new Date(b.date));
                }
                return [];
            } catch (error) {
                console.error('Error fetching stock history:', error);
                return [];
            }
        }

        async function updateAllStockPrices() {
            showLoader(true);

            try {
                const stockSymbols = Object.keys(stocks);
                let upCount = 0;
                let downCount = 0;
                
                // Process stocks sequentially to respect API rate limits
                for (const symbol of stockSymbols) {
                    try {
                        const data = await fetchRealTimeStockData(symbol);
                        if (data) {
                            stockCache[symbol] = data;
                            stocks[symbol].lastUpdated = new Date().toLocaleTimeString();
                            
                            // Update history if price changed
                            if (stocks[symbol].history.length === 0 || 
                                stocks[symbol].history[stocks[symbol].history.length - 1].price !== data.price) {
                                stocks[symbol].history.push({
                                    time: new Date().toISOString(),
                                    price: data.price
                                });
                                
                                // Keep only last 20 data points
                                if (stocks[symbol].history.length > 20) {
                                    stocks[symbol].history.shift();
                                }
                            }
                            
                            // Count up/down stocks
                            if (data.change > 0) upCount++;
                            else if (data.change < 0) downCount++;
                        }
                    } catch (error) {
                        console.error(`Error updating ${symbol}:`, error);
                    }
                }

                lastUpdateTime = Date.now();
                updateStockDisplay();
                updateMarketSummary(stockSymbols.length, upCount, downCount);
                document.getElementById('lastUpdateTime').textContent = new Date().toLocaleTimeString();
                showNotification('Stock data updated successfully', 'success');
            } catch (error) {
                showNotification('Failed to update stock prices', 'error');
                console.error('Update error:', error);
            } finally {
                showLoader(false);
                updateRefreshTimer();
            }
        }

        function updateMarketSummary(total, up, down) {
            document.getElementById('totalStocks').textContent = total;
            document.getElementById('upStocks').textContent = up;
            document.getElementById('downStocks').textContent = down;
        }

        function updateRefreshTimer() {
            const nextRefresh = new Date(lastUpdateTime + UPDATE_INTERVAL);
            document.getElementById('lastRefresh').textContent = nextRefresh.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        }

        function updateStockDisplay() {
            const container = document.getElementById('niftyStocks');
            container.innerHTML = Object.entries(stocks).map(([symbol, meta]) => {
                const data = stockCache[symbol] || {};
                const changeClass = data.change >= 0 ? 'positive' : 'negative';
                const cardClass = data.change >= 0 ? 'positive' : 'negative';
                const marketClass = `market-${meta.market.toLowerCase()}`;
                
                return `
                    <div class="col">
                        <div class="stock-card ${cardClass}" data-symbol="${symbol}" onclick="showStockDetails('${symbol}')">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5>${meta.name}</h5>
                                    <small>
                                        <span class="market-indicator ${marketClass}"></span>
                                        ${symbol} • ${meta.market}
                                    </small>
                                    <small class="d-block">Updated: ${meta.lastUpdated || 'N/A'}</small>
                                </div>
                                <div class="text-end">
                                    <span class="${changeClass} fs-4">
                                        ${meta.currency}${data.price?.toFixed(2) || 'N/A'}
                                    </span>
                                    <div class="${data.change >= 0 ? 'call-badge' : 'put-badge'} mt-1">
                                        ${data.changePercent ? `${data.change >= 0 ? '+' : ''}${data.changePercent}%` : 'N/A'}
                                    </div>
                                </div>
                            </div>
                            ${renderMiniChart(symbol)}
                        </div>
                    </div>
                `;
            }).join('');
        }

        function renderMiniChart(symbol) {
            const history = stocks[symbol]?.history || [];
            if (history.length < 2) return '<div class="chart-container"></div>';
            
            const prices = history.map(item => item.price);
            const minPrice = Math.min(...prices);
            const maxPrice = Math.max(...prices);
            const isPositive = prices[prices.length - 1] >= prices[0];
            
            // Simple SVG sparkline
            const points = prices.map((price, i) => {
                const x = (i / (prices.length - 1)) * 100;
                const y = 100 - ((price - minPrice) / (maxPrice - minPrice)) * 100;
                return `${x},${y}`;
            }).join(' ');
            
            return `
                <div class="chart-container">
                    <svg viewBox="0 0 100 30" preserveAspectRatio="none">
                        <polyline 
                            points="${points}" 
                            fill="none" 
                            stroke="${isPositive ? '#2ecc71' : '#e74c3c'}" 
                            stroke-width="1.5"
                        />
                    </svg>
                </div>
            `;
        }

        function filterStocks() {
            const searchTerm = document.getElementById('stockSearch').value.toLowerCase();
            const cards = document.querySelectorAll('.stock-card');
            
            cards.forEach(card => {
                const symbol = card.getAttribute('data-symbol').toLowerCase();
                const name = card.querySelector('h5').textContent.toLowerCase();
                
                if (symbol.includes(searchTerm) || name.includes(searchTerm)) {
                    card.parentElement.style.display = 'block';
                } else {
                    card.parentElement.style.display = 'none';
                }
            });
        }

        async function showStockDetails(symbol) {
            currentModalStock = symbol;
            const stock = stocks[symbol];
            const data = stockCache[symbol] || {};
            
            // Update basic info
            document.getElementById('stockModalTitle').textContent = stock.name;
            document.getElementById('detailStockName').textContent = stock.name;
            document.getElementById('detailStockSymbol').textContent = `${symbol} • ${stock.market}`;
            document.getElementById('detailStockPrice').textContent = `${stock.currency}${data.price?.toFixed(2) || 'N/A'}`;
            document.getElementById('detailStockPrice').className = `mb-0 me-3 ${data.change >= 0 ? 'positive' : 'negative'}`;
            document.getElementById('detailStockChange').innerHTML = data.changePercent ? 
                `<span class="${data.change >= 0 ? 'call-badge' : 'put-badge'}">
                    ${data.change >= 0 ? '+' : ''}${data.changePercent}% (${stock.currency}${Math.abs(data.change).toFixed(2)})
                </span>` : 'N/A';
            document.getElementById('detailStockMarket').textContent = stock.market;
            document.getElementById('detailStockCurrency').textContent = stock.currency;
            document.getElementById('detailStockUpdated').textContent = stock.lastUpdated || 'N/A';
            
            // Fetch and display history
            showLoader(true);
            try {
                const history = await fetchStockHistory(symbol);
                stock.historyData = history;
                updateHistoryChart(symbol);
                updateHistoryTable(symbol);
            } catch (error) {
                console.error('Error loading stock history:', error);
            } finally {
                showLoader(false);
                modal.show();
            }
        }

        function updateHistoryChart(symbol) {
            const stock = stocks[symbol];
            const history = stock.historyData || [];
            
            if (history.length === 0) {
                document.getElementById('stockHistoryChart').style.display = 'none';
                return;
            }
            
            document.getElementById('stockHistoryChart').style.display = 'block';
            const ctx = document.getElementById('stockHistoryChart').getContext('2d');
            
            // Destroy previous chart if exists
            if (stockCharts[symbol]) {
                stockCharts[symbol].destroy();
            }
            
            const labels = history.map(item => item.date);
            const closes = history.map(item => item.close);
            const isPositive = closes[closes.length - 1] >= closes[0];
            
            stockCharts[symbol] = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Closing Price',
                        data: closes,
                        borderColor: isPositive ? '#2ecc71' : '#e74c3c',
                        backgroundColor: isPositive ? 'rgba(46, 204, 113, 0.1)' : 'rgba(231, 76, 60, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        }
                    }
                }
            });
        }

        function updateHistoryTable(symbol) {
            const stock = stocks[symbol];
            const history = stock.historyData || [];
            const tableBody = document.getElementById('stockHistoryTable');
            
            tableBody.innerHTML = history.map(item => `
                <tr>
                    <td>${item.date}</td>
                    <td>${stock.currency}${item.open.toFixed(2)}</td>
                    <td>${stock.currency}${item.high.toFixed(2)}</td>
                    <td>${stock.currency}${item.low.toFixed(2)}</td>
                    <td>${stock.currency}${item.close.toFixed(2)}</td>
                    <td>${item.volume.toLocaleString()}</td>
                </tr>
            `).join('');
        }

        function addNewStock() {
            const symbol = document.getElementById('newStockSymbol').value.trim().toUpperCase();
            const name = document.getElementById('newStockName').value.trim();
            const market = document.getElementById('newStockMarket').value;
            const currency = document.getElementById('newStockCurrency').value;
            
            if (!symbol || !name || !market || !currency) {
                showNotification('Please fill all fields', 'error');
                return;
            }
            
            if (stocks[symbol]) {
                showNotification('This stock is already being tracked', 'warning');
                return;
            }
            
            // Add the new stock
            stocks[symbol] = {
                name: name,
                currency: currency,
                market: market,
                history: []
            };
            
            // Reset form
            document.getElementById('addStockForm').reset();
            addStockModal.hide();
            
            // Update the display
            updateAllStockPrices();
            showNotification(`${name} (${symbol}) added successfully`, 'success');
        }

        function removeCurrentStock() {
            if (!currentModalStock) return;
            
            const stockName = stocks[currentModalStock].name;
            delete stocks[currentModalStock];
            delete stockCache[currentModalStock];
            
            if (stockCharts[currentModalStock]) {
                stockCharts[currentModalStock].destroy();
                delete stockCharts[currentModalStock];
            }
            
            modal.hide();
            updateStockDisplay();
            updateMarketSummary(Object.keys(stocks).length, 0, 0); // Will be updated on next refresh
            showNotification(`${stockName} removed from tracking`, 'success');
        }

        function showLoader(visible) {
            const loader = document.getElementById('loader');
            loader.style.display = visible ? 'flex' : 'none';
        }

        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `notification ${type} show`;
            
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }
    </script>
</body>
</html>