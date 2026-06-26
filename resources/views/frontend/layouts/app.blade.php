<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>@yield('title', 'Azmeer Bakery — Crafted with Love, Delivered Fresh')</title>
  <meta name="description" content="@yield('meta_description', 'Azmeer Bakery – South Asian fusion delights. Order cakes, sweets, pizza, snacks and more. Same-day delivery in Lahore.')" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,400&family=DM+Sans:wght@400;600;700;800&family=Inter:wght@800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}" />

  @stack('styles')
</head>
<body>

  @include('frontend.partials.header')

  <div class="header-spacer"></div>

  <main>
    @yield('content')
  </main>

  @include('frontend.partials.footer')

  @include('frontend.partials.whatsapp-fab')

  <script src="{{ asset('assets/frontend/js/script.js') }}"></script>
  @stack('scripts')

</body>
</html>
