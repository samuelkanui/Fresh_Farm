<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{
    public function index()
    {
        // Get all completed orders and bookings
        $completedOrders = Order::where('status', 'completed')->get();
        $completedBookings = Booking::where('status', 'confirmed')->get();
        
        // Calculate total revenue
        $orderRevenue = $completedOrders->sum('total');
        $bookingRevenue = $completedBookings->sum('total_price');
        $totalRevenue = $orderRevenue + $bookingRevenue;
        
        // Get monthly revenue (last 12 months)
        $monthlyRevenue = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->format('M Y');
            
            $monthOrders = Order::where('status', 'completed')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total');
                
            $monthBookings = Booking::where('status', 'confirmed')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total_price');
                
            $monthlyRevenue[] = [
                'month' => $month,
                'revenue' => $monthOrders + $monthBookings,
                'orders' => $monthOrders,
                'bookings' => $monthBookings,
            ];
        }
        
        // Calculate this month vs last month
        $thisMonthRevenue = Order::where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total') + 
            Booking::where('status', 'confirmed')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');
            
        $lastMonthRevenue = Order::where('status', 'completed')
            ->whereYear('created_at', now()->subMonth()->year)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('total') +
            Booking::where('status', 'confirmed')
            ->whereYear('created_at', now()->subMonth()->year)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('total_price');
            
        $revenueGrowth = $lastMonthRevenue > 0 
            ? (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 
            : 0;
        
        // Pending revenue (orders not yet completed)
        $pendingRevenue = Order::whereIn('status', ['pending', 'approved'])->sum('total');
        $pendingBookingRevenue = Booking::where('status', 'pending')->sum('total_price');
        
        // Revenue breakdown by category
        $revenueByCategory = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('orders.status', 'completed')
            ->select('categories.name as category', DB::raw('SUM(order_items.subtotal) as revenue'))
            ->groupBy('categories.id', 'categories.name')
            ->get();

        return Inertia::render('Admin/Revenue/Index', [
            'stats' => [
                'totalRevenue' => $totalRevenue,
                'orderRevenue' => $orderRevenue,
                'bookingRevenue' => $bookingRevenue,
                'thisMonthRevenue' => $thisMonthRevenue,
                'lastMonthRevenue' => $lastMonthRevenue,
                'revenueGrowth' => round($revenueGrowth, 2),
                'pendingRevenue' => $pendingRevenue + $pendingBookingRevenue,
                'completedOrders' => $completedOrders->count(),
                'completedBookings' => $completedBookings->count(),
            ],
            'monthlyRevenue' => $monthlyRevenue,
            'revenueByCategory' => $revenueByCategory,
        ]);
    }
}
