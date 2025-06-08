<?php include 'components/header.php'; ?>

<main class="flex-grow fade-in">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-4xl font-bold text-white mb-8 text-center">Model Machine Learning</h1>

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