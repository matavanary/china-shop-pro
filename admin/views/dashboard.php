<?php
$pageTitle = "Dashboard";

ob_start();
?>

<!-- Dashboard Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <i class="fas fa-shopping-bag text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-600 text-sm">Total Orders</p>
                <p class="text-2xl font-bold text-gray-800"><?= number_format($stats['total_orders']) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-full">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-600 text-sm">Pending Orders</p>
                <p class="text-2xl font-bold text-gray-800"><?= number_format($stats['pending_orders']) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-full">
                <i class="fas fa-box text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-600 text-sm">Total Products</p>
                <p class="text-2xl font-bold text-gray-800"><?= number_format($stats['total_products']) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-full">
                <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-600 text-sm">Total Revenue</p>
                <p class="text-2xl font-bold text-gray-800">$<?= number_format($stats['total_revenue'], 2) ?></p>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-8">
    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Recent Orders</h3>
                <a href="?page=orders" class="text-blue-600 hover:text-blue-800 text-sm">View All</a>
            </div>
        </div>
        <div class="p-6">
            <?php if (!empty($stats['recent_orders'])): ?>
                <div class="space-y-4">
                    <?php foreach ($stats['recent_orders'] as $order): ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                            <div>
                                <div class="font-medium text-gray-800">
                                    <a href="?page=orders&action=view&id=<?= $order['id'] ?>" class="hover:text-blue-600">
                                        Order #<?= htmlspecialchars($order['order_number']) ?>
                                    </a>
                                </div>
                                <div class="text-sm text-gray-600">
                                    <?= date('M j, Y', strtotime($order['created_at'])) ?>
                                    <?php if ($order['first_name']): ?>
                                        • <?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold text-gray-800">
                                    $<?= number_format($order['total_amount'], 2) ?>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    <?= $order['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                        ($order['status'] === 'processing' ? 'bg-blue-100 text-blue-800' :
                                        ($order['status'] === 'shipped' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 text-center py-8">No orders yet</p>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 gap-4">
                <a 
                    href="?page=products&action=create" 
                    class="flex flex-col items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition"
                >
                    <i class="fas fa-plus-circle text-3xl text-gray-400 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700">Add Product</span>
                </a>
                
                <a 
                    href="?page=categories&action=create" 
                    class="flex flex-col items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition"
                >
                    <i class="fas fa-tags text-3xl text-gray-400 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700">Add Category</span>
                </a>
                
                <a 
                    href="?page=orders" 
                    class="flex flex-col items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition"
                >
                    <i class="fas fa-shopping-bag text-3xl text-gray-400 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700">Manage Orders</span>
                </a>
                
                <a 
                    href="?page=reports" 
                    class="flex flex-col items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition"
                >
                    <i class="fas fa-chart-bar text-3xl text-gray-400 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700">View Reports</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="mt-8 bg-white rounded-lg shadow-md">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">System Status</h3>
    </div>
    <div class="p-6">
        <div class="grid md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">✓</div>
                <div class="text-sm text-gray-600 mt-1">Database Connected</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">✓</div>
                <div class="text-sm text-gray-600 mt-1">File Permissions OK</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">✓</div>
                <div class="text-sm text-gray-600 mt-1">System Running</div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>