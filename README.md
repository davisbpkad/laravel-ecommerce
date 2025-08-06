# 🛒 Laravel E-commerce Application

A modern, full-featured e-commerce application built with **Laravel 11**, **Vue.js 3**, **TypeScript**, and **Inertia.js**. Features real-time cart functionality, comprehensive admin dashboard, and category management system.

## ✨ Key Features

### For Customers 🛍️
- Browse and search products with category filtering
- Real-time shopping cart with hover preview
- User authentication and profile management
- Order placement and tracking
- Mobile-responsive design

### For Administrators 👨‍💼
- Comprehensive admin dashboard with analytics
- Complete product management (CRUD with categories)
- **Category management system** (hierarchical structure)
- Order and user management
- Store settings configuration
- Sales reports and statistics

### Technical Highlights 🔧
- **Real-time updates** - Event-driven cart system
- **Type safety** - Full TypeScript integration
- **Modern UI** - Tailwind CSS with custom design
- **API-first** - RESTful endpoints with proper validation
- **Security** - CSRF protection and role-based access

## 🛠️ Tech Stack

**Backend:** Laravel 11, MySQL/SQLite, Sanctum Auth, Inertia.js  
**Frontend:** Vue.js 3, TypeScript, Tailwind CSS, Vite  
**Tools:** Laravel Pint, Pest Testing, ESLint

## 📋 Requirements

- **PHP 8.2+** with extensions (BCMath, cURL, JSON, Mbstring, OpenSSL, PDO, XML)
- **Composer** (latest version)
- **Node.js 18+** and npm/yarn
- **MySQL 8.0+** or SQLite
- **Git**

## 🚀 Quick Start

### 1. Clone & Install
```bash
git clone https://github.com/davisbpkad/laravel-ecommerce.git
cd laravel-ecommerce
composer install
npm install
```

### 2. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Configuration
Edit `.env` file:
```env
# For MySQL
DB_CONNECTION=mysql
DB_DATABASE=laravel_ecommerce
DB_USERNAME=your_username
DB_PASSWORD=your_password

# For SQLite (easier for testing)
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/database/database.sqlite
```

### 4. Run Migrations & Seed Data
```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

### 5. Build & Start
```bash
npm run build
php artisan serve
# Access: http://localhost:8000
```

## 🔑 Demo Credentials

Test the application with these accounts:

**Admin Access:**
- Email: `admin@example.com`
- Password: `admin123`
- Access: http://localhost:8000/admin

**Customer Accounts:**
- Email: `jane@example.com` | Password: `password`
- Email: `john@example.com` | Password: `password`

## ⚙️ Store Configuration

The store name and settings are managed through the admin panel:

1. Login as admin → Settings → Store Settings
2. Update store name, description, contact info
3. Changes appear automatically in the frontend navbar/footer

**Default store name:** `E-Shop` (if not configured)

## 🔧 Development

```bash
# Start development servers
php artisan serve          # Laravel backend
npm run dev                # Vite frontend (in another terminal)

