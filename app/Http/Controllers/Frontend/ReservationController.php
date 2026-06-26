<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        return view('frontend.reservation');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|string|max:20',
            'date'    => 'required|date|after_or_equal:today',
            'time'    => 'required',
            'guests'  => 'required|integer|min:1|max:20',
            'message' => 'nullable|string|max:500',
        ]);

        \App\Models\Reservation::create($validated);

        return back()->with('success', 'Your reservation has been received! We will confirm it shortly.');
    }
}
