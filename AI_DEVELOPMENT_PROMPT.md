# 🤖 AI Development Prompt - Fresh Farm Project

## Project Context

You are tasked with developing a **complete farm management system** called "Fresh Farm" using Laravel 12, Vue 3, Inertia.js, and TypeScript. This is a full-stack application that allows customers to order fresh produce and administrators to manage the entire farm operation.

---

## 🎯 Project Overview

**Tech Stack:**
- **Backend:** Laravel 12, PHP 8.2+, SQLite/MySQL
- **Frontend:** Vue 3.5, TypeScript 5.2, Inertia.js 2.0
- **Styling:** Tailwind CSS 4.1
- **Build Tool:** Vite 7.0
- **Authentication:** Laravel Fortify (with 2FA support)

**Architecture:**
- Inertia.js SPA (no REST API needed)
- Server-side rendering with Vue components
- Type-safe TypeScript throughout
- Responsive design with dark mode

---

## 📋 Current State

### ✅ Already Implemented (DO NOT RECREATE)

**Database:**
- ✅ Users table with roles (customer/admin)
- ✅ Categories table (6 categories)
- ✅ Products table (16 sample products)
- ✅ Orders table with status tracking
- ✅ Order_items table
- ✅ Bookings table for farm visits

**Backend:**
- ✅ All models with relationships (Category, Product, Order, OrderItem, Booking, User)
- ✅ ProductController (index, show)
- ✅ OrderController (index, show, store)
- ✅ BookingController (index, create, store)
- ✅ Admin\DashboardController (index, approveOrder, rejectOrder, confirmBooking)
- ✅ OrderPolicy for authorization
- ✅ All routes configured
- ✅ Database seeder with sample data

**Frontend:**
- ✅ Products/Index.vue - Product catalog with filtering
- ✅ Products/Show.vue - Product details
- ✅ Orders/Index.vue - Order history
- ✅ Orders/Show.vue - Order details with timeline
- ✅ Bookings/Index.vue - Booking management
- ✅ Bookings/Create.vue - New booking form
- ✅ Admin/Dashboard.vue - Admin dashboard
- ✅ TypeScript types (models.ts)

**Test Accounts:**
- Admin: admin@freshfarms.com / password
- Customer: customer@example.com / password

---

## 🚀 Your Development Tasks

### Phase 1: Shopping Cart System (HIGH PRIORITY)

**Goal:** Implement a fully functional shopping cart with persistent storage.

**Tasks:**

1. **Create Pinia Store for Cart**
   - File: `resources/js/stores/cart.ts`
   - State: cart items, total, subtotal, tax
   - Actions: addItem, removeItem, updateQuantity, clearCart, loadCart
   - Persist to localStorage
   - Calculate totals automatically

2. **Update Products/Show.vue**
   - Replace alert with actual cart functionality
   - Add to cart button should use cart store
   - Show "Added to cart" notification
   - Update cart icon in navbar with item count

3. **Create Cart Page**
   - File: `resources/js/pages/Cart/Index.vue`
   - Display all cart items
   - Allow quantity updates
   - Remove items functionality
   - Show subtotal, tax (10%), delivery fee ($5)
   - Proceed to checkout button

4. **Create Checkout Page**
   - File: `resources/js/pages/Checkout/Index.vue`
   - Delivery address form
   - Delivery date picker
   - Order notes textarea
   - Order summary
   - Place order button (submits to OrderController)

5. **Update Routes**
   - Add `/cart` route
   - Add `/checkout` route

6. **Update Navbar**
   - Add cart icon with item count badge
   - Link to cart page

**Expected Outcome:**
- Users can add products to cart
- Cart persists across page refreshes
- Users can review and modify cart
- Users can complete checkout and place orders

---

### Phase 2: Admin Product Management (HIGH PRIORITY)

**Goal:** Allow admins to create, edit, and manage products and categories.

**Tasks:**

