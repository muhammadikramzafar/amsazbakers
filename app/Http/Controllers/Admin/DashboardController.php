<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Models\Reservation;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products'        => Product::count(),
            'categories'      => Category::count(),
            'reservations'    => Reservation::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
        ];

        $recentReservations = Reservation::latest()->take(5)->get();
        $recentMessages     = ContactMessage::latest()->take(5)->get();

        return view('admin.dashboard.index', compact('stats', 'recentReservations', 'recentMessages'));
    }
}
