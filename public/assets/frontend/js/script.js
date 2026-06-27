/**
 * AZMEER BAKERY — script.js
 * Global JavaScript for all pages
 * Vanilla JS only — no frameworks
 */

'use strict';

/* ============================================================
   UTILITY HELPERS
   ============================================================ */

/**
 * Debounce function
 */
function debounce(fn, delay) {
  let timer;
  return function (...args) {
    clearTimeout(timer);
    timer = setTimeout(() => fn.apply(this, args), delay);
  };
}

/**
 * Format price as PKR
 */
function formatPrice(num) {
  return 'Rs. ' + num.toLocaleString('en-PK');
}

/**
 * Show a toast notification
 */
function showToast(message, type = 'success') {
  // Remove any existing toast
  const existing = document.getElementById('ab-toast');
  if (existing) existing.remove();

  const toast = document.createElement('div');
  toast.id = 'ab-toast';
  toast.setAttribute('role', 'status');
  toast.setAttribute('aria-live', 'polite');
  toast.textContent = message;

  Object.assign(toast.style, {
    position: 'fixed',
    bottom: '110px',
    right: '40px',
    background: type === 'success' ? '#5a3e2b' : '#c8a24a',
    color: '#fff6e5',
    padding: '14px 24px',
    borderRadius: '8px',
    fontSize: '14px',
    fontWeight: '600',
    fontFamily: "'DM Sans', sans-serif",
    zIndex: '9999',
    boxShadow: '0 8px 24px rgba(0,0,0,0.15)',
    transform: 'translateY(20px)',
    opacity: '0',
    transition: 'transform 0.3s ease, opacity 0.3s ease',
  });

  document.body.appendChild(toast);

  // Animate in
  requestAnimationFrame(() => {
    requestAnimationFrame(() => {
      toast.style.transform = 'translateY(0)';
      toast.style.opacity = '1';
    });
  });

  // Animate out after 3s
  setTimeout(() => {
    toast.style.transform = 'translateY(20px)';
    toast.style.opacity = '0';
    setTimeout(() => toast.remove(), 300);
  }, 3000);
}

/* ============================================================
   CART — localStorage persistence + slide-in drawer
   ============================================================ */

