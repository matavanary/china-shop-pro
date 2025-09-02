<?php
$pageTitle = "Order Confirmation";
$metaDescription = "Thank you for your order! Your order has been received and is being processed.";

ob_start();
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Success Message -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-8">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-600 text-3xl"></i>
                </div>
                <div class="ml-4">
                    <h1 class="text-2xl font-bold text-green-800">Order Confirmed!</h1>
                    <p class="text-green-700 mt-1">Thank you for your order. We've received your order and will process it soon.</p>
                </div>
            </div>
        </div>
        
        <!-- Order Details -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="border-b border-gray-200 pb-4 mb-4">
                <h2 class="text-xl font-semibold">Order Details</h2>
                <div class="mt-2 text-sm text-gray-600">
                    <span>Order Number: <strong class="text-blue-600"><?= htmlspecialchars($order['order_number']) ?></strong></span>
                    <span class="ml-4">Order Date: <?= date('F j, Y', strtotime($order['created_at'])) ?></span>
                </div>
            </div>
            
            <!-- Order Items -->
            <div class="mb-6">
                <h3 class="font-semibold mb-3">Items Ordered</h3>
                <div class="space-y-3">
                    <?php foreach ($order['items'] as $item): ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                            <div class="flex-1">
                                <div class="font-medium"><?= htmlspecialchars($item['product_name']) ?></div>
                                <div class="text-sm text-gray-600">
                                    Quantity: <?= $item['quantity'] ?> × $<?= number_format($item['price'], 2) ?>
                                </div>
                            </div>
                            <div class="font-semibold">
                                $<?= number_format($item['total'], 2) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="border-t border-gray-200 pt-4">
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
        
        <!-- Addresses -->
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <!-- Billing Address -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-3">Billing Address</h3>
                <?php $billing = $order['billing_address']; ?>
                <div class="text-sm text-gray-700 space-y-1">
                    <div><?= htmlspecialchars($billing['first_name'] . ' ' . $billing['last_name']) ?></div>
                    <div><?= htmlspecialchars($billing['address_line_1']) ?></div>
                    <?php if ($billing['address_line_2']): ?>
                        <div><?= htmlspecialchars($billing['address_line_2']) ?></div>
                    <?php endif; ?>
                    <div><?= htmlspecialchars($billing['city'] . ', ' . $billing['state'] . ' ' . $billing['postal_code']) ?></div>
                    <div><?= htmlspecialchars($billing['country']) ?></div>
                    <div class="pt-2">
                        <div>Email: <?= htmlspecialchars($billing['email']) ?></div>
                        <div>Phone: <?= htmlspecialchars($billing['phone']) ?></div>
                    </div>
                </div>
            </div>
            
            <!-- Shipping Address -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-3">Shipping Address</h3>
                <?php $shipping = $order['shipping_address']; ?>
                <div class="text-sm text-gray-700 space-y-1">
                    <div><?= htmlspecialchars($shipping['first_name'] . ' ' . $shipping['last_name']) ?></div>
                    <div><?= htmlspecialchars($shipping['address_line_1']) ?></div>
                    <?php if ($shipping['address_line_2']): ?>
                        <div><?= htmlspecialchars($shipping['address_line_2']) ?></div>
                    <?php endif; ?>
                    <div><?= htmlspecialchars($shipping['city'] . ', ' . $shipping['state'] . ' ' . $shipping['postal_code']) ?></div>
                    <div><?= htmlspecialchars($shipping['country']) ?></div>
                </div>
            </div>
        </div>
        
        <!-- Payment & Status -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold mb-2">Payment Method</h3>
                    <div class="text-sm text-gray-700">
                        <?php
                        $paymentMethods = [
                            'bank_transfer' => 'Bank Transfer',
                            'paysolution' => 'Credit Card (Paysolution)',
                            'cod' => 'Cash on Delivery'
                        ];
                        echo $paymentMethods[$order['payment_method']] ?? $order['payment_method'];
                        ?>
                    </div>
                    
                    <?php if ($order['payment_method'] === 'bank_transfer'): ?>
                        <div class="mt-3 p-3 bg-blue-50 rounded text-sm">
                            <strong>Bank Transfer Instructions:</strong><br>
                            Please transfer the total amount to our bank account and email us the receipt.<br>
                            <strong>Account:</strong> China Shop Pro<br>
                            <strong>Account Number:</strong> 123-456-789<br>
                            <strong>Reference:</strong> <?= htmlspecialchars($order['order_number']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div>
                    <h3 class="font-semibold mb-2">Order Status</h3>
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <?= ucfirst($order['status']) ?>
                        </span>
                        <span class="ml-2 text-sm text-gray-600">
                            <?= ucfirst($order['payment_status']) ?> Payment
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Next Steps -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <h3 class="font-semibold text-blue-800 mb-2">What happens next?</h3>
            <div class="text-blue-700 text-sm space-y-1">
                <div>• We'll send you an email confirmation shortly</div>
                <?php if ($order['payment_method'] === 'bank_transfer'): ?>
                    <div>• Please complete the bank transfer using the instructions above</div>
                    <div>• Once payment is confirmed, we'll prepare your order for shipment</div>
                <?php else: ?>
                    <div>• We'll process your payment and prepare your order</div>
                <?php endif; ?>
                <div>• You'll receive tracking information once your order ships</div>
                <div>• Estimated delivery: 5-10 business days</div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a 
                href="?page=products" 
                class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition text-center"
            >
                Continue Shopping
            </a>
            <a 
                href="?page=track-order&order=<?= htmlspecialchars($order['order_number']) ?>" 
                class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition text-center"
            >
                Track This Order
            </a>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>