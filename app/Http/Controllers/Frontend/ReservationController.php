<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        return view('frontend.pages.reservation');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|string|max:20',
            'date'    => 'required|date|after:today',
            'time'    => 'required|string',
            'guests'  => 'required|integer|min:1|max:50',
            'message' => 'nullable|string|max:1000',
        ]);

        Reservation::create($validated);

        return redirect()->route('reservation')->with('success', 'Reservation received! We will confirm your booking within 2 hours.');
    }
}
