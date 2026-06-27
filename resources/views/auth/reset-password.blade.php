@extends('auth.layouts.guest')
@section('title', 'Set New Password')

@section('content')
  <h2 class="auth-card__heading">Set a new password</h2>
  <p class="auth-card__desc">Choose a strong password for your account.</p>

  <form method="POST" action="{{ route('password.store') }}" novalidate>
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div class="form-group">
      <label class="form-label" for="email">Email Address</label>
      <input class="form-control @error('email') is-invalid @enderror"
             type="email" id="email" name="email"
             value="{{ old('email', $request->email) }}"
             autocomplete="username" autofocus required />
      @error('email')
        <p class="form-error" role="alert">{{ $message }}</p>
      @enderror
    </div>

    <div class="form-group">
      <label class="form-label" for="password">New Password</label>
      <input class="form-control @error('password') is-invalid @enderror"
             type="password" id="password" name="password"
             autocomplete="new-password" required />
      @error('password')
        <p class="form-error" role="alert">{{ $message }}</p>
      @enderror
    </div>

    <div class="form-group">
      <label class="form-label" for="password_confirmation">Confirm Password</label>
      <input class="form-control @error('password_confirmation') is-invalid @enderror"
             type="password" id="password_confirmation" name="password_confirmation"
             autocomplete="new-password" required />
      @error('password_confirmation')
        <p class="form-error" role="alert">{{ $message }}</p>
      @enderror
    </div>

    <button type="submit" class="btn-auth">Reset Password</button>
  </form>
@endsection
