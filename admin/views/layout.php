<?php
$config = require __DIR__ . '/../../src/config/app.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - ' : '' ?>Admin - <?= htmlspecialchars($config['app_name']) ?></title>
    
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .sidebar-link.active {
            background-color: #3B82F6;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md">
            <div class="p-4 border-b border-gray-200">
                <h1 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-store mr-2 text-blue-600"></i>
                    Admin Panel
                </h1>
            </div>
            
            <nav class="mt-4">
                <a 
                    href="?page=dashboard" 
                    class="sidebar-link flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 <?= ($page ?? '') === 'dashboard' ? 'active' : '' ?>"
                >
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                
                <a 
                    href="?page=orders" 
                    class="sidebar-link flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 <?= ($page ?? '') === 'orders' ? 'active' : '' ?>"
                >
                    <i class="fas fa-shopping-bag mr-3"></i>
                    Orders
                </a>
                
                <a 
                    href="?page=products" 
                    class="sidebar-link flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 <?= ($page ?? '') === 'products' ? 'active' : '' ?>"
                >
                    <i class="fas fa-box mr-3"></i>
                    Products
                </a>
                
                <a 
                    href="?page=categories" 
                    class="sidebar-link flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 <?= ($page ?? '') === 'categories' ? 'active' : '' ?>"
                >
                    <i class="fas fa-tags mr-3"></i>
                    Categories
                </a>
                
                <a 
                    href="?page=users" 
                    class="sidebar-link flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 <?= ($page ?? '') === 'users' ? 'active' : '' ?>"
                >
                    <i class="fas fa-users mr-3"></i>
                    Customers
                </a>
                
                <a 
                    href="?page=reports" 
                    class="sidebar-link flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 <?= ($page ?? '') === 'reports' ? 'active' : '' ?>"
                >
                    <i class="fas fa-chart-bar mr-3"></i>
                    Reports
                </a>
                
                <a 
                    href="?page=settings" 
                    class="sidebar-link flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 <?= ($page ?? '') === 'settings' ? 'active' : '' ?>"
                >
                    <i class="fas fa-cog mr-3"></i>
                    Settings
                </a>
            </nav>
            
            <div class="absolute bottom-4 left-4 right-4">
                <div class="border-t pt-4">
                    <a href="../" class="flex items-center text-gray-600 hover:text-blue-600 mb-2">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        View Store
                    </a>
                    <a href="?page=logout" class="flex items-center text-gray-600 hover:text-red-600">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </a>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex justify-between items-center px-6 py-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">
                            <?= htmlspecialchars($pageTitle ?? 'Dashboard') ?>
                        </h2>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">
                            Welcome, <?= htmlspecialchars(Session::getAdmin()['first_name'] ?? 'Admin') ?>
                        </span>
                        <div class="relative">
                            <img 
                                src="https://ui-avatars.com/api/?name=<?= urlencode(Session::getAdmin()['first_name'] ?? 'Admin') ?>&background=3B82F6&color=fff" 
                                alt="Admin Avatar" 
                                class="w-8 h-8 rounded-full"
                            >
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Flash messages -->
            <?php if (Session::hasFlash()): ?>
                <div class="p-6">
                    <?php foreach (Session::getFlash() as $type => $message): ?>
                        <div class="alert alert-<?= $type === 'error' ? 'error' : ($type === 'success' ? 'success' : 'info') ?> flex justify-between items-center mb-4">
                            <span><?= htmlspecialchars($message) ?></span>
                            <button onclick="this.parentElement.remove()" class="text-lg">×</button>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <!-- Page Content -->
            <div class="p-6">
                <?= $content ?? '' ?>
            </div>
        </main>
    </div>
</body>
</html>