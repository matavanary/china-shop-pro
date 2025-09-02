<?php
$pageTitle = "Create Product";

ob_start();
?>

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Create Product</h1>
        <p class="text-gray-600">Add a new product to your catalog</p>
    </div>
    <a 
        href="?page=products" 
        class="bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-700 transition"
    >
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Products
    </a>
</div>

<form method="POST" action="?page=products&action=create" class="space-y-6">
    <input type="hidden" name="csrf_token" value="<?= Session::getCSRFToken() ?>">
    
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Basic Information</h3>
                
                <div class="grid gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter product name"
                        >
                    </div>
                    
                    <div>
                        <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1">Short Description</label>
                        <textarea 
                            id="short_description" 
                            name="short_description" 
                            rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Brief product description (shown in product listings)"
                        ></textarea>
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Full Description</label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="6"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Detailed product description"
                        ></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Pricing -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pricing</h3>
                
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input 
                                type="number" 
                                id="price" 
                                name="price" 
                                step="0.01" 
                                min="0" 
                                required
                                class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="0.00"
                            >
                        </div>
                    </div>
                    
                    <div>
                        <label for="compare_price" class="block text-sm font-medium text-gray-700 mb-1">Compare at Price</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input 
                                type="number" 
                                id="compare_price" 
                                name="compare_price" 
                                step="0.01" 
                                min="0"
                                class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="0.00"
                            >
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Original price for showing discounts</p>
                    </div>
                </div>
            </div>
            
            <!-- Inventory -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Inventory</h3>
                
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                        <input 
                            type="text" 
                            id="sku" 
                            name="sku"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Product SKU"
                        >
                    </div>
                    
                    <div>
                        <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity</label>
                        <input 
                            type="number" 
                            id="stock_quantity" 
                            name="stock_quantity" 
                            min="0" 
                            value="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>
                </div>
            </div>
            
            <!-- TikTok Integration -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fab fa-tiktok text-purple-600 mr-2"></i>
                    TikTok Integration
                </h3>
                
                <div>
                    <label for="tiktok_url" class="block text-sm font-medium text-gray-700 mb-1">TikTok Video URL</label>
                    <input 
                        type="url" 
                        id="tiktok_url" 
                        name="tiktok_url"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="https://www.tiktok.com/@username/video/123456"
                    >
                    <p class="text-xs text-gray-500 mt-1">Add a TikTok video URL to showcase your product in action</p>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Product Status -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Status</h3>
                
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                        <span class="text-sm text-gray-700">Active (visible to customers)</span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="checkbox" name="featured" value="1" class="mr-2">
                        <span class="text-sm text-gray-700">Featured product</span>
                    </label>
                </div>
            </div>
            
            <!-- Category -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Category</h3>
                
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Product Category *</label>
                    <select 
                        id="category_id" 
                        name="category_id" 
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>">
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <!-- Product Images -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Images</h3>
                
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-600">
                        Image upload will be available after creating the product
                    </p>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="space-y-3">
                    <button 
                        type="submit" 
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition font-semibold"
                    >
                        <i class="fas fa-save mr-2"></i>
                        Create Product
                    </button>
                    
                    <a 
                        href="?page=products" 
                        class="w-full block text-center bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400 transition font-semibold"
                    >
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>