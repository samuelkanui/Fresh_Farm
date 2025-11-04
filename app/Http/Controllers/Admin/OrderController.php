<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])
            ->latest()
            ->get();

        return Inertia::render('Admin/Orders/Index', [
            'orders' => $orders,
        ]);
    }

    public function pending()
    {
        $orders = Order::with(['user', 'items.product'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return Inertia::render('Admin/Orders/Pending', [
            'orders' => $orders,
        ]);
    }
}
