<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bakers & Sweets — Restaurant, Bakery & Sweets')</title>
    <meta name="description" content="@yield('meta_description', 'Bakers & Sweets — Authentic flavors, fresh bakes & homemade sweets in Pakistan.')">

    {{-- Place your existing CSS links here --}}
    @stack('styles')
</head>
<body>

    {{-- Navbar / Header --}}
    @include('frontend.partials.navbar')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('frontend.partials.footer')

    {{-- Place your existing JS links here --}}
    @stack('scripts')

</body>
</html>
