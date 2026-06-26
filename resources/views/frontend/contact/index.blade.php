@extends('frontend.layouts.app')
@section('title', 'Contact Us — Azmeer Bakery')

@section('content')

  <section class="page-banner">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}" class="breadcrumb__link">Home</a>
      <span class="breadcrumb__sep" aria-hidden="true">/</span>
      <span class="breadcrumb__current">Contact</span>
    </nav>
    <h1 class="page-banner__title">Get In Touch</h1>
    <span class="gold-rule gold-rule--center" aria-hidden="true"></span>
  </section>

  <section class="contact-section">
    <div class="contact-grid">

      <!-- Contact Form -->
      <div class="contact-form-wrap">
        <h2 class="contact-form__heading">Send Us a Message</h2>

        @if(session('success'))
          <div class="alert alert--success" role="alert">{{ session('success') }}</div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST" class="contact-form" novalidate>
          @csrf
          <div class="form-group">
            <label class="form-label" for="name">Your Name <span aria-hidden="true">*</span></label>
            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name"
                   value="{{ old('name') }}" placeholder="Muhammad Ali" required />
            @error('name')<p class="form-error">{{ $message }}</p>@enderror
          </div>
          <div class="form-group">
            <label class="form-label" for="email">Email Address <span aria-hidden="true">*</span></label>
            <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email"
                   value="{{ old('email') }}" placeholder="you@example.com" required />
            @error('email')<p class="form-error">{{ $message }}</p>@enderror
          </div>
          <div class="form-group">
            <label class="form-label" for="phone">Phone (optional)</label>
            <input class="form-control" type="tel" id="phone" name="phone"
                   value="{{ old('phone') }}" placeholder="+92 300 0000000" />
          </div>
          <div class="form-group">
            <label class="form-label" for="subject">Subject</label>
            <input class="form-control" type="text" id="subject" name="subject"
                   value="{{ old('subject') }}" placeholder="Custom cake order inquiry" />
          </div>
          <div class="form-group">
            <label class="form-label" for="message">Message <span aria-hidden="true">*</span></label>
            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message"
                      rows="5" placeholder="Tell us how we can help..." required>{{ old('message') }}</textarea>
            @error('message')<p class="form-error">{{ $message }}</p>@enderror
          </div>
          <button type="submit" class="btn btn--primary btn--full">Send Message</button>
        </form>
      </div>

      <!-- Contact Info -->
      <div class="contact-info-wrap">
        <h2 class="contact-info__heading">Find Us</h2>
        <div class="contact-info-list">
          <div class="contact-info-item">
            <div class="contact-info-item__icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="24" height="24">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
              </svg>
            </div>
            <div>
              <p class="contact-info-item__label">Address</p>
              <p class="contact-info-item__value">45 Main Boulevard, Gulberg III, Lahore, Pakistan</p>
            </div>
          </div>
          <div class="contact-info-item">
            <div class="contact-info-item__icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="24" height="24">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.86 19.86 0 0 1 3.08 4.18 2 2 0 0 1 5.07 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L9.91 9.91a16 16 0 0 0 6.16 6.16l1.27-.41a2 2 0 0 1 2.11.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
              </svg>
            </div>
            <div>
              <p class="contact-info-item__label">Phone</p>
              <p class="contact-info-item__value">+92 42 3571 8899</p>
            </div>
          </div>
          <div class="contact-info-item">
            <div class="contact-info-item__icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="24" height="24">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
              </svg>
            </div>
            <div>
              <p class="contact-info-item__label">Email</p>
              <p class="contact-info-item__value">hello@azmeerbakery.pk</p>
            </div>
          </div>
          <div class="contact-info-item">
            <div class="contact-info-item__icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="24" height="24">
                <circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/>
              </svg>
            </div>
            <div>
              <p class="contact-info-item__label">Hours</p>
              <p class="contact-info-item__value">Mon–Sat: 9:00 AM – 10:00 PM<br>Sunday: 10:00 AM – 8:00 PM</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
