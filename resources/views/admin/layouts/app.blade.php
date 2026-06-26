<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>@yield('title', 'Admin') — Azmeer Bakery</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/admin/css/admin.css') }}" />
  @stack('styles')
</head>
<body class="admin-body">

  <!-- Sidebar -->
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-sidebar__brand">
      <a href="{{ route('admin.dashboard') }}" class="admin-sidebar__logo">AZMEER BAKERY</a>
      <span class="admin-sidebar__subtitle">Admin Panel</span>
    </div>

    <nav class="admin-nav" aria-label="Admin navigation">
      <a href="{{ route('admin.dashboard') }}"
         class="admin-nav__link {{ request()->routeIs('admin.dashboard') ? 'admin-nav__link--active' : '' }}">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18">
          <rect x="2" y="2" width="7" height="7" rx="1"/><rect x="11" y="2" width="7" height="7" rx="1"/>
          <rect x="2" y="11" width="7" height="7" rx="1"/><rect x="11" y="11" width="7" height="7" rx="1"/>
        </svg>
        Dashboard
      </a>
      <a href="{{ route('admin.products.index') }}"
         class="admin-nav__link {{ request()->routeIs('admin.products.*') ? 'admin-nav__link--active' : '' }}">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18">
          <circle cx="10" cy="10" r="8"/><path d="M10 6v4l3 3"/>
        </svg>
        Products
      </a>
      <a href="{{ route('admin.categories.index') }}"
         class="admin-nav__link {{ request()->routeIs('admin.categories.*') ? 'admin-nav__link--active' : '' }}">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18">
          <rect x="2" y="2" width="16" height="5" rx="1"/><rect x="2" y="9" width="7" height="9" rx="1"/>
          <rect x="11" y="9" width="7" height="9" rx="1"/>
        </svg>
        Categories
      </a>
      <a href="{{ route('admin.reservations.index') }}"
         class="admin-nav__link {{ request()->routeIs('admin.reservations.*') ? 'admin-nav__link--active' : '' }}">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18">
          <rect x="2" y="3" width="16" height="14" rx="1"/><path d="M2 8h16M6 2v2M14 2v2"/>
        </svg>
        Reservations
      </a>
      <a href="{{ route('admin.contacts.index') }}"
         class="admin-nav__link {{ request()->routeIs('admin.contacts.*') ? 'admin-nav__link--active' : '' }}">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18">
          <path d="M4 4h12c.55 0 1 .45 1 1v8c0 .55-.45 1-1 1H4c-.55 0-1-.45-1-1V5c0-.55.45-1 1-1z"/><polyline points="3,4 10,11 17,4"/>
        </svg>
        Messages
      </a>
    </nav>

    <div class="admin-sidebar__footer">
      <a href="{{ route('home') }}" class="admin-nav__link" target="_blank">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18">
          <path d="M3 10h10M9 6l4 4-4 4"/><path d="M3 6v8"/>
        </svg>
        View Site
      </a>
      <form method="POST" action="{{ route('logout') }}" style="margin:0">
        @csrf
        <button type="submit" class="admin-nav__link admin-nav__link--btn">
          <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18">
            <path d="M9 3H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h4M13 15l4-4-4-4M17 11H7"/>
          </svg>
          Logout
        </button>
      </form>
    </div>
  </aside>

  <!-- Main Content -->
  <div class="admin-main">
    <header class="admin-topbar">
      <button class="admin-topbar__toggle" id="sidebarToggle" aria-label="Toggle sidebar">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" width="20" height="20">
          <line x1="2" y1="5"  x2="18" y2="5"/><line x1="2" y1="10" x2="18" y2="10"/><line x1="2" y1="15" x2="18" y2="15"/>
        </svg>
      </button>
      <div class="admin-topbar__breadcrumb">@yield('breadcrumb', 'Dashboard')</div>
      <div class="admin-topbar__user">
        <span class="admin-topbar__username">{{ auth()->user()->name }}</span>
      </div>
    </header>

    <div class="admin-content">
      @if(session('success'))
        <div class="alert alert--success" role="alert">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert--error" role="alert">{{ session('error') }}</div>
      @endif

      @yield('content')
    </div>
  </div>

  <script src="{{ asset('assets/admin/js/admin.js') }}"></script>
  @stack('scripts')

</body>
</html>
