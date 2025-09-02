<?php
$pageTitle = "Checkout";
$metaDescription = "Complete your order with secure checkout.";

ob_start();
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Checkout</h1>
    
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Checkout form -->
        <div class="lg:col-span-2">
            <form id="checkout-form" method="POST" action="?page=checkout&action=place-order" class="space-y-6">
                <input type="hidden" name="csrf_token" value="<?= Session::getCSRFToken() ?>">
                
                <!-- Billing Information -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Billing Information</h2>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="billing_first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                            <input type="text" name="billing_first_name" id="billing_first_name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="billing_last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                            <input type="text" name="billing_last_name" id="billing_last_name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label for="billing_email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" name="billing_email" id="billing_email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label for="billing_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                            <input type="tel" name="billing_phone" id="billing_phone" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label for="billing_address_1" class="block text-sm font-medium text-gray-700 mb-1">Address Line 1 *</label>
                            <input type="text" name="billing_address_1" id="billing_address_1" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label for="billing_address_2" class="block text-sm font-medium text-gray-700 mb-1">Address Line 2</label>
                            <input type="text" name="billing_address_2" id="billing_address_2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="billing_city" class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                            <input type="text" name="billing_city" id="billing_city" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="billing_state" class="block text-sm font-medium text-gray-700 mb-1">State/Province *</label>
                            <input type="text" name="billing_state" id="billing_state" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="billing_postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postal Code *</label>
                            <input type="text" name="billing_postal_code" id="billing_postal_code" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="billing_country" class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
                            <select name="billing_country" id="billing_country" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Country</option>
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                                <option value="GB">United Kingdom</option>
                                <option value="AU">Australia</option>
                                <option value="CN">China</option>
                                <option value="JP">Japan</option>
                                <option value="KR">South Korea</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Shipping Information -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold">Shipping Information</h2>
                        <label class="flex items-center">
                            <input type="checkbox" id="same_as_billing" name="same_as_billing" class="mr-2">
                            <span class="text-sm">Same as billing address</span>
                        </label>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="shipping_first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                            <input type="text" name="shipping_first_name" id="shipping_first_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="shipping_last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                            <input type="text" name="shipping_last_name" id="shipping_last_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label for="shipping_address_1" class="block text-sm font-medium text-gray-700 mb-1">Address Line 1</label>
                            <input type="text" name="shipping_address_1" id="shipping_address_1" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label for="shipping_address_2" class="block text-sm font-medium text-gray-700 mb-1">Address Line 2</label>
                            <input type="text" name="shipping_address_2" id="shipping_address_2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <input type="text" name="shipping_city" id="shipping_city" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="shipping_state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                            <input type="text" name="shipping_state" id="shipping_state" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="shipping_postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                            <input type="text" name="shipping_postal_code" id="shipping_postal_code" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="shipping_country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                            <select name="shipping_country" id="shipping_country" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Country</option>
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                                <option value="GB">United Kingdom</option>
                                <option value="AU">Australia</option>
                                <option value="CN">China</option>
                                <option value="JP">Japan</option>
                                <option value="KR">South Korea</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Method -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Payment Method</h2>
                    
                    <div class="space-y-3">
                        <label class="flex items-center p-3 border border-gray-300 rounded-md hover:bg-gray-50 cursor-pointer">
                            <input type="radio" name="payment_method" value="bank_transfer" checked class="mr-3">
                            <div>
                                <div class="font-medium">Bank Transfer</div>
                                <div class="text-sm text-gray-600">Transfer funds directly to our bank account</div>
                            </div>
                        </label>
                        
                        <label class="flex items-center p-3 border border-gray-300 rounded-md hover:bg-gray-50 cursor-pointer opacity-50">
                            <input type="radio" name="payment_method" value="paysolution" disabled class="mr-3">
                            <div>
                                <div class="font-medium">Credit Card (Paysolution)</div>
                                <div class="text-sm text-gray-600">Pay securely with your credit card (Coming Soon)</div>
                            </div>
                        </label>
                        
                        <label class="flex items-center p-3 border border-gray-300 rounded-md hover:bg-gray-50 cursor-pointer opacity-50">
                            <input type="radio" name="payment_method" value="cod" disabled class="mr-3">
                            <div>
                                <div class="font-medium">Cash on Delivery</div>
                                <div class="text-sm text-gray-600">Pay when you receive your order (Coming Soon)</div>
                            </div>
                        </label>
                    </div>
                </div>
                
                <!-- Order Notes -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Order Notes</h2>
                    <textarea 
                        name="customer_notes" 
                        placeholder="Any special instructions for your order..."
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    ></textarea>
                </div>
                
                <!-- Place Order Button -->
                <div class="text-center">
                    <button 
                        type="submit" 
                        class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition text-lg"
                    >
                        Place Order
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow-md sticky top-4">
                <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                
                <!-- Cart Items -->
                <div class="space-y-3 mb-4">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="flex items-center space-x-3">
                            <img 
                                src="<?= htmlspecialchars($item['image']) ?>" 
                                alt="<?= htmlspecialchars($item['name']) ?>"
                                class="w-12 h-12 object-cover rounded"
                            >
                            <div class="flex-1">
                                <div class="font-medium text-sm"><?= htmlspecialchars($item['name']) ?></div>
                                <div class="text-gray-600 text-sm">Qty: <?= $item['quantity'] ?></div>
                            </div>
                            <div class="font-semibold">
                                $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <hr class="my-4">
                
                <!-- Order Totals -->
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>$<?= number_format($subtotal, 2) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Shipping</span>
                        <span>
                            <?php if ($shipping > 0): ?>
                                $<?= number_format($shipping, 2) ?>
                            <?php else: ?>
                                <span class="text-green-600">Free</span>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span>Tax</span>
                        <span>$<?= number_format($tax, 2) ?></span>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between text-lg font-semibold">
                        <span>Total</span>
                        <span>$<?= number_format($total, 2) ?></span>
                    </div>
                </div>
                
                <div class="mt-4 text-sm text-gray-600">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Your payment information is secure and encrypted
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>