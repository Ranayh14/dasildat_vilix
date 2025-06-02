<?php
require_once 'config/database.php';

// Get prediction history
$stmt = $pdo->query("SELECT * FROM predictions ORDER BY prediction_date DESC LIMIT 50");
$predictions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get data for calculating metrics
$stmt = $pdo->query("SELECT predicted_price, actual_price, model_used FROM predictions WHERE actual_price IS NOT NULL");
$metric_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate metrics per model
$metrics = [];
$model_data = [];
foreach ($metric_data as $row) {
    if (!isset($model_data[$row['model_used']])) {
        $model_data[$row['model_used']] = ['predictions' => [], 'actuals' => []];
    }
    $model_data[$row['model_used']]['predictions'][] = (float) $row['predicted_price'];
    $model_data[$row['model_used']]['actuals'][] = (float) $row['actual_price'];
}

foreach ($model_data as $model_name => $data) {
    $n = count($data['predictions']);
    if ($n == 0) continue;

    // Calculate MSE
    $mse = 0;
    for ($i = 0; $i < $n; $i++) {
        $mse += pow($data['predictions'][$i] - $data['actuals'][$i], 2);
    }
    $mse /= $n;

    // Calculate MAE
    $mae = 0;
    for ($i = 0; $i < $n; $i++) {
        $mae += abs($data['predictions'][$i] - $data['actuals'][$i]);
    }
    $mae /= $n;

    // Calculate R2 Score
    $mean_actual = array_sum($data['actuals']) / $n;
    $total_sum_squares = 0;
    $residual_sum_squares = 0;
    for ($i = 0; $i < $n; $i++) {
        $total_sum_squares += pow($data['actuals'][$i] - $mean_actual, 2);
        $residual_sum_squares += pow($data['predictions'][$i] - $data['actuals'][$i], 2);
    }
    $r2 = 1 - ($residual_sum_squares / $total_sum_squares);
    
    $metrics[$model_name] = ['mse' => $mse, 'mae' => $mae, 'r2_score' => $r2];
}

// Prepare data for charts
$chart_labels = array_keys($metrics);
$mse_data = array_column($metrics, 'mse');
$mae_data = array_column($metrics, 'mae');
$r2_data = array_column($metrics, 'r2_score');

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
            <h2 class="text-2xl font-semibold mb-4">Perbandingan Performa Model (dari Data Prediksi Anda)</h2>
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
                            <th class="px-6 py-3">Harga Aktual</th>
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
                            <td class="px-6 py-4"><?= $pred['actual_price'] ? 'Rp ' . number_format($pred['actual_price'], 0, ',', '.') : 'N/A' ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Prepare data for charts
        const chartLabels = <?= json_encode($chart_labels) ?>;
        const mseData = <?= json_encode($mse_data) ?>;
        const maeData = <?= json_encode($mae_data) ?>;
        const r2Data = <?= json_encode($r2_data) ?>;
        
        // MSE and MAE Chart
        const metricsCtx = document.getElementById('metricsChart').getContext('2d');
        new Chart(metricsCtx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'MSE',
                        data: mseData,
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'MAE',
                        data: maeData,
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
                labels: chartLabels,
                datasets: [{
                    label: 'R² Score',
                    data: r2Data,
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