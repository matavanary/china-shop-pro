<?php
$pageTitle = "Order #" . $order['order_number'];

ob_start();
?>

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Order #<?= htmlspecialchars($order['order_number']) ?></h1>
        <p class="text-gray-600">Order placed on <?= date('F j, Y \a\t g:i A', strtotime($order['created_at'])) ?></p>
    </div>
    <a 
        href="?page=orders" 
        class="bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-700 transition"
    >
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Orders
    </a>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <!-- Order Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Order Items</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <?php foreach ($order['items'] as $item): ?>
                        <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                            <div class="flex-1">
                                <div class="font-medium text-gray-800">
                                    <?= htmlspecialchars($item['product_name']) ?>
                                </div>
                                <div class="text-sm text-gray-600">
                                    SKU: <?= htmlspecialchars($item['product_sku'] ?? 'N/A') ?>
                                </div>
                                <div class="text-sm text-gray-600">
                                    Quantity: <?= $item['quantity'] ?> × $<?= number_format($item['price'], 2) ?>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold text-gray-800">
                                    $<?= number_format($item['total'], 2) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Order Totals -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>$<?= number_format($order['subtotal'], 2) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping</span>
                            <span>
                                <?php if ($order['shipping_amount'] > 0): ?>
                                    $<?= number_format($order['shipping_amount'], 2) ?>
                                <?php else: ?>
                                    <span class="text-green-600">Free</span>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span>Tax</span>
                            <span>$<?= number_format($order['tax_amount'], 2) ?></span>
                        </div>
                        <div class="flex justify-between text-lg font-semibold border-t pt-2">
                            <span>Total</span>
                            <span>$<?= number_format($order['total_amount'], 2) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Customer Information -->
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Billing Address -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Billing Address</h3>
                <?php $billing = $order['billing_address']; ?>
                <div class="text-sm text-gray-700 space-y-1">
                    <div class="font-medium"><?= htmlspecialchars($billing['first_name'] . ' ' . $billing['last_name']) ?></div>
                    <div><?= htmlspecialchars($billing['address_line_1']) ?></div>
                    <?php if ($billing['address_line_2']): ?>
                        <div><?= htmlspecialchars($billing['address_line_2']) ?></div>
                    <?php endif; ?>
                    <div><?= htmlspecialchars($billing['city'] . ', ' . $billing['state'] . ' ' . $billing['postal_code']) ?></div>
                    <div><?= htmlspecialchars($billing['country']) ?></div>
                    <div class="pt-2 space-y-1">
                        <div><strong>Email:</strong> <?= htmlspecialchars($billing['email']) ?></div>
                        <div><strong>Phone:</strong> <?= htmlspecialchars($billing['phone']) ?></div>
                    </div>
                </div>
            </div>
            
            <!-- Shipping Address -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Shipping Address</h3>
                <?php $shipping = $order['shipping_address']; ?>
                <div class="text-sm text-gray-700 space-y-1">
                    <div class="font-medium"><?= htmlspecialchars($shipping['first_name'] . ' ' . $shipping['last_name']) ?></div>
                    <div><?= htmlspecialchars($shipping['address_line_1']) ?></div>
                    <?php if ($shipping['address_line_2']): ?>
                        <div><?= htmlspecialchars($shipping['address_line_2']) ?></div>
                    <?php endif; ?>
                    <div><?= htmlspecialchars($shipping['city'] . ', ' . $shipping['state'] . ' ' . $shipping['postal_code']) ?></div>
                    <div><?= htmlspecialchars($shipping['country']) ?></div>
                </div>
            </div>
        </div>
        
        <!-- Customer Notes -->
        <?php if ($order['customer_notes']): ?>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Customer Notes</h3>
                <p class="text-gray-700"><?= nl2br(htmlspecialchars($order['customer_notes'])) ?></p>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Order Status -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Status</h3>
            
            <form method="POST" action="?page=orders&action=update-status">
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                
                <div class="space-y-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Order Status</label>
                        <select 
                            id="status" 
                            name="status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>Processing</option>
                            <option value="shipped" <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                            <option value="delivered" <?= $order['status'] === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                            <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-1">Admin Notes</label>
                        <textarea 
                            id="admin_notes" 
                            name="admin_notes" 
                            rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Add internal notes..."
                        ><?= htmlspecialchars($order['admin_notes'] ?? '') ?></textarea>
                    </div>
                    
                    <button 
                        type="submit" 
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition font-semibold"
                    >
                        Update Status
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Payment Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment Information</h3>
            
            <div class="space-y-3">
                <div>
                    <span class="text-sm font-medium text-gray-700">Payment Method:</span>
                    <div class="text-sm text-gray-900">
                        <?php
                        $paymentMethods = [
                            'bank_transfer' => 'Bank Transfer',
                            'paysolution' => 'Credit Card (Paysolution)',
                            'cod' => 'Cash on Delivery'
                        ];
                        echo $paymentMethods[$order['payment_method']] ?? $order['payment_method'];
                        ?>
                    </div>
                </div>
                
                <div>
                    <span class="text-sm font-medium text-gray-700">Payment Status:</span>
                    <div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            <?= $order['payment_status'] === 'paid' ? 'bg-green-100 text-green-800' : 
                                ($order['payment_status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') ?>">
                            <?= ucfirst($order['payment_status']) ?>
                        </span>
                    </div>
                </div>
                
                <?php if ($order['payment_method'] === 'bank_transfer' && $order['payment_status'] === 'pending'): ?>
                    <div class="mt-4 p-3 bg-yellow-50 rounded border border-yellow-200">
                        <p class="text-xs text-yellow-800">
                            <strong>Waiting for bank transfer:</strong><br>
                            Customer needs to complete payment and send receipt.
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Order Timeline -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Timeline</h3>
            
            <div class="space-y-3">
                <div class="flex items-center text-sm">
                    <div class="w-2 h-2 bg-blue-600 rounded-full mr-3"></div>
                    <div>
                        <div class="font-medium">Order Placed</div>
                        <div class="text-gray-500"><?= date('M j, Y g:i A', strtotime($order['created_at'])) ?></div>
                    </div>
                </div>
                
                <?php if ($order['shipped_at']): ?>
                    <div class="flex items-center text-sm">
                        <div class="w-2 h-2 bg-green-600 rounded-full mr-3"></div>
                        <div>
                            <div class="font-medium">Order Shipped</div>
                            <div class="text-gray-500"><?= date('M j, Y g:i A', strtotime($order['shipped_at'])) ?></div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if ($order['delivered_at']): ?>
                    <div class="flex items-center text-sm">
                        <div class="w-2 h-2 bg-green-800 rounded-full mr-3"></div>
                        <div>
                            <div class="font-medium">Order Delivered</div>
                            <div class="text-gray-500"><?= date('M j, Y g:i A', strtotime($order['delivered_at'])) ?></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>