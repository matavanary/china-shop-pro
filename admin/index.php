<?php
/**
 * China Shop Pro - Admin Panel
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
require_once __DIR__ . '/../src/models/BaseModel.php';
require_once __DIR__ . '/../src/models/AdminUser.php';
require_once __DIR__ . '/../src/models/Product.php';
require_once __DIR__ . '/../src/models/Category.php';
require_once __DIR__ . '/../src/models/Order.php';
require_once __DIR__ . '/../src/models/User.php';

// Get page and action parameters
$page = $_GET['page'] ?? 'dashboard';
$action = $_GET['action'] ?? null;

// Check admin authentication
if ($page !== 'login' && !Session::isAdminLoggedIn()) {
    header('Location: ?page=login');
    exit;
}

// Initialize models
$adminModel = new AdminUser();
$productModel = new Product();
$categoryModel = new Category();
$orderModel = new Order();
$userModel = new User();

// Route handling
switch ($page) {
    case 'login':
        if (Session::isAdminLoggedIn()) {
            header('Location: ?page=dashboard');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $admin = $adminModel->authenticate($username, $password);
            
            if ($admin) {
                Session::adminLogin($admin);
                header('Location: ?page=dashboard');
                exit;
            } else {
                Session::setFlash('error', 'Invalid username or password.');
            }
        }
        
        include __DIR__ . '/views/login.php';
        break;
        
    case 'logout':
        Session::adminLogout();
        header('Location: ?page=login');
        exit;
        
    case 'dashboard':
        // Dashboard statistics
        $stats = [
            'total_orders' => $orderModel->count(),
            'pending_orders' => $orderModel->count(['status' => 'pending']),
            'total_products' => $productModel->count(['is_active' => 1]),
            'total_revenue' => $orderModel->getTotalRevenue(),
            'recent_orders' => $orderModel->getRecentOrders(5),
        ];
        
        include __DIR__ . '/views/dashboard.php';
        break;
        
    case 'products':
        if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate CSRF token
            $token = $_POST['csrf_token'] ?? '';
            if (!Session::verifyCSRFToken($token)) {
                Session::setFlash('error', 'Invalid security token.');
                header('Location: ?page=products');
                exit;
            }
            
            $data = [
                'category_id' => $_POST['category_id'],
                'name' => $_POST['name'],
                'slug' => $productModel->generateSlug($_POST['name']),
                'description' => $_POST['description'],
                'short_description' => $_POST['short_description'],
                'price' => $_POST['price'],
                'compare_price' => $_POST['compare_price'] ?: null,
                'sku' => $_POST['sku'],
                'stock_quantity' => $_POST['stock_quantity'],
                'tiktok_url' => $_POST['tiktok_url'] ?: null,
                'featured' => isset($_POST['featured']) ? 1 : 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
            ];
            
            try {
                $productId = $productModel->create($data);
                Session::setFlash('success', 'Product created successfully!');
                header('Location: ?page=products&action=edit&id=' . $productId);
                exit;
            } catch (Exception $e) {
                Session::setFlash('error', 'Failed to create product: ' . $e->getMessage());
            }
        }
        
        if ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_GET['id'] ?? 0;
            
            // Validate CSRF token
            $token = $_POST['csrf_token'] ?? '';
            if (!Session::verifyCSRFToken($token)) {
                Session::setFlash('error', 'Invalid security token.');
                header('Location: ?page=products&action=edit&id=' . $productId);
                exit;
            }
            
            $data = [
                'category_id' => $_POST['category_id'],
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'short_description' => $_POST['short_description'],
                'price' => $_POST['price'],
                'compare_price' => $_POST['compare_price'] ?: null,
                'sku' => $_POST['sku'],
                'stock_quantity' => $_POST['stock_quantity'],
                'tiktok_url' => $_POST['tiktok_url'] ?: null,
                'featured' => isset($_POST['featured']) ? 1 : 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
            ];
            
            try {
                $productModel->update($productId, $data);
                Session::setFlash('success', 'Product updated successfully!');
                header('Location: ?page=products&action=edit&id=' . $productId);
                exit;
            } catch (Exception $e) {
                Session::setFlash('error', 'Failed to update product: ' . $e->getMessage());
            }
        }
        
        if ($action === 'delete') {
            $productId = $_GET['id'] ?? 0;
            
            try {
                $productModel->delete($productId);
                Session::setFlash('success', 'Product deleted successfully!');
            } catch (Exception $e) {
                Session::setFlash('error', 'Failed to delete product: ' . $e->getMessage());
            }
            
            header('Location: ?page=products');
            exit;
        }
        
        $currentPage = (int) ($_GET['p'] ?? 1);
        $search = $_GET['search'] ?? '';
        
        if ($action === 'create') {
            $categories = $categoryModel->getActive();
            include __DIR__ . '/views/product-create.php';
        } elseif ($action === 'edit') {
            $productId = $_GET['id'] ?? 0;
            $product = $productModel->getWithImages($productId);
            $categories = $categoryModel->getActive();
            
            if (!$product) {
                Session::setFlash('error', 'Product not found.');
                header('Location: ?page=products');
                exit;
            }
            
            include __DIR__ . '/views/product-edit.php';
        } else {
            $conditions = [];
            if ($search) {
                // For simplicity, we'll just search by name in this basic implementation
                $products = $productModel->search($search, $currentPage, 20);
            } else {
                $products = $productModel->paginate($currentPage, 20, $conditions, 'created_at DESC');
            }
            
            include __DIR__ . '/views/products.php';
        }
        break;
        
    case 'orders':
        if ($action === 'update-status' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = $_POST['order_id'];
            $status = $_POST['status'];
            $notes = $_POST['admin_notes'] ?? '';
            
            try {
                $orderModel->updateStatus($orderId, $status, $notes);
                Session::setFlash('success', 'Order status updated successfully!');
            } catch (Exception $e) {
                Session::setFlash('error', 'Failed to update order status: ' . $e->getMessage());
            }
            
            header('Location: ?page=orders&action=view&id=' . $orderId);
            exit;
        }
        
        $currentPage = (int) ($_GET['p'] ?? 1);
        $status = $_GET['status'] ?? '';
        
        if ($action === 'view') {
            $orderId = $_GET['id'] ?? 0;
            $order = $orderModel->getWithItems($orderId);
            
            if (!$order) {
                Session::setFlash('error', 'Order not found.');
                header('Location: ?page=orders');
                exit;
            }
            
            include __DIR__ . '/views/order-view.php';
        } else {
            if ($status) {
                $orders = $orderModel->getByStatus($status, $currentPage, 20);
            } else {
                $orders = $orderModel->paginate($currentPage, 20, [], 'created_at DESC');
            }
            
            include __DIR__ . '/views/orders.php';
        }
        break;
        
    case 'categories':
        if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'slug' => $categoryModel->generateSlug($_POST['name']),
                'description' => $_POST['description'],
                'sort_order' => $_POST['sort_order'],
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
            ];
            
            try {
                $categoryModel->create($data);
                Session::setFlash('success', 'Category created successfully!');
                header('Location: ?page=categories');
                exit;
            } catch (Exception $e) {
                Session::setFlash('error', 'Failed to create category: ' . $e->getMessage());
            }
        }
        
        if ($action === 'create') {
            include __DIR__ . '/views/category-create.php';
        } else {
            $categories = $categoryModel->getWithProductCount();
            include __DIR__ . '/views/categories.php';
        }
        break;
        
    default:
        header('Location: ?page=dashboard');
        break;
}