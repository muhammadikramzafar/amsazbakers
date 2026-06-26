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
   CART STATE (in-memory, not localStorage per artifact rules)
   ============================================================ */

const cart = {
  items: [],
  count: 0,

  add(name, price, qty = 1) {
    const existing = this.items.find(i => i.name === name);
    if (existing) {
      existing.qty += qty;
    } else {
      this.items.push({ name, price, qty });
    }
    this.count = this.items.reduce((sum, i) => sum + i.qty, 0);
    this.updateUI();
  },

  updateUI() {
    const badges = document.querySelectorAll('.cart-badge');
    badges.forEach(b => {
      b.textContent = this.count;
      b.setAttribute('aria-label', `${this.count} item${this.count !== 1 ? 's' : ''} in cart`);
    });
  }
};

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
  document.querySelectorAll('.btn--cream, .btn--primary').forEach(btn => {
    if (btn.textContent.trim().toUpperCase() === 'ADD TO CART') {
      btn.addEventListener('click', function () {
        // Find product name from nearest card
        const card = this.closest('.product-card') || this.closest('.fresh-card') || this.closest('.special-card');
        let name = 'Item';
        if (card) {
          const nameEl = card.querySelector('.product-card__name, .fresh-card__name, .special-card__name');
          if (nameEl) name = nameEl.textContent.trim();
        }
        cart.add(name, 0, 1);
        showToast(`"${name}" added to cart!`);

        // Brief visual feedback
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
    }
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

    addBtn.textContent = 'Added to Cart ✓';
    addBtn.style.background = '#5a3e2b';
    setTimeout(() => {
      addBtn.textContent = 'Add to Cart';
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

  searchInputs.forEach(input => {
    input.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        const query = input.value.trim();
        if (query) {
          showToast(`Searching for "${query}"…`);
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