1. **Create Admin Product Controller**
   - File: `app/Http/Controllers/Admin/ProductController.php`
   - Methods: index, create, store, edit, update, destroy
   - Handle image uploads to storage/app/public/products
   - Validate all inputs

2. **Create Admin Category Controller**
   - File: `app/Http/Controllers/Admin/CategoryController.php`
   - Methods: index, create, store, edit, update, destroy
   - Handle image uploads

3. **Create Admin Product Pages**
   - `resources/js/pages/Admin/Products/Index.vue` - List all products with edit/delete
   - `resources/js/pages/Admin/Products/Create.vue` - Create new product form
   - `resources/js/pages/Admin/Products/Edit.vue` - Edit product form
   - Include: name, slug, description, price, unit, stock, category, image upload, featured toggle

4. **Create Admin Category Pages**
   - `resources/js/pages/Admin/Categories/Index.vue` - List categories
   - `resources/js/pages/Admin/Categories/Create.vue` - Create category
   - `resources/js/pages/Admin/Categories/Edit.vue` - Edit category

5. **Update Admin Dashboard**
   - Add navigation links to Products and Categories management
   - Add quick stats for low stock products

6. **Add Routes**
   - `/admin/products` - Resource routes
   - `/admin/categories` - Resource routes

7. **Create Image Upload Component**
   - File: `resources/js/components/ImageUpload.vue`
   - Drag & drop support
   - Preview before upload
   - Validation (size, type)

**Expected Outcome:**
- Admins can create/edit/delete products
- Admins can manage categories
- Product images can be uploaded
- Stock levels can be updated

---

### Phase 3: Payment Integration (HIGH PRIORITY)

**Goal:** Integrate Stripe payment processing for orders.

**Tasks:**

1. **Install Stripe**
   ```bash
   composer require stripe/stripe-php
   npm install @stripe/stripe-js
   ```

2. **Create Payment Controller**
   - File: `app/Http/Controllers/PaymentController.php`
   - Methods: createPaymentIntent, processPayment, webhook
   - Handle Stripe events

3. **Update Checkout Page**
   - Add Stripe Elements for card input
   - Process payment before order creation
   - Show loading state during payment
   - Handle payment errors

4. **Update Order Model**
   - Add payment_status field (pending, paid, failed, refunded)
   - Add payment_intent_id field
   - Add paid_at timestamp

5. **Create Migration**
   - Add payment fields to orders table

6. **Environment Variables**
   - Add STRIPE_KEY and STRIPE_SECRET to .env.example
   - Document in README

**Expected Outcome:**
- Customers can pay for orders with credit card
- Payment status is tracked
- Orders are only created after successful payment
- Webhook handles payment confirmations

---

### Phase 4: Email Notifications (MEDIUM PRIORITY)

**Goal:** Send automated emails for order confirmations, status updates, and bookings.

**Tasks:**

1. **Create Mail Classes**
   - `app/Mail/OrderPlaced.php` - Customer order confirmation
   - `app/Mail/OrderApproved.php` - Order approved notification
   - `app/Mail/OrderShipped.php` - Order shipped notification
   - `app/Mail/BookingConfirmed.php` - Booking confirmation
   - `app/Mail/NewOrderAdmin.php` - Admin notification

2. **Create Email Templates**
   - `resources/views/emails/orders/placed.blade.php`
   - `resources/views/emails/orders/approved.blade.php`
   - `resources/views/emails/orders/shipped.blade.php`
   - `resources/views/emails/bookings/confirmed.blade.php`
   - Use Laravel's markdown mail components

3. **Update Controllers**
   - OrderController: Send email after order creation
   - Admin\DashboardController: Send emails on status changes
   - BookingController: Send confirmation email

4. **Create Notification Preferences**
   - Add email_notifications field to users table
   - Create settings page for notification preferences

5. **Queue Configuration**
   - Ensure emails are queued (already configured)
   - Test queue worker is running

**Expected Outcome:**
- Customers receive order confirmations
- Admins receive new order notifications
- Status updates trigger emails
- Booking confirmations are sent

