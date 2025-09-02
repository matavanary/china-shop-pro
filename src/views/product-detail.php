<?php
$pageTitle = htmlspecialchars($product['name']);
$metaDescription = htmlspecialchars($product['short_description'] ?? substr($product['description'], 0, 160));

ob_start();
?>

<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-6">
        <a href="?page=home" class="hover:text-blue-600">Home</a>
        <span>/</span>
        <a href="?page=products" class="hover:text-blue-600">Products</a>
        <?php if ($category): ?>
            <span>/</span>
            <a href="?page=products&category=<?= $category['id'] ?>" class="hover:text-blue-600">
                <?= htmlspecialchars($category['name']) ?>
            </a>
        <?php endif; ?>
        <span>/</span>
        <span class="text-gray-800"><?= htmlspecialchars($product['name']) ?></span>
    </nav>
    
    <div class="grid lg:grid-cols-2 gap-12">
        <!-- Product Images -->
        <div>
            <div class="mb-4">
                <img 
                    id="main-product-image"
                    src="<?= htmlspecialchars($product['images'][0]['image_path'] ?? 'assets/images/placeholder.svg') ?>" 
                    alt="<?= htmlspecialchars($product['name']) ?>"
                    class="w-full h-96 object-cover rounded-lg shadow-md"
                >
            </div>
            
            <?php if (count($product['images']) > 1): ?>
                <!-- Thumbnail images -->
                <div class="grid grid-cols-4 gap-2">
                    <?php foreach ($product['images'] as $index => $image): ?>
                        <img 
                            src="<?= htmlspecialchars($image['image_path']) ?>" 
                            alt="<?= htmlspecialchars($image['alt_text'] ?? $product['name']) ?>"
                            class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-75 transition <?= $index === 0 ? 'ring-2 ring-blue-500' : '' ?>"
                            onclick="changeMainImage('<?= htmlspecialchars($image['image_path']) ?>')"
                        >
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Product Info -->
        <div>
            <div class="mb-4">
                <?php if ($category): ?>
                    <a href="?page=products&category=<?= $category['id'] ?>" class="text-sm text-blue-600 hover:text-blue-800">
                        <?= htmlspecialchars($category['name']) ?>
                    </a>
                <?php endif; ?>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($product['name']) ?></h1>
            
            <!-- Price -->
            <div class="mb-6">
                <div class="flex items-center space-x-4">
                    <span class="text-3xl font-bold text-blue-600">
                        $<?= number_format($product['price'], 2) ?>
                    </span>
                    <?php if ($product['compare_price'] && $product['compare_price'] > $product['price']): ?>
                        <span class="text-xl text-gray-500 line-through">
                            $<?= number_format($product['compare_price'], 2) ?>
                        </span>
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm font-semibold">
                            <?= round((($product['compare_price'] - $product['price']) / $product['compare_price']) * 100) ?>% OFF
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Short Description -->
            <?php if ($product['short_description']): ?>
                <div class="mb-6">
                    <p class="text-lg text-gray-700"><?= htmlspecialchars($product['short_description']) ?></p>
                </div>
            <?php endif; ?>
            
            <!-- TikTok Video -->
            <?php if ($product['tiktok_url']): ?>
                <div class="mb-6">
                    <a 
                        href="<?= htmlspecialchars($product['tiktok_url']) ?>" 
                        target="_blank"
                        class="inline-flex items-center tiktok-btn text-white px-6 py-3 rounded-lg font-semibold"
                    >
                        <i class="fab fa-tiktok mr-2 text-xl"></i>
                        Watch Product Video on TikTok
                    </a>
                </div>
            <?php endif; ?>
            
            <!-- Stock Status -->
            <div class="mb-6">
                <?php if ($product['track_stock']): ?>
                    <?php if ($product['stock_quantity'] > 0): ?>
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>In Stock (<?= $product['stock_quantity'] ?> available)</span>
                        </div>
                        <?php if ($product['stock_quantity'] <= 5): ?>
                            <div class="text-orange-600 text-sm mt-1">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Only <?= $product['stock_quantity'] ?> left - order soon!
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="flex items-center text-red-600">
                            <i class="fas fa-times-circle mr-2"></i>
                            <span>Out of Stock</span>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="flex items-center text-green-600">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>In Stock</span>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Add to Cart -->
            <?php if (!$product['track_stock'] || $product['stock_quantity'] > 0): ?>
                <form method="POST" action="?page=cart&action=add" class="mb-8">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    
                    <div class="flex items-center space-x-4 mb-4">
                        <label for="quantity" class="text-sm font-medium text-gray-700">Quantity:</label>
                        <div class="flex items-center border border-gray-300 rounded">
                            <button 
                                type="button" 
                                onclick="updateQuantity(document.getElementById('quantity'), -1)"
                                class="px-3 py-1 hover:bg-gray-100"
                            >
                                -
                            </button>
                            <input 
                                type="number" 
                                id="quantity" 
                                name="quantity" 
                                value="1" 
                                min="1" 
                                max="<?= $product['track_stock'] ? $product['stock_quantity'] : 99 ?>"
                                class="w-16 text-center border-0 focus:outline-none"
                            >
                            <button 
                                type="button" 
                                onclick="updateQuantity(document.getElementById('quantity'), 1)"
                                class="px-3 py-1 hover:bg-gray-100"
                            >
                                +
                            </button>
                        </div>
                    </div>
                    
                    <button 
                        type="submit"
                        class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition text-lg"
                    >
                        <i class="fas fa-cart-plus mr-2"></i>
                        Add to Cart
                    </button>
                </form>
            <?php else: ?>
                <div class="mb-8">
                    <button 
                        disabled
                        class="w-full bg-gray-400 text-white py-3 px-6 rounded-lg font-semibold cursor-not-allowed text-lg"
                    >
                        Out of Stock
                    </button>
                </div>
            <?php endif; ?>
            
            <!-- Product Features -->
            <div class="grid grid-cols-2 gap-4 mb-8">
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-shipping-fast text-green-600 mr-2"></i>
                    <span>Free shipping on orders over $100</span>
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-shield-alt text-blue-600 mr-2"></i>
                    <span>Secure payment</span>
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-undo text-purple-600 mr-2"></i>
                    <span>30-day return policy</span>
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-headset text-orange-600 mr-2"></i>
                    <span>24/7 customer support</span>
                </div>
            </div>
            
            <!-- Product Details -->
            <?php if ($product['sku'] || $product['weight'] || $product['dimensions']): ?>
                <div class="border-t pt-6">
                    <h3 class="font-semibold mb-3">Product Details</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <?php if ($product['sku']): ?>
                            <div><strong>SKU:</strong> <?= htmlspecialchars($product['sku']) ?></div>
                        <?php endif; ?>
                        <?php if ($product['weight']): ?>
                            <div><strong>Weight:</strong> <?= htmlspecialchars($product['weight']) ?> kg</div>
                        <?php endif; ?>
                        <?php if ($product['dimensions']): ?>
                            <div><strong>Dimensions:</strong> <?= htmlspecialchars($product['dimensions']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Product Description -->
    <?php if ($product['description']): ?>
        <div class="mt-12">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold mb-6">Product Description</h2>
                <div class="prose max-w-none text-gray-700">
                    <?= nl2br(htmlspecialchars($product['description'])) ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Related Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($relatedProducts as $relatedProduct): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden product-card">
                        <div class="relative">
                            <a href="?page=product&id=<?= $relatedProduct['id'] ?>">
                                <img 
                                    src="<?= htmlspecialchars($relatedProduct['primary_image'] ?? 'assets/images/placeholder.svg') ?>" 
                                    alt="<?= htmlspecialchars($relatedProduct['name']) ?>"
                                    class="w-full h-48 object-cover"
                                >
                            </a>
                            <?php if ($relatedProduct['tiktok_url']): ?>
                                <a 
                                    href="<?= htmlspecialchars($relatedProduct['tiktok_url']) ?>" 
                                    target="_blank"
                                    class="absolute top-2 right-2 tiktok-btn text-white px-2 py-1 rounded-full text-xs"
                                >
                                    <i class="fab fa-tiktok"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold mb-2">
                                <a href="?page=product&id=<?= $relatedProduct['id'] ?>" class="hover:text-blue-600">
                                    <?= htmlspecialchars($relatedProduct['name']) ?>
                                </a>
                            </h3>
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-bold text-blue-600">
                                    $<?= number_format($relatedProduct['price'], 2) ?>
                                </span>
                                <button 
                                    onclick="cartManager.addToCart(<?= $relatedProduct['id'] ?>)"
                                    class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition text-sm"
                                >
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>