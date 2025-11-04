# 🌾 Fresh Farm - Complete Development Prompt

## 🎯 Project Vision

Build a **modern farm management and e-commerce system** connecting farmers with customers. Enable product browsing/purchasing, farm visit bookings, order tracking, and provide administrators with comprehensive management tools.

---

## 🏗️ Tech Stack

- **Backend:** Laravel 12, PHP 8.2+, SQLite/MySQL
- **Frontend:** Vue 3.5, TypeScript 5.2, Inertia.js 2.0
- **Styling:** Tailwind CSS 4.1
- **Build:** Vite 7.0
- **Auth:** Laravel Fortify with 2FA
- **State:** Pinia
- **Charts:** Chart.js

---

## 👥 User Roles

### Customer Role
**Capabilities:**
- Browse/search products
- Add to cart & checkout
- Track orders
- Book farm visits
- Write reviews
- Manage wishlist
- Update profile
- Save addresses

**Dashboard:**
- Recent orders
- Upcoming bookings
- Wishlist access
- Order tracking
- Notifications

### Admin Role
**Capabilities:**
- All customer features
- Manage products/categories
- Approve/reject orders
- Confirm bookings
- Manage users
- Moderate reviews
- View analytics
- Generate reports
- System settings

**Dashboard:**
- Real-time statistics
- Pending orders
- Revenue charts
- Low stock alerts
- Quick actions

---

## 🎨 Design System

### Colors
**Primary:** Green #10b981 (Farm theme)
**Secondary:** Blue #3b82f6
**Success:** Green #059669
**Warning:** Yellow #f59e0b
**Error:** Red #ef4444
**Gray Scale:** Tailwind defaults

**Dark Mode:**
- Background: #0f172a
- Surface: #1e293b
- Text: #f1f5f9

### Typography
- **Font:** Inter, system-ui
- **Sizes:** xs(12px) to 4xl(36px)
- **Weights:** 400, 500, 600, 700

### Spacing
Tailwind scale: 0, 1(4px), 2(8px), 4(16px), 6(24px), 8(32px), 12(48px)

---

## 🔐 Authentication Design

### Login Page
```
┌─────────────────────────┐
│  Fresh Farm Logo        │
│                         │
│  Welcome Back           │
│  Sign in to account     │
│                         │
│  Email: [_________]     │
│  Password: [_______]    │
│                         │
│  [✓] Remember me        │
│  Forgot password?       │
│                         │
│  [Sign In Button]       │
│                         │
│  Don't have account?    │
│  Sign Up                │
└─────────────────────────┘
```

**Features:**
- Centered card on farm background
- Real-time validation
- Remember me checkbox
- Password reset link
- Loading states

### Registration Page
```
┌─────────────────────────┐
│  Create Account         │
│                         │
│  Full Name: [_______]   │
│  Email: [___________]   │
│  Password: [________]   │
│  Strength: ████░░       │
│  Confirm: [_________]   │
│                         │
│  [✓] Agree to Terms     │
│                         │
│  [Create Account]       │
│                         │
│  Have account? Sign In  │
└─────────────────────────┘
```

**Validation:**
- Name: Min 2 chars
- Email: Valid & unique
- Password: 8+ chars, uppercase, number
- Terms: Required

---

## 📱 Customer Dashboard

```
┌─────────────────────────────────────┐
│ Logo  [Search]  [Cart] [Profile▼]  │
├─────────────────────────────────────┤
│ Welcome back, John! 👋              │
│                                     │
│ [🛒 3 Cart] [📦 5 Orders]          │
│ [📅 2 Visits] [❤️ 8 Saved]         │
│                                     │
│ Recent Orders        [View All →]  │
│ ORD-123 | $45.99 | Processing      │
│ ORD-122 | $32.50 | Delivered       │
│                                     │
│ Upcoming Bookings    [View All →]  │
│ Farm Tour | Nov 15 | 4 people      │
│                                     │
│ Recommended Products                │
│ [Product Cards Grid]                │
└─────────────────────────────────────┘
```

**Navigation:**
- Dashboard
- Browse Products
- My Orders
- My Bookings
- Wishlist
- Profile
- Logout

---

## 👨‍💼 Admin Dashboard

```
┌─────────────────────────────────────┐
│ Admin Panel    [🔔] [Profile▼]     │
├──────┬──────────────────────────────┤
│ 📊   │ Admin Dashboard              │
│ 📦   │                              │
│ 🛍️   │ [$12,450] [23 Pending]      │
│ 📁   │ [156 Users] [+15% Week]     │
│ 📅   │                              │
│ 👥   │ Revenue Chart (30 days)     │
│ ⭐   │ [Line Chart]                │
│ 📊   │                              │
│ ⚙️   │ Pending Orders              │
│      │ ORD-123 | John | $45 [✓][✗]│
│      │                              │
│      │ Recent Activity              │
│      │ • New order from John        │
│      │ • Low stock: Tomatoes        │
└──────┴──────────────────────────────┘
```

**Sidebar:**
- Dashboard
- Orders
- Products
- Categories
- Bookings
- Users
- Reviews
- Analytics
- Settings

---

## 🛍️ Core Features

### 1. Product Catalog

**Product Card:**
```
┌─────────────┐
│ [Image]     │
│ ⭐⭐⭐⭐⭐   │
│ Tomatoes    │
│ $3.99/kg    │
│ [Add] ❤️    │
└─────────────┘
```

