<?php
$metaDescription = "Browse our collection of quality Chinese products with TikTok videos and fast delivery.";

ob_start();
?>

<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold mb-2"><?= htmlspecialchars($pageTitle) ?></h1>
            <p class="text-gray-600">
                <?php if (isset($search) && $search): ?>
                    Showing results for "<?= htmlspecialchars($search) ?>"
                <?php elseif (isset($category) && $category): ?>
                    <?= htmlspecialchars($category['description'] ?? '') ?>
                <?php else: ?>
                    Discover our complete collection of products
                <?php endif; ?>
            </p>
        </div>
        
        <!-- Sort and filter -->
        <div class="flex items-center space-x-4 mt-4 md:mt-0">
            <select class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>Sort by: Newest</option>
                <option>Price: Low to High</option>
                <option>Price: High to Low</option>
                <option>Most Popular</option>
            </select>
        </div>
    </div>
    
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar -->
        <aside class="lg:w-64 flex-shrink-0">
            <!-- Categories -->
            <div class="bg-white p-4 rounded-lg shadow-md mb-6">
                <h3 class="font-semibold text-lg mb-4">Categories</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="?page=products" class="text-gray-600 hover:text-blue-600 <?= !isset($_GET['category']) ? 'text-blue-600 font-semibold' : '' ?>">
                            All Products
                        </a>
                    </li>
                    <?php foreach ($categories as $cat): ?>
                        <li>
                            <a 
                                href="?page=products&category=<?= $cat['id'] ?>" 
                                class="text-gray-600 hover:text-blue-600 <?= isset($_GET['category']) && $_GET['category'] == $cat['id'] ? 'text-blue-600 font-semibold' : '' ?>"
                            >
                                <?= htmlspecialchars($cat['name']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <!-- Price filter -->
            <div class="bg-white p-4 rounded-lg shadow-md mb-6">
                <h3 class="font-semibold text-lg mb-4">Price Range</h3>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2"> Under $25
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2"> $25 - $50
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2"> $50 - $100
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2"> Over $100
                    </label>
                </div>
            </div>
            
            <!-- Features filter -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h3 class="font-semibold text-lg mb-4">Features</h3>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2"> With TikTok Video
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2"> Free Shipping
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2"> In Stock
                    </label>
                </div>
            </div>
        </aside>
        
        <!-- Main content -->
        <main class="flex-1">
            <?php if (!empty($products)): ?>
                <!-- Products grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <?php foreach ($products as $product): ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden product-card">
                            <div class="relative">
                                <a href="?page=product&id=<?= $product['id'] ?>">
                                    <img 
                                        src="<?= htmlspecialchars($product['primary_image'] ?? 'assets/images/placeholder.jpg') ?>" 
                                        alt="<?= htmlspecialchars($product['name']) ?>"
                                        class="w-full h-48 object-cover"
                                        loading="lazy"
                                    >
                                </a>
                                
                                <!-- TikTok badge -->
                                <?php if (!empty($product['tiktok_url'])): ?>
                                    <a 
                                        href="<?= htmlspecialchars($product['tiktok_url']) ?>" 
                                        target="_blank"
                                        class="absolute top-2 right-2 tiktok-btn text-white px-2 py-1 rounded-full text-xs font-semibold"
                                        title="Watch on TikTok"
                                    >
                                        <i class="fab fa-tiktok"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <!-- Stock badge -->
                                <?php if ($product['track_stock'] && $product['stock_quantity'] <= 5 && $product['stock_quantity'] > 0): ?>
                                    <div class="absolute top-2 left-2 bg-orange-500 text-white px-2 py-1 rounded text-xs">
                                        Only <?= $product['stock_quantity'] ?> left
                                    </div>
                                <?php elseif ($product['track_stock'] && $product['stock_quantity'] <= 0): ?>
                                    <div class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded text-xs">
                                        Out of Stock
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="p-4">
                                <div class="mb-2">
                                    <?php if (isset($product['category_name'])): ?>
                                        <span class="text-xs text-gray-500 uppercase tracking-wide">
                                            <?= htmlspecialchars($product['category_name']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <h3 class="font-semibold text-gray-800 mb-2">
                                    <a href="?page=product&id=<?= $product['id'] ?>" class="hover:text-blue-600 line-clamp-2">
                                        <?= htmlspecialchars($product['name']) ?>
                                    </a>
                                </h3>
                                
                                <?php if ($product['short_description']): ?>
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                        <?= htmlspecialchars($product['short_description']) ?>
                                    </p>
                                <?php endif; ?>
                                
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-lg font-bold text-blue-600">
                                            $<?= number_format($product['price'], 2) ?>
                                        </span>
                                        <?php if ($product['compare_price'] && $product['compare_price'] > $product['price']): ?>
                                            <span class="text-sm text-gray-500 line-through ml-2">
                                                $<?= number_format($product['compare_price'], 2) ?>
                                            </span>
                                            <span class="text-xs text-green-600 ml-1">
                                                (<?= round((($product['compare_price'] - $product['price']) / $product['compare_price']) * 100) ?>% off)
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if (!$product['track_stock'] || $product['stock_quantity'] > 0): ?>
                                        <button 
                                            onclick="cartManager.addToCart(<?= $product['id'] ?>)"
                                            class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition text-sm"
                                        >
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    <?php else: ?>
                                        <span class="text-gray-500 text-sm">Out of Stock</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Pagination -->
                <?php if ($pagination['last_page'] > 1): ?>
                    <nav class="flex justify-center">
                        <div class="flex items-center space-x-1">
                            <?php if ($pagination['current_page'] > 1): ?>
                                <a 
                                    href="?<?= http_build_query(array_merge($_GET, ['p' => $pagination['current_page'] - 1])) ?>" 
                                    class="px-3 py-2 border border-gray-300 rounded hover:bg-gray-50"
                                >
                                    Previous
                                </a>
                            <?php endif; ?>
                            
                            <?php for ($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['last_page'], $pagination['current_page'] + 2); $i++): ?>
                                <a 
                                    href="?<?= http_build_query(array_merge($_GET, ['p' => $i])) ?>" 
                                    class="px-3 py-2 border border-gray-300 rounded <?= $i === $pagination['current_page'] ? 'bg-blue-600 text-white' : 'hover:bg-gray-50' ?>"
                                >
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                            
                            <?php if ($pagination['current_page'] < $pagination['last_page']): ?>
                                <a 
                                    href="?<?= http_build_query(array_merge($_GET, ['p' => $pagination['current_page'] + 1])) ?>" 
                                    class="px-3 py-2 border border-gray-300 rounded hover:bg-gray-50"
                                >
                                    Next
                                </a>
                            <?php endif; ?>
                        </div>
                    </nav>
                <?php endif; ?>
                
            <?php else: ?>
                <!-- No products found -->
                <div class="text-center py-12">
                    <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No products found</h3>
                    <p class="text-gray-500 mb-4">
                        <?php if (isset($search) && $search): ?>
                            We couldn't find any products matching "<?= htmlspecialchars($search) ?>"
                        <?php else: ?>
                            There are no products in this category yet.
                        <?php endif; ?>
                    </p>
                    <a href="?page=products" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                        Browse All Products
                    </a>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>