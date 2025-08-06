# 🛒 Laravel E-commerce Application

Modern e-commerce application built with Laravel 11, Vue.js 3, TypeScript, and Inertia.js. Features a responsive design with admin dashboard, real-time cart functionality, and comprehensive product management.

## 📋 Table of Contents

- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Prerequisites](#-prerequisites)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Development](#-development)
- [Project Structure](#-project-structure)
- [API Endpoints](#-api-endpoints)
- [Contributing](#-contributing)
- [License](#-license)

## ✨ Features

### 🛍️ Customer Features
- **Product Browsing**: Browse and search products with category filters
- **Category Navigation**: Hierarchical category browsing system
- **Shopping Cart**: Real-time cart updates with hover preview
- **User Authentication**: Login, register, and profile management
- **Order Management**: Place orders and track order history
- **Responsive Design**: Mobile-first design with Tailwind CSS

### 👨‍💼 Admin Features
- **Dashboard**: Comprehensive analytics and statistics
- **Product Management**: CRUD operations for products with category assignment
- **Category Management**: Hierarchical category system with parent-child relationships
- **Order Management**: View and manage customer orders
- **User Management**: Manage customer accounts
- **Sales Reports**: Generate and view sales analytics
- **Settings**: Configure application settings and profile

### 🔧 Technical Features
- **Real-time Updates**: Event-driven cart updates
- **Type Safety**: Full TypeScript integration
- **Modern UI**: Tailwind CSS with custom design system
- **API-first**: RESTful API with proper error handling
- **Security**: CSRF protection and authentication middleware

## 🛠️ Tech Stack

### Backend
- **Laravel 11** - PHP framework
- **MySQL/SQLite** - Database
- **Sanctum** - API authentication
- **Inertia.js** - Modern monolith approach

### Frontend
- **Vue.js 3** - Progressive JavaScript framework
- **TypeScript** - Type-safe JavaScript
- **Tailwind CSS** - Utility-first CSS framework
- **Vite** - Fast build tool
- **Inertia.js** - SPA-like experience

### Development Tools
- **Laravel Pint** - Code styling
- **Pest** - Testing framework
- **ESLint** - JavaScript linting
- **TypeScript** - Type checking

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 8.2+** with required extensions:
  - BCMath
  - Ctype
  - cURL
  - DOM
  - Fileinfo
  - JSON
  - Mbstring
  - OpenSSL
  - PCRE
  - PDO
  - Tokenizer
  - XML
- **Composer** (latest)
- **Node.js 18+** and **npm/yarn**
- **MySQL 8.0+** or **SQLite**
- **Git**

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/davisbpkad/laravel-ecommerce.git
cd laravel-ecommerce
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node.js Dependencies
```bash
npm install
# or
yarn install
```

### 4. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Database Setup
```bash
# Create database (MySQL)
mysql -u root -p -e "CREATE DATABASE laravel_ecommerce"

# Or use SQLite (already included)
touch database/database.sqlite
```

### 6. Configure Environment
Edit `.env` file with your database credentials:

```env
# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_ecommerce
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Or for SQLite
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite

# App Configuration
APP_NAME="Laravel E-commerce"
APP_URL=http://localhost:8000

# Mail Configuration (optional)
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 7. Run Database Migrations
```bash
# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

### 8. Create Storage Link
```bash
php artisan storage:link
```

### 9. Build Frontend Assets
```bash
# Development build
npm run dev

# Production build
npm run build
```

## ⚙️ Configuration

### Admin User Setup
Create an admin user manually:

```bash
php artisan tinker
```

```php
$user = new App\Models\User();
$user->name = 'Admin User';
$user->email = 'admin@example.com';
$user->password = bcrypt('password');
$user->role = 'admin';
$user->email_verified_at = now();
$user->save();
```

### File Permissions
```bash
# Set proper permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## 🔧 Development

### Start Development Server
```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server
npm run dev
```

Access the application:
- **Frontend**: http://localhost:8000
- **Admin**: http://localhost:8000/admin

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

### Code Quality
```bash
# Fix code style
./vendor/bin/pint

# Run TypeScript check
npm run type-check

# Run ESLint
npm run lint
```

## 📁 Project Structure

Below is a detailed overview of the main directories and files in the project:

```
laravel-ecommerce/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   └── CartController.php         # Cart API endpoints (add, update, remove, clear)
│   │   │   ├── Admin/
│   │   │   │   ├── AdminProfileController.php # Admin profile settings (128 lines)
│   │   │   │   ├── CategoryController.php     # Category CRUD operations
│   │   │   │   └── StoreSettingController.php # Store configuration settings
│   │   │   ├── Auth/
│   │   │   │   ├── AuthenticatedSessionController.php     # Login/logout (57 lines)
│   │   │   │   ├── RegisteredUserController.php          # User registration
│   │   │   │   ├── EmailVerificationPromptController.php # Email verification prompt
│   │   │   │   ├── EmailVerificationNotificationController.php # Send verification emails
│   │   │   │   ├── VerifyEmailController.php              # Email verification handler
│   │   │   │   ├── PasswordResetLinkController.php        # Send password reset links
│   │   │   │   ├── NewPasswordController.php              # Handle password resets
│   │   │   │   └── ConfirmablePasswordController.php      # Password confirmation
│   │   │   ├── Settings/
│   │   │   │   ├── ProfileController.php      # User profile management (112 lines)
│   │   │   │   └── PasswordController.php     # Password update functionality
│   │   │   ├── AdminDashboardController.php   # Admin dashboard with analytics & sales report
│   │   │   ├── CartController.php             # Web cart functionality (137 lines)
│   │   │   ├── Controller.php                 # Base controller class
│   │   │   ├── DashboardController.php        # User dashboard (62 lines)
│   │   │   ├── HomeController.php             # Homepage with admin redirect (57 lines)
│   │   │   ├── OrderController.php            # Order management & checkout (323 lines)
│   │   │   └── ProductController.php          # Product listing & details (441 lines)
│   │   ├── Middleware/
│   │   │   └── AdminMiddleware.php            # Admin access control
│   │   └── Requests/
│   │       └── Auth/
│   │           └── LoginRequest.php           # Login form validation
│   ├── Models/
│   │   ├── User.php                           # User model with relationships (73 lines)
│   │   ├── Product.php                        # Product model with SoftDeletes & Category (54 lines)
│   │   ├── Category.php                       # Category model with parent-child relationships
│   │   ├── Cart.php                           # Cart model with relationships (31 lines) 
│   │   ├── Order.php                          # Order model with relationships (50 lines)
│   │   ├── OrderItem.php                      # Order items model (36 lines)
│   │   └── StoreSetting.php                   # Store settings model with caching (107 lines)
│   └── Providers/
│       └── AppServiceProvider.php             # Service provider configuration
├── bootstrap/
│   ├── app.php                                # Application bootstrap
│   ├── providers.php                          # Provider registration
│   └── cache/
│       ├── packages.php                       # Package discovery cache
│       └── services.php                       # Service discovery cache
├── config/
│   ├── app.php                                # Application configuration
│   ├── auth.php                               # Authentication configuration
│   ├── database.php                           # Database configuration
│   ├── inertia.php                            # Inertia.js configuration
│   ├── session.php                            # Session configuration
│   └── services.php                           # Third-party services
├── database/
│   ├── database.sqlite                        # SQLite database file
│   ├── factories/
│   │   └── UserFactory.php                    # User model factory
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php      # Users table
│   │   ├── 0001_01_01_000001_create_cache_table.php      # Cache table
│   │   ├── 0001_01_01_000002_create_jobs_table.php       # Jobs table
│   │   ├── 2025_08_04_065442_create_products_table.php   # Products table
│   │   ├── 2025_08_04_065512_create_carts_table.php      # Shopping cart table
│   │   ├── 2025_08_04_065546_create_orders_table.php     # Orders table
│   │   ├── 2025_08_04_065604_create_order_items_table.php # Order items table
│   │   ├── 2025_08_04_065727_add_role_to_users_table.php # Add role column to users
│   │   ├── 2025_08_04_075549_add_product_fields_to_products_table.php # Additional product fields
│   │   ├── 2025_08_04_142108_add_payment_method_to_orders_table.php # Payment method column
│   │   ├── 2025_08_04_143554_update_orders_status_enum.php # Order status enum update
│   │   ├── 2025_08_04_152743_add_soft_deletes_to_products_table.php # Soft deletes for products
│   │   ├── 2025_08_04_154239_create_store_settings_table.php # Store settings table
│   │   ├── 2025_08_04_162528_add_profile_fields_to_users_table.php # User profile fields
│   │   ├── 2025_08_06_030456_create_categories_table.php  # Categories table
│   │   ├── 2025_08_06_033327_add_category_id_to_products_table.php # Category foreign key
│   │   └── 2025_08_06_035001_simplify_categories_table.php # Simplified category structure
│   └── seeders/
│       ├── DatabaseSeeder.php                 # Database seeder
│       ├── UserSeeder.php                     # User data seeder
│       └── CategorySeeder.php                 # Category data seeder
├── public/
│   ├── index.php                              # Application entry point
│   ├── favicon.ico                            # Favicon
│   ├── favicon.svg                            # SVG favicon
│   ├── apple-touch-icon.png                   # Apple touch icon
│   ├── robots.txt                             # SEO robots file
│   ├── hot                                    # Vite hot reload file
│   └── build/                                 # Compiled assets
│       ├── manifest.json                      # Asset manifest
│       └── assets/                            # CSS and JS bundles
├── resources/
│   ├── css/
│   │   └── app.css                            # Main CSS file with Tailwind
│   ├── js/
│   │   ├── app.ts                             # Main TypeScript entry point
│   │   ├── ssr.ts                             # Server-side rendering setup
│   │   ├── components/
│   │   │   ├── ui/
│   │   │   │   └── button/
│   │   │   │       └── Button.vue             # Reusable button component
│   │   │   ├── AddToCartButton.vue            # Add to cart functionality
│   │   │   ├── AppContent.vue                 # App content wrapper
│   │   │   ├── AppHeader.vue                  # Application header
│   │   │   ├── AppLayout.vue                  # Base app layout
│   │   │   ├── AppLogo.vue                    # Application logo
│   │   │   ├── AppShell.vue                   # Application shell
│   │   │   ├── AppSidebar.vue                 # Application sidebar
│   │   │   ├── Breadcrumbs.vue                # Navigation breadcrumbs
│   │   │   ├── CartHover.vue                  # Cart dropdown component
│   │   │   ├── DeleteUser.vue                 # User deletion component
│   │   │   ├── Heading.vue                    # Page heading component
│   │   │   ├── Icon.vue                       # Icon component
│   │   │   ├── ProductCard.vue                # Product display card
│   │   │   ├── SettingsModal.vue              # Settings modal dialog
│   │   │   ├── TextLink.vue                   # Text link component
│   │   │   ├── UserInfo.vue                   # User information display
│   │   │   └── UserMenuContent.vue            # User menu dropdown
│   │   ├── composables/
│   │   │   ├── useAddToCart.ts                # Add to cart functionality
│   │   │   ├── useAppearance.ts               # Appearance/theme management
│   │   │   ├── useCart.ts                     # Cart state management
│   │   │   ├── useInitials.ts                 # User initials utility
│   │   │   └──  useNotifications.ts            # Notification system
│   │   ├── layouts/
│   │   │   ├── AdminLayout.vue                # Admin panel layout
│   │   │   ├── AppLayout.vue                  # Base application layout
│   │   │   ├── AuthLayout.vue                 # Authentication layout
│   │   │   ├── EcommerceLayout.vue            # Main e-commerce layout
│   │   │   └── SettingsLayout.vue             # Settings page layout
│   │   ├── pages/
│   │   │   ├── Admin/
│   │   │   │   ├── Dashboard.vue              # Admin dashboard
│   │   │   │   ├── Categories/
│   │   │   │   │   ├── Index.vue              # Category management listing
│   │   │   │   │   ├── Create.vue             # Add new category form
│   │   │   │   │   ├── Edit.vue               # Edit category form
│   │   │   │   │   └── Show.vue               # Category details view
│   │   │   │   ├── Orders/
│   │   │   │   │   └── Index.vue              # Order management
│   │   │   │   ├── Products/
│   │   │   │   │   ├── Index.vue              # Product management listing
│   │   │   │   │   ├── Create.vue             # Add new product form
│   │   │   │   │   └── Edit.vue               # Edit product form
│   │   │   │   ├── SalesReport.vue            # Sales analytics
│   │   │   │   └── Settings/
│   │   │   │       └── Profile.vue            # Admin profile settings
│   │   │   ├── auth/
│   │   │   │   ├── ConfirmPassword.vue        # Password confirmation
│   │   │   │   ├── ForgotPassword.vue         # Password reset request
│   │   │   │   ├── Login.vue                  # Login page
│   │   │   │   ├── Register.vue               # Registration page
│   │   │   │   ├── ResetPassword.vue          # Password reset
│   │   │   │   └── VerifyEmail.vue            # Email verification
│   │   │   ├── Cart/
│   │   │   │   └── Index.vue                  # Shopping cart page
│   │   │   ├── Checkout/
│   │   │   │   └── Index.vue                  # Checkout process
│   │   │   ├── Orders/
│   │   │   │   ├── Index.vue                  # Order history
│   │   │   │   ├── Show.vue                   # Order details
│   │   │   │   ├── Success.vue                # Order success page
│   │   │   │   └── Track.vue                  # Order tracking
│   │   │   ├── Products/
│   │   │   │   ├── Index.vue                  # Product listing
│   │   │   │   └── Show.vue                   # Product details
│   │   │   ├── settings/
│   │   │   │   ├── Appearance.vue             # Appearance settings
│   │   │   │   ├── Password.vue               # Password settings
│   │   │   │   └── Profile.vue                # Profile settings
│   │   │   ├── About.vue                      # About page
│   │   │   ├── Contact.vue                    # Contact page
│   │   │   ├── Dashboard.vue                  # User dashboard
│   │   │   ├── FAQ.vue                        # FAQ page
│   │   │   ├── Help.vue                       # Help page
│   │   │   ├── Returns.vue                    # Returns policy
│   │   │   └── Shipping.vue                   # Shipping information
│   │   ├── types/
│   │   │   └── index.ts                       # TypeScript type definitions
│   │   └── lib/
│   │       └── utils.ts                       # Utility functions
│   └── views/
│       └── app.blade.php                      # Main Blade template
├── routes/
│   ├── web.php                                # Web routes (frontend)
│   ├── auth.php                               # Authentication routes
│   ├── console.php                            # Artisan console routes
│   └── settings.php                           # Settings routes
├── storage/
│   ├── app/
│   │   ├── private/                           # Private file storage
│   │   └── public/                            # Public file storage
│   ├── framework/
│   │   ├── cache/                             # Application cache
│   │   ├── sessions/                          # Session files
│   │   ├── testing/                           # Testing cache
│   │   └── views/                             # Compiled views
│   └── logs/                                  # Application logs
├── tests/
│   ├── Pest.php                               # Pest testing configuration
│   ├── TestCase.php                           # Base test case
│   ├── Feature/
│   │   ├── DashboardTest.php                  # Dashboard functionality tests
│   │   ├── ExampleTest.php                    # Example feature test
│   │   ├── Auth/                              # Authentication tests
│   │   └── Settings/                          # Settings tests
│   └── Unit/
│       └── ExampleTest.php                    # Example unit test
├── vendor/                                    # Composer dependencies
├── .env                                       # Environment configuration
├── .env.example                               # Environment template
├── artisan                                    # Artisan CLI tool
├── composer.json                              # PHP dependencies
├── composer.lock                              # Locked PHP dependencies
├── package.json                               # Node.js dependencies
├── package-lock.json                          # Locked Node.js dependencies
├── components.json                            # UI components configuration
├── eslint.config.js                           # ESLint configuration
├── phpunit.xml                                # PHPUnit configuration
├── tailwind.config.js                         # Tailwind CSS configuration
├── tsconfig.json                              # TypeScript configuration
├── vite.config.ts                             # Vite build configuration
└── README.md                                  # Project documentation
```

### 🔍 **Key Implementation Files**

#### **Core E-commerce Controllers (5)**
- `app/Http/Controllers/HomeController.php` (57 lines) - Homepage with admin redirect logic
- `app/Http/Controllers/ProductController.php` (441 lines) - Product listing, search, details & CRUD
- `app/Http/Controllers/CartController.php` (137 lines) - Web cart display and management  
- `app/Http/Controllers/OrderController.php` (323 lines) - Checkout process & order history
- `app/Http/Controllers/DashboardController.php` (62 lines) - User dashboard with orders

#### **Admin Panel Controllers (3)**
- `app/Http/Controllers/AdminDashboardController.php` - Analytics dashboard & sales reports
- `app/Http/Controllers/Admin/AdminProfileController.php` (128 lines) - Admin profile settings
- `app/Http/Controllers/Admin/StoreSettingController.php` - Store configuration

#### **Authentication Controllers (8)**
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php` (57 lines) - Login/logout
- `app/Http/Controllers/Auth/RegisteredUserController.php` - User registration
- `app/Http/Controllers/Auth/EmailVerificationPromptController.php` - Email verification prompt
- `app/Http/Controllers/Auth/EmailVerificationNotificationController.php` - Send verification emails
- `app/Http/Controllers/Auth/VerifyEmailController.php` - Email verification handler
- `app/Http/Controllers/Auth/PasswordResetLinkController.php` - Send password reset links
- `app/Http/Controllers/Auth/NewPasswordController.php` - Handle password resets
- `app/Http/Controllers/Auth/ConfirmablePasswordController.php` - Password confirmation

#### **Settings Controllers (2)**
- `app/Http/Controllers/Settings/ProfileController.php` (112 lines) - User profile management
- `app/Http/Controllers/Settings/PasswordController.php` - Password update functionality

#### **API Controllers (1)**
- `app/Http/Controllers/Api/CartController.php` - Real-time cart API operations

#### **Base Controller (1)**
- `app/Http/Controllers/Controller.php` - Base controller class

#### **Cart System Implementation**
- `app/Http/Controllers/Api/CartController.php` - Real-time cart API
- `app/Http/Controllers/CartController.php` - Web cart functionality  
- `resources/js/composables/useCart.ts` - Cart state management
- `resources/js/components/CartHover.vue` - Cart dropdown with live updates
- `resources/js/components/AddToCartButton.vue` - Add to cart functionality

#### **Authentication**
- `app/Http/Controllers/Auth/` - Authentication controllers
- `resources/js/pages/Auth/` - Login/register pages
- `routes/auth.php` - Authentication routes

#### **Frontend Architecture**
- `resources/js/app.ts` - Main application entry
- `resources/js/layouts/EcommerceLayout.vue` - Main layout with cart integration
- `resources/js/composables/` - Reusable composition functions
- `resources/js/types/index.ts` - TypeScript definitions

#### **Database & Models (6)**
- `app/Models/User.php` (73 lines) - User model with role-based auth & relationships
- `app/Models/Product.php` (54 lines) - Product model with SoftDeletes & categories
- `app/Models/Cart.php` (31 lines) - Cart model with user & product relationships
- `app/Models/Order.php` (50 lines) - Order model with status & payment tracking
- `app/Models/OrderItem.php` (36 lines) - Order items with pricing & relationships
- `app/Models/StoreSetting.php` (107 lines) - Store configuration with caching system

#### **Frontend Resources**
**Components (20+ components):**
- Core UI: `Button.vue`, `Icon.vue`, `Heading.vue`, `TextLink.vue`
- E-commerce: `CartHover.vue`, `AddToCartButton.vue`, `ProductCard.vue`
- Layout: `AppHeader.vue`, `AppSidebar.vue`, `AppContent.vue`, `Breadcrumbs.vue`
- User: `UserInfo.vue`, `UserMenuContent.vue`, `DeleteUser.vue`
- Admin: `SettingsModal.vue`, `AppShell.vue`

**Layouts (5 layouts):**
- `AdminLayout.vue` - Admin panel with sidebar
- `EcommerceLayout.vue` - Main customer-facing layout
- `AuthLayout.vue` - Login/register pages
- `SettingsLayout.vue` - User settings pages
- `AppLayout.vue` - Base application layout

## 🗄️ Database Schema

### Core Tables

#### **Users Table**
```sql
users:
  - id (primary key)
  - name (string)
  - email (unique string)
  - email_verified_at (timestamp)
  - password (hashed string)
  - role (enum: 'customer', 'admin')
  - phone (nullable string)
  - address (nullable text)
  - avatar (nullable string)
  - remember_token (nullable string)
  - created_at, updated_at (timestamps)
```

#### **Categories Table** ⭐ **New Feature**
```sql
categories:
  - id (primary key)
  - name (string)
  - slug (unique string)
  - description (nullable text)
  - parent_id (nullable foreign key to categories.id)
  - is_active (boolean, default: true)
  - created_at, updated_at (timestamps)
  
  Relationships:
  - parent: belongsTo(Category)
  - children: hasMany(Category)
  - products: hasMany(Product)
```

#### **Products Table**
```sql
products:
  - id (primary key)
  - name (string)
  - slug (unique string)
  - description (text)
  - price (decimal 10,2)
  - image (nullable string)
  - stock (integer, default: 0)
  - category_id (nullable foreign key to categories.id) ⭐ **New**
  - deleted_at (nullable timestamp - soft deletes)
  - created_at, updated_at (timestamps)
  
  Relationships:
  - category: belongsTo(Category) ⭐ **New**
  - cartItems: hasMany(Cart)
  - orderItems: hasMany(OrderItem)
```

#### **Orders Table**
```sql
orders:
  - id (primary key)
  - user_id (foreign key to users.id)
  - total_amount (decimal 10,2)
  - status (enum: 'pending', 'processing', 'shipped', 'delivered', 'cancelled')
  - payment_method (enum: 'bank_transfer', 'cod', 'e_wallet')
  - shipping_address (text)
  - created_at, updated_at (timestamps)
  
  Relationships:
  - user: belongsTo(User)
  - items: hasMany(OrderItem)
```

#### **Order Items Table**
```sql
order_items:
  - id (primary key)
  - order_id (foreign key to orders.id)
  - product_id (foreign key to products.id)
  - quantity (integer)
  - price (decimal 10,2)
  - created_at, updated_at (timestamps)
  
  Relationships:
  - order: belongsTo(Order)
  - product: belongsTo(Product)
```

#### **Cart Table**
```sql
carts:
  - id (primary key)
  - user_id (foreign key to users.id)
  - product_id (foreign key to products.id)
  - quantity (integer)
  - created_at, updated_at (timestamps)
  
  Relationships:
  - user: belongsTo(User)
  - product: belongsTo(Product)
```

#### **Store Settings Table**
```sql
store_settings:
  - id (primary key)
  - key (unique string)
  - value (text)
  - created_at, updated_at (timestamps)
```

### System Tables (Laravel)
- `cache` - Application cache storage
- `jobs` - Queue jobs for background processing
- `migrations` - Database migration tracking

**Pages (30+ pages organized):**
- **Admin**: Dashboard, Products/Index, Products/Create, Products/Edit, Orders/Index, SalesReport, Settings/Profile
- **Auth**: Login, Register, VerifyEmail, ForgotPassword, ResetPassword, ConfirmPassword
- **E-commerce**: Cart/Index, Checkout/Index, Products/Index, Products/Show
- **Orders**: Index, Show, Success, Track
- **Settings**: Profile, Password, Appearance
- **Info Pages**: About, Contact, FAQ, Help, Shipping, Returns

**Composables (6 composables):**
- `useCart.ts` - Cart state management with real-time updates
- `useAddToCart.ts` - Add to cart functionality
- `useNotifications.ts` - Toast notification system
- `useAppearance.ts` - Theme/appearance management
- `useProductModal.ts` - Product modal functionality
- `useInitials.ts` - User initials utility

#### **Configuration**
- `config/inertia.php` - Inertia.js setup
- `tailwind.config.js` - Design system configuration
- `vite.config.ts` - Build tool configuration
- `tsconfig.json` - TypeScript compiler options

This structure implements a **modern Laravel application** with:
- ✅ **Separation of Concerns** - Clear MVC architecture
- ✅ **Type Safety** - Full TypeScript integration
- ✅ **Real-time Features** - Event-driven cart updates
- ✅ **Admin Management** - Complete dashboard system
- ✅ **Modern Frontend** - Vue 3 + Composition API
- ✅ **Testing Ready** - Pest framework setup

### 📊 **Project Statistics**
**Controllers**: 20 controllers total (~2,200+ PHP lines)
- **Main App**: 5 controllers (core e-commerce functionality)
- **Admin**: 3 controllers (admin panel management)  
- **Authentication**: 8 controllers (complete auth system)
- **Settings**: 2 controllers (user settings)
- **API**: 1 controller (cart API)
- **Base**: 1 controller

**Models**: 6 models total (~350+ PHP lines)
- **Core E-commerce**: User, Product, Cart, Order, OrderItem (5 models)
- **Configuration**: StoreSetting (1 model)

**Frontend Resources**: (~3,500+ TypeScript/Vue lines)
- **Components**: 20+ Vue components (UI, E-commerce, Layout, User, Admin)
- **Pages**: 30+ organized pages (Admin, Auth, E-commerce, Orders, Settings, Info)
- **Composables**: 6 TypeScript utilities for state management & business logic
- **Layouts**: 5 layouts for different application sections
- **Layouts**: 5 layout components (Admin, Ecommerce, Auth, Settings, App)
- **Composables**: 6 reusable composables (Cart, Notifications, Appearance, etc.)

### 🎯 **Largest Files by Functionality**
**Controllers:**
1. **ProductController.php** (441 lines) - Product management with search, filters, CRUD
2. **OrderController.php** (323 lines) - Complete order processing & checkout system
3. **CartController.php** (137 lines) - Shopping cart display and management
4. **Admin/AdminProfileController.php** (128 lines) - Admin profile settings
5. **Settings/ProfileController.php** (112 lines) - User profile management

**Models:**
1. **StoreSetting.php** (107 lines) - Store configuration with caching system
2. **User.php** (73 lines) - User model with role-based auth & relationships
3. **Product.php** (54 lines) - Product model with SoftDeletes & categories
4. **Order.php** (50 lines) - Order model with status & payment tracking
5. **OrderItem.php** (36 lines) - Order items with pricing & relationships

**Frontend Architecture:**
- **useCart.ts** - Complex cart state management with real-time updates
- **CartHover.vue** - Interactive cart dropdown with live data
- **AdminLayout.vue** - Comprehensive admin panel layout
- **EcommerceLayout.vue** - Main customer layout with cart integration

### Key Directories Explained

#### `/app/Http/Controllers/`
- **Api/**: API controllers for cart, products, etc.
- **Admin/**: Admin panel controllers
- **Auth/**: Authentication related controllers

#### `/resources/js/`
- **components/**: Reusable Vue components
- **composables/**: Vue 3 composition functions
- **layouts/**: Page layout components
- **pages/**: Page-specific components
- **types/**: TypeScript type definitions

#### `/database/`
- **migrations/**: Database schema definitions
- **seeders/**: Sample data generators
- **factories/**: Model factories for testing

## 🔌 API Endpoints

### Cart API
```
GET    /api/cart/items         # Get cart items
GET    /api/cart/count         # Get cart count
POST   /api/cart/add           # Add item to cart
PUT    /api/cart/update/{id}   # Update cart item
DELETE /api/cart/remove/{id}   # Remove cart item
DELETE /api/cart/clear         # Clear entire cart
```

### Products API
```
GET    /api/products           # Get products list
GET    /api/products/{id}      # Get single product
GET    /api/products?category={slug}  # Filter products by category
```

### Categories API ⭐ **New**
```
GET    /api/categories         # Get all categories
GET    /api/categories/active  # Get active categories only
GET    /api/categories/tree    # Get hierarchical category tree
```

### Admin Routes
```
GET    /admin                  # Admin dashboard
GET    /admin/products         # Product management
GET    /admin/orders           # Order management
GET    /admin/categories       # Category management ⭐ New
POST   /admin/categories       # Create category
GET    /admin/categories/{id}/edit  # Edit category form
PUT    /admin/categories/{id}  # Update category
DELETE /admin/categories/{id}  # Delete category
GET    /admin/users            # User management
GET    /admin/settings         # Settings
```

## 🧪 Testing

### Database Testing
The application uses SQLite for testing by default. Test database is automatically created and migrated.

```bash
# Run specific test
php artisan test tests/Feature/DashboardTest.php

# Run with specific filter
php artisan test --filter=dashboard
```

### Frontend Testing
```bash
# Run Vue component tests (if configured)
npm run test

# Type checking
npm run type-check
```

## 🎨 Styling

### Tailwind CSS Configuration
The project uses a custom design system with:
- **Color Scheme**: Defined in `tailwind.config.js`
- **Components**: Located in `/resources/js/components/ui/`
- **Custom Classes**: Neubrutalism-inspired design

### Design System
- **Primary Colors**: Blue-based palette
- **Typography**: Inter font family
- **Spacing**: Consistent 8px grid system
- **Borders**: Bold 2px borders with shadow effects

## 🔒 Security

### Authentication
- **Sanctum**: API token authentication
- **CSRF Protection**: Enabled for all forms
- **Password Hashing**: bcrypt algorithm
- **Email Verification**: Built-in support

### Authorization
- **Role-based Access**: Admin and user roles
- **Middleware Protection**: Route-level security
- **API Rate Limiting**: Configurable limits

## 🚀 Deployment

### Production Setup
1. **Server Requirements**: Same as prerequisites
2. **Environment**: Copy and configure `.env.production`
3. **Build Assets**: `npm run build`
4. **Optimize**: `php artisan optimize`
5. **Cache**: `php artisan config:cache && php artisan route:cache`

### Docker (Optional)
```dockerfile
# Example Dockerfile structure
FROM php:8.2-fpm
# ... installation steps
```

## 🤝 Contributing

1. **Fork** the repository
2. **Create** a feature branch (`git checkout -b feature/amazing-feature`)
3. **Commit** your changes (`git commit -m 'Add amazing feature'`)
4. **Push** to the branch (`git push origin feature/amazing-feature`)
5. **Open** a Pull Request

### Coding Standards
- **PHP**: Follow PSR-12 standards
- **JavaScript/TypeScript**: Use ESLint configuration
- **Vue**: Follow Vue 3 composition API best practices
- **Commits**: Use conventional commit messages

### Development Guidelines
- Write tests for new features
- Update documentation for significant changes
- Follow existing code patterns and conventions
- Use TypeScript for all new JavaScript code

## 📚 Learning Resources

### Laravel
- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Bootcamp](https://bootcamp.laravel.com)
- [Laracasts](https://laracasts.com)

### Vue.js
- [Vue.js Documentation](https://vuejs.org/guide/)
- [Vue 3 Composition API](https://vuejs.org/guide/extras/composition-api-faq.html)
- [Inertia.js Documentation](https://inertiajs.com)

### TypeScript
- [TypeScript Handbook](https://www.typescriptlang.org/docs/)
- [Vue TypeScript Guide](https://vuejs.org/guide/typescript/overview.html)

## 🐛 Troubleshooting

### Common Issues

#### 1. **Vite Build Errors**
```bash
# Clear cache and rebuild
rm -rf node_modules package-lock.json
npm install
npm run build
```

#### 2. **Database Connection Issues**
```bash
# Check database configuration
php artisan config:clear
php artisan migrate:status
```

#### 3. **Permission Issues**
```bash
# Fix storage permissions
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R $USER:www-data storage bootstrap/cache
```

#### 4. **Cart Not Updating**
- Check browser console for JavaScript errors
- Verify CSRF token is present
- Ensure user is authenticated

### Debug Mode
Enable debug mode in `.env`:
```env
APP_DEBUG=true
```

## � Changelog

### Version 2.1.0 - Category Management System (August 6, 2025) ⭐ **Latest**

#### ✨ New Features
- **Hierarchical Category System**: Complete parent-child category relationships
- **Category CRUD Management**: Full admin interface for category management
- **Product-Category Integration**: Products can now be assigned to categories
- **Category-based Product Filtering**: Filter products by category in listings
- **Simplified Category Structure**: Streamlined design focusing on essential fields

#### 🗄️ Database Changes
- **New Table**: `categories` with parent-child relationships
- **Enhanced Products**: Added `category_id` foreign key to products table
- **Simplified Schema**: Removed image and sort_order fields for cleaner structure

#### 🎨 Frontend Updates
- **Admin Categories Module**: Complete CRUD interface (Index, Create, Edit, Show)
- **Category Navigation**: Added to admin sidebar
- **Product Forms**: Category selection dropdown in product management
- **Vue.js Components**: Responsive category management interface

#### 🔧 Backend Implementation
- **Category Model**: With parent/children relationships and product associations
- **CategoryController**: Full resource controller with validation
- **CategorySeeder**: Sample category data generator
- **API Endpoints**: Category listing and management routes

#### 📁 File Structure Updates
```
app/Models/Category.php                     # New category model
app/Http/Controllers/Admin/CategoryController.php  # New category controller
database/migrations/2025_08_06_030456_create_categories_table.php
database/migrations/2025_08_06_033327_add_category_id_to_products_table.php
database/migrations/2025_08_06_035001_simplify_categories_table.php
database/seeders/CategorySeeder.php         # New category seeder
resources/js/pages/Admin/Categories/        # New Vue.js category pages
├── Index.vue, Create.vue, Edit.vue, Show.vue
```

#### 🚀 Migration Guide
```bash
# Update to latest version
git pull origin main
composer install
npm install
php artisan migrate
php artisan db:seed --class=CategorySeeder
npm run build
```

### Version 2.0.0 - E-commerce Foundation
- Initial e-commerce application
- User authentication and authorization
- Product management system
- Shopping cart functionality
- Order management
- Admin dashboard
- Payment integration

## �📞 Support

- **Issues**: [GitHub Issues](https://github.com/davisbpkad/laravel-ecommerce/issues)
- **Discussions**: [GitHub Discussions](https://github.com/davisbpkad/laravel-ecommerce/discussions)
- **Email**: support@example.com

---

**Built with ❤️ using Laravel, Vue.js, and TypeScript**
