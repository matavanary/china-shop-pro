<?php
$pageTitle = "Page Not Found";
$metaDescription = "The page you're looking for could not be found.";

ob_start();
?>

<div class="container mx-auto px-4 py-16 text-center">
    <div class="max-w-md mx-auto">
        <i class="fas fa-exclamation-triangle text-8xl text-gray-300 mb-6"></i>
        <h1 class="text-4xl font-bold text-gray-800 mb-4">404</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Page Not Found</h2>
        <p class="text-gray-600 mb-8">
            The page you're looking for doesn't exist or has been moved.
        </p>
        <div class="space-y-4">
            <a 
                href="?page=home" 
                class="block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition"
            >
                Go Home
            </a>
            <a 
                href="?page=products" 
                class="block border border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition"
            >
                Browse Products
            </a>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>