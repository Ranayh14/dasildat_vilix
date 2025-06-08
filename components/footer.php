<!-- Footer -->
<footer class="bg-gray-900 text-gray-400 text-sm text-center py-4 mt-auto">
    <p>&copy; <?= date('Y') ?> Prediksi Harga Apartemen | Dibuat dengan <span class="text-red-500">&hearts;</span> oleh Tim ViliX</p>
</footer>

<script>
    // Mobile menu toggle
    const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            const expanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            mobileMenuButton.setAttribute('aria-expanded', !expanded);
            mobileMenu.classList.toggle('hidden');
        });
    }
</script>
</body>
</html> 