<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')
            ->withCount('orders')
            ->withSum(['orders as total_spent' => function($query) {
                $query->where('status', '!=', 'cancelled');
            }], 'total')
            ->latest()
            ->get();

        return Inertia::render('Admin/Customers/Index', [
            'customers' => $customers,
        ]);
    }
}
