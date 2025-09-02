<?php
$config = require __DIR__ . '/../config/app.php';
$cart = new Cart();
$cartCount = $cart->getCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - ' : '' ?><?= htmlspecialchars($config['app_name']) ?></title>
    <meta name="description" content="<?= isset($metaDescription) ? htmlspecialchars($metaDescription) : 'Quality Chinese products with fast delivery' ?>">
    
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-40">
        <div class="container mx-auto px-4">
            <!-- Top bar -->
            <div class="flex justify-between items-center py-2 text-sm text-gray-600 border-b border-gray-200">
                <div class="flex items-center space-x-4">
                    <span><i class="fas fa-phone mr-1"></i> +1-555-0123</span>
                    <span><i class="fas fa-envelope mr-1"></i> contact@chinashoppro.com</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="?page=track-order" class="hover:text-blue-600">Track Order</a>
                    <?php if (Session::isLoggedIn()): ?>
                        <span>Hello, <?= htmlspecialchars(Session::getUser()['first_name']) ?>!</span>
                        <a href="?page=account" class="hover:text-blue-600">My Account</a>
                        <a href="?page=logout" class="hover:text-blue-600">Logout</a>
                    <?php else: ?>
                        <a href="?page=login" class="hover:text-blue-600">Login</a>
                        <a href="?page=register" class="hover:text-blue-600">Register</a>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Main navigation -->
            <nav class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="?page=home" class="text-2xl font-bold text-blue-600">
                        <i class="fas fa-store mr-2"></i>
                        China Shop Pro
                    </a>
                </div>
                
                <!-- Search bar -->
                <div class="hidden md:flex flex-1 max-w-lg mx-8">
                    <form action="?page=products" method="GET" class="flex w-full">
                        <input type="hidden" name="page" value="products">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Search for products..." 
                            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        <button 
                            type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                
                <!-- Cart and mobile menu -->
                <div class="flex items-center space-x-4">
                    <!-- Cart -->
                    <a href="?page=cart" class="relative">
                        <i class="fas fa-shopping-cart text-xl text-gray-700 hover:text-blue-600"></i>
                        <?php if ($cartCount > 0): ?>
                            <span class="cart-count absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                <?= $cartCount ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    
                    <!-- Mobile menu button -->
                    <button onclick="toggleMobileMenu()" class="md:hidden">
                        <i class="fas fa-bars text-xl text-gray-700"></i>
                    </button>
                </div>
            </nav>
        </div>
        
        <!-- Mobile menu -->
        <div class="mobile-menu md:hidden fixed inset-y-0 left-0 w-64 bg-white shadow-lg z-50">
            <div class="p-4">
                <button onclick="toggleMobileMenu()" class="float-right">
                    <i class="fas fa-times text-xl"></i>
                </button>
                <div class="clear-both pt-8">
                    <div class="mb-4">
                        <form action="?page=products" method="GET">
                            <input type="hidden" name="page" value="products">
                            <input 
                                type="text" 
                                name="search" 
                                placeholder="Search..." 
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                        </form>
                    </div>
                    <nav class="space-y-2">
                        <a href="?page=home" class="block py-2 text-gray-700 hover:text-blue-600">Home</a>
                        <a href="?page=products" class="block py-2 text-gray-700 hover:text-blue-600">All Products</a>
                        <a href="?page=cart" class="block py-2 text-gray-700 hover:text-blue-600">Cart (<?= $cartCount ?>)</a>
                        <a href="?page=track-order" class="block py-2 text-gray-700 hover:text-blue-600">Track Order</a>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Flash messages -->
    <?php if (Session::hasFlash()): ?>
        <div class="container mx-auto px-4 mt-4">
            <?php foreach (Session::getFlash() as $type => $message): ?>
                <div class="alert alert-<?= $type === 'error' ? 'error' : ($type === 'success' ? 'success' : 'info') ?> flex justify-between items-center">
                    <span><?= htmlspecialchars($message) ?></span>
                    <button onclick="this.parentElement.remove()" class="text-lg">×</button>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <!-- Main content -->
    <main class="min-h-screen">
        <?= $content ?? '' ?>
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12 mt-16">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Company info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">China Shop Pro</h3>
                    <p class="text-gray-300 mb-4">Your trusted source for quality Chinese products with fast delivery worldwide.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                
                <!-- Quick links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="?page=products" class="hover:text-white">All Products</a></li>
                        <li><a href="?page=track-order" class="hover:text-white">Track Order</a></li>
                        <li><a href="?page=shipping-info" class="hover:text-white">Shipping Info</a></li>
                        <li><a href="?page=returns" class="hover:text-white">Returns</a></li>
                    </ul>
                </div>
                
                <!-- Customer service -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Customer Service</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="?page=contact" class="hover:text-white">Contact Us</a></li>
                        <li><a href="?page=faq" class="hover:text-white">FAQ</a></li>
                        <li><a href="?page=support" class="hover:text-white">Support</a></li>
                        <li><a href="?page=feedback" class="hover:text-white">Feedback</a></li>
                    </ul>
                </div>
                
                <!-- Payment methods -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Payment Methods</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-gray-700 px-2 py-1 rounded text-sm">Bank Transfer</span>
                        <span class="bg-gray-700 px-2 py-1 rounded text-sm">Credit Card</span>
                        <span class="bg-gray-700 px-2 py-1 rounded text-sm">Cash on Delivery</span>
                    </div>
                    
                    <div class="mt-4">
                        <h4 class="font-semibold mb-2">Contact Info</h4>
                        <p class="text-gray-300 text-sm">
                            <i class="fas fa-phone mr-1"></i> +1-555-0123<br>
                            <i class="fas fa-envelope mr-1"></i> contact@chinashoppro.com
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; <?= date('Y') ?> China Shop Pro. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- JavaScript -->
    <script src="assets/js/app.js"></script>
</body>
</html>