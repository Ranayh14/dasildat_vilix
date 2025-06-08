<?php include 'components/header.php'; ?>

<main class="flex-grow fade-in">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-4xl font-bold text-white mb-8 text-center">Prediksi Manual</h1>

        <!-- Petunjuk Pengisian -->
        <div class="mb-10 bg-gray-800 p-6 rounded-lg shadow-lg">
            <h4 class="text-lg font-semibold text-white">Petunjuk Pengisian:</h4>
            <ul class="list-disc pl-5 mt-2 text-sm space-y-1 text-gray-300">
                <li><strong>Menit ke Transportasi Umum:</strong> Waktu (dalam menit) ke stasiun transportasi umum terdekat.</li>
                <li><strong>Luas Total:</strong> Total luas apartemen dalam m².</li>
                <li><strong>Luas Ruang Tamu & Kamar Tidur:</strong> Ukuran Ruang Tamu dan Kamar Tidur dalam m².</li>
                <li><strong>Luas Dapur:</strong> Ukuran dapur dalam m².</li>
                <li><strong>Lantai:</strong> Lantai tempat apartemen berada.</li>
                <li><strong>Jumlah Lantai Gedung:</strong> Total lantai di gedung.</li>
                <li><strong>Jumlah Kamar:</strong> Termasuk kamar tidur dan ruang tamu.</li>
                <li><strong>Tipe Apartemen:</strong> Bangunan baru atau Bangunan Lama.</li>
                <li><strong>Renovasi:</strong> Apakah sudah direnovasi atau belum.</li>
            </ul>
        </div>

        <!-- Form Input Manual -->
        <div class="bg-gray-900 p-8 rounded-lg shadow-xl">
            <form method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php
                    $fields = [
                        "metro" => "Menit ke Transportasi Umum",
                        "area" => "Luas Total (m²)",
                        "living_area" => "Luas Ruang Tamu & Kamar Tidur (m²)",
                        "kitchen_area" => "Luas Dapur (m²)",
                        "floor" => "Lantai",
                        "num_floors" => "Jumlah Lantai Gedung",
                        "num_rooms" => "Jumlah Kamar"
                    ];
                    foreach ($fields as $name => $label) {
                        echo "
                        <div>
                            <label class='block mb-1 font-medium text-white'>$label</label>
                            <input type='number' step='any' name='$name' class='w-full rounded-md border-gray-700 bg-gray-800 text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500' required>
                        </div>";
                    }
                    ?>
                    <div>
                        <label class="block mb-1 font-medium text-white">Tipe Apartemen</label>
                        <select name="apt_type" class="w-full rounded-md border-gray-700 bg-gray-800 text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            <option value="New building">Bangunan Baru</option>
                            <option value="Secondary">Bangunan Lama</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium text-white">Renovasi</label>
                        <select name="renovation" class="w-full rounded-md border-gray-700 bg-gray-800 text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            <option value="no">Tidak</option>
                            <option value="yes">Ya</option>
                        </select>
                    </div>
                </div>

                <!-- Pilih Model -->
                <div class="mt-6">
                    <label class="block mb-1 font-medium text-white">Pilih Model Prediksi</label>
                    <select name="model" class="w-full rounded-md border-gray-700 bg-gray-800 text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="DT">Decision Tree</option>
                        <option value="RF">Random Forest</option>
                        <option value="KNN">KNN</option>
                    </select>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition duration-200">
                    Prediksi Harga
                </button>
            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['model'])) {
                $data_input = [
                    'Menit ke Transportasi Umum' => $_POST['metro'],
                    'Luas Total (m²)' => $_POST['area'],
                    'Luas Ruang Tamu & Kamar Tidur (m²)' => $_POST['living_area'],
                    'Luas Dapur (m²)' => $_POST['kitchen_area'],
                    'Lantai' => $_POST['floor'],
                    'Jumlah Lantai Gedung' => $_POST['num_floors'],
                    'Jumlah Kamar' => $_POST['num_rooms'],
                    'Tipe Apartemen' => $_POST['apt_type'] == 'New building' ? 'Bangunan Baru' : 'Bangunan Lama',
                    'Renovasi' => $_POST['renovation'] == 'yes' ? 'Ya' : 'Tidak',
                    'Model yang Dipilih' => match ($_POST['model']) {
                        'DT' => 'Decision Tree',
                        'RF' => 'Random Forest',
                        'KNN' => 'K-Nearest Neighbor',
                        default => 'Tidak Diketahui'
                    }
                ];

                $args = [
                    escapeshellarg($_POST['model']),
                    'manual',
                    escapeshellarg($_POST['metro']),
                    escapeshellarg($_POST['area']),
                    escapeshellarg($_POST['living_area']),
                    escapeshellarg($_POST['kitchen_area']),
                    escapeshellarg($_POST['floor']),
                    escapeshellarg($_POST['num_floors']),
                    escapeshellarg($_POST['num_rooms']),
                    escapeshellarg($_POST['apt_type']),
                    escapeshellarg($_POST['renovation'])
                ];
                $arg_string = implode(' ', $args);
                $cmd = "python predict.py $arg_string";
                $output = shell_exec($cmd);

                // Save prediction to database
                require_once 'config/database.php';
                $stmt = $pdo->prepare("INSERT INTO predictions (metro_minutes, area, living_area, kitchen_area, floor, num_floors, num_rooms, apartment_type, renovation, predicted_price, model_used) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $_POST['metro'],
                    $_POST['area'],
                    $_POST['living_area'],
                    $_POST['kitchen_area'],
                    $_POST['floor'],
                    $_POST['num_floors'],
                    $_POST['num_rooms'],
                    $_POST['apt_type'],
                    $_POST['renovation'],
                    $output, // predicted price
                    $_POST['model']
                ]);

                // Tampilkan data input dan hasil prediksi dalam card yang lebih menarik
                echo "<div class='mt-8 bg-gray-800 rounded-lg overflow-hidden'>
                        <div class='bg-gray-700 px-6 py-4'>
                            <h3 class='text-xl font-bold text-white'>Hasil Prediksi</h3>
                        </div>
                        <div class='p-6 space-y-6'>
                            <!-- Data Input -->
                            <div class='grid grid-cols-1 md:grid-cols-2 gap-6'>
                                <div>
                                    <h4 class='text-lg font-semibold text-white mb-4'>Data Input:</h4>
                                    <div class='space-y-3'>";
                                    foreach ($data_input as $key => $value) {
                                        echo "<div class='flex justify-between items-center border-b border-gray-700 pb-2'>
                                                <span class='text-gray-400'>$key:</span>
                                                <span class='text-white font-medium'>$value</span>
                                            </div>";
                                    }
                echo "          </div>
                                </div>
                                <!-- Hasil Prediksi -->
                                <div class='bg-gray-900 rounded-lg p-6 flex flex-col justify-center items-center'>
                                    <h4 class='text-lg font-semibold text-white mb-4'>Prediksi Harga:</h4>
                                    <div class='text-3xl font-bold text-green-500'>
                                        Rp " . number_format($output, 0, ',', '.') . "
                                    </div>
                                    <p class='text-gray-400 mt-2 text-sm'>
                                        *Hasil prediksi berdasarkan model " . $data_input['Model yang Dipilih'] . "
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>";
            }
            ?>
        </div>
    </div>
</main>

<?php include 'components/footer.php'; ?> 