@extends('frontend.layouts.app')
@section('title', 'Contact Us — Azmeer Bakery')

@section('content')

{{-- ── HERO ── --}}
<section class="pg-hero pg-hero--contact">
  <div class="pg-hero__inner">
    <p class="pg-hero__eyebrow">We'd love to hear from you</p>
    <h1 class="pg-hero__title">Get In Touch</h1>
    <p class="pg-hero__sub">Visit us in Lahore, call us, or drop us a message — we'll get back to you within 24 hours.</p>
  </div>
</section>

{{-- ── QUICK INFO STRIP ── --}}
<div class="contact-strip">
  <div class="contact-strip__inner">
    <div class="contact-strip__item">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" width="20" height="20" aria-hidden="true"><path d="M10 1.3a6.2 6.2 0 0 0-6.2 6.2c0 4.65 6.2 11.2 6.2 11.2s6.2-6.55 6.2-11.2A6.2 6.2 0 0 0 10 1.3z"/><circle cx="10" cy="7.5" r="2.3"/></svg>
      45 Main Blvd, Gulberg III, Lahore
    </div>
    <div class="contact-strip__sep" aria-hidden="true"></div>
    <div class="contact-strip__item">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" width="20" height="20" aria-hidden="true"><path d="M16.6 13.4l-2.5-2.1a1.2 1.2 0 0 0-1.6.1l-1 1a10.5 10.5 0 0 1-3.9-3.9l1-1a1.2 1.2 0 0 0 .1-1.6L6.6 3.4a1.2 1.2 0 0 0-1.6-.2L3.5 4.6A2.5 2.5 0 0 0 3 7C4.5 12.1 7.9 15.5 13 17a2.5 2.5 0 0 0 2.4-.5l1.4-1.5a1.2 1.2 0 0 0-.2-1.6z"/></svg>
      +92 42 3571 8899
    </div>
    <div class="contact-strip__sep" aria-hidden="true"></div>
    <div class="contact-strip__item">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" width="20" height="20" aria-hidden="true"><circle cx="10" cy="10" r="8"/><polyline points="10,5.5 10,10 12.5,12.5"/></svg>
      Mon–Sat 9 AM – 10 PM
    </div>
  </div>
</div>

{{-- ── FORM + INFO ── --}}
<section class="contact-main">
  <div class="contact-main__inner">

    {{-- Form --}}
    <div class="contact-form-card">
      <div class="contact-form-card__header">
        <span class="contact-form-card__tag">Message Us</span>
        <h2 class="contact-form-card__title">Send a Message</h2>
        <p class="contact-form-card__sub">Fill in the form and we'll respond as soon as possible.</p>
      </div>

      @if(session('success'))
        <div class="contact-alert contact-alert--success" role="alert">
          <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M4 10l4 4 8-8"/></svg>
          {{ session('success') }}
        </div>
      @endif

      <form action="{{ route('contact.store') }}" method="POST" class="cform" novalidate>
        @csrf
        <div class="cform__row">
          <div class="cform__field">
            <label class="cform__label" for="cn_name">Your Name <span>*</span></label>
            <input class="cform__input @error('name') cform__input--err @enderror" type="text" id="cn_name" name="name" value="{{ old('name') }}" placeholder="Muhammad Ali" required />
            @error('name')<p class="cform__err">{{ $message }}</p>@enderror
          </div>
          <div class="cform__field">
            <label class="cform__label" for="cn_email">Email Address <span>*</span></label>
            <input class="cform__input @error('email') cform__input--err @enderror" type="email" id="cn_email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required />
            @error('email')<p class="cform__err">{{ $message }}</p>@enderror
          </div>
        </div>
        <div class="cform__row">
          <div class="cform__field">
            <label class="cform__label" for="cn_phone">Phone</label>
            <input class="cform__input" type="tel" id="cn_phone" name="phone" value="{{ old('phone') }}" placeholder="+92 300 0000000" />
          </div>
          <div class="cform__field">
            <label class="cform__label" for="cn_subject">Subject</label>
            <input class="cform__input" type="text" id="cn_subject" name="subject" value="{{ old('subject') }}" placeholder="Custom cake order…" />
          </div>
        </div>
        <div class="cform__field">
          <label class="cform__label" for="cn_message">Message <span>*</span></label>
          <textarea class="cform__input cform__input--ta @error('message') cform__input--err @enderror" id="cn_message" name="message" rows="5" placeholder="Tell us how we can help…" required>{{ old('message') }}</textarea>
          @error('message')<p class="cform__err">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="btn btn--primary" style="width:100%;justify-content:center;">
          <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18" aria-hidden="true"><line x1="2" y1="10" x2="18" y2="10"/><polyline points="13,5 18,10 13,15"/></svg>
          Send Message
        </button>
      </form>
    </div>

    {{-- Info --}}
    <div class="contact-info-col">
      <div class="contact-info-card">
        <div class="cic__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="24" height="24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>
        <div>
          <p class="cic__label">Our Location</p>
          <p class="cic__value">45 Main Boulevard, Gulberg III<br>Lahore, Pakistan</p>
        </div>
      </div>
      <div class="contact-info-card">
        <div class="cic__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="24" height="24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.86 19.86 0 0 1 3.08 4.18 2 2 0 0 1 5.07 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L9.91 9.91a16 16 0 0 0 6.16 6.16l1.27-.41a2 2 0 0 1 2.11.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        </div>
        <div>
          <p class="cic__label">Phone</p>
          <a href="tel:+924235718899" class="cic__value cic__value--link">+92 42 3571 8899</a>
        </div>
      </div>
      <div class="contact-info-card">
        <div class="cic__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="24" height="24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        </div>
        <div>
          <p class="cic__label">Email</p>
          <a href="mailto:hello@azmeerbakery.pk" class="cic__value cic__value--link">hello@azmeerbakery.pk</a>
        </div>
      </div>
      <div class="contact-info-card">
        <div class="cic__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="24" height="24"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
        </div>
        <div>
          <p class="cic__label">Opening Hours</p>
          <p class="cic__value">Mon – Sat: 9:00 AM – 10:00 PM<br>Sunday: 10:00 AM – 8:00 PM</p>
        </div>
      </div>

      {{-- Social links --}}
      <div class="contact-socials">
        <a href="#" class="contact-social-btn" aria-label="Instagram">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="20" height="20"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="5"/><circle cx="17.5" cy="6.5" r="1.5" fill="currentColor" stroke="none"/></svg>
        </a>
        <a href="#" class="contact-social-btn" aria-label="Facebook">
          <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
        </a>
        <a href="#" class="contact-social-btn" aria-label="WhatsApp">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="20" height="20"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
        </a>
      </div>
    </div>

  </div>