# Access points
# Frontend: http://localhost:8000
# Admin Panel: http://localhost:8000/admin
```

### Testing & Code Quality
```bash
php artisan test           # Run tests
./vendor/bin/pint         # Fix code style
npm run type-check        # TypeScript validation
npm run lint              # ESLint
```

## 📁 Project Structure (Simplified)

```
laravel-ecommerce/
├── app/
│   ├── Http/Controllers/
│   │   ├── Api/CategoryController.php          # Category API endpoints
│   │   ├── Admin/CategoryController.php        # Admin category management  
│   │   ├── ProductController.php               # Product CRUD (441 lines)
│   │   ├── OrderController.php                 # Order & checkout (323 lines)
│   │   ├── CartController.php                  # Shopping cart (137 lines)
│   │   └── Auth/                               # Authentication controllers
│   ├── Models/
│   │   ├── User.php                           # User with roles & relationships
│   │   ├── Product.php                        # Product with categories & soft deletes
│   │   ├── Category.php                       # Category with parent/child relationships
│   │   ├── Cart.php, Order.php, OrderItem.php # E-commerce models
│   │   └── StoreSetting.php                   # Store configuration
│   └── Http/Middleware/HandleInertiaRequests.php # Shared data (store settings)
├── database/
│   ├── migrations/                            # Database schema
│   └── seeders/                               # Sample data
├── resources/
│   ├── js/
│   │   ├── pages/Admin/Categories/            # Category management UI
│   │   ├── pages/Products/, Orders/, Auth/    # Main application pages
│   │   ├── components/                        # Reusable Vue components
│   │   ├── layouts/EcommerceLayout.vue        # Main layout with cart
│   │   └── composables/useCart.ts             # Cart state management
│   └── css/app.css                            # Tailwind CSS
└── routes/web.php                             # Application routes
```

## 🔌 API Endpoints

### Categories ⭐ New Feature
```
GET    /api/categories         # List all categories
GET    /admin/categories       # Admin category management
POST   /admin/categories       # Create category
PUT    /admin/categories/{id}  # Update category
DELETE /admin/categories/{id}  # Delete category
```

### Products & Cart
```
GET    /api/products                    # Product listing
GET    /api/products?category={id}      # Filter by category
POST   /api/cart/add                   # Add to cart
GET    /api/cart/items                 # Cart contents
DELETE /api/cart/remove/{id}           # Remove from cart
```

### Admin Routes
```
GET    /admin                 # Dashboard
GET    /admin/products        # Product management
GET    /admin/orders          # Order management
GET    /admin/settings        # Store settings
```

## 🗄️ Database Schema

### Core Tables

**Users** - Customer & admin accounts with role-based access  
**Categories** ⭐ - Hierarchical product categories (parent/child relationships)  
**Products** - Product catalog with category assignment and soft deletes  
**Orders & Order Items** - Order management with payment tracking  
**Cart** - Real-time shopping cart functionality  
**Store Settings** - Configurable store information

### Key Relationships
- Products → Categories (Many-to-One)
- Users → Orders → Order Items (One-to-Many-to-Many)  
- Users → Cart Items → Products (Many-to-Many through Cart)

## 🚀 What's New in v2.1.0

### ⭐ Category Management System
- **Hierarchical Categories**: Parent-child category relationships
- **Admin Interface**: Complete CRUD for category management
- **Product Integration**: Assign products to categories
- **API Endpoints**: Category listing and filtering
- **Dynamic Navigation**: Category-based product filtering

### 🔧 Store Settings Integration
- **Dynamic Store Name**: Managed through admin panel
- **Shared Data**: Store settings available across all pages
- **Real-time Updates**: Changes reflect immediately in frontend

### 📁 New Files Added
```
app/Models/Category.php
app/Http/Controllers/Admin/CategoryController.php
database/migrations/*_create_categories_table.php
database/seeders/CategorySeeder.php
resources/js/pages/Admin/Categories/Index.vue
```

## 🐛 Troubleshooting

### Common Issues
1. **Build Errors**: `rm -rf node_modules && npm install && npm run build`
2. **Database Issues**: `php artisan migrate:fresh --seed`
3. **Permissions**: `chmod -R 775 storage bootstrap/cache`
4. **Cart Not Working**: Check browser console and CSRF token

### Debug Mode
Set `APP_DEBUG=true` in `.env` for detailed error messages.

## 📚 Learning Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Vue.js 3 Guide](https://vuejs.org/guide/)
- [Inertia.js Documentation](https://inertiajs.com)
- [TypeScript Handbook](https://www.typescriptlang.org/docs/)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)

### Standards
- **PHP**: PSR-12 coding standards
- **JavaScript**: ESLint configuration
- **Vue**: Composition API best practices
- **Commits**: Conventional commit messages

## 📞 Support

- **Issues**: [GitHub Issues](https://github.com/davisbpkad/laravel-ecommerce/issues)
---

**Built with ❤️ using Laravel, Vue.js, and TypeScript**
