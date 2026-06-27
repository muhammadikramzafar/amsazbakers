<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use App\Models\Product;
use App\Models\Reservation;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products'       => Product::count(),
            'blogs'          => rescue(fn () => Blog::count(), 0, false),
            'link_clicks'    => 0,
            'inquiries'      => ContactMessage::count(),
            'subscribers'    => rescue(fn () => NewsletterSubscriber::count(), 0, false),
            'categories'     => Category::count(),
            'reservations'   => Reservation::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
        ];

        $recentReservations = Reservation::latest()->take(5)->get();
        $recentMessages     = ContactMessage::latest()->take(5)->get();

        return view('admin.dashboard.index', compact('stats', 'recentReservations', 'recentMessages'));
    }
}
