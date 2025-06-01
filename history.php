<?php
require_once 'config/database.php';

// Get prediction history
$stmt = $pdo->query("SELECT * FROM predictions ORDER BY prediction_date DESC LIMIT 50");
$predictions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get model metrics
$stmt = $pdo->query("SELECT * FROM model_metrics ORDER BY update_date DESC LIMIT 1");
$metrics = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Prediksi & Perbandingan Model</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
    <style>
        body {
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
        }
    </style>
</head>
<body class="min-h-screen text-white">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8 text-center">History Prediksi & Perbandingan Model</h1>

        <!-- Model Comparison Section -->
        <div class="bg-gray-800 rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-4">Perbandingan Performa Model</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <canvas id="metricsChart"></canvas>
                </div>
                <div>
                    <canvas id="r2Chart"></canvas>
                </div>
            </div>
        </div>

        <!-- Prediction History Section -->
        <div class="bg-gray-800 rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4">History Prediksi</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-300">
                    <thead class="text-xs uppercase bg-gray-700">
                        <tr>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Model</th>
                            <th class="px-6 py-3">Luas Total</th>
                            <th class="px-6 py-3">Jumlah Kamar</th>
                            <th class="px-6 py-3">Tipe</th>
                            <th class="px-6 py-3">Prediksi Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($predictions as $pred): ?>
                        <tr class="border-b border-gray-700">
                            <td class="px-6 py-4"><?= date('d/m/Y H:i', strtotime($pred['prediction_date'])) ?></td>
                            <td class="px-6 py-4"><?= $pred['model_used'] ?></td>
                            <td class="px-6 py-4"><?= $pred['area'] ?> m²</td>
                            <td class="px-6 py-4"><?= $pred['num_rooms'] ?></td>
                            <td class="px-6 py-4"><?= $pred['apartment_type'] ?></td>
                            <td class="px-6 py-4">Rp <?= number_format($pred['predicted_price'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Prepare data for charts
        const metrics = <?= json_encode($metrics) ?>;
        const models = ['DT', 'RF', 'KNN'];
        
        // MSE and MAE Chart
        const metricsCtx = document.getElementById('metricsChart').getContext('2d');
        new Chart(metricsCtx, {
            type: 'bar',
            data: {
                labels: models,
                datasets: [
                    {
                        label: 'MSE',
                        data: models.map(model => metrics.find(m => m.model_name === model)?.mse || 0),
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'MAE',
                        data: models.map(model => metrics.find(m => m.model_name === model)?.mae || 0),
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Perbandingan MSE dan MAE',
                        color: 'white'
                    },
                    legend: {
                        labels: {
                            color: 'white'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'white'
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    },
                    x: {
                        ticks: {
                            color: 'white'
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    }
                }
            }
        });

        // R² Score Chart
        const r2Ctx = document.getElementById('r2Chart').getContext('2d');
        new Chart(r2Ctx, {
            type: 'bar',
            data: {
                labels: models,
                datasets: [{
                    label: 'R² Score',
                    data: models.map(model => metrics.find(m => m.model_name === model)?.r2_score || 0),
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Perbandingan R² Score',
                        color: 'white'
                    },
                    legend: {
                        labels: {
                            color: 'white'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 1,
                        ticks: {
                            color: 'white'
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    },
                    x: {
                        ticks: {
                            color: 'white'
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html> 