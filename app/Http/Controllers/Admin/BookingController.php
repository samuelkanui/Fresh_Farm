<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user')
            ->latest()
            ->get();

        return Inertia::render('Admin/Bookings/Index', [
            'bookings' => $bookings,
        ]);
    }

    public function pending()
    {
        $bookings = Booking::with('user')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return Inertia::render('Admin/Bookings/Pending', [
            'bookings' => $bookings,
        ]);
    }
}
