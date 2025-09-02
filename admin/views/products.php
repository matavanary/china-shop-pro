<?php
$pageTitle = "Products";

ob_start();
?>

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Products</h1>
        <p class="text-gray-600">Manage your product catalog</p>
    </div>
    <a 
        href="?page=products&action=create" 
        class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition"
    >
        <i class="fas fa-plus mr-2"></i>
        Add Product
    </a>
</div>

<!-- Search and Filters -->
<div class="bg-white rounded-lg shadow-md p-4 mb-6">
    <form method="GET" action="?page=products" class="flex items-center space-x-4">
        <input type="hidden" name="page" value="products">
        <div class="flex-1">
            <input 
                type="text" 
                name="search" 
                placeholder="Search products..." 
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>
        <button 
            type="submit" 
            class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition"
        >
            <i class="fas fa-search"></i>
        </button>
        <?php if (!empty($_GET['search'])): ?>
            <a 
                href="?page=products" 
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition"
            >
                Clear
            </a>
        <?php endif; ?>
    </form>
</div>

<!-- Products Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Product
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Category
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Price
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Stock
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($products['data'])): ?>
                    <?php foreach ($products['data'] as $product): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <img 
                                            class="h-12 w-12 rounded object-cover" 
                                            src="<?= htmlspecialchars($product['primary_image'] ?? '../assets/images/placeholder.svg') ?>" 
                                            alt="<?= htmlspecialchars($product['name']) ?>"
                                        >
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <a href="?page=products&action=edit&id=<?= $product['id'] ?>" class="hover:text-blue-600">
                                                <?= htmlspecialchars($product['name']) ?>
                                            </a>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            SKU: <?= htmlspecialchars($product['sku'] ?? 'N/A') ?>
                                        </div>
                                        <?php if ($product['tiktok_url']): ?>
                                            <div class="text-xs text-purple-600">
                                                <i class="fab fa-tiktok mr-1"></i>Has TikTok Video
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= htmlspecialchars($product['category_name'] ?? 'Uncategorized') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    $<?= number_format($product['price'], 2) ?>
                                </div>
                                <?php if ($product['compare_price'] && $product['compare_price'] > $product['price']): ?>
                                    <div class="text-xs text-gray-500 line-through">
                                        $<?= number_format($product['compare_price'], 2) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <?php if ($product['track_stock']): ?>
                                    <span class="<?= $product['stock_quantity'] <= 5 ? 'text-red-600' : 'text-gray-900' ?>">
                                        <?= $product['stock_quantity'] ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-green-600">Unlimited</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?= $product['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <?= $product['is_active'] ? 'Active' : 'Inactive' ?>
                                </span>
                                <?php if ($product['featured']): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ml-2">
                                        Featured
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a 
                                    href="?page=products&action=edit&id=<?= $product['id'] ?>" 
                                    class="text-blue-600 hover:text-blue-900"
                                    title="Edit"
                                >
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a 
                                    href="../?page=product&id=<?= $product['id'] ?>" 
                                    target="_blank"
                                    class="text-green-600 hover:text-green-900"
                                    title="View"
                                >
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a 
                                    href="?page=products&action=delete&id=<?= $product['id'] ?>" 
                                    class="text-red-600 hover:text-red-900"
                                    title="Delete"
                                    onclick="return confirm('Are you sure you want to delete this product?')"
                                >
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-box text-4xl text-gray-300 mb-4"></i>
                            <div>No products found</div>
                            <a href="?page=products&action=create" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                                Add your first product
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<?php if (!empty($products['data']) && $products['last_page'] > 1): ?>
    <div class="flex justify-center mt-6">
        <nav class="flex items-center space-x-1">
            <?php if ($products['current_page'] > 1): ?>
                <a 
                    href="?<?= http_build_query(array_merge($_GET, ['p' => $products['current_page'] - 1])) ?>" 
                    class="px-3 py-2 border border-gray-300 rounded hover:bg-gray-50"
                >
                    Previous
                </a>
            <?php endif; ?>
            
            <?php for ($i = max(1, $products['current_page'] - 2); $i <= min($products['last_page'], $products['current_page'] + 2); $i++): ?>
                <a 
                    href="?<?= http_build_query(array_merge($_GET, ['p' => $i])) ?>" 
                    class="px-3 py-2 border border-gray-300 rounded <?= $i === $products['current_page'] ? 'bg-blue-600 text-white' : 'hover:bg-gray-50' ?>"
                >
                    <?= $i ?>
                </a>
            <?php endfor; ?>
            
            <?php if ($products['current_page'] < $products['last_page']): ?>
                <a 
                    href="?<?= http_build_query(array_merge($_GET, ['p' => $products['current_page'] + 1])) ?>" 
                    class="px-3 py-2 border border-gray-300 rounded hover:bg-gray-50"
                >
                    Next
                </a>
            <?php endif; ?>
        </nav>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>