**Features:**
- Grid/list view
- Category filter
- Price filter
- Sort options
- Search
- Pagination
- Stock indicator
- Quick view
- Wishlist

**Detail Page:**
- Image gallery
- Description
- Price & stock
- Ratings
- Quantity selector
- Add to cart
- Related products
- Reviews section

### 2. Shopping Cart

```
┌─────────────────────────┐
│ Cart (3 items)          │
├─────────────────────────┤
│ Tomatoes $3.99 × 2      │
│ [- 2 +] Remove          │
├─────────────────────────┤
│ Subtotal:    $12.48     │
│ Tax (10%):   $1.25      │
│ Delivery:    $5.00      │
│ Total:       $18.73     │
│                         │
│ [Shop] [Checkout]       │
└─────────────────────────┘
```

**Features:**
- Add/remove items
- Update quantities
- Real-time totals
- LocalStorage persistence
- Stock validation
- Minimum order check

### 3. Checkout

**Step 1: Delivery**
- Address form
- Saved addresses
- Date picker
- Special instructions

**Step 2: Payment**
- Stripe integration
- Card input
- Order summary
- Place order

**Features:**
- Progress indicator
- Address validation
- Payment processing
- Success page
- Email confirmation

### 4. Order Management

**Customer View:**
- Order list with filters
- Status tracking
- Order details
- Invoice download
- Cancel option

**Order Statuses:**
- 🟡 Pending
- 🔵 Approved
- 🟣 Processing
- 🟢 Completed
- 🔴 Cancelled

**Admin View:**
- All orders
- Bulk actions
- Status updates
- Packing slips
- Refunds

### 5. Booking System

**Types:**
- Farm Tour ($10/person)
- Special Event ($25/person)
- Workshop ($50/person)
- Private Visit ($100/person)

**Booking Form:**
```
┌─────────────────────────┐
│ Book a Visit            │
│ Type: [Tour▼]           │
│ Date: [Picker]          │
│ Time: [10:00 AM▼]       │
│ People: [- 4 +]         │
│ Notes: [_______]        │
│ Total: $40.00           │
│ [Submit Request]        │
└─────────────────────────┘
```

**Features:**
- Calendar availability
- Dynamic pricing
- Capacity limits
- Email confirmation
- Admin approval

### 6. Product Reviews

**Review Form:**
- Star rating (1-5)
- Title & text
- Submit button

**Display:**
- Average rating
- Review list
- Verified badge
- Helpful votes
- Sort options

**Admin:**
- Approve/reject
- Moderate content
- Respond to reviews

### 7. Wishlist
- Save products
- Move to cart
- Price alerts
- Stock notifications

### 8. User Profile

**Sections:**
- Personal info
- Avatar upload
- Saved addresses
- Order history
- Notifications
- Password/2FA

### 9. Admin Analytics

**Charts:**
- Revenue trends
- Sales by category
- Customer growth
- Top products

**Reports:**
- Sales report
- Customer report
- Inventory report
- Export PDF/Excel

### 10. Admin Products

**Product Form:**
- Name, category
- Description (rich text)
- Price, unit, stock
- Image upload
- Available/Featured toggles

**Features:**
- Multiple images
- Bulk import (CSV)
- Bulk edit
- SEO fields

---

## 🔔 Notifications

### Email Templates
**Customer:**
- Welcome
- Order confirmation
- Order updates
- Booking confirmation
- Password reset
- Review reminder

**Admin:**
- New order
- New booking
- Low stock
- Daily summary

### In-App
- Notification center
- Real-time updates
- Mark as read
- Preferences

---

## 📱 Responsive Design

**Breakpoints:**
- sm: 640px (Mobile)
- md: 768px (Tablet)
- lg: 1024px (Desktop)
- xl: 1280px (Large)

**Mobile:**
- Hamburger menu
- Touch-friendly
- Swipe gestures
- Bottom navigation

---

## 🔧 Technical Requirements

### Code Quality
- TypeScript strict mode
- ESLint/Prettier
- Laravel Pint
- PHPDoc comments
- Unit tests

### Performance
- Eager loading
- Caching
- Pagination
- Image optimization
- Lazy loading

### Security
- Input validation
- Authorization policies
- CSRF protection
- XSS prevention
- SQL injection prevention

---

## ✅ Implementation Phases

### Phase 1: Shopping Cart (HIGH)
- Pinia store
- Cart page
- Checkout flow
- Stripe integration

### Phase 2: Admin Products (HIGH)
- Product CRUD
- Category CRUD
- Image uploads
- Bulk operations

### Phase 3: Email System (MEDIUM)
- Email templates
- Queue jobs
- Notification preferences

### Phase 4: User Profiles (MEDIUM)
- Profile editing
- Address management
- Order history

### Phase 5: Reviews (LOW)
- Review system
- Moderation
- Ratings display

### Phase 6: Advanced Features (LOW)
- Wishlist
- Search/filters
- Analytics
- PWA

---

## 📚 Development Commands

```bash
# Start development
composer dev

# Database
php artisan migrate
php artisan db:seed

# Create resources
php artisan make:model ModelName -mcr
php artisan make:controller ControllerName
php artisan make:policy PolicyName

# Frontend
npm run dev
npm run build
npm run lint

# Testing
php artisan test
```

---

## 🎯 Success Criteria

✅ All features implemented
✅ Responsive design
✅ Dark mode support
✅ Type-safe code
✅ Security best practices
✅ Performance optimized
✅ Tests passing
✅ Documentation complete

---

**Build an amazing farm management system! 🌾**
