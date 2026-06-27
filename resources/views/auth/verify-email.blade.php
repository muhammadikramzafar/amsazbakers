@extends('auth.layouts.guest')
@section('title', 'Verify Email')

@section('content')
  <h2 class="auth-card__heading">Verify your email</h2>
  <p class="auth-card__desc">
    Thanks for joining! Before accessing the admin panel, please verify your email
    address by clicking the link we sent you.
  </p>

  @if(session('status') == 'verification-link-sent')
    <div class="auth-status" role="alert">
      A new verification link has been sent to your email address.
    </div>
  @endif

  <form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit" class="btn-auth">Resend Verification Email</button>
  </form>

  <p style="text-align:center; margin-top:16px;">
    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
      @csrf
      <button type="submit" class="auth-link" style="background:none; border:none; cursor:pointer; padding:0;">
        Log out
      </button>
    </form>
  </p>
@endsection
