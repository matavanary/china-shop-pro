<?php
$pageTitle = "Shopping Cart";
$metaDescription = "Review your selected products and proceed to checkout.";

ob_start();
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>
    
    <?php if (!empty($stockErrors)): ?>
        <div class="alert alert-error mb-6">
            <strong>Stock Update:</strong>
            <ul class="mt-2">
                <?php foreach ($stockErrors as $error): ?>
                    <li>• <?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($cartItems)): ?>
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Cart items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-4">Cart Items</h2>
                        
                        <div class="space-y-4">
                            <?php foreach ($cartItems as $item): ?>
                                <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                                    <!-- Product image -->
                                    <div class="flex-shrink-0">
                                        <img 
                                            src="<?= htmlspecialchars($item['image']) ?>" 
                                            alt="<?= htmlspecialchars($item['name']) ?>"
                                            class="w-16 h-16 object-cover rounded"
                                        >
                                    </div>
                                    
                                    <!-- Product details -->
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-800">
                                            <a href="?page=product&id=<?= $item['product_id'] ?>" class="hover:text-blue-600">
                                                <?= htmlspecialchars($item['name']) ?>
                                            </a>
                                        </h3>
                                        <p class="text-gray-600">$<?= number_format($item['price'], 2) ?> each</p>
                                        
                                        <?php if ($item['tiktok_url']): ?>
                                            <a 
                                                href="<?= htmlspecialchars($item['tiktok_url']) ?>" 
                                                target="_blank"
                                                class="inline-flex items-center text-sm tiktok-btn text-white px-2 py-1 rounded mt-1"
                                            >
                                                <i class="fab fa-tiktok mr-1"></i> Watch Video
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Quantity controls -->
                                    <div class="flex items-center space-x-2">
                                        <form method="POST" action="?page=cart&action=update" class="flex items-center space-x-2">
                                            <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                            <div class="flex items-center border border-gray-300 rounded">
                                                <button 
                                                    type="button" 
                                                    onclick="updateQuantity(this.nextElementSibling, -1)"
                                                    class="quantity-btn px-2 py-1 hover:bg-gray-100"
                                                >
                                                    -
                                                </button>
                                                <input 
                                                    type="number" 
                                                    name="quantity" 
                                                    value="<?= $item['quantity'] ?>" 
                                                    min="1" 
                                                    class="w-12 text-center border-0 focus:outline-none"
                                                    onchange="this.form.submit()"
                                                >
                                                <button 
                                                    type="button" 
                                                    onclick="updateQuantity(this.previousElementSibling, 1)"
                                                    class="quantity-btn quantity-plus px-2 py-1 hover:bg-gray-100"
                                                >
                                                    +
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                    <!-- Item total -->
                                    <div class="text-right">
                                        <p class="font-semibold text-lg">
                                            $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                                        </p>
                                        <a 
                                            href="?page=cart&action=remove&id=<?= $item['product_id'] ?>" 
                                            class="text-red-600 hover:text-red-800 text-sm"
                                            onclick="return confirm('Remove this item from cart?')"
                                        >
                                            Remove
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Cart summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between">
                            <span>Subtotal (<?= $cart->getCount() ?> items)</span>
                            <span>$<?= number_format($cart->getSubtotal(), 2) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping</span>
                            <span>
                                <?php if ($cart->getShippingCost() > 0): ?>
                                    $<?= number_format($cart->getShippingCost(), 2) ?>
                                <?php else: ?>
                                    <span class="text-green-600">Free</span>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span>Tax</span>
                            <span>$<?= number_format($cart->getTax(), 2) ?></span>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between text-lg font-semibold">
                            <span>Total</span>
                            <span>$<?= number_format($cart->getTotal(), 2) ?></span>
                        </div>
                    </div>
                    
                    <?php if ($cart->getShippingCost() > 0): ?>
                        <div class="text-sm text-gray-600 mb-4">
                            <i class="fas fa-info-circle"></i>
                            Add $<?= number_format(100 - $cart->getSubtotal(), 2) ?> more for free shipping
                        </div>
                    <?php endif; ?>
                    
                    <a 
                        href="?page=checkout" 
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition text-center block"
                    >
                        Proceed to Checkout
                    </a>
                    
                    <a 
                        href="?page=products" 
                        class="w-full border border-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-50 transition text-center block mt-3"
                    >
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
        
    <?php else: ?>
        <!-- Empty cart -->
        <div class="text-center py-12">
            <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">Your cart is empty</h2>
            <p class="text-gray-500 mb-6">Add some products to get started</p>
            <a 
                href="?page=products" 
                class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition"
            >
                Start Shopping
            </a>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>