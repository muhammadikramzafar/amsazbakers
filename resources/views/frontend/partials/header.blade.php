<!-- ===== HEADER ===== -->
<header class="site-header">
  <nav class="site-header__nav">
    <a href="{{ route('home') }}" class="site-header__logo">AZMEER BAKERY</a>

    <div class="search-bar" role="search">
      <svg class="search-bar__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
      </svg>
      <input class="search-bar__input" type="search" placeholder="Search for cakes, sweets, pastries..." aria-label="Search products" />
    </div>

    <div class="header-controls">
      <div class="lang-switcher" aria-label="Language selector">
        <span class="lang-switcher__active">EN</span>
        <div class="lang-switcher__divider" aria-hidden="true"></div>
        <span class="lang-switcher__inactive">URDU</span>
      </div>
      <div class="header-icons">
        @auth
          <a href="{{ route('admin.dashboard') }}" class="header-icon-btn" aria-label="Admin">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="24" height="24">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
          </a>
        @else
          <a href="{{ route('login') }}" class="header-icon-btn" aria-label="Account">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="24" height="24">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
          </a>
        @endauth
        <div class="cart-wrapper">
          <button class="header-icon-btn" aria-label="Shopping bag">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="24" height="24">
              <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>
            </svg>
          </button>
          <span class="cart-badge" aria-label="0 items in cart">0</span>
        </div>
      </div>
    </div>

    <button class="hamburger" id="hamburger" aria-label="Toggle menu" aria-expanded="false" aria-controls="mobile-nav">
      <span></span><span></span><span></span>
    </button>
  </nav>

  <div class="delivery-strip" role="marquee" aria-live="off">
    Free delivery on orders above Rs. 999 &mdash; Same-day delivery available
  </div>
</header>

<!-- Mobile nav -->
<nav class="mobile-nav" id="mobile-nav" aria-label="Mobile navigation">
  <div class="search-bar mobile-nav__search" role="search">
    <svg class="search-bar__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
      <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
    </svg>
    <input class="search-bar__input" type="search" placeholder="Search..." aria-label="Search products" />
  </div>
  <div class="mobile-nav__links">
    <a href="{{ route('home') }}" class="mobile-nav__link">Home</a>
    <a href="{{ route('products.listing') }}" class="mobile-nav__link">Shop All</a>
    <a href="{{ route('products.category', 'sweets') }}" class="mobile-nav__link">Sweets</a>
    <a href="{{ route('products.category', 'deals') }}" class="mobile-nav__link">Deals</a>
  </div>
</nav>
