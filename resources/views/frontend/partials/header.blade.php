{{-- ================================================================
     SITE HEADER
     ================================================================ --}}
<header class="site-header" role="banner">
  <nav class="site-header__nav" aria-label="Primary navigation">

    {{-- Logo --}}
    <a href="{{ route('home') }}" class="site-header__logo" aria-label="{{ config('app.name') }} Home">
      AZMEER BAKERY
    </a>

    {{-- Desktop nav links --}}
    <ul class="site-header__links" role="list">
      <li><a href="{{ route('products.listing') }}"  class="site-header__link {{ request()->routeIs('products.*') ? 'site-header__link--active' : '' }}">Shop</a></li>
      <li><a href="{{ route('recipes.index') }}"     class="site-header__link {{ request()->routeIs('recipes.*') ? 'site-header__link--active' : '' }}">Recipes</a></li>
      <li><a href="{{ route('blog.index') }}"        class="site-header__link {{ request()->routeIs('blog.*') ? 'site-header__link--active' : '' }}">Blog</a></li>
      <li><a href="{{ route('pages.about') }}"       class="site-header__link {{ request()->routeIs('pages.about') ? 'site-header__link--active' : '' }}">Our Story</a></li>
      <li><a href="{{ route('contact') }}"           class="site-header__link {{ request()->routeIs('contact') ? 'site-header__link--active' : '' }}">Contact</a></li>
    </ul>

    {{-- Search --}}
    <div class="search-bar" role="search">
      <svg class="search-bar__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
      </svg>
      <input class="search-bar__input" type="search"
             placeholder="Search for cakes, sweets, pastries…"
             aria-label="Search products" />
    </div>

    {{-- Controls: account + cart --}}
    <div class="header-controls">
      <div class="header-icons">
        @auth
          <a href="{{ route('admin.dashboard') }}" class="header-icon-btn" aria-label="Admin panel">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="24" height="24">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
          </a>
        @else
          <a href="{{ route('login') }}" class="header-icon-btn" aria-label="Sign in">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="24" height="24">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
          </a>
        @endauth

        {{-- Cart button with badge overlay --}}
        <button class="cart-icon-btn" id="cartToggleBtn"
                aria-label="Open cart" aria-expanded="false" aria-controls="cartDrawer">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="24" height="24" aria-hidden="true">
            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
            <line x1="3" y1="6" x2="21" y2="6"/>
            <path d="M16 10a4 4 0 0 1-8 0"/>
          </svg>
          <span class="cart-badge" id="cartBadge" aria-live="polite">0</span>
        </button>
      </div>
    </div>

    {{-- Hamburger --}}
    <button class="hamburger" id="hamburger"
            aria-label="Open menu" aria-expanded="false" aria-controls="mobile-nav">
      <span></span><span></span><span></span>
    </button>

  </nav>

  {{-- Delivery strip --}}
  <div class="delivery-strip" role="marquee" aria-live="off">
    Free delivery on orders above Rs.&nbsp;999 &mdash; Same-day delivery available &mdash;
    Order before 3:00&nbsp;PM
  </div>
</header>

{{-- ================================================================
     CART DRAWER (slide-in from right)
     ================================================================ --}}
<div class="cart-drawer" id="cartDrawer" role="dialog" aria-modal="true" aria-label="Shopping cart" hidden>
  <div class="cart-drawer__header">
    <h2 class="cart-drawer__title">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="20" height="20" aria-hidden="true">
        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
        <line x1="3" y1="6" x2="21" y2="6"/>
        <path d="M16 10a4 4 0 0 1-8 0"/>
      </svg>
      Your Cart
      <span class="cart-drawer__count" id="cartDrawerCount">0 items</span>
    </h2>
    <button class="cart-drawer__close" id="cartCloseBtn" aria-label="Close cart">&times;</button>
  </div>

  <div class="cart-drawer__body" id="cartDrawerBody">
    {{-- Rendered by JS --}}
  </div>

  <div class="cart-drawer__footer" id="cartDrawerFooter" hidden>
    <div class="cart-drawer__subtotal">
      <span>Subtotal</span>
      <span class="cart-drawer__subtotal-amount" id="cartSubtotal">Rs. 0</span>
    </div>
    <p class="cart-drawer__delivery-note">
      Free delivery on orders above Rs. 999
    </p>
    <a href="{{ route('checkout') }}" class="btn btn--primary btn--full">
      Proceed to Checkout
    </a>
    <button class="btn btn--outline btn--full cart-drawer__clear" id="cartClearBtn">
      Clear Cart
    </button>
  </div>
</div>

{{-- Cart overlay (backdrop) --}}
<div class="cart-overlay" id="cartOverlay" hidden></div>

{{-- ================================================================
     MOBILE NAV DRAWER
     ================================================================ --}}
<nav class="mobile-nav" id="mobile-nav" aria-label="Mobile navigation" hidden>
  <div class="search-bar mobile-nav__search" role="search">
    <svg class="search-bar__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
      <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
    </svg>
    <input class="search-bar__input" type="search" placeholder="Search…" aria-label="Search products" />
  </div>

  <div class="mobile-nav__links">
    <a href="{{ route('home') }}"                           class="mobile-nav__link">Home</a>
    <a href="{{ route('products.listing') }}"               class="mobile-nav__link">Shop All</a>
    <a href="{{ route('products.category', 'sweets') }}"    class="mobile-nav__link">Sweets</a>
    <a href="{{ route('products.category', 'pizza') }}"     class="mobile-nav__link">Pizza</a>
    <a href="{{ route('products.category', 'deals') }}"     class="mobile-nav__link">Deals</a>
    <a href="{{ route('recipes.index') }}"                  class="mobile-nav__link">Recipes</a>
    <a href="{{ route('blog.index') }}"                     class="mobile-nav__link">Blog</a>
    <a href="{{ route('pages.about') }}"                    class="mobile-nav__link">Our Story</a>
    <a href="{{ route('contact') }}"                        class="mobile-nav__link">Contact</a>
  </div>
</nav>