---

### Phase 5: User Profile & Account Management (MEDIUM PRIORITY)

**Goal:** Allow users to manage their profiles and view account information.

**Tasks:**

1. **Enhance Profile Page**
   - File: `resources/js/pages/settings/Profile.vue` (already exists)
   - Add avatar upload
   - Add phone number field
   - Add address management (multiple addresses)
   - Add order history link

2. **Create Address Management**
   - Create addresses table migration
   - Create Address model
   - Create AddressController
   - Create Address CRUD pages
   - Allow setting default address

3. **Update Checkout**
   - Show saved addresses in dropdown
   - Allow selecting saved address
   - Option to save new address

4. **Create Order History Dashboard**
   - Enhanced version of Orders/Index.vue
   - Filter by status
   - Search by order number
   - Date range filter
   - Export to PDF option

**Expected Outcome:**
- Users can update their profiles
- Users can save multiple addresses
- Checkout is faster with saved addresses
- Better order history management

---

### Phase 6: Advanced Admin Features (MEDIUM PRIORITY)

**Goal:** Provide comprehensive admin tools for business management.

**Tasks:**

1. **Create Admin Users Management**
   - File: `resources/js/pages/Admin/Users/Index.vue`
   - List all users with filters
   - View user details
   - Change user roles
   - Suspend/activate accounts
   - View user order history

2. **Create Admin Orders Management**
   - File: `resources/js/pages/Admin/Orders/Index.vue`
   - Enhanced order list with filters
   - Bulk actions (approve multiple, export)
   - Update order status
   - Print packing slips
   - Refund orders

3. **Create Admin Bookings Management**
   - File: `resources/js/pages/Admin/Bookings/Index.vue`
   - Calendar view of bookings
   - Availability management
   - Booking capacity limits
   - Send custom messages to customers

4. **Create Analytics Dashboard**
   - File: `resources/js/pages/Admin/Analytics.vue`
   - Sales charts (Chart.js)
   - Revenue by category
   - Top selling products
   - Customer growth
   - Export reports

5. **Create Settings Page**
   - File: `resources/js/pages/Admin/Settings.vue`
   - Site settings (name, logo, contact)
   - Tax rate configuration
   - Delivery fee settings
   - Email templates customization

**Expected Outcome:**
- Complete admin control panel
- User management capabilities
- Advanced order management
- Business analytics and insights
- Configurable settings

---

### Phase 7: Product Reviews & Ratings (LOW PRIORITY)

**Goal:** Allow customers to review and rate products.

**Tasks:**

1. **Create Reviews Table**
   - Migration: product_reviews table
   - Fields: user_id, product_id, rating (1-5), title, comment, verified_purchase, created_at

2. **Create Review Model & Controller**
   - Model: ProductReview
   - Controller: ReviewController (store, update, destroy)
   - Policy: Only verified buyers can review

3. **Update Product Pages**
   - Show average rating and review count
   - Display reviews with pagination
   - Add review form (authenticated users only)
   - Star rating component

4. **Admin Review Moderation**
   - Page: `resources/js/pages/Admin/Reviews/Index.vue`
   - Approve/reject reviews
   - Flag inappropriate content
   - Respond to reviews

**Expected Outcome:**
- Customers can leave reviews
- Products show ratings
- Admins can moderate reviews
- Verified purchase badges

---

### Phase 8: Search & Filtering (LOW PRIORITY)

**Goal:** Implement advanced search and filtering capabilities.

**Tasks:**

1. **Create Search Functionality**
   - Add search bar to navbar
   - Create SearchController
   - Search products by name, description, category
   - Show search results page
   - Highlight search terms

2. **Enhanced Product Filtering**
   - Price range slider
   - Sort by: price, name, popularity, newest
   - Filter by availability
   - Filter by featured
   - Multiple category selection

3. **Add Laravel Scout (Optional)**
   - Install Laravel Scout
   - Configure Algolia or Meilisearch
   - Index products
   - Full-text search

