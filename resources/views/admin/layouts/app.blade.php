<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>

  {{-- Fonts --}}
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

  {{-- Admin styles --}}
  <link rel="stylesheet" href="{{ asset('assets/admin/css/admin.css') }}" />
  @stack('styles')
</head>
<body class="admin-body">

  {{-- Sidebar --}}
  @include('admin.partials.sidebar')

  {{-- Main wrapper --}}
  <div class="admin-main">

    {{-- Topbar + flash alerts --}}
    @include('admin.partials.header')

    {{-- Page content --}}
    <div class="admin-content">
      @yield('content')
    </div>

    {{-- Footer --}}
    @include('admin.partials.footer')

  </div>{{-- /.admin-main --}}

  {{-- Scripts --}}
  <script src="{{ asset('assets/admin/js/admin.js') }}"></script>
  @stack('scripts')

</body>
</html>