const cart = {
  _key: 'ab_cart',

  _load() {
    try { return JSON.parse(localStorage.getItem(this._key) || '[]'); } catch { return []; }
  },

  _save(items) {
    try { localStorage.setItem(this._key, JSON.stringify(items)); } catch {}
  },

  get items() { return this._load(); },

  get count() {
    return this._load().reduce((sum, i) => sum + i.qty, 0);
  },

  get subtotal() {
    return this._load().reduce((sum, i) => sum + (i.price * i.qty), 0);
  },

  add(name, price, qty = 1) {
    const items = this._load();
    const existing = items.find(i => i.name === name);
    if (existing) {
      existing.qty += qty;
    } else {
      items.push({ name, price: price || 0, qty });
    }
    this._save(items);
    this._bumpBadge();
    this.updateUI();
    this.renderDrawer();
  },

  remove(name) {
    const items = this._load().filter(i => i.name !== name);
    this._save(items);
    this.updateUI();
    this.renderDrawer();
  },

  setQty(name, qty) {
    if (qty < 1) { this.remove(name); return; }
    const items = this._load();
    const item = items.find(i => i.name === name);
    if (item) { item.qty = qty; this._save(items); }
    this.updateUI();
    this.renderDrawer();
  },

  clear() {
    this._save([]);
    this.updateUI();
    this.renderDrawer();
  },

  _bumpBadge() {
    const badge = document.getElementById('cartBadge');
    if (!badge) return;
    badge.classList.remove('bump');
    void badge.offsetWidth;
    badge.classList.add('bump');
    setTimeout(() => badge.classList.remove('bump'), 400);
  },

  updateUI() {
    const count = this.count;
    const badge = document.getElementById('cartBadge');
    if (badge) {
      badge.textContent = count;
      badge.style.display = count === 0 ? 'none' : '';
    }
    const toggleBtn = document.getElementById('cartToggleBtn');
    if (toggleBtn) {
      toggleBtn.setAttribute('aria-label', `Open cart (${count} item${count !== 1 ? 's' : ''})`);
    }
    const countEl = document.getElementById('cartDrawerCount');
    if (countEl) countEl.textContent = `${count} item${count !== 1 ? 's' : ''}`;
  },

  renderDrawer() {
    const body   = document.getElementById('cartDrawerBody');
    const footer = document.getElementById('cartDrawerFooter');
    const subtotalEl = document.getElementById('cartSubtotal');
    if (!body) return;

    const items = this._load();

    if (items.length === 0) {
      body.innerHTML = `
        <div class="cart-empty">
          <div class="cart-empty__icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="32" height="32">
              <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
              <line x1="3" y1="6" x2="21" y2="6"/>
              <path d="M16 10a4 4 0 0 1-8 0"/>
            </svg>
          </div>
          <p class="cart-empty__title">Your cart is empty</p>
          <p class="cart-empty__sub">Add some delicious items to get started.</p>
          <a href="/products" class="btn btn--primary" style="margin-top:8px;padding:12px 28px;">
            Browse Products
          </a>
        </div>`;
      if (footer) footer.hidden = true;
      return;
    }

    body.innerHTML = items.map(item => `
      <div class="cart-item" data-name="${escHtml(item.name)}">
        <div class="cart-item__img">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" width="28" height="28">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
          </svg>
        </div>
        <div class="cart-item__info">
          <p class="cart-item__name">${escHtml(item.name)}</p>
          <p class="cart-item__price">${item.price > 0 ? formatPrice(item.price) : '—'}</p>
          <div class="cart-item__qty">
            <button class="cart-item__qty-btn" data-action="dec" data-name="${escHtml(item.name)}" aria-label="Decrease quantity">−</button>
            <span class="cart-item__qty-val">${item.qty}</span>
            <button class="cart-item__qty-btn" data-action="inc" data-name="${escHtml(item.name)}" aria-label="Increase quantity">+</button>
          </div>
        </div>
        <button class="cart-item__remove" data-name="${escHtml(item.name)}" aria-label="Remove ${escHtml(item.name)} from cart">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
          </svg>
        </button>
      </div>
    `).join('');

    if (footer) footer.hidden = false;
    if (subtotalEl) {
      const sub = this.subtotal;
      subtotalEl.textContent = sub > 0 ? formatPrice(sub) : '—';
    }

    // Bind qty / remove handlers
    body.querySelectorAll('.cart-item__qty-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const name = btn.dataset.name;
        const current = this._load().find(i => i.name === name);
        if (!current) return;
        if (btn.dataset.action === 'inc') this.setQty(name, current.qty + 1);
        else this.setQty(name, current.qty - 1);
      });
    });
    body.querySelectorAll('.cart-item__remove').forEach(btn => {
      btn.addEventListener('click', () => this.remove(btn.dataset.name));
    });
  },

  open() {
    const drawer  = document.getElementById('cartDrawer');
    const overlay = document.getElementById('cartOverlay');
    const btn     = document.getElementById('cartToggleBtn');
    if (!drawer) return;
    this.renderDrawer();
    drawer.hidden  = false;
    overlay.hidden = false;
    if (btn) btn.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
    // focus close btn
    setTimeout(() => document.getElementById('cartCloseBtn')?.focus(), 50);
  },

  close() {
    const drawer  = document.getElementById('cartDrawer');
    const overlay = document.getElementById('cartOverlay');
    const btn     = document.getElementById('cartToggleBtn');
    if (!drawer) return;
    drawer.hidden  = true;
    overlay.hidden = true;
    if (btn) { btn.setAttribute('aria-expanded', 'false'); btn.focus(); }
    document.body.style.overflow = '';
  }
};

function escHtml(str) {
  return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

/* ── Cart toggle / close / clear wiring ─────────── */
function initCartDrawer() {
  document.getElementById('cartToggleBtn')?.addEventListener('click', () => {
    const drawer = document.getElementById('cartDrawer');
    if (drawer && !drawer.hidden) cart.close(); else cart.open();
  });
  document.getElementById('cartCloseBtn')?.addEventListener('click', () => cart.close());
  document.getElementById('cartOverlay')?.addEventListener('click', () => cart.close());
  document.getElementById('cartClearBtn')?.addEventListener('click', () => {
    if (confirm('Remove all items from your cart?')) cart.clear();
  });
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      const drawer = document.getElementById('cartDrawer');
      if (drawer && !drawer.hidden) cart.close();
    }
  });
}

/* ============================================================
   MOBILE HAMBURGER MENU
   ============================================================ */

