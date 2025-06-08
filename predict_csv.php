<?php include 'components/header.php'; ?>

<main class="flex-grow fade-in">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-4xl font-bold text-white mb-8 text-center">Prediksi dengan File CSV</h1>

        <!-- Petunjuk Format CSV -->
        <div class="mb-10 bg-gray-800 p-6 rounded-lg shadow-lg">
            <h4 class="text-lg font-semibold text-white mb-4">Format File CSV:</h4>
            <p class="text-gray-300 mb-4">
                File CSV harus memiliki header dan format kolom sebagai berikut:
            </p>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-gray-300">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-4 py-2">Nama Kolom</th>
                            <th class="px-4 py-2">Tipe Data</th>
                            <th class="px-4 py-2">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800">
                        <tr>
                            <td class="border px-4 py-2">metro_minutes</td>
                            <td class="border px-4 py-2">Numerik</td>
                            <td class="border px-4 py-2">Waktu ke transportasi umum (menit)</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">area</td>
                            <td class="border px-4 py-2">Numerik</td>
                            <td class="border px-4 py-2">Luas total (m²)</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">living_area</td>
                            <td class="border px-4 py-2">Numerik</td>
                            <td class="border px-4 py-2">Luas ruang tamu & kamar tidur (m²)</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">kitchen_area</td>
                            <td class="border px-4 py-2">Numerik</td>
                            <td class="border px-4 py-2">Luas dapur (m²)</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">floor</td>
                            <td class="border px-4 py-2">Numerik</td>
                            <td class="border px-4 py-2">Lantai apartemen</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">num_floors</td>
                            <td class="border px-4 py-2">Numerik</td>
                            <td class="border px-4 py-2">Jumlah lantai gedung</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">num_rooms</td>
                            <td class="border px-4 py-2">Numerik</td>
                            <td class="border px-4 py-2">Jumlah kamar tidur</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">apartment_type</td>
                            <td class="border px-4 py-2">Text</td>
                            <td class="border px-4 py-2">"New building" atau "Secondary"</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">renovation</td>
                            <td class="border px-4 py-2">Text</td>
                            <td class="border px-4 py-2">"yes" atau "no"</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <h5 class="font-semibold text-white mb-2">Contoh isi file CSV:</h5>
                <pre class="bg-gray-900 p-4 rounded text-gray-300 overflow-x-auto">
metro_minutes,area,living_area,kitchen_area,floor,num_floors,num_rooms,apartment_type,renovation
15,65.5,40.2,12.3,5,12,1,New building,yes
20,48.0,32.5,8.5,3,9,2,Secondary,no</pre>
            </div>
        </div>

        <!-- Form Upload CSV -->
        <div class="bg-gray-900 p-8 rounded-lg shadow-xl">
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Upload File CSV -->
                <div>
                    <label class="block mb-2 font-medium text-white">Upload File CSV</label>
                    <input type="file" name="csv_file" accept=".csv" class="w-full text-sm text-gray-400
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-indigo-600 file:text-white
                        hover:file:bg-indigo-700" required>
                </div>

                <!-- Pilih Model -->
                <div>
                    <label class="block mb-2 font-medium text-white">Pilih Model Prediksi</label>
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
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
                    $file = $_FILES['csv_file'];
                    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    
                    if ($file_ext == 'csv') {
                        $upload_dir = 'uploads/';
                        if (!file_exists($upload_dir)) {
                            mkdir($upload_dir, 0777, true);
                        }
                        
                        $file_path = $upload_dir . basename($file['name']);
                        if (move_uploaded_file($file['tmp_name'], $file_path)) {
                            // Process CSV file with Python script
                            $model = escapeshellarg($_POST['model']);
                            $cmd = "python predict.py $model csv " . escapeshellarg($file_path);
                            $output = shell_exec($cmd);
                            
                            if (strpos($output, 'ERROR') !== false) {
                                echo "<div class='mt-4 bg-red-800 text-red-100 p-4 rounded'>
                                        <strong>Error:</strong> " . htmlspecialchars($output) . "
                                      </div>";
                                unlink($file_path); // Delete the uploaded file
                                exit;
                            }
                            
                            // Save predictions to database
                            require_once 'config/database.php';
                            
                            // Get predictions from python output
                            $predictions = array_filter(explode("\n", trim($output))); // Remove empty lines
                            $num_predictions = count($predictions);
                            
                            if ($num_predictions == 0) {
                                echo "<div class='mt-4 bg-red-800 text-red-100 p-4 rounded'>
                                        <strong>Error:</strong> Tidak ada prediksi yang dihasilkan
                                      </div>";
                                unlink($file_path); // Delete the uploaded file
                                exit;
                            }
                            
                            // Create new CSV prediction record
                            $stmt = $pdo->prepare("INSERT INTO csv_predictions (file_name, num_predictions, model_used) VALUES (?, ?, ?)");
                            $stmt->execute([
                                basename($file['name']),
                                $num_predictions,
                                $_POST['model']
                            ]);
                            $csv_prediction_id = $pdo->lastInsertId();
                            
                            // Re-reading the CSV for input data
                            $file = fopen($file_path, 'r');
                            $headers = fgetcsv($file); // Skip header row
                            
                            foreach ($predictions as $i => $prediction) {
                                $row_data = fgetcsv($file);
                                if ($row_data) {
                                    $stmt = $pdo->prepare("INSERT INTO csv_prediction_details (
                                        csv_prediction_id, metro_minutes, area, living_area, kitchen_area, 
                                        floor, num_floors, num_rooms, apartment_type, renovation, predicted_price
                                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                                    
                                    $stmt->execute([
                                        $csv_prediction_id,
                                        $row_data[0], // Minutes to metro
                                        $row_data[1], // Area
                                        $row_data[2], // Living area
                                        $row_data[3], // Kitchen area
                                        $row_data[4], // Floor
                                        $row_data[5], // Number of floors
                                        $row_data[6], // Number of rooms
                                        $row_data[7], // Apartment type
                                        $row_data[8], // Renovation
                                        (float)$prediction // predicted_price
                                    ]);
                                }
                            }
                            fclose($file);
                            
                            // Delete the uploaded file
                            unlink($file_path);
                            
                            echo "<div class='mt-4 bg-green-800 text-green-100 p-4 rounded'>
                                    <strong>Proses Prediksi Selesai!</strong><br>
                                    Berhasil memprediksi " . $num_predictions . " data.<br>
                                    Hasil prediksi telah tersimpan di History.
                                  </div>";
                                  
                            // Redirect to detail page
                            echo "<script>
                                    setTimeout(function() {
                                        window.location.href = 'csv_prediction_detail.php?id=" . $csv_prediction_id . "';
                                    }, 2000);
                                  </script>";
                        } else {
                            echo "<div class='mt-4 bg-red-800 text-red-100 p-4 rounded'>
                                    <strong>Error:</strong> Gagal mengupload file
                                  </div>";
                        }
                    } else {
                        echo "<div class='mt-4 bg-red-800 text-red-100 p-4 rounded'>
                                <strong>Error:</strong> File harus berformat CSV
                              </div>";
                    }
                }
            }
            ?>
        </div>
    </div>
</main>

<?php include 'components/footer.php'; ?> 