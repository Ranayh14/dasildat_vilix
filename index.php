<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Prediksi Harga Apartemen</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.css" rel="stylesheet" />
  <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen text-gray-800">

<header class="bg-gradient-to-r from-blue-600 to-purple-600 py-10 shadow-md">
  <h1 class="text-4xl md:text-5xl font-bold text-white text-center">Prediksi Harga Apartemen</h1>
</header>

<div class="max-w-7xl mx-auto px-4 py-10">
  <div class="bg-white shadow-lg rounded-lg p-8">

    <div class="mb-6">
      <h4 class="text-lg font-semibold">Petunjuk Pengisian:</h4>
      <ul class="list-disc pl-5 mt-2 text-sm text-gray-700 space-y-1">
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
            <label class='block mb-1 font-medium'>$label</label>
            <input type='number' step='any' name='$name' class='w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500' required>
          </div>";
        }
        ?>
        <div>
          <label class="block mb-1 font-medium">Tipe Apartemen</label>
          <select name="apt_type" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            <option value="New building">Bangunan Baru</option>
            <option value="Secondary">Bangunan Lama</option>
          </select>
        </div>
        <div>
          <label class="block mb-1 font-medium">Renovasi</label>
          <select name="renovation" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            <option value="no">Tidak</option>
            <option value="yes">Ya</option>
          </select>
        </div>
      </div>

      <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition duration-200">
        Prediksi
      </button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $input_data = [
        "Menit ke Transportasi Umum" => $_POST['metro'],
        "Luas Total (m²)" => $_POST['area'],
        "Ruang Tamu & Kamar Tidur (m²)" => $_POST['living_area'],
        "Luas Dapur (m²)" => $_POST['kitchen_area'],
        "Lantai" => $_POST['floor'],
        "Jumlah Lantai Gedung" => $_POST['num_floors'],
        "Jumlah Kamar" => $_POST['num_rooms'],
        "Tipe Apartemen" => $_POST['apt_type'] == "New building" ? "Bangunan Baru" : "Bangunan Lama",
        "Renovasi" => $_POST['renovation'] == "yes" ? "Ya" : "Tidak"
      ];

      echo "<div class='mt-8 bg-gray-100 p-6 rounded-lg'>";
      echo "<h5 class='text-xl font-semibold mb-4 text-gray-700'>Data yang Anda Masukkan:</h5><ul class='list-disc pl-5 space-y-1'>";
      foreach ($input_data as $key => $val) {
        echo "<li><strong>$key:</strong> $val</li>";
      }
      echo "</ul>";

      $args = [
        $_POST['metro'], $_POST['area'], $_POST['living_area'], $_POST['kitchen_area'],
        $_POST['floor'], $_POST['num_floors'], $_POST['num_rooms'],
        escapeshellarg($_POST['apt_type']), escapeshellarg($_POST['renovation'])
      ];

      $arg_string = implode(' ', $args);
      $cmd = "python predict.py $arg_string";
      $output = shell_exec($cmd);

      echo "<div class='mt-5 bg-green-100 text-green-700 px-4 py-3 rounded'>
              <strong>Hasil Prediksi Harga:</strong> Rp " . number_format($output, 0, ',', '.') . "
            </div>";
      echo "</div>";
    }
    ?>
  </div>
</div>

</body>
</html>
