{{-- ================================================================
     ADMIN FOOTER  —  copyright bar at the bottom of main content
     Scripts are loaded in admin/layouts/app.blade.php after @yield('content')
     ================================================================ --}}
<footer class="admin-footer" role="contentinfo">
  <p class="admin-footer__copy">
    &copy; {{ date('Y') }} <strong>Azmeer Bakery</strong>. All rights reserved.
  </p>
  <p class="admin-footer__version">
    Laravel {{ app()->version() }}
  </p>
</footer>
