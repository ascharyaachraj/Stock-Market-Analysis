<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Predictive Analytics - Stock Optimization</title>
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
            --dark-bg: #0a1a2f;
            --text-dark: #e0e0e0;
            --card-bg: rgba(255, 255, 255, 0.08);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0a1a2f, #0d2b4e);
            color: var(--text-dark);
            min-height: 100vh;
            padding-top: 20px;
        }

        .dashboard-header {
            background: linear-gradient(135deg, rgba(16, 42, 77, 0.8), rgba(10, 26, 47, 0.9));
            backdrop-filter: blur(10px);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .card {
            background-color: var(--card-bg);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(5px);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            background-color: rgba(255, 255, 255, 0.12);
        }

        .card-title {
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .chart-container {
            height: 300px;
            margin-top: 15px;
        }

        .table {
            color: var(--text-dark);
        }

        .table th {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .table td {
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .positive {
            color: var(--success-color);
        }

        .negative {
            color: var(--danger-color);
        }

        .alert {
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .form-control, .form-select {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        .form-control:focus, .form-select:focus {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }

        .btn-primary {
            background-color: rgba(52, 152, 219, 0.8);
            border-color: rgba(52, 152, 219, 0.5);
        }

        .btn-primary:hover {
            background-color: rgba(52, 152, 219, 1);
            border-color: rgba(52, 152, 219, 0.8);
        }

        .badge {
            font-weight: 500;
            padding: 5px 10px;
        }

        .model-accuracy {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .kpi-card {
            text-align: center;
            padding: 15px;
            border-radius: 8px;
            background-color: rgba(16, 42, 77, 0.5);
            margin-bottom: 15px;
        }

        .kpi-value {
            font-size: 2rem;
            font-weight: bold;
            color: white;
        }

        .kpi-label {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
        }

        @media (max-width: 768px) {
            .chart-container {
                height: 250px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="dashboard-header">
            <div class="row">
                <div class="col-md-8">
                    <h1><i class="fas fa-chart-line me-2"></i> Predictive Stock Analytics</h1>
                    <p class="mb-0">Machine learning forecasts demand and optimizes stock levels</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="last-update">
                        <i class="fas fa-sync-alt me-1"></i> Last Updated: <span id="lastUpdateTime">Just now</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="kpi-card">
                    <div class="kpi-value positive">94.7%</div>
                    <div class="kpi-label">Model Accuracy</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="kpi-card">
                    <div class="kpi-value">$1.2M</div>
                    <div class="kpi-label">Potential Savings</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="kpi-card">
                    <div class="kpi-value positive">23%</div>
                    <div class="kpi-label">Stock Reduction</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="kpi-card">
                    <div class="kpi-value negative">-12%</div>
                    <div class="kpi-label">Stockouts Reduced</div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-8">
                <div class="card">
                    <h5 class="card-title"><i class="fas fa-chart-bar me-2"></i>Demand Forecast vs Actual</h5>
                    <div class="chart-container">
                        <canvas id="demandChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <h5 class="card-title"><i class="fas fa-bell me-2"></i>Stock Alerts</h5>
                    <div class="alert alert-warning">
                        <strong><i class="fas fa-exclamation-triangle me-2"></i>Low Stock</strong>
                        <p class="mb-0">Product A123 is predicted to run out in 3 days</p>
                    </div>
                    <div class="alert alert-success">
                        <strong><i class="fas fa-check-circle me-2"></i>Optimal Stock</strong>
                        <p class="mb-0">Product B456 is at perfect inventory levels</p>
                    </div>
                    <div class="alert alert-danger">
                        <strong><i class="fas fa-times-circle me-2"></i>Overstock</strong>
                        <p class="mb-0">Product C789 has 45% excess inventory</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-6">
                <div class="card">
                    <h5 class="card-title"><i class="fas fa-boxes me-2"></i>Recommended Stock Levels</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Current</th>
                                    <th>Recommended</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>A123</td>
                                    <td>45</td>
                                    <td>78</td>
                                    <td><span class="badge bg-warning">Increase</span></td>
                                </tr>
                                <tr>
                                    <td>B456</td>
                                    <td>120</td>
                                    <td>115</td>
                                    <td><span class="badge bg-success">Optimal</span></td>
                                </tr>
                                <tr>
                                    <td>C789</td>
                                    <td>210</td>
                                    <td>150</td>
                                    <td><span class="badge bg-danger">Decrease</span></td>
                                </tr>
                                <tr>
                                    <td>D012</td>
                                    <td>32</td>
                                    <td>65</td>
                                    <td><span class="badge bg-warning">Increase</span></td>
                                </tr>
                                <tr>
                                    <td>E345</td>
                                    <td>95</td>
                                    <td>90</td>
                                    <td><span class="badge bg-success">Optimal</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <h5 class="card-title"><i class="fas fa-project-diagram me-2"></i>ML Model Performance</h5>
                    <div class="chart-container">
                        <canvas id="modelChart"></canvas>
                    </div>
                    <div class="mt-3">
                        <div class="progress mb-2">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 94.7%" aria-valuenow="94.7" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="mb-1"><strong>Random Forest Model</strong> - 94.7% accuracy</p>
                        <p class="mb-1"><strong>Features:</strong> Historical sales, seasonality, promotions, economic indicators</p>
                        <p class="mb-0"><strong>Last trained:</strong> 2 days ago</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-title"><i class="fas fa-sliders-h me-2"></i>Adjust Forecast Parameters</h5>
                    <form>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="forecastPeriod" class="form-label">Forecast Period</label>
                                    <select class="form-select" id="forecastPeriod">
                                        <option>30 days</option>
                                        <option selected>60 days</option>
                                        <option>90 days</option>
                                        <option>180 days</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="confidenceLevel" class="form-label">Confidence Level</label>
                                    <select class="form-select" id="confidenceLevel">
                                        <option>80%</option>
                                        <option selected>90%</option>
                                        <option>95%</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="safetyStock" class="form-label">Safety Stock %</label>
                                    <input type="number" class="form-control" id="safetyStock" value="15">
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-primary"><i class="fas fa-calculator me-2"></i>Recalculate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script>
        // Initialize charts
        document.addEventListener('DOMContentLoaded', function() {
            // Demand Forecast Chart
            const demandCtx = document.getElementById('demandChart').getContext('2d');
            const demandChart = new Chart(demandCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [
                        {
                            label: 'Actual Demand',
                            data: [120, 190, 170, 210, 230, 250, 220, 240, 260, 280, 300, 320],
                            borderColor: '#3498db',
                            backgroundColor: 'rgba(52, 152, 219, 0.1)',
                            borderWidth: 2,
                            tension: 0.4
                        },
                        {
                            label: 'Predicted Demand',
                            data: [null, null, null, null, null, null, 220, 235, 255, 275, 295, 315],
                            borderColor: '#2ecc71',
                            backgroundColor: 'rgba(46, 204, 113, 0.1)',
                            borderWidth: 2,
                            borderDash: [5, 5],
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: '#e0e0e0'
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#e0e0e0'
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#e0e0e0'
                            }
                        }
                    }
                }
            });

            // Model Performance Chart
            const modelCtx = document.getElementById('modelChart').getContext('2d');
            const modelChart = new Chart(modelCtx, {
                type: 'bar',
                data: {
                    labels: ['Random Forest', 'XGBoost', 'LSTM', 'Prophet', 'ARIMA'],
                    datasets: [{
                        label: 'Model Accuracy (%)',
                        data: [94.7, 92.3, 89.5, 87.1, 83.4],
                        backgroundColor: [
                            'rgba(46, 204, 113, 0.7)',
                            'rgba(52, 152, 219, 0.7)',
                            'rgba(155, 89, 182, 0.7)',
                            'rgba(230, 126, 34, 0.7)',
                            'rgba(231, 76, 60, 0.7)'
                        ],
                        borderColor: [
                            'rgba(46, 204, 113, 1)',
                            'rgba(52, 152, 219, 1)',
                            'rgba(155, 89, 182, 1)',
                            'rgba(230, 126, 34, 1)',
                            'rgba(231, 76, 60, 1)'
                        ],
                        borderWidth: 1
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
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y.toFixed(1) + '% accuracy';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#e0e0e0'
                            }
                        },
                        y: {
                            min: 80,
                            max: 100,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#e0e0e0',
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        }
                    }
                }
            });

            // Update last updated time
            function updateTime() {
                const now = new Date();
                document.getElementById('lastUpdateTime').textContent = now.toLocaleTimeString();
            }
            updateTime();
            setInterval(updateTime, 60000);
        });
    </script>
</body>
</html>