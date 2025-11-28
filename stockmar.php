<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Market Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2962ff;
            --secondary-color: #0d47a1;
            --success-color: #00c853;
            --danger-color: #d50000;
            --warning-color: #ffab00;
            --dark-color: #263238;
            --light-color: #eceff1;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: var(--dark-color);
            overflow-x: hidden;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 5rem 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 L0,100 Z" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="2"/></svg>');
            background-size: 50px 50px;
            opacity: 0.3;
        }

        .hero-title {
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .hero-subtitle {
            font-weight: 300;
            opacity: 0.9;
        }

        .section-title {
            position: relative;
            display: inline-block;
            margin-bottom: 2rem;
        }

        .section-title::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .card-concept {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .card-concept:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .card-concept .card-header {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            padding: 1rem;
        }

        .concept-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .interactive-chart {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .chart-container {
            height: 300px;
            position: relative;
        }

        .tooltip {
            position: absolute;
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.8rem;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 100;
        }

        .timeline {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
        }

        .timeline::after {
            content: '';
            position: absolute;
            width: 6px;
            background-color: var(--primary-color);
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -3px;
            border-radius: 3px;
        }

        .timeline-item {
            padding: 10px 40px;
            position: relative;
            width: 50%;
            box-sizing: border-box;
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            width: 25px;
            height: 25px;
            right: -12px;
            background-color: white;
            border: 4px solid var(--primary-color);
            top: 15px;
            border-radius: 50%;
            z-index: 1;
        }

        .left {
            left: 0;
        }

        .right {
            left: 50%;
        }

        .left::before {
            content: " ";
            height: 0;
            position: absolute;
            top: 22px;
            width: 0;
            z-index: 1;
            right: 30px;
            border: medium solid var(--primary-color);
            border-width: 10px 0 10px 10px;
            border-color: transparent transparent transparent white;
        }

        .right::before {
            content: " ";
            height: 0;
            position: absolute;
            top: 22px;
            width: 0;
            z-index: 1;
            left: 30px;
            border: medium solid var(--primary-color);
            border-width: 10px 10px 10px 0;
            border-color: transparent white transparent transparent;
        }

        .right::after {
            left: -12px;
        }

        .timeline-content {
            padding: 20px 30px;
            background-color: white;
            position: relative;
            border-radius: 6px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .quiz-container {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .quiz-question {
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .quiz-option {
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            background: var(--light-color);
            cursor: pointer;
            transition: all 0.3s;
        }

        .quiz-option:hover {
            background: #cfd8dc;
        }

        .quiz-option.correct {
            background: var(--success-color);
            color: white;
        }

        .quiz-option.incorrect {
            background: var(--danger-color);
            color: white;
        }

        .progress-container {
            height: 10px;
            background: #e0e0e0;
            border-radius: 5px;
            margin-bottom: 1rem;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: var(--primary-color);
            width: 0%;
            transition: width 0.5s ease;
        }

        .nav-pills .nav-link.active {
            background-color: var(--primary-color);
        }

        .nav-pills .nav-link {
            color: var(--dark-color);
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }

        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }

        @media screen and (max-width: 768px) {
            .timeline::after {
                left: 31px;
            }

            .timeline-item {
                width: 100%;
                padding-left: 70px;
                padding-right: 25px;
            }

            .timeline-item::before {
                left: 60px;
                border: medium solid var(--primary-color);
                border-width: 10px 10px 10px 0;
                border-color: transparent white transparent transparent;
            }

            .left::after, .right::after {
                left: 18px;
            }

            .right {
                left: 0%;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section text-center animate-on-scroll">
        <div class="container">
            <h1 class="hero-title animate__animated animate__fadeInDown">Stock Market Academy</h1>
            <p class="hero-subtitle lead animate__animated animate__fadeIn animate__delay-1s">Master the art of stock market analysis with interactive lessons</p>
            <button onclick="window.location.href = 'market.php';" class="btn btn-light btn-lg mt-4 animate__animated animate__fadeInUp animate__delay-2s">Start Learning</button>
        </div>
    </section>

    <!-- Concepts Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center section-title animate-on-scroll">Core Concepts</h2>
            <div class="row g-4">
                <div class="col-md-4 animate-on-scroll">
                    <div class="card card-concept">
                        <div class="card-header">Technical Analysis</div>
                        <div class="card-body text-center">
                            <i class="fas fa-chart-line concept-icon"></i>
                            <p>Learn how to read charts, identify trends, and use technical indicators to predict price movements.</p>
                            <button class="btn btn-outline-primary">Explore</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 animate-on-scroll" style="transition-delay: 0.2s;">
                    <div class="card card-concept">
                        <div class="card-header">Fundamental Analysis</div>
                        <div class="card-body text-center">
                            <i class="fas fa-file-invoice-dollar concept-icon"></i>
                            <p>Understand financial statements, valuation metrics, and how to assess a company's intrinsic value.</p>
                            <button class="btn btn-outline-primary">Explore</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 animate-on-scroll" style="transition-delay: 0.4s;">
                    <div class="card card-concept">
                        <div class="card-header">Market Psychology</div>
                        <div class="card-body text-center">
                            <i class="fas fa-brain concept-icon"></i>
                            <p>Discover how investor behavior and market sentiment influence stock prices and market trends.</p>
                            <button class="btn btn-outline-primary">Explore</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Chart Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title animate-on-scroll">Interactive Chart Analysis</h2>
            <div class="interactive-chart animate-on-scroll">
                <div class="progress-container">
                    <div class="progress-bar" id="chartProgress"></div>
                </div>
                <div class="chart-container" id="mainChart"></div>
                <div class="tooltip" id="chartTooltip"></div>
                <div class="mt-3">
                    <ul class="nav nav-pills mb-3" id="chartTypes">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" data-type="line">Line Chart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-type="candlestick">Candlestick</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-type="bar">Volume Bars</a>
                        </li>
                    </ul>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary" data-range="1m">1M</button>
                    <button type="button" class="btn btn-outline-primary" data-range="3m">3M</button>
                    <button type="button" class="btn btn-outline-primary active" data-range="6m">6M</button>
                    <button type="button" class="btn btn-outline-primary" data-range="1y">1Y</button>
                    <button type="button" class="btn btn-outline-primary" data-range="5y">5Y</button>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6 animate-on-scroll">
                    <div class="card">
                        <div class="card-header bg-primary text-white">Chart Patterns</div>
                        <div class="card-body">
                            <p>Identify common chart patterns that signal potential price movements:</p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Head and Shoulders</li>
                                <li class="list-group-item">Double Top/Bottom</li>
                                <li class="list-group-item">Triangles</li>
                                <li class="list-group-item">Flags and Pennants</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 animate-on-scroll" style="transition-delay: 0.2s;">
                    <div class="card">
                        <div class="card-header bg-primary text-white">Technical Indicators</div>
                        <div class="card-body">
                            <p>Learn how to use these powerful technical indicators:</p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Moving Averages</li>
                                <li class="list-group-item">Relative Strength Index (RSI)</li>
                                <li class="list-group-item">MACD</li>
                                <li class="list-group-item">Bollinger Bands</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Historical Events Timeline -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center section-title animate-on-scroll">Market History Timeline</h2>
            <div class="timeline animate-on-scroll">
                <div class="timeline-item left">
                    <div class="timeline-content">
                        <h3>1929: Wall Street Crash</h3>
                        <p>The most devastating stock market crash in U.S. history, marking the beginning of the Great Depression.</p>
                    </div>
                </div>
                <div class="timeline-item right">
                    <div class="timeline-content">
                        <h3>1987: Black Monday</h3>
                        <p>The largest one-day percentage decline in stock market history, with the DJIA dropping 22.6%.</p>
                    </div>
                </div>
                <div class="timeline-item left">
                    <div class="timeline-content">
                        <h3>2000: Dot-com Bubble</h3>
                        <p>The collapse of overvalued tech stocks after years of speculative investing in internet companies.</p>
                    </div>
                </div>
                <div class="timeline-item right">
                    <div class="timeline-content">
                        <h3>2008: Financial Crisis</h3>
                        <p>Global financial crisis triggered by the collapse of the housing bubble and subprime mortgage crisis.</p>
                    </div>
                </div>
                <div class="timeline-item left">
                    <div class="timeline-content">
                        <h3>2020: COVID-19 Crash</h3>
                        <p>Rapid global market decline followed by one of the fastest recoveries in history.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Quiz -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title animate-on-scroll">Test Your Knowledge</h2>
            <div class="quiz-container animate-on-scroll">
                <div class="progress-container">
                    <div class="progress-bar" id="quizProgress" style="width: 0%"></div>
                </div>
                <h4 class="quiz-question" id="quizQuestion">What does RSI stand for in technical analysis?</h4>
                <div class="quiz-options">
                    <div class="quiz-option" data-correct="false">Real Stock Indicator</div>
                    <div class="quiz-option" data-correct="false">Relative Stock Index</div>
                    <div class="quiz-option" data-correct="true">Relative Strength Index</div>
                    <div class="quiz-option" data-correct="false">Rapid Stock Investment</div>
                </div>
                <div class="mt-3 text-end">
                    <button class="btn btn-primary" id="nextQuestion">Next Question</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5 bg-primary text-white text-center">
        <div class="container animate-on-scroll">
            <h2 class="mb-4">Ready to Master Stock Market Analysis?</h2>
            <p class="lead mb-4">Join thousands of students learning how to analyze stocks like a pro</p>
            <button class="btn btn-light btn-lg">Enroll Now</button>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.0.2"></script>
    <script>
        // Animate on scroll functionality
        const animateElements = document.querySelectorAll('.animate-on-scroll');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.1
        });

        animateElements.forEach(element => {
            observer.observe(element);
        });

        // Interactive Chart
        const chartData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            prices: [150, 165, 142, 178, 190, 205],
            volumes: [1200000, 1500000, 900000, 1800000, 2000000, 1700000],
            opens: [148, 163, 140, 175, 188, 202],
            highs: [155, 168, 145, 182, 195, 210],
            lows: [142, 158, 135, 170, 180, 198],
            closes: [150, 165, 142, 178, 190, 205]
        };

        let currentChartType = 'line';
        let currentRange = '6m';
        let chart;

        function createChart(type) {
            const ctx = document.getElementById('mainChart').getContext('2d');
            
            if (chart) {
                chart.destroy();
            }

            const tooltip = document.getElementById('chartTooltip');
            
            if (type === 'candlestick') {
                chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'OHLC',
                            data: chartData.labels.map((label, i) => ({
                                x: label,
                                o: chartData.opens[i],
                                h: chartData.highs[i],
                                l: chartData.lows[i],
                                c: chartData.closes[i]
                            })),
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            backgroundColor: chartData.closes.map((close, i) => 
                                close >= chartData.opens[i] ? 'rgba(0, 200, 83, 0.7)' : 'rgba(213, 0, 0, 0.7)'
                            )
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
                                enabled: false,
                                external: function(context) {
                                    const data = context.tooltip.dataPoints[0].raw;
                                    tooltip.innerHTML = `
                                        <strong>${context.tooltip.dataPoints[0].label}</strong><br>
                                        Open: $${data.o}<br>
                                        High: $${data.h}<br>
                                        Low: $${data.l}<br>
                                        Close: $${data.c}
                                    `;
                                    tooltip.style.opacity = 1;
                                    tooltip.style.left = context.tooltip.caretX + 'px';
                                    tooltip.style.top = context.tooltip.caretY + 'px';
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false
                            }
                        }
                    }
                });
            } else if (type === 'bar') {
                chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'Volume',
                            data: chartData.volumes,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
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
                                        return 'Volume: ' + context.raw.toLocaleString();
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } else {
                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'Price',
                            data: chartData.prices,
                            borderColor: 'rgba(41, 98, 255, 1)',
                            backgroundColor: 'rgba(41, 98, 255, 0.1)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true
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
                                        return 'Price: $' + context.raw;
                                    }
                                }
                            },
                            annotation: {
                                annotations: {
                                    line1: {
                                        type: 'line',
                                        yMin: 170,
                                        yMax: 170,
                                        borderColor: 'rgb(255, 99, 132)',
                                        borderWidth: 2,
                                        label: {
                                            content: 'Resistance',
                                            enabled: true,
                                            position: 'right'
                                        }
                                    },
                                    line2: {
                                        type: 'line',
                                        yMin: 145,
                                        yMax: 145,
                                        borderColor: 'rgb(75, 192, 192)',
                                        borderWidth: 2,
                                        label: {
                                            content: 'Support',
                                            enabled: true,
                                            position: 'right'
                                        }
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false
                            }
                        }
                    }
                });
            }
        }

        // Initialize chart
        createChart(currentChartType);

        // Chart type switcher
        document.querySelectorAll('#chartTypes .nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector('#chartTypes .nav-link.active').classList.remove('active');
                this.classList.add('active');
                currentChartType = this.dataset.type;
                createChart(currentChartType);
            });
        });

        // Range switcher
        document.querySelectorAll('[data-range]').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelector('[data-range].active').classList.remove('active');
                this.classList.add('active');
                currentRange = this.dataset.range;
                // In a real app, we would fetch new data based on the range
                document.getElementById('chartProgress').style.width = '0%';
                animateProgress('chartProgress', 100, 1500);
            });
        });

        // Chart tooltip
        const chartContainer = document.getElementById('mainChart');
        chartContainer.addEventListener('mousemove', function(e) {
            const tooltip = document.getElementById('chartTooltip');
            tooltip.style.left = e.pageX + 10 + 'px';
            tooltip.style.top = e.pageY + 10 + 'px';
        });

        chartContainer.addEventListener('mouseout', function() {
            document.getElementById('chartTooltip').style.opacity = '0';
        });

        // Quiz functionality
        const quizQuestions = [
            {
                question: "What does P/E ratio stand for?",
                options: [
                    "Price-to-Earnings ratio",
                    "Profit-to-Expense ratio",
                    "Purchase-to-Equity ratio",
                    "Performance-to-Expectation ratio"
                ],
                correct: 0
            },
            {
                question: "Which of these is a bullish chart pattern?",
                options: [
                    "Head and Shoulders",
                    "Double Top",
                    "Cup and Handle",
                    "Descending Triangle"
                ],
                correct: 2
            },
            {
                question: "What does MACD stand for?",
                options: [
                    "Moving Average Convergence Divergence",
                    "Market Analysis Correlation Data",
                    "Monetary Asset Calculation Device",
                    "Multiple Asset Comparison Dashboard"
                ],
                correct: 0
            }
        ];

        let currentQuestion = 0;
        let score = 0;

        function loadQuestion(index) {
            const question = quizQuestions[index];
            document.getElementById('quizQuestion').textContent = question.question;
            const optionsContainer = document.querySelector('.quiz-options');
            optionsContainer.innerHTML = '';
            
            question.options.forEach((option, i) => {
                const optionElement = document.createElement('div');
                optionElement.className = 'quiz-option';
                optionElement.textContent = option;
                optionElement.dataset.correct = i === question.correct ? 'true' : 'false';
                optionElement.addEventListener('click', selectAnswer);
                optionsContainer.appendChild(optionElement);
            });
            
            document.getElementById('quizProgress').style.width = ((index + 1) / quizQuestions.length * 100) + '%';
        }

        function selectAnswer(e) {
            const selectedOption = e.target;
            const isCorrect = selectedOption.dataset.correct === 'true';
            
            document.querySelectorAll('.quiz-option').forEach(option => {
                option.removeEventListener('click', selectAnswer);
                if (option.dataset.correct === 'true') {
                    option.classList.add('correct');
                } else {
                    option.classList.add('incorrect');
                }
            });
            
            if (isCorrect) {
                score++;
            }
            
            document.getElementById('nextQuestion').style.display = 'block';
        }

        document.getElementById('nextQuestion').addEventListener('click', function() {
            currentQuestion++;
            if (currentQuestion < quizQuestions.length) {
                loadQuestion(currentQuestion);
                this.style.display = 'none';
            } else {
                document.querySelector('.quiz-container').innerHTML = `
                    <h4 class="text-center">Quiz Completed!</h4>
                    <p class="text-center">Your score: ${score} out of ${quizQuestions.length}</p>
                    <div class="text-center">
                        <button class="btn btn-primary" onclick="location.reload()">Try Again</button>
                    </div>
                `;
            }
        });

        // Start quiz
        loadQuestion(0);

        // Progress animation
        function animateProgress(elementId, targetPercent, duration) {
            const element = document.getElementById(elementId);
            let start = null;
            const initialWidth = parseFloat(element.style.width) || 0;
            
            function step(timestamp) {
                if (!start) start = timestamp;
                const progress = timestamp - start;
                const increment = (targetPercent - initialWidth) * (progress / duration);
                const currentWidth = initialWidth + increment;
                
                element.style.width = Math.min(currentWidth, targetPercent) + '%';
                
                if (progress < duration) {
                    window.requestAnimationFrame(step);
                }
            }
            
            window.requestAnimationFrame(step);
        }

        // Initialize animations
        animateProgress('chartProgress', 100, 1500);
    </script>
</body>
</html>