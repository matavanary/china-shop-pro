<?php
$pageTitle = "Orders";

ob_start();
?>

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Orders</h1>
        <p class="text-gray-600">Manage customer orders</p>
    </div>
</div>

<!-- Order Status Filter -->
<div class="bg-white rounded-lg shadow-md p-4 mb-6">
    <div class="flex items-center space-x-4">
        <span class="text-sm font-medium text-gray-700">Filter by status:</span>
        <a 
            href="?page=orders" 
            class="px-3 py-1 rounded-full text-sm <?= empty($_GET['status']) ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?>"
        >
            All
        </a>
        <a 
            href="?page=orders&status=pending" 
            class="px-3 py-1 rounded-full text-sm <?= ($_GET['status'] ?? '') === 'pending' ? 'bg-yellow-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?>"
        >
            Pending
        </a>
        <a 
            href="?page=orders&status=processing" 
            class="px-3 py-1 rounded-full text-sm <?= ($_GET['status'] ?? '') === 'processing' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?>"
        >
            Processing
        </a>
        <a 
            href="?page=orders&status=shipped" 
            class="px-3 py-1 rounded-full text-sm <?= ($_GET['status'] ?? '') === 'shipped' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?>"
        >
            Shipped
        </a>
        <a 
            href="?page=orders&status=delivered" 
            class="px-3 py-1 rounded-full text-sm <?= ($_GET['status'] ?? '') === 'delivered' ? 'bg-green-800 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?>"
        >
            Delivered
        </a>
    </div>
</div>

<!-- Orders Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Order
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Customer
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Payment
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Total
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($orders['data'])): ?>
                    <?php foreach ($orders['data'] as $order): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    <a href="?page=orders&action=view&id=<?= $order['id'] ?>" class="hover:text-blue-600">
                                        #<?= htmlspecialchars($order['order_number']) ?>
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <?php 
                                    $billing = json_decode($order['billing_address'], true);
                                    echo htmlspecialchars($billing['first_name'] . ' ' . $billing['last_name']);
                                    ?>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <?= htmlspecialchars($billing['email'] ?? '') ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= date('M j, Y', strtotime($order['created_at'])) ?><br>
                                <span class="text-xs text-gray-500"><?= date('g:i A', strtotime($order['created_at'])) ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?= $order['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                        ($order['status'] === 'processing' ? 'bg-blue-100 text-blue-800' :
                                        ($order['status'] === 'shipped' ? 'bg-green-100 text-green-800' : 
                                        ($order['status'] === 'delivered' ? 'bg-green-200 text-green-900' : 'bg-gray-100 text-gray-800'))) ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?= $order['payment_status'] === 'paid' ? 'bg-green-100 text-green-800' : 
                                        ($order['payment_status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') ?>">
                                    <?= ucfirst($order['payment_status']) ?>
                                </span>
                                <div class="text-xs text-gray-500 mt-1">
                                    <?= ucfirst(str_replace('_', ' ', $order['payment_method'])) ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                $<?= number_format($order['total_amount'], 2) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a 
                                    href="?page=orders&action=view&id=<?= $order['id'] ?>" 
                                    class="text-blue-600 hover:text-blue-900"
                                    title="View Order"
                                >
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-shopping-bag text-4xl text-gray-300 mb-4"></i>
                            <div>No orders found</div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<?php if (!empty($orders['data']) && $orders['last_page'] > 1): ?>
    <div class="flex justify-center mt-6">
        <nav class="flex items-center space-x-1">
            <?php if ($orders['current_page'] > 1): ?>
                <a 
                    href="?<?= http_build_query(array_merge($_GET, ['p' => $orders['current_page'] - 1])) ?>" 
                    class="px-3 py-2 border border-gray-300 rounded hover:bg-gray-50"
                >
                    Previous
                </a>
            <?php endif; ?>
            
            <?php for ($i = max(1, $orders['current_page'] - 2); $i <= min($orders['last_page'], $orders['current_page'] + 2); $i++): ?>
                <a 
                    href="?<?= http_build_query(array_merge($_GET, ['p' => $i])) ?>" 
                    class="px-3 py-2 border border-gray-300 rounded <?= $i === $orders['current_page'] ? 'bg-blue-600 text-white' : 'hover:bg-gray-50' ?>"
                >
                    <?= $i ?>
                </a>
            <?php endfor; ?>
            
            <?php if ($orders['current_page'] < $orders['last_page']): ?>
                <a 
                    href="?<?= http_build_query(array_merge($_GET, ['p' => $orders['current_page'] + 1])) ?>" 
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