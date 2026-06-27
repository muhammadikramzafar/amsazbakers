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

    <a href="{{ route('admin.menu.items.index') }}"
       class="admin-nav__link {{ request()->routeIs('admin.menu.*') ? 'admin-nav__link--active' : '' }}">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18" aria-hidden="true">
        <path d="M3 6h14M3 10h10M3 14h7"/>
        <circle cx="16" cy="14" r="2.5"/>
        <path d="M16 7v4.5"/>
      </svg>
      Menu
    </a>

    <a href="{{ route('admin.recipes.index') }}"
       class="admin-nav__link {{ request()->routeIs('admin.recipes.*') || request()->routeIs('admin.recipe-categories.*') ? 'admin-nav__link--active' : '' }}">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18" aria-hidden="true">
        <path d="M4 3h12a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/>
        <path d="M7 7h6M7 10h6M7 13h4"/>
        <path d="M14 1v4"/>
      </svg>
      Recipes
    </a>

    <a href="{{ route('admin.blog.posts.index') }}"
       class="admin-nav__link {{ request()->routeIs('admin.blog.*') ? 'admin-nav__link--active' : '' }}">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18"><path d="M4 4h12c.5 0 1 .45 1 1v12c0 .55-.5 1-1 1H4c-.55 0-1-.45-1-1V5c0-.55.45-1 1-1z"/><path d="M7 8h6M7 11h6M7 14h3"/><path d="M14 1v4"/></svg>
      Blog
    </a>

    <a href="{{ route('admin.gallery.albums.index') }}"
       class="admin-nav__link {{ request()->routeIs('admin.gallery.*') ? 'admin-nav__link--active' : '' }}">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18"><rect x="2" y="4" width="16" height="12" rx="1"/><circle cx="7" cy="9" r="1.5"/><path d="M2 14l4-4 3 3 3-3 6 4"/></svg>
      Gallery
    </a>

    <a href="{{ route('admin.awards.index') }}"
       class="admin-nav__link {{ request()->routeIs('admin.awards.*') ? 'admin-nav__link--active' : '' }}">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18"><circle cx="10" cy="8" r="5"/><path d="M7 13l-3 5h12l-3-5"/></svg>
      Awards
    </a>

    <a href="{{ route('admin.careers.listings.index') }}"
       class="admin-nav__link {{ request()->routeIs('admin.careers.*') ? 'admin-nav__link--active' : '' }}">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18"><rect x="3" y="7" width="14" height="10" rx="1"/><path d="M7 7V5a3 3 0 0 1 6 0v2"/><path d="M7 12h6"/></svg>
      Careers
    </a>

    <a href="{{ route('admin.newsletter.index') }}"
       class="admin-nav__link {{ request()->routeIs('admin.newsletter.*') ? 'admin-nav__link--active' : '' }}">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18"><path d="M4 4h12c.55 0 1 .45 1 1v8c0 .55-.45 1-1 1H4c-.55 0-1-.45-1-1V5c0-.55.45-1 1-1z"/><polyline points="3,4 10,11 17,4"/></svg>
      Newsletter
    </a>

    {{-- ── CMS section ─── --}}
    <p class="admin-nav__section">Content</p>

    <a href="{{ route('admin.homepage.index') }}"
       class="admin-nav__link {{ request()->routeIs('admin.homepage*') ? 'admin-nav__link--active' : '' }}">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18" aria-hidden="true">
        <path d="M3 9.5L10 3l7 6.5V17a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5z"/>
        <path d="M7 18V11h6v7"/>
      </svg>
      Homepage
    </a>

    <a href="{{ route('admin.pages.index') }}"
       class="admin-nav__link {{ request()->routeIs('admin.pages.*') ? 'admin-nav__link--active' : '' }}">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18" aria-hidden="true">
        <rect x="3" y="2" width="14" height="16" rx="1"/>
        <path d="M7 7h6M7 10h6M7 13h4"/>
      </svg>
      Pages
    </a>

    <a href="{{ route('admin.media.index') }}"
       class="admin-nav__link {{ request()->routeIs('admin.media.*') ? 'admin-nav__link--active' : '' }}">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18" aria-hidden="true">
        <rect x="2" y="4" width="16" height="12" rx="1"/>
        <circle cx="7" cy="9" r="1.5"/>
        <path d="M2 14l4-4 3 3 3-3 6 4"/>
      </svg>
      Media Library
    </a>

    {{-- ── Admin section ─── --}}
    <p class="admin-nav__section">Admin</p>

    @if(auth()->user()->hasRole('super-admin'))
    <a href="{{ route('admin.users.index') }}"
       class="admin-nav__link {{ request()->routeIs('admin.users.*') ? 'admin-nav__link--active' : '' }}">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18" aria-hidden="true">
        <path d="M14 12c2 .5 4 2 4 4v1H2v-1c0-2 2-3.5 4-4"/>
        <circle cx="10" cy="7" r="3.5"/>
        <path d="M16 6c1.5.5 2.5 1.5 2.5 3"/>
      </svg>
      Users
    </a>

    <a href="{{ route('admin.settings.index') }}"
       class="admin-nav__link {{ request()->routeIs('admin.settings.*') ? 'admin-nav__link--active' : '' }}">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18" aria-hidden="true">
        <path d="M10 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
        <path d="M17.66 10.42c.04-.28.04-.56 0-.84l1.8-1.4a.43.43 0 0 0 .1-.55l-1.7-2.94a.43.43 0 0 0-.53-.19l-2.12.85a6.26 6.26 0 0 0-.73-.42l-.32-2.26a.42.42 0 0 0-.42-.37h-3.4a.42.42 0 0 0-.42.37l-.32 2.26c-.26.12-.51.26-.74.42L6.77 5.5a.43.43 0 0 0-.53.19L4.54 8.63a.42.42 0 0 0 .1.55l1.8 1.4c-.04.28-.04.56 0 .84l-1.8 1.4a.43.43 0 0 0-.1.55l1.7 2.94a.43.43 0 0 0 .53.19l2.12-.85c.23.16.47.3.73.42l.32 2.26c.05.21.24.37.42.37h3.4c.19 0 .37-.16.42-.37l.32-2.26c.26-.12.51-.26.74-.42l2.12.85a.43.43 0 0 0 .53-.19l1.7-2.94a.42.42 0 0 0-.1-.55l-1.8-1.4z"/>
      </svg>
      Settings
    </a>
    @endif

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
