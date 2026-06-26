{{-- ================================================================
     SITE FOOTER  —  3-column grid + copyright bar
     ================================================================ --}}
<footer class="site-footer" role="contentinfo">
  <div class="site-footer__grid">

    {{-- Col 1: Brand + social links --}}
    <div class="footer-col">
      <p class="site-footer__brand-name">AZMEER BAKERY</p>
      <p class="site-footer__tagline">
        Crafting the finest South Asian fusion delights. Every bite is a story of
        heritage and love, delivered fresh to your doorstep.
      </p>
      <div class="footer-socials">
        <a href="#" class="footer-socials__btn" aria-label="Instagram" rel="noopener noreferrer" target="_blank">
          <svg viewBox="0 0 20 20" fill="none" stroke="white" stroke-width="1.8" width="20" height="20">
            <rect x="2" y="2" width="16" height="16" rx="5" ry="5"/>
            <circle cx="10" cy="10" r="3.5"/>
            <circle cx="14.5" cy="5.5" r="1" fill="white" stroke="none"/>
          </svg>
        </a>
        <a href="#" class="footer-socials__btn" aria-label="Facebook" rel="noopener noreferrer" target="_blank">
          <svg viewBox="0 0 20 20" fill="white" width="20" height="20">
            <path d="M15 2h-2.5A4.5 4.5 0 0 0 8 6.5V9H5v3h3v6h3v-6h3l.5-3H11V6.5A1.5 1.5 0 0 1 12.5 5H15z"/>
          </svg>
        </a>
        <a href="#" class="footer-socials__btn" aria-label="Twitter / X" rel="noopener noreferrer" target="_blank">
          <svg viewBox="0 0 20 20" fill="white" width="20" height="20">
            <path d="M17.3 4.2 12 9.6 17.6 16h-3.4l-4-5.4-4.6 5.4H2.4l5.6-6.6L2.4 4.2h3.4l3.7 5 4.4-5h3.4z"/>
          </svg>
        </a>
      </div>
    </div>

    {{-- Col 2: Quick links --}}
    <div class="footer-col">
      <h3 class="footer-col__heading">Quick Links</h3>
      <ul class="footer-links">
        <li><a href="{{ route('pages.about') }}"                         class="footer-links__item">Our Story</a></li>
        <li><a href="{{ route('products.listing') }}"                    class="footer-links__item">Shop All</a></li>
        <li><a href="{{ route('products.category', 'sweets') }}"         class="footer-links__item">Sweets</a></li>
        <li><a href="{{ route('products.category', 'deals') }}"          class="footer-links__item">Deals</a></li>
        <li><a href="{{ route('reservation') }}"                         class="footer-links__item">Reservations</a></li>
        <li><a href="{{ route('contact') }}"                             class="footer-links__item">Contact Us</a></li>
      </ul>
    </div>

    {{-- Col 3: Contact info --}}
    <div class="footer-col">
      <h3 class="footer-col__heading">Contact Info</h3>
      <div class="footer-contact-list">

        <div class="footer-contact-row">
          <svg viewBox="0 0 16 16" fill="none" stroke="#fff6e5" stroke-width="1.5" width="16" height="16" aria-hidden="true">
            <path d="M8 1.3a5 5 0 0 0-5 5c0 3.75 5 9.4 5 9.4s5-5.65 5-9.4a5 5 0 0 0-5-5z"/>
            <circle cx="8" cy="6.3" r="2"/>
          </svg>
          <span>45 Main Blvd, Gulberg III, Lahore</span>
        </div>

        <div class="footer-contact-row">
          <svg viewBox="0 0 16 16" fill="none" stroke="#fff6e5" stroke-width="1.5" width="16" height="16" aria-hidden="true">
            <path d="M13.3 10.7l-2-1.7a1 1 0 0 0-1.3.1l-.8.8a8.5 8.5 0 0 1-3.1-3.1l.8-.8a1 1 0 0 0 .1-1.3L5.3 2.7A1 1 0 0 0 4 2.5L2.8 3.7A2 2 0 0 0 2.4 6C3.6 9.8 6.2 12.4 10 13.6a2 2 0 0 0 2.3-.4l1.2-1.2a1 1 0 0 0-.2-1.3z"/>
          </svg>
          <a href="tel:+924235718899" class="footer-contact-row__link">+92 42 3571 8899</a>
        </div>

        <div class="footer-contact-row">
          <svg viewBox="0 0 16 16" fill="none" stroke="#fff6e5" stroke-width="1.5" width="16" height="16" aria-hidden="true">
            <path d="M12.5 3h-9A1.5 1.5 0 0 0 2 4.5v7A1.5 1.5 0 0 0 3.5 13h9a1.5 1.5 0 0 0 1.5-1.5v-7A1.5 1.5 0 0 0 12.5 3z"/>
            <polyline points="2,4.5 8,9 14,4.5"/>
          </svg>
          <a href="mailto:hello@azmeerbakery.pk" class="footer-contact-row__link">hello@azmeerbakery.pk</a>
        </div>

        <div class="footer-contact-row">
          <svg viewBox="0 0 16 16" fill="none" stroke="#fff6e5" stroke-width="1.5" width="16" height="16" aria-hidden="true">
            <circle cx="8" cy="8" r="6.5"/>
            <polyline points="8,4.5 8,8 10.5,10"/>
          </svg>
          <span>Mon–Sat 9 AM–10 PM &nbsp;|&nbsp; Sun 10 AM–8 PM</span>
        </div>

      </div>
    </div>

  </div>

  <div class="footer-divider" aria-hidden="true"></div>

  <p class="footer-copy">
    &copy; {{ date('Y') }} Azmeer Bakery. All rights reserved.
  </p>
</footer>