function initMobileMenu() {
  const hamburger = document.getElementById('hamburger');
  const mobileNav = document.getElementById('mobile-nav');
  if (!hamburger || !mobileNav) return;

  hamburger.addEventListener('click', () => {
    const isOpen = mobileNav.classList.toggle('is-open');
    hamburger.classList.toggle('is-active', isOpen);
    hamburger.setAttribute('aria-expanded', String(isOpen));
    document.body.style.overflow = isOpen ? 'hidden' : '';
  });

  // Close on outside click
  document.addEventListener('click', (e) => {
    if (!hamburger.contains(e.target) && !mobileNav.contains(e.target)) {
      mobileNav.classList.remove('is-open');
      hamburger.classList.remove('is-active');
      hamburger.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
    }
  });

  // Close on Escape
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      mobileNav.classList.remove('is-open');
      hamburger.classList.remove('is-active');
      hamburger.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
    }
  });
}

/* ============================================================
   STICKY HEADER SHADOW ON SCROLL
   ============================================================ */

function initStickyHeader() {
  const header = document.querySelector('.site-header');
  if (!header) return;

  const onScroll = debounce(() => {
    if (window.scrollY > 10) {
      header.style.boxShadow = '0 4px 20px rgba(90,62,43,0.08)';
    } else {
      header.style.boxShadow = 'none';
    }
  }, 50);

  window.addEventListener('scroll', onScroll, { passive: true });
}

/* ============================================================
   LAZY IMAGE LOADING
   ============================================================ */

function initLazyImages() {
  if (!('IntersectionObserver' in window)) return;

  const imgs = document.querySelectorAll('img[loading="lazy"]');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.classList.add('loaded');
        observer.unobserve(img);
      }
    });
  }, { rootMargin: '100px' });

  imgs.forEach(img => {
    img.classList.add('lazy');
    // If already loaded (cached)
    if (img.complete) {
      img.classList.add('loaded');
    } else {
      img.addEventListener('load', () => img.classList.add('loaded'));
      observer.observe(img);
    }
  });
}

/* ============================================================
   ADD TO CART BUTTONS (listing + home)
   ============================================================ */

function initAddToCartButtons() {
  document.querySelectorAll('button[data-product]').forEach(btn => {
    if (btn.dataset.cartBound) return;
    btn.dataset.cartBound = '1';

    btn.addEventListener('click', function (e) {
      e.stopPropagation(); // prevent triggering card link navigation

      // Prefer explicit data attributes; fall back to DOM scraping
      let name  = this.dataset.product || '';
      let price = parseInt(this.dataset.price, 10) || 0;

      if (!name) {
        const card = this.closest('article, .product-card, .fresh-card, .kitchen-card');
        if (card) {
          const nameEl = card.querySelector('h3, h2, .product-card__name, .kitchen-card__name');
          if (nameEl) name = nameEl.textContent.trim();
          if (!price) {
            const priceEl = card.querySelector('.product-card__price, .kitchen-card__price, .fresh-card__price, #productPrice');
            if (priceEl) price = parseInt(priceEl.textContent.replace(/[^0-9]/g, ''), 10) || 0;
          }
        }
      }
      name = name || 'Item';

      cart.add(name, price, 1);
      showToast(`"${name}" added to cart!`);

      const original = this.textContent;
      this.textContent = 'Added ✓';
      this.style.background = '#5a3e2b';
      this.style.color = '#fff6e5';
      setTimeout(() => {
        this.textContent = original;
        this.style.background = '';
        this.style.color = '';
      }, 1200);
    });
  });
}

/* ============================================================
   PRODUCT DETAIL — QUANTITY PICKER
   ============================================================ */

function initQuantityPicker() {
  const minusBtn = document.getElementById('qtyMinus');
  const plusBtn  = document.getElementById('qtyPlus');
  const qtyVal   = document.getElementById('qtyValue');
  if (!minusBtn || !plusBtn || !qtyVal) return;

  let qty = 1;

  minusBtn.addEventListener('click', () => {
    if (qty > 1) {
      qty--;
      qtyVal.textContent = qty;
    }
  });

  plusBtn.addEventListener('click', () => {
    if (qty < 99) {
      qty++;
      qtyVal.textContent = qty;
    }
  });
}

/* ============================================================
   PRODUCT DETAIL — SIZE SELECTOR + PRICE UPDATE
   ============================================================ */

function initSizeSelector() {
  const sizeOptions  = document.querySelectorAll('.size-option');
  const priceDisplay = document.getElementById('productPrice');
  if (!sizeOptions.length) return;

  sizeOptions.forEach(btn => {
    btn.addEventListener('click', function () {
      // Deselect all
      sizeOptions.forEach(b => {
        b.classList.remove('is-selected');
        b.setAttribute('aria-pressed', 'false');
      });
      // Select clicked
      this.classList.add('is-selected');
      this.setAttribute('aria-pressed', 'true');

      // Update price
      const price = parseInt(this.dataset.price, 10);
      if (priceDisplay && !isNaN(price)) {
        priceDisplay.textContent = formatPrice(price);
      }
    });
  });
}

