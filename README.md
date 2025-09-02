# China Shop Pro - Complete E-commerce Solution

A comprehensive e-commerce platform specifically designed for Chinese products with TikTok integration, built with PHP, MySQL, and TailwindCSS.

## Overview

China Shop Pro is a full-featured e-commerce store that combines traditional online shopping with modern social media integration. Customers can browse products, watch TikTok videos to see products in action, and complete purchases with multiple payment options.

## Features

### 🛍️ Customer Features
- **Product Catalog**: Browse products with high-quality images
- **TikTok Integration**: Watch product videos before purchasing
- **Smart Shopping Cart**: Easy add/remove with quantity management
- **Multiple Payment Methods**: Bank transfer, Credit card, Cash on delivery
- **Order Tracking**: Real-time order status updates
- **Mobile-First Design**: Responsive design built with TailwindCSS

### 🔧 Admin Features
- **Product Management**: Add/edit/delete products and categories
- **Order Management**: Process orders and update status
- **Inventory Tracking**: Stock management with low-stock alerts
- **Sales Analytics**: Revenue reports and performance metrics
- **Customer Management**: User accounts and order history

### 🛡️ Security & Performance
- **CSRF Protection**: Secure form submissions
- **Password Hashing**: Secure user authentication
- **Session Management**: Secure user sessions
- **SQL Injection Prevention**: Prepared statements throughout
- **Input Validation**: Comprehensive data sanitization

## Quick Start

### Prerequisites
- PHP 8.0+
- MySQL 5.7+
- Web server (Apache/Nginx)

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd china-shop-pro
   ```

2. **Database Setup**
   ```bash
   # Create database
   mysql -u root -p -e "CREATE DATABASE china_shop_pro"
   
   # Import schema
   mysql -u root -p china_shop_pro < database/migrations/001_initial_schema.sql
   ```

3. **Configuration**
   ```bash
   # Copy database config
   cp src/config/database.example.php src/config/database.php
   
   # Edit with your database credentials
   nano src/config/database.php
   ```

4. **Web Server Setup**
   - Point document root to `public/` directory
   - Ensure mod_rewrite is enabled (Apache)
   - Set proper file permissions

5. **Access Your Store**
   - Frontend: `http://your-domain.com`
   - Admin Panel: `http://your-domain.com/admin` (coming soon)

## Default Credentials

**Admin Account:**
- Username: `admin`
- Email: `admin@chinashoppro.com`
- Password: `admin123`

## Database Schema

The system includes comprehensive tables for:
- **Products & Categories**: Full product management
- **Users & Addresses**: Customer account system
- **Orders & Payments**: Complete order processing
- **Inventory & Shipping**: Stock and fulfillment tracking
- **Admin & Logs**: Administrative functions

## Technology Stack

- **Backend**: PHP 8+ with MVC architecture
- **Database**: MySQL with PDO
- **Frontend**: TailwindCSS + Vanilla JavaScript
- **Security**: Session management, CSRF protection, password hashing
- **Integration Ready**: Paysolution, courier APIs, email systems

## Project Structure

```
china-shop-pro/
├── public/                 # Web accessible files
│   ├── index.php          # Application entry point
│   └── assets/            # Static assets (CSS, JS, images)
├── src/
│   ├── config/            # Configuration files
│   ├── models/            # Database models
│   ├── views/             # Template files
│   └── includes/          # Helper classes
├── admin/                 # Admin dashboard (Phase 2)
├── database/
│   ├── migrations/        # Database schema files
│   └── seeds/            # Sample data
└── docs/                 # Documentation
```

## Development Roadmap

### Phase 1 ✅ (Completed)
- Core MVC architecture
- Product catalog with TikTok integration
- Shopping cart functionality
- Basic order processing
- Responsive frontend design

### Phase 2 🚧 (In Progress)
- Admin dashboard
- User authentication system
- Email notifications
- Payment gateway integration
- Advanced order management

### Phase 3 📋 (Planned)
- Analytics and reporting
- API endpoints for mobile
- Advanced user roles
- Automated courier integration
- Performance optimization

## API Integration Structure

### Payment Gateways
- **Paysolution**: Credit card processing
- **Bank Transfer**: Manual verification system
- **COD**: Cash on delivery option

### Shipping & Tracking
- Courier API integration ready
- Automatic tracking number updates
- Delivery status notifications

### Email System
- Order confirmation emails
- Status update notifications
- Marketing email support

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, bug reports, or feature requests:
- Create an issue in the GitHub repository
- Email: support@chinashoppro.com
- Documentation: `/docs` directory

---

**Built with ❤️ for the global e-commerce community**