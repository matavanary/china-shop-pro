# Setup Instructions

## Quick Setup Guide

### 1. Database Configuration
```bash
# Create the database configuration file
cp src/config/database.example.php src/config/database.php
```

Edit `src/config/database.php` with your database credentials:
```php
return [
    'host' => 'localhost',
    'port' => 3306,
    'database' => 'china_shop_pro',
    'username' => 'your_username',
    'password' => 'your_password',
    // ... other settings
];
```

### 2. Database Setup
```bash
# Create database
mysql -u root -p -e "CREATE DATABASE china_shop_pro CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"

# Import schema
mysql -u root -p china_shop_pro < database/migrations/001_initial_schema.sql

# Optional: Add sample data
mysql -u root -p china_shop_pro < database/seeds/sample_products.sql
```

### 3. Web Server Configuration

#### Apache
Point your virtual host to the `public/` directory:
```apache
<VirtualHost *:80>
    DocumentRoot /path/to/china-shop-pro/public
    ServerName chinashoppro.local
    
    <Directory /path/to/china-shop-pro/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### Nginx
```nginx
server {
    listen 80;
    server_name chinashoppro.local;
    root /path/to/china-shop-pro/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 4. File Permissions
```bash
# Set proper permissions
chmod -R 755 public/
chmod -R 777 public/assets/images/uploads/
```

### 5. Test Installation
- Visit your configured domain
- You should see the China Shop Pro homepage
- Test adding products to cart
- Test the checkout process

## Production Deployment

### Security Checklist
- [ ] Change default admin password
- [ ] Set `debug` to `false` in `src/config/app.php`
- [ ] Configure proper error logging
- [ ] Set up SSL certificate
- [ ] Configure backup system
- [ ] Set up monitoring

### Environment Variables
Create a `.env` file for production:
```env
DB_HOST=localhost
DB_NAME=china_shop_pro
DB_USER=production_user
DB_PASS=secure_password
APP_ENV=production
DEBUG=false
SECRET_KEY=your-secret-key-here
```

### Performance Optimization
- Enable OPcache for PHP
- Configure MySQL query cache
- Set up CDN for static assets
- Enable gzip compression
- Configure proper caching headers

## Troubleshooting

### Common Issues

1. **Database Connection Failed**
   - Check database credentials in config file
   - Ensure MySQL service is running
   - Verify database exists

2. **404 Errors**
   - Check web server configuration
   - Ensure mod_rewrite is enabled (Apache)
   - Verify document root points to `public/` directory

3. **Permission Errors**
   - Check file permissions
   - Ensure web server has read access to files
   - Verify upload directory is writable

4. **Blank Page/White Screen**
   - Check PHP error logs
   - Enable error reporting temporarily
   - Verify all required PHP extensions are installed

### Getting Help
- Check the main README.md for detailed documentation
- Review error logs in your web server
- Ensure all PHP requirements are met