/* ============================================================
   PRODUCT DETAIL — ADD TO CART BUTTON
   ============================================================ */

function initProductAddToCart() {
  const addBtn = document.getElementById('addToCartBtn');
  if (!addBtn) return;

  addBtn.addEventListener('click', () => {
    const name = document.querySelector('.product-info__title')?.textContent.trim() || 'Cake';
    const priceText = document.getElementById('productPrice')?.textContent || '';
    const price = parseInt(priceText.replace(/[^0-9]/g, ''), 10) || 0;
    const qty   = parseInt(document.getElementById('qtyValue')?.textContent || '1', 10);

    cart.add(name, price, qty);
    showToast(`"${name}" added to cart!`);

    addBtn.textContent = 'Added ✓';
    addBtn.style.background = '#5a3e2b';
    setTimeout(() => {
      addBtn.textContent = 'Chef, Make This!';
      addBtn.style.background = '';
    }, 1500);
  });
}

/* ============================================================
   PRODUCT DETAIL — WISHLIST
   ============================================================ */

function initWishlist() {
  const btn = document.getElementById('wishlistBtn');
  if (!btn) return;

  btn.addEventListener('click', () => {
    const isWishlisted = btn.dataset.wishlisted === 'true';
    if (isWishlisted) {
      btn.textContent = 'Add to Wishlist';
      btn.dataset.wishlisted = 'false';
      showToast('Removed from wishlist', 'warn');
    } else {
      btn.textContent = '♥ Wishlisted';
      btn.dataset.wishlisted = 'true';
      showToast('Added to wishlist!');
    }
  });
}

/* ============================================================
   PRODUCT DETAIL — IMAGE GALLERY THUMBNAILS
   ============================================================ */

function initProductGallery() {
  const thumbs    = document.querySelectorAll('.product-gallery__thumb');
  const mainImage = document.getElementById('mainImage');
  if (!thumbs.length || !mainImage) return;

  thumbs.forEach(thumb => {
    thumb.addEventListener('click', function () {
      const newSrc = this.dataset.src;
      if (!newSrc) return;

      // Fade transition
      mainImage.style.opacity = '0';
      mainImage.style.transform = 'scale(0.97)';
      mainImage.style.transition = 'opacity 0.2s ease, transform 0.2s ease';

      setTimeout(() => {
        mainImage.src = newSrc;
        mainImage.style.opacity = '1';
        mainImage.style.transform = 'scale(1)';
      }, 200);

      // Update active state
      thumbs.forEach(t => t.classList.remove('is-active'));
      this.classList.add('is-active');
    });
  });
}

/* ============================================================
   PRODUCT DETAIL — TABS
   ============================================================ */

function initProductTabs() {
  const tabBtns   = document.querySelectorAll('.tab-btn');
  const tabPanels = document.querySelectorAll('.tab-panel');
  if (!tabBtns.length) return;

  tabBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      const targetId = this.getAttribute('aria-controls');
      const target   = document.getElementById(targetId);
      if (!target) return;

      // Deactivate all
      tabBtns.forEach(b => {
        b.classList.remove('is-active');
        b.setAttribute('aria-selected', 'false');
      });
      tabPanels.forEach(p => p.classList.remove('is-active'));

      // Activate clicked
      this.classList.add('is-active');
      this.setAttribute('aria-selected', 'true');
      target.classList.add('is-active');
    });
  });

  // Keyboard navigation for tabs
  tabBtns.forEach((btn, i) => {
    btn.addEventListener('keydown', (e) => {
      let next;
      if (e.key === 'ArrowRight') next = tabBtns[i + 1] || tabBtns[0];
      if (e.key === 'ArrowLeft')  next = tabBtns[i - 1] || tabBtns[tabBtns.length - 1];
      if (next) {
        next.focus();
        next.click();
      }
    });
  });
}

/* ============================================================
   LISTING PAGE — FILTER SIDEBAR TOGGLE (mobile)
   ============================================================ */

function initFilterToggle() {
  const toggleBtn = document.getElementById('filterToggle');
  const sidebar   = document.querySelector('.filter-sidebar');
  if (!toggleBtn || !sidebar) return;

  toggleBtn.addEventListener('click', () => {
    const isOpen = sidebar.classList.toggle('is-open');
    toggleBtn.setAttribute('aria-expanded', String(isOpen));
    toggleBtn.textContent = isOpen ? '✕ Close Filters' : '⊟ Filter & Sort';
  });
}

