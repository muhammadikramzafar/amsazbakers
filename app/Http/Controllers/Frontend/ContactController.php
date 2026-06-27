<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactRequest;
use App\Mail\ContactNotificationMail;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact.index');
    }

    public function store(ContactRequest $request)
    {
        $message = ContactMessage::create($request->validated());

        Mail::to(config('mail.from.address'))
            ->queue(new ContactNotificationMail($message));

        return redirect()->route('contact')
            ->with('success', 'Thank you! Your message has been sent. We will get back to you shortly.');
    }
}
