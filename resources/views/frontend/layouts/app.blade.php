<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>@yield('title', config('app.name').' — Crafted with Love, Delivered Fresh')</title>
  <meta name="description" content="@yield('meta_description', 'South Asian fusion delights — cakes, sweets, pizza, snacks and more. Same-day delivery in Lahore.')" />

  {{-- Fonts --}}
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,400&family=DM+Sans:wght@400;600;700;800&family=Inter:wght@800&display=swap" rel="stylesheet" />

  {{-- Styles --}}
  <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}" />
  @stack('styles')
</head>
<body>

  @include('frontend.partials.header')

  <main id="main-content">
    @yield('content')
  </main>

  @include('frontend.partials.footer')

  @include('frontend.partials.whatsapp-fab')

  {{-- Scripts --}}
  <script src="{{ asset('assets/frontend/js/script.js') }}"></script>
  @stack('scripts')

</body>
</html>
