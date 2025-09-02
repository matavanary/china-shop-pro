<?php
/**
 * Application Configuration
 */

return [
    'app_name' => 'China Shop Pro',
    'app_url' => $_ENV['APP_URL'] ?? 'http://localhost',
    'app_env' => $_ENV['APP_ENV'] ?? 'development',
    'debug' => $_ENV['DEBUG'] ?? true,
    
    // Security
    'secret_key' => $_ENV['SECRET_KEY'] ?? 'change-this-in-production',
    'session_timeout' => 3600, // 1 hour
    
    // Upload settings
    'upload_path' => 'public/assets/images/uploads/',
    'max_file_size' => 5 * 1024 * 1024, // 5MB
    'allowed_extensions' => ['jpg', 'jpeg', 'png', 'webp'],
    
    // Pagination
    'items_per_page' => 12,
    'admin_items_per_page' => 20,
    
    // Email settings
    'smtp_host' => $_ENV['SMTP_HOST'] ?? '',
    'smtp_port' => $_ENV['SMTP_PORT'] ?? 587,
    'smtp_username' => $_ENV['SMTP_USERNAME'] ?? '',
    'smtp_password' => $_ENV['SMTP_PASSWORD'] ?? '',
    'from_email' => $_ENV['FROM_EMAIL'] ?? 'noreply@chinashoppro.com',
    'from_name' => 'China Shop Pro',
    
    // Payment gateways
    'payment_methods' => [
        'bank_transfer' => true,
        'paysolution' => false,
        'cod' => false,
    ],
    
    // Currency
    'currency' => 'USD',
    'currency_symbol' => '$',
];