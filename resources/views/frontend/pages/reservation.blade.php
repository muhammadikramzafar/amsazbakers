@extends('frontend.layouts.app')
@section('title', 'Make a Reservation — Azmeer Bakery')
@section('content')

  <section class="page-banner">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}" class="breadcrumb__link">Home</a>
      <span class="breadcrumb__sep" aria-hidden="true">/</span>
      <span class="breadcrumb__current">Reservation</span>
    </nav>
    <h1 class="page-banner__title">Make a Reservation</h1>
    <span class="gold-rule gold-rule--center" aria-hidden="true"></span>
  </section>

  <section class="contact-section">
    <div class="contact-form-wrap" style="max-width:600px; margin:0 auto">
      @if(session('success'))
        <div class="alert alert--success" role="alert">{{ session('success') }}</div>
      @endif
      <form action="{{ route('reservation.store') }}" method="POST" class="contact-form" novalidate>
        @csrf
        <div class="form-group">
          <label class="form-label" for="rsv-name">Full Name *</label>
          <input class="form-control @error('name') is-invalid @enderror" type="text" id="rsv-name" name="name"
                 value="{{ old('name') }}" required />
          @error('name')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="rsv-email">Email *</label>
            <input class="form-control @error('email') is-invalid @enderror" type="email" id="rsv-email" name="email"
                   value="{{ old('email') }}" required />
            @error('email')<p class="form-error">{{ $message }}</p>@enderror
          </div>
          <div class="form-group">
            <label class="form-label" for="rsv-phone">Phone *</label>
            <input class="form-control @error('phone') is-invalid @enderror" type="tel" id="rsv-phone" name="phone"
                   value="{{ old('phone') }}" placeholder="+92 300 0000000" required />
            @error('phone')<p class="form-error">{{ $message }}</p>@enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="rsv-date">Date *</label>
            <input class="form-control @error('date') is-invalid @enderror" type="date" id="rsv-date" name="date"
                   value="{{ old('date') }}" min="{{ now()->addDay()->format('Y-m-d') }}" required />
            @error('date')<p class="form-error">{{ $message }}</p>@enderror
          </div>
          <div class="form-group">
            <label class="form-label" for="rsv-time">Time *</label>
            <select class="form-control @error('time') is-invalid @enderror" id="rsv-time" name="time" required>
              <option value="">Select time</option>
              @foreach(['12:00 PM','1:00 PM','2:00 PM','3:00 PM','4:00 PM','5:00 PM','6:00 PM','7:00 PM','8:00 PM','9:00 PM'] as $t)
                <option value="{{ $t }}" {{ old('time') == $t ? 'selected' : '' }}>{{ $t }}</option>
              @endforeach
            </select>
            @error('time')<p class="form-error">{{ $message }}</p>@enderror
          </div>
        </div>
        <div class="form-group">
          <label class="form-label" for="rsv-guests">Number of Guests *</label>
          <input class="form-control @error('guests') is-invalid @enderror" type="number" id="rsv-guests" name="guests"
                 value="{{ old('guests', 2) }}" min="1" max="50" required />
          @error('guests')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="rsv-message">Special Requests</label>
          <textarea class="form-control" id="rsv-message" name="message" rows="3"
                    placeholder="Any dietary requirements or special occasions?">{{ old('message') }}</textarea>
        </div>
        <button type="submit" class="btn btn--primary btn--full">Confirm Reservation</button>
      </form>
    </div>
  </section>

@endsection
