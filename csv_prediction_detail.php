<?php
require_once 'config/database.php';

// Get CSV prediction details
$csv_prediction_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get CSV prediction info
$stmt = $pdo->prepare("SELECT * FROM csv_predictions WHERE id = ?");
$stmt->execute([$csv_prediction_id]);
$csv_prediction = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$csv_prediction) {
    header("Location: history.php");
    exit;
}

// Get prediction details
$stmt = $pdo->prepare("SELECT * FROM csv_prediction_details WHERE csv_prediction_id = ?");
$stmt->execute([$csv_prediction_id]);
$predictions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Prediksi CSV</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
    <style>
        body {
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col text-white">
    <?php include 'components/header.php'; ?>
    <div class="container mx-auto px-4 py-8 flex-1">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Detail Prediksi CSV</h1>
            <a href="history.php" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition duration-200">
                Kembali ke History
            </a>
        </div>

        <!-- CSV File Info -->
        <div class="bg-gray-800 rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Informasi File</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-gray-400">Nama File:</p>
                    <p class="font-medium"><?= htmlspecialchars($csv_prediction['file_name']) ?></p>
                </div>
                <div>
                    <p class="text-gray-400">Model yang Digunakan:</p>
                    <p class="font-medium"><?= $csv_prediction['model_used'] ?></p>
                </div>
                <div>
                    <p class="text-gray-400">Tanggal Prediksi:</p>
                    <p class="font-medium"><?= date('d/m/Y H:i', strtotime($csv_prediction['prediction_date'])) ?></p>
                </div>
            </div>
        </div>

        <!-- Prediction Results -->
        <div class="bg-gray-800 rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Hasil Prediksi</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-300">
                    <thead class="text-xs uppercase bg-gray-700">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Menit ke Trans. Umum</th>
                            <th class="px-4 py-3">Luas Total</th>
                            <th class="px-4 py-3">Luas R. Tamu & K. Tidur</th>
                            <th class="px-4 py-3">Luas Dapur</th>
                            <th class="px-4 py-3">Lantai</th>
                            <th class="px-4 py-3">Jumlah Lantai</th>
                            <th class="px-4 py-3">Jumlah Kamar</th>
                            <th class="px-4 py-3">Tipe</th>
                            <th class="px-4 py-3">Renovasi</th>
                            <th class="px-4 py-3">Prediksi Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($predictions as $index => $pred): ?>
                        <tr class="border-b border-gray-700">
                            <td class="px-4 py-3"><?= $index + 1 ?></td>
                            <td class="px-4 py-3"><?= $pred['metro_minutes'] ?></td>
                            <td class="px-4 py-3"><?= $pred['area'] ?> m²</td>
                            <td class="px-4 py-3"><?= $pred['living_area'] ?> m²</td>
                            <td class="px-4 py-3"><?= $pred['kitchen_area'] ?> m²</td>
                            <td class="px-4 py-3"><?= $pred['floor'] ?></td>
                            <td class="px-4 py-3"><?= $pred['num_floors'] ?></td>
                            <td class="px-4 py-3"><?= $pred['num_rooms'] ?></td>
                            <td class="px-4 py-3"><?= $pred['apartment_type'] ?></td>
                            <td class="px-4 py-3"><?= $pred['renovation'] ?></td>
                            <td class="px-4 py-3">Rp <?= number_format($pred['predicted_price'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include 'components/footer.php'; ?>
</body>
</html> 