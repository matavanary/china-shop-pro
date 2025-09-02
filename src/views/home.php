<?php
$pageTitle = "Home";
$metaDescription = "Discover amazing Chinese products with TikTok integration. Quality products, fast delivery, and great prices.";

ob_start();
?>

<!-- Hero Section -->
<section class="hero-gradient text-white py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">
            Discover Amazing Chinese Products
        </h1>
        <p class="text-xl md:text-2xl mb-8 opacity-90">
            Quality products with TikTok integration • Fast delivery • Great prices
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="?page=products" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                Shop Now
            </a>
            <a href="#featured" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">
                View Featured
            </a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Shop by Category</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            <?php foreach ($categories as $category): ?>
                <a href="?page=products&category=<?= $category['id'] ?>" class="group">
                    <div class="bg-gray-100 rounded-lg p-6 text-center hover:bg-blue-50 transition group-hover:shadow-lg">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition">
                            <i class="fas fa-box text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800 group-hover:text-blue-600">
                            <?= htmlspecialchars($category['name']) ?>
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            <?= $category['product_count'] ?> products
                        </p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section id="featured" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4">Featured Products</h2>
            <p class="text-gray-600">Handpicked products with TikTok videos</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($featured_products as $product): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden product-card">
                    <div class="relative">
                        <a href="?page=product&id=<?= $product['id'] ?>">
                            <img 
                                src="<?= htmlspecialchars($product['primary_image'] ?? 'assets/images/placeholder.jpg') ?>" 
                                alt="<?= htmlspecialchars($product['name']) ?>"
                                class="w-full h-48 object-cover"
                            >
                        </a>
                        <?php if ($product['tiktok_url']): ?>
                            <a 
                                href="<?= htmlspecialchars($product['tiktok_url']) ?>" 
                                target="_blank"
                                class="absolute top-2 right-2 tiktok-btn text-white px-2 py-1 rounded-full text-sm font-semibold"
                            >
                                <i class="fab fa-tiktok"></i> Video
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2 truncate">
                            <a href="?page=product&id=<?= $product['id'] ?>" class="hover:text-blue-600">
                                <?= htmlspecialchars($product['name']) ?>
                            </a>
                        </h3>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                            <?= htmlspecialchars($product['short_description'] ?? substr($product['description'], 0, 100) . '...') ?>
                        </p>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-lg font-bold text-blue-600">
                                    $<?= number_format($product['price'], 2) ?>
                                </span>
                                <?php if ($product['compare_price'] && $product['compare_price'] > $product['price']): ?>
                                    <span class="text-sm text-gray-500 line-through ml-2">
                                        $<?= number_format($product['compare_price'], 2) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <button 
                                onclick="cartManager.addToCart(<?= $product['id'] ?>)"
                                class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition text-sm"
                            >
                                <i class="fas fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-8">
            <a href="?page=products" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                View All Products
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shipping-fast text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Fast Delivery</h3>
                <p class="text-gray-600">Get your orders delivered quickly with our reliable shipping partners.</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fab fa-tiktok text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">TikTok Integration</h3>
                <p class="text-gray-600">Watch product videos on TikTok to see products in action before buying.</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-purple-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Secure Payment</h3>
                <p class="text-gray-600">Multiple payment options including bank transfer, credit card, and COD.</p>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-16 bg-blue-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Stay Updated</h2>
        <p class="text-xl mb-8 opacity-90">Get notified about new products and special offers</p>
        
        <form class="max-w-md mx-auto flex">
            <input 
                type="email" 
                placeholder="Enter your email" 
                class="flex-1 px-4 py-3 rounded-l-lg text-gray-800 focus:outline-none"
                required
            >
            <button 
                type="submit" 
                class="bg-white text-blue-600 px-6 py-3 rounded-r-lg font-semibold hover:bg-gray-100 transition"
            >
                Subscribe
            </button>
        </form>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>