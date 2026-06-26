{{-- ================================================================
     ADMIN TOPBAR  —  sidebar toggle, breadcrumb, user info
     Plus flash alert banners rendered directly below the bar
     ================================================================ --}}
<header class="admin-topbar" role="banner">

  {{-- Sidebar toggle (mobile) --}}
  <button class="admin-topbar__toggle" id="sidebarToggle" aria-label="Toggle sidebar" aria-expanded="false" aria-controls="adminSidebar">
    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" width="20" height="20" aria-hidden="true">
      <line x1="2" y1="5"  x2="18" y2="5"/>
      <line x1="2" y1="10" x2="18" y2="10"/>
      <line x1="2" y1="15" x2="18" y2="15"/>
    </svg>
  </button>

  {{-- Page breadcrumb (child views set this via @section('breadcrumb')) --}}
  <div class="admin-topbar__breadcrumb" aria-label="Breadcrumb">
    <span class="admin-topbar__breadcrumb-home">
      <a href="{{ route('admin.dashboard') }}">Admin</a>
    </span>
    @hasSection('breadcrumb')
      <span class="admin-topbar__breadcrumb-sep" aria-hidden="true">/</span>
      <span>@yield('breadcrumb')</span>
    @endif
  </div>

  {{-- Authenticated user --}}
  <div class="admin-topbar__user">
    <span class="admin-topbar__avatar" aria-hidden="true">
      {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
    </span>
    <span class="admin-topbar__username">{{ auth()->user()->name }}</span>
  </div>

</header>

{{-- Flash messages --}}
@if(session('success'))
  <div class="alert alert--success" role="alert" aria-live="polite">
    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="16" height="16" aria-hidden="true">
      <path d="M13.5 4.5 6.5 11.5 2.5 7.5"/>
    </svg>
    {{ session('success') }}
  </div>
@endif

@if(session('error'))
  <div class="alert alert--error" role="alert" aria-live="assertive">
    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="16" height="16" aria-hidden="true">
      <circle cx="8" cy="8" r="6.5"/><path d="M8 5v3.5M8 10.5v.5"/>
    </svg>
    {{ session('error') }}
  </div>
@endif
