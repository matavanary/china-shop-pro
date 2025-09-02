<?php
/**
 * China Shop Pro - Main Entry Point
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include required files
require_once __DIR__ . '/../src/includes/Database.php';
require_once __DIR__ . '/../src/includes/Session.php';
require_once __DIR__ . '/../src/includes/Cart.php';
require_once __DIR__ . '/../src/models/BaseModel.php';
require_once __DIR__ . '/../src/models/Product.php';
require_once __DIR__ . '/../src/models/Category.php';
require_once __DIR__ . '/../src/models/Order.php';
require_once __DIR__ . '/../src/models/OrderItem.php';
require_once __DIR__ . '/../src/models/User.php';

// Get page parameter
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? null;

// Initialize models
$productModel = new Product();
$categoryModel = new Category();
$cart = new Cart();

// Route handling
switch ($page) {
    case 'home':
        $featured_products = $productModel->getFeatured(8);
        $categories = $categoryModel->getWithProductCount();
        include __DIR__ . '/../src/views/home.php';
        break;
        
    case 'products':
        $currentPage = (int) ($_GET['p'] ?? 1);
        $search = $_GET['search'] ?? null;
        $categoryId = $_GET['category'] ?? null;
        
        if ($search) {
            $result = $productModel->search($search, $currentPage, 12);
            $pageTitle = "Search Results for: " . htmlspecialchars($search);
        } elseif ($categoryId) {
            $category = $categoryModel->find($categoryId);
            $result = $productModel->getByCategory($categoryId, $currentPage, 12);
            $pageTitle = $category ? $category['name'] . " Products" : "Products";
        } else {
            $result = $productModel->paginate($currentPage, 12, ['is_active' => 1], 'created_at DESC');
            $pageTitle = "All Products";
        }
        
        $products = $result['data'];
        $pagination = $result;
        $categories = $categoryModel->getActive();
        
        include __DIR__ . '/../src/views/products.php';
        break;
        
    case 'product':
        $productId = $_GET['id'] ?? 0;
        $product = $productModel->getWithImages($productId);
        
        if (!$product || !$product['is_active']) {
            header('HTTP/1.0 404 Not Found');
            include __DIR__ . '/../src/views/404.php';
            exit;
        }
        
        $category = $categoryModel->find($product['category_id']);
        $relatedProducts = $productModel->getByCategory($product['category_id'], 1, 4)['data'];
        
        include __DIR__ . '/../src/views/product-detail.php';
        break;
        
    case 'cart':
        if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int) ($_POST['product_id'] ?? 0);
            $quantity = (int) ($_POST['quantity'] ?? 1);
            
            if ($cart->add($productId, $quantity)) {
                Session::setFlash('success', 'Product added to cart successfully!');
            } else {
                Session::setFlash('error', 'Failed to add product to cart. Please check stock availability.');
            }
            
            header('Location: ?page=cart');
            exit;
        }
        
        if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int) ($_POST['product_id'] ?? 0);
            $quantity = (int) ($_POST['quantity'] ?? 0);
            
            $cart->update($productId, $quantity);
            header('Location: ?page=cart');
            exit;
        }
        
        if ($action === 'remove') {
            $productId = (int) ($_GET['id'] ?? 0);
            $cart->remove($productId);
            Session::setFlash('success', 'Product removed from cart.');
            header('Location: ?page=cart');
            exit;
        }
        
        $cartItems = $cart->getItems();
        $stockErrors = $cart->validateStock();
        
        include __DIR__ . '/../src/views/cart.php';
        break;
        
    case 'checkout':
        if ($cart->isEmpty()) {
            header('Location: ?page=cart');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'place-order') {
            // Validate CSRF token
            $token = $_POST['csrf_token'] ?? '';
            if (!Session::verifyCSRFToken($token)) {
                Session::setFlash('error', 'Invalid security token.');
                header('Location: ?page=checkout');
                exit;
            }
            
            // Process order
            $orderData = [
                'user_id' => Session::getUserId(),
                'subtotal' => $cart->getSubtotal(),
                'tax_amount' => $cart->getTax(),
                'shipping_amount' => $cart->getShippingCost(),
                'total_amount' => $cart->getTotal(),
                'payment_method' => $_POST['payment_method'] ?? 'bank_transfer',
                'billing_address' => json_encode([
                    'first_name' => $_POST['billing_first_name'] ?? '',
                    'last_name' => $_POST['billing_last_name'] ?? '',
                    'email' => $_POST['billing_email'] ?? '',
                    'phone' => $_POST['billing_phone'] ?? '',
                    'address_line_1' => $_POST['billing_address_1'] ?? '',
                    'address_line_2' => $_POST['billing_address_2'] ?? '',
                    'city' => $_POST['billing_city'] ?? '',
                    'state' => $_POST['billing_state'] ?? '',
                    'postal_code' => $_POST['billing_postal_code'] ?? '',
                    'country' => $_POST['billing_country'] ?? '',
                ]),
                'shipping_address' => json_encode([
                    'first_name' => $_POST['shipping_first_name'] ?? $_POST['billing_first_name'] ?? '',
                    'last_name' => $_POST['shipping_last_name'] ?? $_POST['billing_last_name'] ?? '',
                    'address_line_1' => $_POST['shipping_address_1'] ?? $_POST['billing_address_1'] ?? '',
                    'address_line_2' => $_POST['shipping_address_2'] ?? $_POST['billing_address_2'] ?? '',
                    'city' => $_POST['shipping_city'] ?? $_POST['billing_city'] ?? '',
                    'state' => $_POST['shipping_state'] ?? $_POST['billing_state'] ?? '',
                    'postal_code' => $_POST['shipping_postal_code'] ?? $_POST['billing_postal_code'] ?? '',
                    'country' => $_POST['shipping_country'] ?? $_POST['billing_country'] ?? '',
                ]),
                'customer_notes' => $_POST['customer_notes'] ?? '',
                'items' => []
            ];
            
            // Add cart items to order
            foreach ($cart->getItems() as $item) {
                $orderData['items'][] = [
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['price'] * $item['quantity']
                ];
            }
            
            try {
                $orderModel = new Order();
                $orderId = $orderModel->createOrder($orderData);
                $cart->clear();
                
                Session::setFlash('success', 'Order placed successfully!');
                header('Location: ?page=order-confirmation&id=' . $orderId);
                exit;
                
            } catch (Exception $e) {
                Session::setFlash('error', 'Failed to place order. Please try again.');
            }
        }
        
        $cartItems = $cart->getItems();
        $subtotal = $cart->getSubtotal();
        $shipping = $cart->getShippingCost();
        $tax = $cart->getTax();
        $total = $cart->getTotal();
        
        include __DIR__ . '/../src/views/checkout.php';
        break;
        
    case 'order-confirmation':
        $orderId = $_GET['id'] ?? 0;
        $orderModel = new Order();
        $order = $orderModel->getWithItems($orderId);
        
        if (!$order) {
            header('Location: ?page=home');
            exit;
        }
        
        include __DIR__ . '/../src/views/order-confirmation.php';
        break;
        
    default:
        header('HTTP/1.0 404 Not Found');
        include __DIR__ . '/../src/views/404.php';
        break;
}