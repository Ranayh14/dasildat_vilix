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

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
<div id="post-submit-flag" data-submitted="true"></div>
<?php endif; ?>

<!-- Welcome screen -->
<div id="welcome" class="fixed inset-0 z-50 bg-black flex flex-col items-center justify-center text-center text-white">
  <img src="https://cdn-icons-png.flaticon.com/512/1933/1933005.png" alt="Apartment" class="w-24 h-24 mb-4 animate-bounce">
  <h1 class="text-4xl font-bold mb-2">Selamat Datang!</h1>
  <p class="text-lg">Website Prediksi Harga Apartemen</p>
</div>

<?php include 'components/header.php'; ?>

<main class="flex-grow fade-in">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">Prediksi Harga Apartemen</h1>
            <p class="text-xl text-gray-300">Solusi cerdas untuk memprediksi harga apartemen di Moskow dan Oblast</p>
        </div>

        <!-- About Dataset Section -->
        <div class="bg-gray-800 rounded-lg p-8 mb-12">
            <h2 class="text-2xl font-bold mb-4">Tentang Dataset</h2>
            <p class="text-gray-300 mb-4">
                Dataset yang digunakan dalam website ini disediakan oleh Egor Kainov di platform Kaggle. Dataset ini berisi informasi 
                penting untuk memprediksi harga perumahan di wilayah Moskow dan Oblast Moskow yang dikumpulkan pada November 2023.
            </p>
            <p class="text-gray-300">
                Data mencakup berbagai atribut penting yang mempengaruhi harga properti, seperti:
            </p>
            <ul class="list-disc list-inside text-gray-300 mt-2 space-y-2">
                <li>Lokasi properti</li>
                <li>Ukuran dan luas area</li>
                <li>Fasilitas yang tersedia</li>
                <li>Jarak ke transportasi umum</li>
                <li>Kondisi properti (renovasi)</li>
                <li>Dan faktor-faktor relevan lainnya</li>
            </ul>
        </div>

        <!-- Machine Learning Models Section -->
        <div class="grid md:grid-cols-3 gap-8 mb-12">
            <div class="bg-gray-800 rounded-lg p-6">
                <h3 class="text-xl font-bold mb-3">Decision Tree</h3>
                <p class="text-gray-300">
                    Model pembelajaran mesin yang membuat keputusan berdasarkan serangkaian aturan yang dipelajari dari data, 
                    mirip dengan diagram alir keputusan.
                </p>
            </div>
            <div class="bg-gray-800 rounded-lg p-6">
                <h3 class="text-xl font-bold mb-3">Random Forest</h3>
                <p class="text-gray-300">
                    Kumpulan pohon keputusan yang bekerja bersama untuk menghasilkan prediksi yang lebih akurat dan stabil.
                </p>
            </div>
            <div class="bg-gray-800 rounded-lg p-6">
                <h3 class="text-xl font-bold mb-3">K-Nearest Neighbors</h3>
                <p class="text-gray-300">
                    Model yang memprediksi berdasarkan kesamaan dengan data-data terdekat, sangat efektif untuk pola data yang lokal.
                </p>
            </div>
        </div>

        <!-- Features Section -->
        <div class="bg-gray-800 rounded-lg p-8">
            <h2 class="text-2xl font-bold mb-6">Fitur Website</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-3">Prediksi Manual</h3>
                    <p class="text-gray-300">
                        Masukkan data properti secara manual untuk mendapatkan prediksi harga yang akurat menggunakan model pilihan Anda.
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-3">Prediksi Batch (CSV)</h3>
                    <p class="text-gray-300">
                        Upload file CSV dengan multiple data untuk mendapatkan prediksi harga secara massal.
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-3">Perbandingan Model</h3>
                    <p class="text-gray-300">
                        Analisis dan bandingkan performa dari tiga model machine learning yang tersedia.
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-3">History Prediksi</h3>
                    <p class="text-gray-300">
                        Akses riwayat prediksi yang telah dilakukan dan lihat perbandingan dengan harga aktual.
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'components/footer.php'; ?>

<script>
  // Welcome screen fade out
  window.addEventListener("load", () => {
    const postSubmitFlag = document.getElementById('post-submit-flag');
    if (postSubmitFlag && postSubmitFlag.dataset.submitted === 'true') {
      // If page loaded after a POST submission, hide welcome screen instantly
      document.getElementById("welcome").classList.add("hidden");
    } else {
      // Otherwise, show welcome screen and fade out after delay
      setTimeout(() => {
        document.getElementById("welcome").classList.add("hidden");
      }, 2000);
    }
  });
</script>

</body>
</html>
