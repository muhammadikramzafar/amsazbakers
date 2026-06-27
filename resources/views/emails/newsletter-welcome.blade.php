<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome to our Newsletter</title>
<style>
  body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
  .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
  .header { background: #8B1A1A; color: #fff; padding: 40px 32px; text-align: center; }
  .header h1 { margin: 0 0 8px; font-size: 26px; }
  .body { padding: 40px 32px; text-align: center; }
  .body p { color: #555; line-height: 1.7; margin: 0 0 20px; }
  .highlights { display: flex; gap: 16px; margin: 32px 0; flex-wrap: wrap; }
  .highlight { flex: 1; min-width: 140px; background: #fdf8f0; border-radius: 8px; padding: 20px 16px; }
  .highlight h3 { margin: 0 0 8px; font-size: 14px; color: #8B1A1A; }
  .highlight p { font-size: 13px; margin: 0; }
  .btn { display: inline-block; background: #8B1A1A; color: #fff; padding: 14px 32px; border-radius: 4px; text-decoration: none; font-weight: bold; }
  .footer { background: #f5f5f5; padding: 24px 32px; font-size: 12px; color: #999; text-align: center; }
  .footer a { color: #8B1A1A; }
</style>
</head>
<body>
<div class="container">
  <div class="header">
    <h1>Welcome{{ $subscriber->name ? ', ' . $subscriber->name : '' }}!</h1>
    <p style="margin:0;opacity:.85;">You're now part of the {{ config('app.name') }} family</p>
  </div>
  <div class="body">
    <p>Thank you for subscribing to our newsletter! You'll be the first to know about our latest recipes, seasonal specials, new menu items, and exclusive offers.</p>
    <div class="highlights">
      <div class="highlight">
        <h3>Fresh Recipes</h3>
        <p>Get our latest baking recipes delivered to your inbox.</p>
      </div>
      <div class="highlight">
        <h3>Exclusive Offers</h3>
        <p>Subscriber-only discounts and seasonal promotions.</p>
      </div>
      <div class="highlight">
        <h3>New Arrivals</h3>
        <p>Be first to discover new products and menu additions.</p>
      </div>
    </div>
    <a href="{{ route('home') }}" class="btn">Visit Our Website</a>
  </div>
  <div class="footer">
    <p>You are receiving this because you subscribed at {{ config('app.url') }}.</p>
    <p>If you no longer wish to receive these emails, simply ignore this message or <a href="{{ route('home') }}">visit our website</a>.</p>
  </div>
</div>
</body>
</html>
