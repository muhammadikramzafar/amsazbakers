<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class NewsletterAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($search = $request->input('search')) {
            $query->where(fn ($q) => $q->where('email', 'like', "%{$search}%")
                                       ->orWhere('name', 'like', "%{$search}%"));
        }

        $subscribers = $query->paginate(30)->withQueryString();
        $totalActive = NewsletterSubscriber::active()->count();
        return view('admin.newsletter.index', compact('subscribers', 'totalActive'));
    }

    public function destroy(NewsletterSubscriber $newsletterSubscriber)
    {
        $newsletterSubscriber->delete();
        return back()->with('success', 'Subscriber deleted.');
    }

    public function export()
    {
        $subscribers = NewsletterSubscriber::active()->orderBy('email')->get(['name', 'email', 'created_at']);

        $csv = "Name,Email,Subscribed At\n";
        foreach ($subscribers as $s) {
            $csv .= '"'.str_replace('"', '""', $s->name ?? '').'",'
                  . '"'.str_replace('"', '""', $s->email).'",'
                  . '"'.$s->created_at->format('Y-m-d H:i').'"'."\n";
        }

        return Response::make($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="subscribers_'.now()->format('Y-m-d').'.csv"',
        ]);
    }
}
