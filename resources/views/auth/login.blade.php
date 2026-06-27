@extends('auth.layouts.guest')
@section('title', 'Sign In')

@section('content')
  <h2 class="auth-card__heading">Welcome back</h2>
  <p class="auth-card__desc">Sign in to manage your bakery.</p>

  @if(session('status'))
    <div class="auth-status" role="alert">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ route('login') }}" novalidate>
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

    <div class="form-group">
      <label class="form-label" for="password">Password</label>
      <input class="form-control @error('password') is-invalid @enderror"
             type="password" id="password" name="password"
             autocomplete="current-password" required />
      @error('password')
        <p class="form-error" role="alert">{{ $message }}</p>
      @enderror
    </div>

    <div class="auth-row">
      <label class="form-check">
        <input type="checkbox" name="remember" id="remember">
        <span>Remember me</span>
      </label>
      @if(Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="auth-link">Forgot password?</a>
      @endif
    </div>

    <button type="submit" class="btn-auth">Sign In</button>
  </form>
@endsection
