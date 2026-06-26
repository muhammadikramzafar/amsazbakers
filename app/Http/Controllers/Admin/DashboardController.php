<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products'     => \App\Models\Product::count(),
            'categories'   => \App\Models\Category::count(),
            'reservations' => \App\Models\Reservation::count(),
            'messages'     => \App\Models\ContactMessage::where('is_read', false)->count(),
        ];

        $recentReservations = \App\Models\Reservation::latest()->take(5)->get();
        $recentMessages     = \App\Models\ContactMessage::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentReservations', 'recentMessages'));
    }
}
