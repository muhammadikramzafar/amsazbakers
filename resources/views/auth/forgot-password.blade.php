@extends('auth.layouts.guest')
@section('title', 'Forgot Password')

@section('content')
  <h2 class="auth-card__heading">Reset your password</h2>
  <p class="auth-card__desc">
    Enter your email address and we'll send you a password reset link.
  </p>

  @if(session('status'))
    <div class="auth-status" role="alert">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ route('password.email') }}" novalidate>
    @csrf

    <div class="form-group">
      <label class="form-label" for="email">Email Address</label>
      <input class="form-control @error('email') is-invalid @enderror"
             type="email" id="email" name="email"
             value="{{ old('email') }}"
             autocomplete="username" autofocus required />
      @error('email')
        <p class="form-error" role="alert">{{ $message }}</p>
      @enderror
    </div>

    <button type="submit" class="btn-auth">Send Reset Link</button>

    <p style="text-align:center; margin-top:16px;">
      <a href="{{ route('login') }}" class="auth-link">&larr; Back to login</a>
    </p>
  </form>
@endsection
