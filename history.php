<?php
require_once 'config/database.php';

// Get prediction history
$stmt = $pdo->query("SELECT * FROM predictions ORDER BY prediction_date DESC LIMIT 50");
$predictions = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
<body class="min-h-screen flex flex-col text-white">
    <?php include 'components/header.php'; ?>
    <div class="container mx-auto px-4 py-8 flex-1">
        <h1 class="text-3xl font-bold mb-8 text-center">History Prediksi & Perbandingan Model</h1>

        <!-- Prediction History Section -->
        <div class="bg-gray-800 rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4">History Prediksi</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-300">
                    <thead class="text-xs uppercase bg-gray-700">
                        <tr>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Model</th>
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
                        <?php foreach ($predictions as $pred): ?>
                        <tr class="border-b border-gray-700">
                            <td class="px-4 py-3"><?= date('d/m/Y H:i', strtotime($pred['prediction_date'])) ?></td>
                            <td class="px-4 py-3"><?= $pred['model_used'] ?></td>
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