4. **Create Saved Searches**
   - Allow users to save search criteria
   - Quick access to saved searches
   - Email alerts for new matching products

**Expected Outcome:**
- Fast product search
- Advanced filtering options
- Better product discovery
- Personalized search experience

---

### Phase 9: Wishlist & Favorites (LOW PRIORITY)

**Goal:** Allow users to save products for later.

**Tasks:**

1. **Create Wishlist Table**
   - Migration: wishlists table
   - Fields: user_id, product_id, created_at

2. **Create Wishlist Functionality**
   - Model: Wishlist
   - Controller: WishlistController
   - Add to wishlist button on products
   - Heart icon toggle

3. **Create Wishlist Page**
   - File: `resources/js/pages/Wishlist/Index.vue`
   - Display all wishlist items
   - Move to cart button
   - Remove from wishlist
   - Share wishlist (optional)

4. **Wishlist Notifications**
   - Email when wishlist item goes on sale
   - Email when wishlist item back in stock

**Expected Outcome:**
- Users can save favorite products
- Easy access to wishlist
- Notifications for saved items

---

### Phase 10: Mobile Optimization & PWA (LOW PRIORITY)

**Goal:** Optimize for mobile and add PWA capabilities.

**Tasks:**

1. **Mobile Menu**
   - Create mobile-friendly navigation
   - Hamburger menu
   - Touch-friendly buttons
   - Swipe gestures

2. **PWA Setup**
   - Install Vite PWA plugin
   - Create manifest.json
   - Add service worker
   - Enable offline mode
   - Add to home screen prompt

3. **Mobile-Specific Features**
   - Touch-optimized image gallery
   - Mobile payment options (Apple Pay, Google Pay)
   - Location services for delivery
   - Push notifications

4. **Performance Optimization**
   - Lazy load images
   - Code splitting
   - Optimize bundle size
   - Compress images

**Expected Outcome:**
- Excellent mobile experience
- Installable as app
- Works offline
- Fast performance

---

## 🎨 Design Guidelines

### UI/UX Principles
- **Consistency:** Use existing Tailwind classes and color scheme
- **Accessibility:** WCAG 2.1 AA compliance
- **Responsive:** Mobile-first approach
- **Dark Mode:** Support both themes
- **Loading States:** Show feedback for all async operations
- **Error Handling:** User-friendly error messages