/* ============================================================
   LISTING PAGE — PAGINATION
   ============================================================ */

function initPagination() {
  const paginationBtns = document.querySelectorAll('.pagination__btn');
  if (!paginationBtns.length) return;

  paginationBtns.forEach(btn => {
    if (btn.textContent === '…' || btn.textContent === '...') return;

    btn.addEventListener('click', function () {
      paginationBtns.forEach(b => {
        b.classList.remove('pagination__btn--active');
        b.removeAttribute('aria-current');
      });
      this.classList.add('pagination__btn--active');
      this.setAttribute('aria-current', 'page');

      // Scroll to top of product grid
      const grid = document.querySelector('.product-grid-3') || document.querySelector('.listing-main');
      if (grid) {
        grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
}

/* ============================================================
   LISTING PAGE — SORT SELECT
   ============================================================ */

function initSortSelect() {
  const sortWrap = document.querySelector('.sort-select-wrap select');
  if (!sortWrap) return;

  sortWrap.addEventListener('change', function () {
    showToast(`Sorted by: ${this.options[this.selectedIndex].text}`);
  });
}

/* ============================================================
   SEARCH BAR — LIVE SEARCH TOGGLE
   ============================================================ */

function initSearchBar() {
  const searchInputs = document.querySelectorAll('.search-bar__input');
  const searchBase   = document.querySelector('meta[name="search-url"]')?.content || '/search';

  searchInputs.forEach(input => {
    input.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        const query = input.value.trim();
        if (query.length >= 2) {
          window.location.href = searchBase + '?q=' + encodeURIComponent(query);
        }
      }
    });
  });
}

/* ============================================================
   SCROLL ANIMATIONS — fade in up on scroll
   ============================================================ */

function initScrollAnimations() {
  if (!('IntersectionObserver' in window)) return;

  const animTargets = document.querySelectorAll(
    '.product-card, .category-card, .fresh-card, .special-card, .testimonial-card, .section-header'
  );

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.animation = 'fadeInUp 0.5s ease both';
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

  animTargets.forEach((el, i) => {
    el.style.opacity = '0';
    el.style.animationDelay = `${(i % 4) * 60}ms`;
    observer.observe(el);
  });
}

/* ============================================================
   CATEGORY CARDS — keyboard navigation
   ============================================================ */

function initCategoryCards() {
  document.querySelectorAll('.category-card[role="link"]').forEach(card => {
    card.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        window.location.href = 'listing.html';
      }
    });
  });
}

/* ============================================================
   SMOOTH ANCHOR SCROLL
   ============================================================ */

function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        const headerH = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--header-h') || '128', 10);
        const top = target.getBoundingClientRect().top + window.scrollY - headerH - 20;
        window.scrollTo({ top, behavior: 'smooth' });
      }
    });
  });
}

/* ============================================================
   BACK TO TOP (auto-inject if page is long)
   ============================================================ */

function initBackToTop() {
  if (document.body.scrollHeight < 1800) return;

  const btn = document.createElement('button');
  btn.textContent = '↑';
  btn.setAttribute('aria-label', 'Back to top');
  Object.assign(btn.style, {
    position: 'fixed',
    bottom: '110px',
    left: '40px',
    width: '44px',
    height: '44px',
    borderRadius: '50%',
    background: 'var(--clr-primary)',
    color: '#fff',
    fontSize: '18px',
    fontWeight: '700',
    border: 'none',
    cursor: 'pointer',
    zIndex: '998',
    opacity: '0',
    transition: 'opacity 0.3s ease, transform 0.3s ease',
    transform: 'translateY(10px)',
    boxShadow: '0 4px 12px rgba(200,162,74,0.4)',
  });

  document.body.appendChild(btn);

  window.addEventListener('scroll', debounce(() => {
    if (window.scrollY > 400) {
      btn.style.opacity = '1';
      btn.style.transform = 'translateY(0)';
    } else {
      btn.style.opacity = '0';
      btn.style.transform = 'translateY(10px)';
    }
  }, 100), { passive: true });

  btn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

/* ============================================================
   INIT — run all on DOM ready
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {
  initCartDrawer();
  initMobileMenu();
  initStickyHeader();
  initLazyImages();
  initAddToCartButtons();
  initQuantityPicker();
  initSizeSelector();
  initProductAddToCart();
  initWishlist();
  initProductGallery();
  initProductTabs();
  initFilterToggle();
  initPagination();
  initSortSelect();
  initSearchBar();
  initScrollAnimations();
  initCategoryCards();
  initSmoothScroll();
  initBackToTop();

  // Initialize cart display
  cart.updateUI();
});
