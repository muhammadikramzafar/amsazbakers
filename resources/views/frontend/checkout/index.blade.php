@extends('frontend.layouts.app')

@section('title', 'Checkout — Azmeer Bakery')

@section('content')

<section class="checkout-hero">
  <div class="checkout-hero__inner">
    <svg viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.5" width="64" height="64" aria-hidden="true" class="checkout-hero__icon">
      <path d="M20 60a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"/>
      <path d="M48 60a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"/>
      <path d="M4 4h8l7.2 36h25.6L52 20H16"/>
    </svg>
    <h1 class="checkout-hero__title">Your Order</h1>
    <p class="checkout-hero__sub">Review your cart and place your order below.</p>
  </div>
</section>

<div class="checkout-wrap">

  {{-- Order summary (populated by JS from localStorage) --}}
  <div class="checkout-card" id="checkoutSummary">
    <h2 class="checkout-card__heading">Order Summary</h2>
    <div id="checkoutItems" class="checkout-items">
      {{-- JS renders rows here --}}
    </div>
    <div class="checkout-totals" id="checkoutTotals" hidden>
      <div class="checkout-totals__row">
        <span>Subtotal</span>
        <span id="coSubtotal">Rs. 0</span>
      </div>
      <div class="checkout-totals__row checkout-totals__row--delivery" id="coDeliveryRow">
        <span>Delivery</span>
        <span id="coDelivery">Rs. 150</span>
      </div>
      <div class="checkout-totals__row checkout-totals__row--total">
        <span>Total</span>
        <span id="coTotal">Rs. 0</span>
      </div>
    </div>
  </div>

  {{-- Contact / delivery form --}}
  <div class="checkout-card">
    <h2 class="checkout-card__heading">Delivery Details</h2>

    <form class="checkout-form" id="checkoutForm" novalidate>
      @csrf

      <div class="cf-row cf-row--2">
        <div class="cf-field">
          <label class="cf-label" for="coName">Full Name <span aria-hidden="true">*</span></label>
          <input class="cf-input" type="text" id="coName" name="name" placeholder="Muhammad Ali" required>
        </div>
        <div class="cf-field">
          <label class="cf-label" for="coPhone">Phone <span aria-hidden="true">*</span></label>
          <input class="cf-input" type="tel" id="coPhone" name="phone" placeholder="+92 3xx xxxxxxx" required>
        </div>
      </div>

      <div class="cf-field">
        <label class="cf-label" for="coAddress">Delivery Address <span aria-hidden="true">*</span></label>
        <textarea class="cf-input cf-input--textarea" id="coAddress" name="address" rows="3"
                  placeholder="House/flat number, street, area, city" required></textarea>
      </div>

      <div class="cf-row cf-row--2">
        <div class="cf-field">
          <label class="cf-label" for="coCity">City</label>
          <input class="cf-input" type="text" id="coCity" name="city" placeholder="Lahore" value="Lahore">
        </div>
        <div class="cf-field">
          <label class="cf-label" for="coTime">Preferred Time</label>
          <select class="cf-input" id="coTime" name="preferred_time">
            <option value="">As soon as possible</option>
            <option value="morning">Morning (9 AM – 12 PM)</option>
            <option value="afternoon">Afternoon (12 PM – 4 PM)</option>
            <option value="evening">Evening (4 PM – 8 PM)</option>
            <option value="night">Night (8 PM – 10 PM)</option>
          </select>
        </div>
      </div>

      <div class="cf-field">
        <label class="cf-label" for="coNotes">Special Instructions</label>
        <textarea class="cf-input cf-input--textarea" id="coNotes" name="notes" rows="2"
                  placeholder="Extra spicy, no onions, ring the bell…"></textarea>
      </div>

      <div class="cf-field">
        <p class="cf-label">Payment Method</p>
        <div class="cf-payment-opts">
          <label class="cf-payment-opt">
            <input type="radio" name="payment" value="cod" checked>
            <span class="cf-payment-opt__box">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="20" height="20"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M2 10h20"/></svg>
              Cash on Delivery
            </span>
          </label>
          <label class="cf-payment-opt">
            <input type="radio" name="payment" value="easypaisa">
            <span class="cf-payment-opt__box">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="20" height="20"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              Easypaisa / JazzCash
            </span>
          </label>
        </div>
      </div>

      <button type="submit" class="btn btn--primary btn--full checkout-submit" id="coSubmitBtn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18" aria-hidden="true">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
        Place Order
      </button>

      <p class="checkout-secure">
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14" aria-hidden="true">
          <rect x="3" y="7" width="10" height="8" rx="1"/><path d="M5 7V5a3 3 0 0 1 6 0v2"/>
        </svg>
        Your information is safe and secure.
      </p>
    </form>
  </div>

