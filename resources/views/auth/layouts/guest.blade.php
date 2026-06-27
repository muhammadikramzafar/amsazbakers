<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>@yield('title', 'Login') — {{ config('app.name') }}</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet" />

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --gold:   #c8a24a;
      --gold-d: #b08d38;
      --brown:  #5a3e2b;
      --cream:  #fff6e5;
      --muted:  #6c757d;
      --border: #e0d5c5;
      --danger: #dc3545;
      --radius: 8px;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      background: var(--cream);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px 16px;
    }

    .auth-card {
      width: 100%;
      max-width: 420px;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 32px rgba(90,62,43,.12);
      overflow: hidden;
    }

    /* Header band */
    .auth-card__header {
      background: var(--brown);
      padding: 28px 32px 24px;
      text-align: center;
    }
    .auth-card__logo {
      font-family: 'Fraunces', serif;
      font-size: 22px;
      letter-spacing: .08em;
      color: var(--gold);
      text-decoration: none;
      display: block;
    }
    .auth-card__subtitle {
      margin-top: 4px;
      font-size: 12px;
      color: rgba(255,246,229,.6);
      letter-spacing: .04em;
    }

    /* Body */
    .auth-card__body {
      padding: 32px;
    }
    .auth-card__heading {
      font-size: 18px;
      font-weight: 700;
      color: var(--brown);
      margin-bottom: 6px;
    }
    .auth-card__desc {
      font-size: 13px;
      color: var(--muted);
      margin-bottom: 24px;
      line-height: 1.5;
    }

    /* Form elements */
    .form-group   { margin-bottom: 18px; }
    .form-label   { display: block; font-size: 13px; font-weight: 600; color: var(--brown); margin-bottom: 6px; }
    .form-control {
      width: 100%; padding: 10px 14px;
      border: 1.5px solid var(--border); border-radius: var(--radius);
      font-size: 14px; font-family: inherit; color: #212529;
      transition: border-color .15s, box-shadow .15s;
      background: #fff;
    }
    .form-control:focus {
      outline: none;
      border-color: var(--gold);
      box-shadow: 0 0 0 3px rgba(200,162,74,.18);
    }
    .form-control.is-invalid { border-color: var(--danger); }
    .form-error { font-size: 12px; color: var(--danger); margin-top: 4px; }

    /* Status / success message */
    .auth-status {
      background: #d4edda; color: #155724;
      border: 1px solid #c3e6cb; border-radius: var(--radius);
      padding: 10px 14px; font-size: 13px; margin-bottom: 20px;
    }

    /* Submit button */
    .btn-auth {
      width: 100%; padding: 11px;
      background: var(--gold); color: #fff;
      border: none; border-radius: var(--radius);
      font-size: 14px; font-weight: 700; font-family: inherit;
      cursor: pointer; letter-spacing: .02em;
      transition: background .15s;
    }
    .btn-auth:hover { background: var(--gold-d); }

    /* Row with link */
    .auth-row {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 20px;
    }
    .auth-link {
      font-size: 13px; color: var(--gold); text-decoration: none; font-weight: 500;
    }
    .auth-link:hover { text-decoration: underline; }

    /* Remember me */
    .form-check { display: flex; align-items: center; gap: 8px; cursor: pointer; }
    .form-check input { accent-color: var(--gold); width: 15px; height: 15px; cursor: pointer; }
    .form-check span { font-size: 13px; color: var(--muted); }

    /* Footer */
    .auth-card__footer {
      border-top: 1px solid var(--border);
      padding: 16px 32px;
      text-align: center;
      font-size: 12px;
      color: var(--muted);
    }
  </style>
</head>
<body>
  <div class="auth-card">

    <div class="auth-card__header">
      <a href="{{ route('home') }}" class="auth-card__logo">AZMEER BAKERY</a>
      <p class="auth-card__subtitle">Admin Panel</p>
    </div>

    <div class="auth-card__body">
      @yield('content')
    </div>

    <div class="auth-card__footer">
      &copy; {{ date('Y') }} Azmeer Bakery. All rights reserved.
    </div>

  </div>
</body>
</html>
