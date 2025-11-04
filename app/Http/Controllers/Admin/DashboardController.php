<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total'),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_products' => Product::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
        ];

        // Recent orders
        $recentOrders = Order::with(['user', 'items.product'])
            ->latest()
            ->limit(5)
            ->get();

        // Pending orders for approval
        $pendingOrders = Order::with(['user', 'items.product'])
            ->where('status', 'pending')
            ->latest()
            ->limit(10)
            ->get();

        // Recent bookings
        $recentBookings = Booking::with('user')
            ->latest()
            ->limit(5)
            ->get();

        // Generate real-time notifications
        $notifications = [];
        
        // Pending orders notifications
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        if ($pendingOrdersCount > 0) {
            $notifications[] = [
                'title' => "You have {$pendingOrdersCount} pending " . ($pendingOrdersCount === 1 ? 'order' : 'orders'),
                'description' => 'Awaiting your approval',
                'type' => 'order'
            ];
        }
        
        // Pending bookings notifications
        $pendingBookingsCount = Booking::where('status', 'pending')->count();
        if ($pendingBookingsCount > 0) {
            $notifications[] = [
                'title' => "{$pendingBookingsCount} new booking " . ($pendingBookingsCount === 1 ? 'request' : 'requests'),
                'description' => 'Requires confirmation',
                'type' => 'booking'
            ];
        }
        
        // Low stock notifications
        $lowStockProducts = Product::where('stock_quantity', '<', 10)
            ->where('stock_quantity', '>', 0)
            ->count();
        if ($lowStockProducts > 0) {
            $notifications[] = [
                'title' => "{$lowStockProducts} " . ($lowStockProducts === 1 ? 'product' : 'products') . " running low on stock",
                'description' => 'Restock needed soon',
                'type' => 'system'
            ];
        }
        
        // Out of stock notifications
        $outOfStockProducts = Product::where('stock_quantity', 0)->count();
        if ($outOfStockProducts > 0) {
            $notifications[] = [
                'title' => "{$outOfStockProducts} " . ($outOfStockProducts === 1 ? 'product is' : 'products are') . " out of stock",
                'description' => 'Immediate attention required',
                'type' => 'system'
            ];
        }
        
        // Recent orders in last hour
        $recentNewOrders = Order::where('created_at', '>=', now()->subHour())->count();
        if ($recentNewOrders > 0) {
            $notifications[] = [
                'title' => "{$recentNewOrders} new " . ($recentNewOrders === 1 ? 'order' : 'orders') . " received",
                'description' => 'In the last hour',
                'type' => 'order'
            ];
        }

        // Revenue trend data - Last 6 months
        $revenueData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthRevenue = Order::where('status', '!=', 'cancelled')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total');
            
            $revenueData[] = [
                'month' => $date->format('M'),
                'revenue' => (float) $monthRevenue
            ];
        }

        // Top Selling Products
        $topProducts = Product::withCount(['orderItems as total_sold' => function($query) {
            $query->select(DB::raw('SUM(quantity)'));
        }])
        ->withSum(['orderItems as total_revenue' => function($query) {
            $query->whereHas('order', function($q) {
                $q->where('status', '!=', 'cancelled');
            });
        }], 'subtotal')
        ->orderBy('total_revenue', 'desc')
        ->limit(5)
        ->get();

        // Low Stock Products
        $lowStockProducts = Product::where('stock_quantity', '<', 10)
            ->where('stock_quantity', '>', 0)
            ->orderBy('stock_quantity', 'asc')
            ->limit(5)
            ->get();

        // Performance Metrics
        $totalOrderValue = Order::where('status', '!=', 'cancelled')->sum('total');
        $totalOrders = Order::where('status', '!=', 'cancelled')->count();
        $averageOrderValue = $totalOrders > 0 ? $totalOrderValue / $totalOrders : 0;
        
        $totalCustomersWithOrders = Order::distinct('user_id')->count('user_id');
        $conversionRate = User::where('role', 'customer')->count() > 0 
            ? ($totalCustomersWithOrders / User::where('role', 'customer')->count()) * 100 
            : 0;

        // Upcoming Bookings (next 7 days)
        $upcomingBookings = Booking::with('user')
            ->where('booking_date', '>=', now())
            ->where('booking_date', '<=', now()->addDays(7))
            ->orderBy('booking_date', 'asc')
            ->limit(5)
            ->get();

        // Sales by Category
        $salesByCategory = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelled')
            ->select('categories.name as category', DB::raw('SUM(order_items.subtotal) as revenue'))
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('revenue', 'desc')
            ->get();

        // Customer Growth (last 6 months)
        $customerGrowth = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $newCustomers = User::where('role', 'customer')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            $customerGrowth[] = [
                'month' => $date->format('M'),
                'customers' => $newCustomers
            ];
        }

        // Top Customers
        $topCustomers = User::where('role', 'customer')
            ->withCount('orders')
            ->withSum(['orders as total_spent' => function($query) {
                $query->where('status', '!=', 'cancelled');
            }], 'total')
            ->orderBy('total_spent', 'desc')
            ->limit(5)
            ->get();

        // Revenue Target (example: $50,000)
        $revenueTarget = 50000;
        $targetProgress = $totalOrderValue > 0 ? ($totalOrderValue / $revenueTarget) * 100 : 0;

        // Pie chart data - Order status distribution
        $orderStatusData = [
            [
                'label' => 'Pending',
                'value' => Order::where('status', 'pending')->count(),
                'color' => 'rgb(234, 179, 8)' // yellow
            ],
            [
                'label' => 'Approved',
                'value' => Order::where('status', 'approved')->count(),
                'color' => 'rgb(59, 130, 246)' // blue
            ],
            [
                'label' => 'Completed',
                'value' => Order::where('status', 'completed')->count(),
                'color' => 'rgb(34, 197, 94)' // green
            ],
            [
                'label' => 'Cancelled',
                'value' => Order::where('status', 'cancelled')->count(),
                'color' => 'rgb(239, 68, 68)' // red
            ],
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'pendingOrders' => $pendingOrders,
            'recentBookings' => $recentBookings,
            'notifications' => $notifications,
            'orderStatusData' => $orderStatusData,
            'revenueData' => $revenueData,
            'topProducts' => $topProducts,
            'lowStockProducts' => $lowStockProducts,
            'performanceMetrics' => [
                'averageOrderValue' => $averageOrderValue,
                'conversionRate' => $conversionRate,
                'revenueTarget' => $revenueTarget,
                'targetProgress' => $targetProgress,
            ],
            'upcomingBookings' => $upcomingBookings,
            'salesByCategory' => $salesByCategory,
            'customerGrowth' => $customerGrowth,
            'topCustomers' => $topCustomers,
        ]);
    }

    public function approveOrder(Order $order)
    {
        $order->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Order approved successfully!');
    }

    public function rejectOrder(Order $order)
    {
        $order->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Order rejected.');
    }

    public function confirmBooking(Booking $booking)
    {
        $booking->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        return back()->with('success', 'Booking confirmed successfully!');
    }
}