### Color Scheme
- **Primary:** Green (#10b981) - Farm/nature theme
- **Secondary:** Blue (#3b82f6)
- **Success:** Green (#059669)
- **Warning:** Yellow (#f59e0b)
- **Error:** Red (#ef4444)
- **Gray Scale:** Tailwind default

### Component Patterns
- Use existing components as reference
- Follow Vue 3 Composition API
- Use TypeScript for all new files
- Implement proper prop validation
- Add JSDoc comments for complex functions

---

## 🔧 Technical Requirements

### Code Quality
- **TypeScript:** Strict mode enabled, no `any` types
- **ESLint:** Fix all linting errors
- **Prettier:** Format all code
- **Laravel Pint:** Format PHP code
- **Comments:** Document complex logic
- **Testing:** Write tests for critical features

### Performance
- **Database:** Use eager loading to prevent N+1 queries
- **Caching:** Cache frequently accessed data
- **Pagination:** Paginate large datasets
- **Optimization:** Optimize images and assets
- **Lazy Loading:** Lazy load routes and components

### Security
- **Validation:** Validate all inputs server-side
- **Authorization:** Use policies for all actions
- **CSRF:** Ensure CSRF protection
- **XSS:** Escape all user-generated content
- **SQL Injection:** Use Eloquent ORM only
- **File Uploads:** Validate file types and sizes

---

## 📝 Development Workflow

### Step-by-Step Process

1. **Understand the Task**
   - Read the phase requirements carefully
   - Check existing code to avoid duplication
   - Plan the implementation

2. **Backend First**
   - Create migrations
   - Create/update models
   - Create controllers
   - Add routes
   - Test with Postman/Tinker

3. **Frontend Second**
   - Create TypeScript types
   - Create Vue components
   - Implement UI
   - Connect to backend
   - Test in browser

4. **Testing**
   - Test all user flows
   - Test edge cases
   - Test on mobile
   - Test dark mode
   - Test with different roles

5. **Documentation**
   - Update README if needed
   - Add code comments
   - Document new features
   - Update API documentation

### Commands Reference

```bash
# Development
composer dev                    # Start all services

# Database
php artisan make:migration      # Create migration
php artisan migrate            # Run migrations
php artisan db:seed            # Seed database
php artisan migrate:fresh --seed # Reset & seed

# Models & Controllers
php artisan make:model ModelName -mcr  # Model + migration + controller + resource
php artisan make:controller ControllerName
php artisan make:policy PolicyName --model=ModelName

# Frontend
npm run dev                    # Vite dev server
npm run build                  # Production build
npm run lint                   # Lint code
npm run format                 # Format code

# Testing
php artisan test               # Run PHP tests
npm run test                   # Run JS tests

# Code Quality
./vendor/bin/pint              # Format PHP
php artisan route:list         # List all routes
php artisan tinker             # Laravel REPL
```

---

## 🐛 Common Issues & Solutions

### Issue: "Vite manifest not found"
```bash
npm run build
```

### Issue: "Class not found"
```bash
composer dump-autoload
```

### Issue: "Route not found"
```bash
php artisan route:clear
php artisan optimize:clear
```

### Issue: "Database locked"
```bash
# Close all database connections
# Restart Laravel server
```

### Issue: "Permission denied on storage"
```bash
chmod -R 775 storage bootstrap/cache
```

---

## ✅ Testing Checklist

After implementing each phase, verify:

- [ ] Feature works as expected
- [ ] No console errors
- [ ] No PHP errors in logs
- [ ] Responsive on mobile
- [ ] Works in dark mode
- [ ] Proper loading states
- [ ] Error handling works
- [ ] Authorization is correct
- [ ] Data validates properly
- [ ] No N+1 query issues

---

## 📚 Resources

### Documentation
- Laravel: https://laravel.com/docs/12.x
- Vue 3: https://vuejs.org/guide/
- Inertia.js: https://inertiajs.com/
- Tailwind CSS: https://tailwindcss.com/docs
- TypeScript: https://www.typescriptlang.org/docs/

### Packages
- Laravel Fortify: https://laravel.com/docs/12.x/fortify
- Pinia: https://pinia.vuejs.org/
- VueUse: https://vueuse.org/
- Chart.js: https://www.chartjs.org/
- Stripe: https://stripe.com/docs

---

## 🎯 Success Criteria

The project is complete when:

✅ All 10 phases are implemented
✅ All features work correctly
✅ No critical bugs
✅ Code is clean and documented
✅ Tests pass
✅ Performance is optimized
✅ Security is ensured
✅ Mobile responsive
✅ Dark mode works
✅ Documentation is updated

---

## 💡 Tips for AI Agent

1. **Don't Recreate:** Check existing files before creating new ones
2. **Follow Patterns:** Use existing code as reference for style and structure
3. **Test Frequently:** Test after each major change
4. **Read Errors:** Laravel and Vue provide helpful error messages
5. **Use Types:** TypeScript will catch many errors before runtime
6. **Check Routes:** Always verify routes are registered
7. **Migrations:** Never edit old migrations, create new ones
8. **Git:** Commit frequently with clear messages
9. **Performance:** Use eager loading, caching, and pagination
10. **Security:** Always validate, authorize, and sanitize

---

## 🚀 Getting Started

1. Read this entire document
2. Review existing code in the project
3. Start with Phase 1 (Shopping Cart)
4. Complete each phase in order
5. Test thoroughly after each phase
6. Update documentation as you go
7. Celebrate when complete! 🎉

---

**Good luck! Build an amazing farm management system! 🌾**
