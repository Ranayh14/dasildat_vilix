<?php include 'components/header.php'; 
require_once 'config/database.php';

// Define metrics for each model
$metrics = [
    'DT' => [
        'mse' => 16636768949153.031,
        'r2_score' => 0.825260589647193
    ],
    'KNN' => [
        'mse' => 12660001757974.5,
        'r2_score' => 0.8670293944085466
    ],
    'RF' => [
        'mse' => 11202372803816.945,
        'r2_score' => 0.8823391714897291
    ]
];

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
<main class="flex-grow fade-in">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-4xl font-bold text-white mb-8 text-center">Model Machine Learning</h1>

        <!-- Model Comparison Section -->
        <div class="bg-gray-800 rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-4">Perbandingan Performa Model</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <canvas id="mseChart"></canvas>
                </div>
                <div>
                    <canvas id="r2Chart"></canvas>
                </div>
            </div>
        </div>

        <!-- Decision Tree Section -->
        <div class="bg-gray-800 rounded-lg p-8 mb-8">
            <h2 class="text-2xl font-bold mb-4">Decision Tree</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <p class="text-gray-300 mb-4">
                        Decision Tree adalah model machine learning yang membuat keputusan berdasarkan serangkaian aturan 
                        yang dipelajari dari data. Model ini bekerja seperti diagram alir, di mana setiap node mewakili 
                        keputusan berdasarkan fitur tertentu.
                    </p>
                    <h3 class="text-xl font-semibold mb-2">Kelebihan:</h3>
                    <ul class="list-disc list-inside text-gray-300 mb-4">
                        <li>Mudah dipahami dan diinterpretasikan</li>
                        <li>Dapat menangani data numerik dan kategorikal</li>
                        <li>Membutuhkan sedikit persiapan data</li>
                        <li>Cepat dalam membuat prediksi</li>
                    </ul>
                    <h3 class="text-xl font-semibold mb-2">Kekurangan:</h3>
                    <ul class="list-disc list-inside text-gray-300">
                        <li>Dapat mengalami overfitting</li>
                        <li>Sensitif terhadap perubahan kecil dalam data</li>
                        <li>Mungkin tidak optimal untuk dataset kompleks</li>
                    </ul>
                </div>
                <div class="flex items-center justify-center">
                    <img src="assets/images/decision-tree.png" alt="Decision Tree Illustration" class="max-w-full h-auto rounded-lg shadow-lg">
                </div>
            </div>
        </div>

        <!-- Random Forest Section -->
        <div class="bg-gray-800 rounded-lg p-8 mb-8">
            <h2 class="text-2xl font-bold mb-4">Random Forest</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <p class="text-gray-300 mb-4">
                        Random Forest adalah ensemble learning method yang menggunakan multiple decision trees untuk 
                        menghasilkan prediksi yang lebih akurat. Setiap tree dilatih dengan subset data yang berbeda 
                        dan hasil akhir ditentukan melalui voting atau rata-rata dari semua trees.
                    </p>
                    <h3 class="text-xl font-semibold mb-2">Kelebihan:</h3>
                    <ul class="list-disc list-inside text-gray-300 mb-4">
                        <li>Lebih akurat dari single decision tree</li>
                        <li>Mengurangi overfitting</li>
                        <li>Dapat menangani dataset besar</li>
                        <li>Memberikan estimasi feature importance</li>
                    </ul>
                    <h3 class="text-xl font-semibold mb-2">Kekurangan:</h3>
                    <ul class="list-disc list-inside text-gray-300">
                        <li>Lebih kompleks dan membutuhkan lebih banyak komputasi</li>
                        <li>Membutuhkan lebih banyak memori</li>
                        <li>Kurang interpretable dibanding decision tree tunggal</li>
                    </ul>
                </div>
                <div class="flex items-center justify-center">
                    <img src="assets/images/random-forest.png" alt="Random Forest Illustration" class="max-w-full h-auto rounded-lg shadow-lg">
                </div>
            </div>
        </div>

        <!-- KNN Section -->
        <div class="bg-gray-800 rounded-lg p-8">
            <h2 class="text-2xl font-bold mb-4">K-Nearest Neighbors (KNN)</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <p class="text-gray-300 mb-4">
                        K-Nearest Neighbors adalah algoritma yang memprediksi nilai berdasarkan kesamaan dengan data-data 
                        terdekat. Model ini menggunakan konsep "tetangga terdekat" untuk membuat prediksi, di mana nilai 
                        prediksi didasarkan pada rata-rata atau voting dari k tetangga terdekat.
                    </p>
                    <h3 class="text-xl font-semibold mb-2">Kelebihan:</h3>
                    <ul class="list-disc list-inside text-gray-300 mb-4">
                        <li>Sederhana dan mudah diimplementasikan</li>
                        <li>Tidak memerlukan training model</li>
                        <li>Dapat beradaptasi saat data baru ditambahkan</li>
                        <li>Efektif untuk dataset kecil hingga menengah</li>
                    </ul>
                    <h3 class="text-xl font-semibold mb-2">Kekurangan:</h3>
                    <ul class="list-disc list-inside text-gray-300">
                        <li>Komputasi dapat lambat untuk dataset besar</li>
                        <li>Sensitif terhadap fitur yang tidak relevan</li>
                        <li>Membutuhkan normalisasi fitur</li>
                        <li>Memerlukan penyimpanan seluruh dataset training</li>
                    </ul>
                </div>
                <div class="flex items-center justify-center">
                    <img src="assets/images/knn.png" alt="KNN Illustration" class="max-w-full h-auto rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'components/footer.php'; ?> 

    <script>
        // Prepare data for charts
        const modelLabels = ['Decision Tree', 'KNN', 'Random Forest'];
        const mseData = [
            <?= $metrics['DT']['mse'] ?>,
            <?= $metrics['KNN']['mse'] ?>,
            <?= $metrics['RF']['mse'] ?>
        ];
        const r2Data = [
            <?= $metrics['DT']['r2_score'] ?>,
            <?= $metrics['KNN']['r2_score'] ?>,
            <?= $metrics['RF']['r2_score'] ?>
        ];
        
        // MSE Chart
        const mseCtx = document.getElementById('mseChart').getContext('2d');
        new Chart(mseCtx, {
            type: 'bar',
            data: {
                labels: modelLabels,
                datasets: [{
                    label: 'Mean Squared Error (MSE)',
                    data: mseData,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Perbandingan MSE',
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
                            color: 'white',
                            callback: function(value) {
                                return (value / 1e12).toFixed(2) + ' T';
                            }
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
                labels: modelLabels,
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
                        min: 0.8,
                        max: 0.9,
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