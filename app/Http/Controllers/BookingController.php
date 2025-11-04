<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = auth()->user()->bookings()
            ->latest()
            ->get();

        return Inertia::render('Bookings/Index', [
            'bookings' => $bookings,
        ]);
    }

    public function create()
    {
        return Inertia::render('Bookings/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:tour,event,workshop,private',
            'booking_date' => 'required|date|after:today',
            'booking_time' => 'required',
            'number_of_people' => 'required|integer|min:1|max:50',
            'special_requests' => 'nullable|string|max:500',
        ]);

        $pricePerPerson = match($validated['type']) {
            'tour' => 10.00,
            'event' => 25.00,
            'workshop' => 50.00,
            'private' => 100.00,
        };

        $totalPrice = $pricePerPerson * $validated['number_of_people'];

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'booking_number' => 'BKG-' . strtoupper(uniqid()),
            'type' => $validated['type'],
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'number_of_people' => $validated['number_of_people'],
            'special_requests' => $validated['special_requests'] ?? null,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking request submitted successfully!');
    }
}
