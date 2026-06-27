<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\NewsletterRequest;
use App\Mail\NewsletterWelcomeMail;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function subscribe(NewsletterRequest $request)
    {
        $data     = $request->validated();
        $existing = NewsletterSubscriber::where('email', $data['email'])->first();

        if ($existing) {
            if ($existing->status === 'unsubscribed') {
                $existing->update(['status' => 'active', 'name' => $data['name'] ?? $existing->name]);
                $message = 'Welcome back! You have been re-subscribed.';
            } else {
                $message = 'You are already subscribed to our newsletter.';
            }
        } else {
            $subscriber = NewsletterSubscriber::create([
                'email'      => $data['email'],
                'name'       => $data['name'] ?? null,
                'status'     => 'active',
                'ip_address' => $request->ip(),
            ]);

            Mail::to($subscriber->email)
                ->queue(new NewsletterWelcomeMail($subscriber));

            $message = 'Thank you for subscribing to our newsletter!';
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back()->with('newsletter_success', $message);
    }
}
