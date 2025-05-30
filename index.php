<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prediksi Harga Apartemen</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.css" rel="stylesheet" />
  <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
  <style>
    body {
      background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
    }
    .fade-in {
      animation: fadeIn 2s ease-in forwards;
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
  </style>
</head>
<body class="min-h-screen text-white flex flex-col">

<!-- Welcome screen -->
<div id="welcome" class="fixed inset-0 z-50 bg-black flex flex-col items-center justify-center text-center text-white">
  <img src="https://cdn-icons-png.flaticon.com/512/1933/1933005.png" alt="Apartment" class="w-24 h-24 mb-4 animate-bounce">
  <h1 class="text-4xl font-bold mb-2">Selamat Datang!</h1>
  <p class="text-lg">Website Prediksi Harga Apartemen</p>
</div>

<!-- Header -->
<header class="bg-gradient-to-r from-indigo-700 to-purple-900 py-10 shadow-md text-center">
  <h1 class="text-4xl md:text-5xl font-bold text-white">Prediksi Harga Apartemen</h1>
</header>

<main class="flex-grow fade-in">
  <div class="max-w-5xl mx-auto px-4 py-10">

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
      <form method="POST" enctype="multipart/form-data" class="space-y-6">
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

          // Tampilkan data input
          echo "<div class='mt-6 bg-gray-800 text-gray-100 p-4 rounded'>
                  <h4 class='text-lg font-semibold mb-2'>Data Input:</h4>
                  <ul class='list-disc pl-5 space-y-1'>";
          foreach ($data_input as $key => $value) {
              echo "<li><strong>$key:</strong> $value</li>";
          }
          echo "  </ul>
                </div>";

          // Tampilkan hasil prediksi
          echo "<div class='mt-4 bg-green-800 text-green-100 p-4 rounded'>
                  <strong>Hasil Prediksi Harga:</strong> Rp " . number_format($output, 0, ',', '.') . "
                </div>";
      }
      ?>
    </div>
  </div>
</main>

<!-- Footer -->
<footer class="bg-gray-900 text-gray-400 text-sm text-center py-4 mt-auto">
  <p>&copy; <?= date('Y') ?> Prediksi Harga Apartemen | Dibuat dengan <span class="text-red-500">&hearts;</span> oleh Tim Mahasiswa</p>
</footer>

<script>
  // Welcome screen fade out
  window.addEventListener("load", () => {
    setTimeout(() => {
      document.getElementById("welcome").classList.add("hidden");
    }, 2000);
  });
</script>

</body>
</html>
