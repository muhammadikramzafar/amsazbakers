<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title') — {{ config('app.name') }}</title>
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: 'Georgia', serif;
    background: #1a0a0a;
    color: #fff;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 40px 20px;
  }
  .logo { font-size: 28px; font-weight: bold; color: #c9a96e; letter-spacing: 2px; margin-bottom: 48px; text-decoration: none; }
  .code {
    font-size: 120px;
    font-weight: 900;
    color: #8B1A1A;
    line-height: 1;
    text-shadow: 0 4px 20px rgba(139,26,26,.4);
  }
  h1 { font-size: 28px; color: #c9a96e; margin: 16px 0 12px; letter-spacing: 1px; }
  p { color: #ccc; font-size: 16px; line-height: 1.6; max-width: 480px; }
  .divider { width: 60px; height: 3px; background: #8B1A1A; margin: 24px auto; border-radius: 2px; }
  .actions { margin-top: 36px; display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }
  .btn {
    display: inline-block;
    padding: 12px 28px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 14px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: opacity .2s;
  }
  .btn:hover { opacity: .85; }
  .btn-primary { background: #8B1A1A; color: #fff; }
  .btn-secondary { border: 1px solid #555; color: #ccc; }
</style>
</head>
<body>
  <a href="{{ route('home') }}" class="logo">{{ config('app.name', 'Bakers & Sweets') }}</a>
  <div class="code">@yield('code')</div>
  <h1>@yield('title')</h1>
  <div class="divider"></div>
  <p>@yield('message')</p>
  <div class="actions">
    <a href="{{ route('home') }}" class="btn btn-primary">Go Home</a>
    <a href="{{ route('contact') }}" class="btn btn-secondary">Contact Us</a>
  </div>
</body>
</html>