</div>

{{-- Order Confirmed modal --}}
<div class="co-modal" id="coModal" hidden role="dialog" aria-modal="true" aria-labelledby="coModalTitle">
  <div class="co-modal__box">
    <div class="co-modal__icon">
      <svg viewBox="0 0 48 48" fill="none" stroke="#2e7d32" stroke-width="2.5" width="48" height="48">
        <circle cx="24" cy="24" r="22" stroke="#2e7d32"/>
        <path d="M14 24l7 7 13-14" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <h2 class="co-modal__title" id="coModalTitle">Order Placed!</h2>
    <p class="co-modal__msg">Thank you! We've received your order and our team will call you to confirm shortly.</p>
    <a href="{{ route('home') }}" class="btn btn--primary">Back to Home</a>
  </div>
</div>
<div class="co-modal-overlay" id="coModalOverlay" hidden></div>

@endsection

@push('styles')
<style>
/* ── Checkout hero ── */
.checkout-hero {
  background: linear-gradient(135deg, #3d1f0e 0%, #5c2d0a 100%);
  padding: 56px 24px 48px;
  text-align: center;
  color: #fff;
}
.checkout-hero__icon { color: #c8a24a; margin-bottom: 16px; }
.checkout-hero__title { font-family: var(--font-display); font-size: clamp(2rem, 4vw, 3rem); margin-bottom: 8px; }
.checkout-hero__sub   { color: rgba(255,255,255,.7); font-size: 15px; }

/* ── Layout ── */
.checkout-wrap {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 32px;
  max-width: 1100px;
  margin: 48px auto;
  padding: 0 clamp(16px, 4vw, 48px);
  align-items: start;
}
@media (max-width: 760px) { .checkout-wrap { grid-template-columns: 1fr; } }

/* ── Card ── */
.checkout-card { background: #fff; border: 1px solid #ede8e0; border-radius: 16px; padding: 32px; }
.checkout-card__heading { font-family: var(--font-display); font-size: 1.3rem; color: var(--clr-brown); margin-bottom: 20px; }

/* ── Order summary rows ── */
.checkout-items { display: flex; flex-direction: column; gap: 12px; margin-bottom: 20px; }
.co-item { display: flex; justify-content: space-between; align-items: center; font-size: 14px; padding-bottom: 12px; border-bottom: 1px solid #f5f0e8; }
.co-item:last-child { border-bottom: none; }
.co-item__name  { font-weight: 600; color: var(--clr-brown); }
.co-item__qty   { color: #888; font-size: 13px; }
.co-item__price { font-weight: 700; color: var(--clr-primary); }
.co-empty       { text-align: center; padding: 32px; color: #aaa; }

/* ── Totals ── */
.checkout-totals { border-top: 2px solid #f5f0e8; padding-top: 16px; display: flex; flex-direction: column; gap: 10px; }
.checkout-totals__row { display: flex; justify-content: space-between; font-size: 14px; }
.checkout-totals__row--delivery { color: #2e7d32; font-size: 13px; }
.checkout-totals__row--total { font-weight: 800; font-size: 1.1rem; color: var(--clr-brown); padding-top: 8px; border-top: 1px solid #ede8e0; margin-top: 4px; }

/* ── Form ── */
.checkout-form { display: flex; flex-direction: column; gap: 18px; }
.cf-row { display: grid; gap: 16px; }
.cf-row--2 { grid-template-columns: 1fr 1fr; }
@media (max-width: 520px) { .cf-row--2 { grid-template-columns: 1fr; } }
.cf-field { display: flex; flex-direction: column; gap: 6px; }
.cf-label { font-size: 13px; font-weight: 600; color: var(--clr-brown); }
.cf-label span { color: var(--clr-primary); }
.cf-input {
  border: 1.5px solid #ddd6cc; border-radius: 10px; padding: 10px 14px;
  font-size: 14px; color: var(--clr-brown); background: #fdfaf6;
  transition: border-color .2s;
  font-family: inherit;
}
.cf-input:focus { outline: none; border-color: var(--clr-primary); }
.cf-input--textarea { resize: vertical; min-height: 80px; }

/* ── Payment options ── */
.cf-payment-opts { display: flex; gap: 12px; flex-wrap: wrap; }
.cf-payment-opt input { display: none; }
.cf-payment-opt__box {
  display: flex; align-items: center; gap: 8px;
  border: 2px solid #ddd6cc; border-radius: 10px; padding: 10px 16px;
  font-size: 13px; font-weight: 600; color: var(--clr-brown); cursor: pointer;
  transition: border-color .2s, background .2s;
}
.cf-payment-opt input:checked + .cf-payment-opt__box { border-color: var(--clr-primary); background: #fdf5ec; color: var(--clr-primary); }

/* ── Submit ── */
.checkout-submit { display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 4px; }
.checkout-secure { font-size: 12px; color: #888; text-align: center; display: flex; align-items: center; justify-content: center; gap: 5px; }

/* ── Confirm modal ── */
.co-modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 500; }
.co-modal {
  position: fixed; inset: 0; z-index: 501; display: flex; align-items: center; justify-content: center;
  padding: 24px;
}
.co-modal[hidden], .co-modal-overlay[hidden] { display: none; }
.co-modal__box {
  background: #fff; border-radius: 20px; padding: 48px 40px; text-align: center;
  max-width: 440px; width: 100%; box-shadow: 0 20px 60px rgba(0,0,0,.15);
}
.co-modal__icon { margin-bottom: 16px; }
.co-modal__title { font-family: var(--font-display); font-size: 1.8rem; color: #2e7d32; margin-bottom: 12px; }
.co-modal__msg { color: #666; font-size: 15px; line-height: 1.6; margin-bottom: 28px; }
</style>
@endpush

@push('scripts')
<script>
(function () {
  const DELIVERY_FEE   = 150;
  const FREE_THRESHOLD = 999;
  const CART_KEY       = 'ab_cart';

  function getCart() {
    try { return JSON.parse(localStorage.getItem(CART_KEY)) || {}; } catch { return {}; }
  }

  function formatPrice(n) {
    return 'Rs. ' + n.toLocaleString('en-PK');
  }

  function render() {
    const cart    = getCart();
    const items   = Object.values(cart);
    const $items  = document.getElementById('checkoutItems');
    const $totals = document.getElementById('checkoutTotals');

    if (!items.length) {
      $items.innerHTML = '<p class="co-empty">Your cart is empty. <a href="{{ route("products.listing") }}">Shop now →</a></p>';
      $totals.hidden = true;
      return;
    }

    let subtotal = 0;
    $items.innerHTML = items.map(item => {
      const line = item.price * item.qty;
      subtotal += line;
      return `<div class="co-item">
        <div>
          <div class="co-item__name">${item.name}</div>
          <div class="co-item__qty">Qty: ${item.qty}</div>
        </div>
        <div class="co-item__price">${formatPrice(line)}</div>
      </div>`;
    }).join('');

    const delivery = subtotal >= FREE_THRESHOLD ? 0 : DELIVERY_FEE;
    const total    = subtotal + delivery;

    document.getElementById('coSubtotal').textContent = formatPrice(subtotal);
    document.getElementById('coDelivery').textContent = delivery === 0 ? 'FREE' : formatPrice(delivery);
    document.getElementById('coDeliveryRow').style.color = delivery === 0 ? '#2e7d32' : '';
    document.getElementById('coTotal').textContent = formatPrice(total);
    $totals.hidden = false;
  }

  render();

  // Form submit — show confirmation modal, clear cart
  document.getElementById('checkoutForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const name    = document.getElementById('coName').value.trim();
    const phone   = document.getElementById('coPhone').value.trim();
    const address = document.getElementById('coAddress').value.trim();

    if (!name || !phone || !address) {
      alert('Please fill in Name, Phone, and Delivery Address.');
      return;
    }

    // Clear cart
    localStorage.removeItem(CART_KEY);
    if (typeof window.updateCartBadge === 'function') window.updateCartBadge();

    // Show modal
    document.getElementById('coModal').hidden        = false;
    document.getElementById('coModalOverlay').hidden = false;
  });
})();
</script>
@endpush
