<?php
$pageTitle = "Create Category";

ob_start();
?>

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Create Category</h1>
        <p class="text-gray-600">Add a new product category</p>
    </div>
    <a 
        href="?page=categories" 
        class="bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-700 transition"
    >
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Categories
    </a>
</div>

<div class="max-w-2xl">
    <form method="POST" action="?page=categories&action=create" class="bg-white rounded-lg shadow-md p-6">
        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category Name *</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter category name"
                >
            </div>
            
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Category description"
                ></textarea>
            </div>
            
            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                <input 
                    type="number" 
                    id="sort_order" 
                    name="sort_order" 
                    value="0"
                    min="0"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <p class="text-xs text-gray-500 mt-1">Lower numbers appear first in category listings</p>
            </div>
            
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                    <span class="text-sm text-gray-700">Active (visible to customers)</span>
                </label>
            </div>
            
            <div class="flex space-x-4">
                <button 
                    type="submit" 
                    class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition font-semibold"
                >
                    <i class="fas fa-save mr-2"></i>
                    Create Category
                </button>
                
                <a 
                    href="?page=categories" 
                    class="bg-gray-300 text-gray-700 py-2 px-6 rounded-md hover:bg-gray-400 transition font-semibold"
                >
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>