</section>

@endsection

@push('styles')
<style>
/* ── Hero ── */
.pg-hero {
  position: relative;
  padding: 80px 24px 72px;
  text-align: center;
  background: linear-gradient(135deg, #2b1207 0%, #4a1e08 50%, #3d1a0b 100%);
  overflow: hidden;
}
.pg-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c8a24a' fill-opacity='0.06'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.pg-hero__inner { position: relative; max-width: 640px; margin: 0 auto; }
.pg-hero__eyebrow { font-size: 13px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: #c8a24a; margin-bottom: 12px; }
.pg-hero__title { font-family: var(--font-display); font-size: clamp(2.4rem, 5vw, 3.5rem); color: #fff; margin-bottom: 16px; line-height: 1.1; }
.pg-hero__sub { font-size: 16px; color: rgba(255,255,255,.65); line-height: 1.6; }

/* ── Strip ── */
.contact-strip { background: #c8a24a; }
.contact-strip__inner { display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 0; max-width: 900px; margin: 0 auto; padding: 14px 24px; }
.contact-strip__item { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: #2b1207; padding: 6px 20px; }
.contact-strip__sep { width: 1px; height: 24px; background: rgba(43,18,7,.2); }

/* ── Main layout ── */
.contact-main { padding: 64px clamp(16px,5vw,80px); }
.contact-main__inner { display: grid; grid-template-columns: 1fr 380px; gap: 40px; max-width: 1100px; margin: 0 auto; align-items: start; }
@media (max-width: 900px) { .contact-main__inner { grid-template-columns: 1fr; } }

/* ── Form card ── */
.contact-form-card { background: #fff; border: 1px solid #ede8e0; border-radius: 20px; padding: 40px; }
.contact-form-card__header { margin-bottom: 28px; }
.contact-form-card__tag { display: inline-block; background: #fdf0e0; color: #b07d30; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; padding: 4px 10px; border-radius: 20px; margin-bottom: 10px; }
.contact-form-card__title { font-family: var(--font-display); font-size: 1.6rem; color: var(--clr-brown); margin-bottom: 6px; }
.contact-form-card__sub { font-size: 14px; color: #888; }

/* ── Alert ── */
.contact-alert { display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 10px; font-size: 14px; font-weight: 600; margin-bottom: 20px; }
.contact-alert--success { background: #edfaf3; color: #1a7a47; border: 1px solid #b2e8ca; }

/* ── Form fields ── */
.cform { display: flex; flex-direction: column; gap: 16px; }
.cform__row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
@media (max-width: 560px) { .cform__row { grid-template-columns: 1fr; } }
.cform__field { display: flex; flex-direction: column; gap: 6px; }
.cform__label { font-size: 13px; font-weight: 600; color: var(--clr-brown); }
.cform__label span { color: var(--clr-primary); }
.cform__input {
  border: 1.5px solid #ddd6cc; border-radius: 10px; padding: 11px 14px;
  font-size: 14px; color: var(--clr-brown); background: #fdfaf6;
  transition: border-color .2s; font-family: inherit; width: 100%; box-sizing: border-box;
}
.cform__input:focus { outline: none; border-color: var(--clr-primary); }
.cform__input--ta { resize: vertical; min-height: 120px; }
.cform__input--err { border-color: #e03e3e; }
.cform__err { font-size: 12px; color: #e03e3e; margin-top: 2px; }

/* ── Info column ── */
.contact-info-col { display: flex; flex-direction: column; gap: 12px; }
.contact-info-card {
  display: flex; align-items: flex-start; gap: 16px;
  background: #fff; border: 1px solid #ede8e0; border-radius: 14px;
  padding: 20px;
}
.cic__icon {
  width: 44px; height: 44px; flex-shrink: 0;
  background: #fdf0e0; border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  color: #b07d30;
}
.cic__label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #a08060; margin-bottom: 4px; }
.cic__value { font-size: 14px; color: var(--clr-brown); line-height: 1.55; }
.cic__value--link { text-decoration: none; color: var(--clr-primary); font-weight: 600; }
.cic__value--link:hover { text-decoration: underline; }

/* ── Social ── */
.contact-socials { display: flex; gap: 10px; padding-top: 8px; }
.contact-social-btn {
  width: 40px; height: 40px; border-radius: 10px;
  background: #fff; border: 1px solid #ede8e0;
  display: flex; align-items: center; justify-content: center;
  color: var(--clr-brown); transition: background .15s, color .15s;
}
.contact-social-btn:hover { background: var(--clr-primary); color: #fff; border-color: var(--clr-primary); }
</style>
@endpush
