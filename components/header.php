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
    <!-- Navbar -->
    <nav class="bg-gray-900 border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img class="h-30 w-40" src="assets/images/logo.png" alt="Logo">
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> px-3 py-2 rounded-md text-sm font-medium">Home</a>
                            <a href="models.php" class="<?= basename($_SERVER['PHP_SELF']) == 'models.php' ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> px-3 py-2 rounded-md text-sm font-medium">Model ML</a>
                            <a href="predict_manual.php" class="<?= basename($_SERVER['PHP_SELF']) == 'predict_manual.php' ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> px-3 py-2 rounded-md text-sm font-medium">Prediksi Manual</a>
                            <a href="predict_csv.php" class="<?= basename($_SERVER['PHP_SELF']) == 'predict_csv.php' ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> px-3 py-2 rounded-md text-sm font-medium">Prediksi CSV</a>
                            <a href="history.php" class="<?= basename($_SERVER['PHP_SELF']) == 'history.php' ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> px-3 py-2 rounded-md text-sm font-medium">History</a>
                        </div>
                    </div>
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> block px-3 py-2 rounded-md text-base font-medium">Home</a>
                <a href="predict_manual.php" class="<?= basename($_SERVER['PHP_SELF']) == 'predict_manual.php' ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> block px-3 py-2 rounded-md text-base font-medium">Prediksi Manual</a>
                <a href="predict_csv.php" class="<?= basename($_SERVER['PHP_SELF']) == 'predict_csv.php' ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> block px-3 py-2 rounded-md text-base font-medium">Prediksi CSV</a>
                <a href="models.php" class="<?= basename($_SERVER['PHP_SELF']) == 'models.php' ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> block px-3 py-2 rounded-md text-base font-medium">Model ML</a>
                <a href="history.php" class="<?= basename($_SERVER['PHP_SELF']) == 'history.php' ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> block px-3 py-2 rounded-md text-base font-medium">History</a>
            </div>
        </div>
    </nav>
</body>
</html> 