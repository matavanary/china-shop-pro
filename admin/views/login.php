<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - China Shop Pro</title>
    
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-600 to-purple-700 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <i class="fas fa-store text-4xl text-blue-600 mb-4"></i>
            <h1 class="text-2xl font-bold text-gray-800">China Shop Pro</h1>
            <p class="text-gray-600">Admin Panel Login</p>
        </div>
        
        <!-- Flash messages -->
        <?php if (Session::hasFlash()): ?>
            <?php foreach (Session::getFlash() as $type => $message): ?>
                <div class="alert alert-<?= $type === 'error' ? 'error' : 'success' ?> mb-4">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <form method="POST" action="?page=login">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
                    Username or Email
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        required
                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter your username"
                    >
                </div>
            </div>
            
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Password
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter your password"
                    >
                </div>
            </div>
            
            <button 
                type="submit" 
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition font-semibold"
            >
                <i class="fas fa-sign-in-alt mr-2"></i>
                Login
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <a href="../" class="text-sm text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-1"></i>
                Back to Store
            </a>
        </div>
        
        <div class="mt-8 p-4 bg-gray-50 rounded-md text-sm text-gray-600">
            <strong>Default Admin Credentials:</strong><br>
            Username: <code>admin</code><br>
            Password: <code>admin123</code>
        </div>
    </div>
</body>
</html>