{{-- ================================================================
     ADMIN SIDEBAR  —  brand, primary nav, utility links
     ================================================================ --}}
<aside class="admin-sidebar" id="adminSidebar" aria-label="Admin sidebar">

  {{-- Brand --}}
  <div class="admin-sidebar__brand">
    <a href="{{ route('admin.dashboard') }}" class="admin-sidebar__logo">
      AZMEER BAKERY
    </a>
    <span class="admin-sidebar__subtitle">Admin Panel</span>
  </div>

  {{-- Primary navigation --}}
  <nav class="admin-nav" aria-label="Admin navigation">

    <a href="{{ route('admin.dashboard') }}"
       class="admin-nav__link {{ request()->routeIs('admin.dashboard') ? 'admin-nav__link--active' : '' }}">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18" aria-hidden="true">
        <rect x="2"  y="2"  width="7" height="7" rx="1"/>
        <rect x="11" y="2"  width="7" height="7" rx="1"/>
        <rect x="2"  y="11" width="7" height="7" rx="1"/>
        <rect x="11" y="11" width="7" height="7" rx="1"/>
      </svg>
      Dashboard
    </a>

    <a href="{{ route('admin.products.index') }}"
       class="admin-nav__link {{ request()->routeIs('admin.products.*') ? 'admin-nav__link--active' : '' }}">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18" aria-hidden="true">
        <path d="M3 5h14M3 10h14M3 15h14"/>
      </svg>
      Products
    </a>

    <a href="{{ route('admin.categories.index') }}"
       class="admin-nav__link {{ request()->routeIs('admin.categories.*') ? 'admin-nav__link--active' : '' }}">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18" aria-hidden="true">
        <rect x="2" y="2" width="16" height="5" rx="1"/>
        <rect x="2" y="9" width="7" height="9" rx="1"/>
        <rect x="11" y="9" width="7" height="9" rx="1"/>
      </svg>
      Categories
    </a>

    <a href="{{ route('admin.reservations.index') }}"
       class="admin-nav__link {{ request()->routeIs('admin.reservations.*') ? 'admin-nav__link--active' : '' }}">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18" aria-hidden="true">
        <rect x="2" y="3" width="16" height="14" rx="1"/>
        <path d="M2 8h16M6 2v2M14 2v2"/>
      </svg>
      Reservations
    </a>

    <a href="{{ route('admin.contacts.index') }}"
       class="admin-nav__link {{ request()->routeIs('admin.contacts.*') ? 'admin-nav__link--active' : '' }}">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18" aria-hidden="true">
        <path d="M4 4h12c.55 0 1 .45 1 1v8c0 .55-.45 1-1 1H4c-.55 0-1-.45-1-1V5c0-.55.45-1 1-1z"/>
        <polyline points="3,4 10,11 17,4"/>
      </svg>
      Messages
      @php($unread = \App\Models\ContactMessage::where('is_read', false)->count())
      @if($unread)
        <span class="admin-nav__badge">{{ $unread }}</span>
      @endif
    </a>

  </nav>

  {{-- Utility links: view site + logout --}}
  <div class="admin-sidebar__footer">

    <a href="{{ route('home') }}" class="admin-nav__link" target="_blank" rel="noopener" aria-label="View live site">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18" aria-hidden="true">
        <path d="M11 3h6v6"/><path d="M17 3l-8 8"/><path d="M9 5H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-5"/>
      </svg>
      View Site
    </a>

    <form method="POST" action="{{ route('logout') }}" style="margin:0">
      @csrf
      <button type="submit" class="admin-nav__link admin-nav__link--btn" aria-label="Log out">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18" aria-hidden="true">
          <path d="M9 3H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h4M13 15l4-4-4-4M17 11H7"/>
        </svg>
        Logout
      </button>
    </form>

  </div>

</aside>
