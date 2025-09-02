<?php
$pageTitle = "Categories";

ob_start();
?>

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Categories</h1>
        <p class="text-gray-600">Organize your products into categories</p>
    </div>
    <a 
        href="?page=categories&action=create" 
        class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition"
    >
        <i class="fas fa-plus mr-2"></i>
        Add Category
    </a>
</div>

<!-- Categories Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Category
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Description
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Products
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Sort Order
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
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    <?= htmlspecialchars($category['name']) ?>
                                </div>
                                <div class="text-sm text-gray-500">
                                    Slug: <?= htmlspecialchars($category['slug']) ?>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs truncate">
                                    <?= htmlspecialchars($category['description'] ?? 'No description') ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <a 
                                    href="?page=products&category=<?= $category['id'] ?>" 
                                    class="text-blue-600 hover:text-blue-800"
                                >
                                    <?= $category['product_count'] ?> products
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= $category['sort_order'] ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?= $category['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <?= $category['is_active'] ? 'Active' : 'Inactive' ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a 
                                    href="?page=categories&action=edit&id=<?= $category['id'] ?>" 
                                    class="text-blue-600 hover:text-blue-900"
                                    title="Edit"
                                >
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a 
                                    href="../?page=products&category=<?= $category['id'] ?>" 
                                    target="_blank"
                                    class="text-green-600 hover:text-green-900"
                                    title="View Products"
                                >
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php if ($category['product_count'] == 0): ?>
                                    <a 
                                        href="?page=categories&action=delete&id=<?= $category['id'] ?>" 
                                        class="text-red-600 hover:text-red-900"
                                        title="Delete"
                                        onclick="return confirm('Are you sure you want to delete this category?')"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-tags text-4xl text-gray-300 mb-4"></i>
                            <div>No categories found</div>
                            <a href="?page=categories&action=create" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                                Create your first category
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>