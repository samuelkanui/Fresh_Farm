# 🌾 Fresh Farms - Modern Farm Management System

![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-3.5-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white)
![Inertia.js](https://img.shields.io/badge/Inertia.js-2.0-9553E9?style=for-the-badge&logo=inertia&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-7.0-646CFF?style=for-the-badge&logo=vite&logoColor=white)
![TypeScript](https://img.shields.io/badge/TypeScript-5.2-3178C6?style=for-the-badge&logo=typescript&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-4.1-06B6D4?style=for-the-badge&logo=tailwind-css&logoColor=white)

A modern, full-featured farm management system built with Laravel 12, Vue 3, Inertia.js, and TypeScript. This application provides a seamless SPA experience for customers to order fresh produce and for administrators to manage the entire farm operation.

---

## 📋 Table of Contents

- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Project Structure](#-project-structure)
- [Prerequisites](#-prerequisites)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Running the Application](#-running-the-application)
- [Building for Production](#-building-for-production)
- [API Integration](#-api-integration)
- [State Management](#-state-management)
- [Routing](#-routing)
- [Components](#-components)
- [Styling](#-styling)
- [Testing](#-testing)
- [Deployment](#-deployment)
- [Environment Variables](#-environment-variables)
- [Troubleshooting](#-troubleshooting)
- [Contributing](#-contributing)
- [License](#-license)

---

## ✨ Features

### Customer Features
- 🛒 **Product Ordering** - Browse and order from 6 product categories
- 📦 **Order Tracking** - Real-time order status updates
- 📅 **Farm Visit Booking** - Schedule tours and events
- 👤 **Profile Management** - Update personal information
- 💳 **Payment Integration** - Secure payment processing
- 🔔 **Notifications** - Real-time updates on order status
- 📱 **Responsive Design** - Works on all devices
- 🌙 **Dark Mode** - Toggle between light and dark themes

### Admin Features
- 📊 **Dashboard Analytics** - Real-time statistics and insights
- 👥 **User Management** - Manage customers and admins
- ✅ **Order Approval** - Review and approve/reject orders
- 📆 **Booking Management** - Manage farm visit bookings
- 📈 **Sales Reports** - Generate detailed sales reports
- 📧 **Email Notifications** - Automated email system
- 🔐 **Role-Based Access** - Granular permission control
- 📱 **Mobile Admin Panel** - Manage on the go

### Technical Features
- ⚡ **Lightning Fast** - Built with Vite for instant HMR
- 🎨 **Modern UI** - Tailwind CSS with custom design system
- 🔒 **Secure** - JWT authentication with refresh tokens
- 🌐 **i18n Ready** - Multi-language support
- ♿ **Accessible** - WCAG 2.1 AA compliant
- 🧪 **Well Tested** - Unit and E2E tests
- 📦 **Optimized** - Code splitting and lazy loading
- 🔄 **PWA Ready** - Offline support capability

---

## 🛠️ Tech Stack

### Backend Framework
- **Laravel 12** - Modern PHP framework
- **Laravel Fortify** - Authentication scaffolding
- **Laravel Wayfinder** - Type-safe route generation
- **Inertia.js Laravel** - Server-side adapter
- **SQLite** - Default database (MySQL/PostgreSQL supported)

### Frontend Framework
- **Vue 3.5** - Progressive JavaScript framework
- **Composition API** - Modern Vue development
- **TypeScript 5.2** - Type-safe development
- **Inertia.js Vue3** - Client-side adapter (no API needed)
- **Vite 7.0** - Next-generation build tool

### UI & Styling
- **Tailwind CSS 4.1** - Utility-first CSS framework with Vite plugin
- **Reka UI** - Headless, accessible UI components
- **Lucide Vue** - Beautiful SVG icon library
- **VueUse** - Collection of essential Vue Composition Utilities
- **Class Variance Authority** - Component variant management

### Development Tools
- **ESLint** - Code linting with TypeScript support
- **Prettier** - Code formatting with Tailwind plugin
- **Laravel Pint** - PHP code style fixer
- **PHPUnit** - PHP testing framework
- **Concurrently** - Run multiple dev processes

---

## 📁 Project Structure

```
Fresh_Farm/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php
│   │   │   ├── ProductController.php
│   │   │   ├── OrderController.php
│   │   │   ├── BookingController.php
│   │   │   └── Settings/
│   │   │       ├── ProfileController.php
│   │   │       ├── PasswordController.php
│   │   │       └── TwoFactorAuthenticationController.php
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── Order.php
│   │   └── Booking.php
│   └── Providers/
│       ├── AppServiceProvider.php
│       └── FortifyServiceProvider.php
│
├── database/
│   ├── migrations/
│   │   ├── create_users_table.php
│   │   ├── create_categories_table.php
│   │   ├── create_products_table.php
│   │   ├── create_orders_table.php
│   │   └── create_bookings_table.php
│   ├── factories/
│   └── seeders/
│
├── resources/
│   ├── js/
│   │   ├── app.ts                    # Inertia app setup
│   │   ├── ssr.ts                    # SSR entry point
│   │   ├── pages/                    # Inertia pages
│   │   │   ├── Welcome.vue
│   │   │   ├── Dashboard.vue
│   │   │   ├── Products/
│   │   │   │   ├── Index.vue
│   │   │   │   └── Show.vue
│   │   │   ├── Orders/
│   │   │   │   ├── Index.vue
│   │   │   │   └── Show.vue
│   │   │   ├── Bookings/
│   │   │   │   ├── Index.vue
│   │   │   │   └── Create.vue
│   │   │   ├── auth/
│   │   │   │   ├── Login.vue
│   │   │   │   ├── Register.vue
│   │   │   │   └── ForgotPassword.vue
│   │   │   └── settings/
│   │   │       ├── Profile.vue
│   │   │       ├── Password.vue
│   │   │       ├── Appearance.vue
│   │   │       └── TwoFactor.vue
│   │   │
│   │   ├── components/               # Reusable Vue components
│   │   │   ├── ui/                   # UI components (buttons, cards, etc.)
│   │   │   ├── ProductCard.vue
│   │   │   ├── OrderCard.vue
│   │   │   └── BookingForm.vue
│   │   │
│   │   ├── layouts/                  # Layout components
│   │   │   ├── AppLayout.vue
│   │   │   ├── AuthLayout.vue
│   │   │   └── app/
│   │   │       ├── Navbar.vue
│   │   │       └── Sidebar.vue
│   │   │
│   │   ├── composables/              # Vue composables
│   │   │   ├── useAppearance.ts
│   │   │   └── useAuth.ts
│   │   │
│   │   ├── types/                    # TypeScript types
│   │   │   ├── index.d.ts
│   │   │   └── models.ts
│   │   │
│   │   └── lib/                      # Utilities
│   │       └── utils.ts
│   │
│   ├── css/
│   │   └── app.css                   # Tailwind CSS
│   │
│   └── views/
│       └── app.blade.php             # Main Blade template
│
├── routes/
│   ├── web.php                       # Web routes
│   ├── settings.php                  # Settings routes
│   └── console.php                   # Console routes
│
├── tests/
│   ├── Feature/
│   └── Unit/
│
├── .env.example                      # Environment variables template
├── artisan                           # Laravel CLI
├── composer.json                     # PHP dependencies
├── package.json                      # Node dependencies
├── phpunit.xml                       # PHPUnit configuration
├── tsconfig.json                     # TypeScript configuration
├── vite.config.ts                    # Vite configuration
└── README.md                         # This file
```

---

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.0.0 (LTS recommended)
- **npm** >= 9.0.0
- **SQLite** (or MySQL/PostgreSQL)
- **Git** >= 2.30.0
- **VS Code** (recommended) with extensions:
  - Laravel Extension Pack
  - Volar (Vue Language Features)
  - TypeScript Vue Plugin
  - Tailwind CSS IntelliSense
  - ESLint
  - Prettier

### Check Versions
```bash
php --version     # Should be >= 8.2
composer --version
node --version    # Should be >= 18.0.0
npm --version     # Should be >= 9.0.0
```

---

## 🚀 Installation

### Step 1: Clone the Repository

```bash
# Clone the project
git clone <repository-url> fresh-farm
cd fresh-farm
```

### Step 2: Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### Step 3: Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create SQLite database (if using SQLite)
touch database/database.sqlite

# Or configure MySQL/PostgreSQL in .env
```

### Step 4: Database Setup

```bash
# Run migrations
php artisan migrate

# (Optional) Seed database with sample data
php artisan db:seed
```

### Step 5: Build Assets

```bash
# Build frontend assets
npm run build

# Or for development with hot reload
npm run dev
```

---

## ⚙️ Configuration

The project is already configured with optimal settings. Key configuration files:

### Environment Variables (`.env`)

```env
APP_NAME="Fresh Farms"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite
# Or use MySQL/PostgreSQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=fresh_farm
# DB_USERNAME=root
# DB_PASSWORD=

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database

MAIL_MAILER=log
```

### Vite Configuration (`vite.config.ts`)

Already configured with:
- Laravel Vite Plugin for asset compilation
- Tailwind CSS Vite plugin
- Vue 3 support with Inertia.js
- Laravel Wayfinder for type-safe routing
- SSR support

### TypeScript Configuration (`tsconfig.json`)

Configured for Vue 3 with strict type checking and modern ES features.

---

## 🔧 Environment Variables

Key environment variables in `.env`:

```env
# Application
APP_NAME="Fresh Farms"
APP_URL=http://localhost
VITE_APP_NAME="${APP_NAME}"

# Database
DB_CONNECTION=sqlite  # or mysql, pgsql

# Mail (for notifications)
MAIL_MAILER=log  # Change to smtp for production
MAIL_FROM_ADDRESS="hello@freshfarms.com"

# Queue (for background jobs)
QUEUE_CONNECTION=database

# Optional: Payment Integration
# STRIPE_KEY=
# STRIPE_SECRET=
```

---

## 🏃 Running the Application

### Development Mode (Recommended)
```bash
# Run all services concurrently (Laravel + Queue + Vite)
composer dev

# This starts:
# - Laravel server at http://localhost:8000
# - Queue worker for background jobs
# - Vite dev server for hot module replacement
```

### Individual Services
```bash
# Laravel server only
php artisan serve

# Vite dev server only
npm run dev

# Queue worker
php artisan queue:listen
```

### Production Build
```bash
# Build frontend assets
npm run build

# Optimize Laravel
php artisan optimize
```

### Code Quality
```bash
# Format JavaScript/TypeScript/Vue
npm run format

# Lint JavaScript/TypeScript/Vue
npm run lint

# Format PHP code
./vendor/bin/pint

# Run tests
php artisan test
```

---

## 🏗️ Building for Production

```bash
# Build for production
npm run build

# Output will be in the 'dist' directory
```

### Build Optimization
- Code splitting for faster loading
- Tree shaking to remove unused code
- Minification and compression
- Asset optimization
- Source maps (optional)

---

## 🔌 Inertia.js Architecture

### How It Works

Inertia.js eliminates the need for a traditional REST API:

1. **Server-Side**: Laravel controllers return Inertia responses
2. **Client-Side**: Vue components receive data as props
3. **Navigation**: Inertia intercepts links and makes AJAX requests
4. **State**: Shared data via Inertia's page props



## 🧪 Testing

### PHP Tests (PHPUnit)
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=ProductTest

# Run with coverage
php artisan test --coverage
```



## 🚀 Deployment

### Production Checklist

1. **Environment Setup**
```bash
# Set production environment
APP_ENV=production
APP_DEBUG=false

# Configure database
DB_CONNECTION=mysql

# Set up mail service
MAIL_MAILER=smtp
```

2. **Build Assets**
```bash
npm run build
```

3. **Optimize Laravel**
```bash
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

4. **Run Migrations**
```bash
php artisan migrate --force
```

### Deployment Platforms

- **Laravel Forge** - Recommended for Laravel apps
- **Laravel Vapor** - Serverless deployment
- **DigitalOcean App Platform**
- **Heroku** - With PHP buildpack
- **AWS/GCP/Azure** - Traditional VPS

---

## 🔐 Security Best Practices

1. **Environment Variables** - Never commit `.env` files
2. **HTTPS** - Always use HTTPS in production
3. **CSRF Protection** - Laravel provides automatic CSRF protection
4. **Input Validation** - Use Laravel Form Requests
5. **SQL Injection** - Use Eloquent ORM (never raw queries)
6. **XSS Protection** - Laravel Blade auto-escapes output
7. **Authentication** - Laravel Fortify handles secure auth
8. **Rate Limiting** - Configure in `app/Http/Kernel.php`
9. **2FA** - Already configured with Fortify

---

## 📊 Performance Optimization

1. **Code Splitting** - Lazy load routes and components
2. **Image Optimization** - Use WebP format, lazy loading
3. **Caching** - Implement service workers
4. **Bundle Size** - Monitor and optimize
5. **Tree Shaking** - Remove unused code
6. **Compression** - Enable gzip/brotli
7. **CDN** - Use CDN for static assets

---

## 🐛 Troubleshooting

### Common Issues

**Issue: Module not found**
```bash
# Clear node_modules and reinstall
rm -rf node_modules package-lock.json
npm install
```

**Issue: TypeScript errors**
```bash
# Restart TypeScript server in VS Code
Ctrl+Shift+P -> TypeScript: Restart TS Server
```

**Issue: Tailwind styles not working**
```bash
# Ensure Tailwind is properly configured
# Check tailwind.config.js content paths
# Restart dev server
```

---

## 📚 Additional Resources

- [Vue 3 Documentation](https://vuejs.org/)
- [Vite Documentation](https://vitejs.dev/)
- [Pinia Documentation](https://pinia.vuejs.org/)
- [Vue Router Documentation](https://router.vuejs.org/)
- [Tailwind CSS Documentation](https://tailwindcss.com/)
- [TypeScript Documentation](https://www.typescriptlang.org/)

---

## 👥 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

---

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

---

## 👨‍💻 Author

**Fresh Farms Development Team**

- Website: https://freshfarms.com
- Email: dev@freshfarms.com
- GitHub: [@freshfarms](https://github.com/freshfarms)

---

## 🙏 Acknowledgments

- Vue.js team for the amazing framework
- Tailwind CSS for the utility-first CSS framework
- All open-source contributors

---

**Version:** 1.0.0  
**Last Updated:** November 2025  
**Status:** 🚧 In Development

---

## 📞 Support

For support, email support@freshfarms.com or open an issue on GitHub.

---

Made with ❤️ by Fresh Farms Team
