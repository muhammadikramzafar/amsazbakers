@extends('frontend.layouts.app')
@section('title', 'Our Story — Azmeer Bakery')

@section('content')

{{-- ── HERO ── --}}
<section class="pg-hero pg-hero--about">
  <div class="pg-hero__inner">
    <p class="pg-hero__eyebrow">Est. 2008 · Lahore, Pakistan</p>
    <h1 class="pg-hero__title">Our Story</h1>
    <p class="pg-hero__sub">From a humble kitchen in Gulberg to one of Lahore's most-loved bakeries — a journey built on love, flour, and heritage.</p>
  </div>
</section>

{{-- ── INTRO ── --}}
<section class="about-intro">
  <div class="about-intro__inner">
    <div class="about-intro__text">
      <span class="section-tag">Who We Are</span>
      <h2 class="about-intro__heading">Crafting Memories<br>Since 2008</h2>
      <span class="gold-rule" aria-hidden="true"></span>
      <p>Founded in the heart of Lahore, Azmeer Bakery began as a humble kitchen experiment and grew into one of the city's most beloved bakeries. We blend traditional South Asian flavours with modern confectionery techniques to create truly unique experiences.</p>
      <p>Every product is handcrafted with the finest local ingredients — from farm-fresh dairy to hand-ground spices — ensuring that each bite carries the warmth of our heritage.</p>
      <a href="{{ route('products.listing') }}" class="btn btn--primary" style="margin-top: 24px; display: inline-flex;">Explore Our Menu</a>
    </div>
    <div class="about-intro__image">
      <img src="{{ asset('assets/frontend/img/about-bakery.jpg') }}"
           onerror="this.src='https://placehold.co/600x460/f3e2c7/5a3e2b?text=Our+Bakery'"
           alt="Azmeer Bakery kitchen" loading="lazy" />
    </div>
  </div>
</section>

{{-- ── STATS ── --}}
<section class="about-stats-section">
  <div class="about-stats__inner">
    <div class="about-stat-item">
      <span class="about-stat-item__num">15+</span>
      <span class="about-stat-item__label">Years of Baking</span>
    </div>
    <div class="about-stat-sep" aria-hidden="true"></div>
    <div class="about-stat-item">
      <span class="about-stat-item__num">50,000+</span>
      <span class="about-stat-item__label">Happy Customers</span>
    </div>
    <div class="about-stat-sep" aria-hidden="true"></div>
    <div class="about-stat-item">
      <span class="about-stat-item__num">120+</span>
      <span class="about-stat-item__label">Menu Items</span>
    </div>
    <div class="about-stat-sep" aria-hidden="true"></div>
    <div class="about-stat-item">
      <span class="about-stat-item__num">3</span>
      <span class="about-stat-item__label">Branches in Lahore</span>
    </div>
  </div>
</section>

{{-- ── VALUES ── --}}
<section class="about-values">
  <div class="about-values__inner">
    <div class="section-header" style="margin-bottom:48px;">
      <h2 class="section-heading">What Makes Us Different</h2>
      <span class="gold-rule gold-rule--center" aria-hidden="true"></span>
    </div>
    <div class="about-values__grid">
      <div class="about-value-card">
        <div class="about-value-card__icon">
          <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.6" width="32" height="32"><path d="M16 3C9 3 3 9 3 16s6 13 13 13 13-6 13-13S23 3 16 3z"/><path d="M10 16l4 4 8-8"/></svg>
        </div>
        <h3 class="about-value-card__title">100% Halal</h3>
        <p class="about-value-card__desc">Every ingredient is certified halal and sourced responsibly from trusted local suppliers.</p>
      </div>
      <div class="about-value-card">
        <div class="about-value-card__icon">
          <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.6" width="32" height="32"><path d="M4 20s3-3 6-3 6 6 9 6 6-3 6-3"/><path d="M4 12s3-3 6-3 6 6 9 6 6-3 6-3"/></svg>
        </div>
        <h3 class="about-value-card__title">Fresh Daily</h3>
        <p class="about-value-card__desc">We bake every morning. Nothing sits on a shelf overnight — freshness is non-negotiable.</p>
      </div>
      <div class="about-value-card">
        <div class="about-value-card__icon">
          <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.6" width="32" height="32"><path d="M16 2l3 9h9l-7 5 3 9-8-6-8 6 3-9-7-5h9z"/></svg>
        </div>
        <h3 class="about-value-card__title">Award-Winning</h3>
        <p class="about-value-card__desc">Recognized by the Lahore Food Festival three years running for best artisan bakery.</p>
      </div>
      <div class="about-value-card">
        <div class="about-value-card__icon">
          <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.6" width="32" height="32"><path d="M20 8c2 0 8 1.5 8 8s-6 8-8 8H12c-2 0-8-1.5-8-8s6-8 8-8h3"/><path d="M16 12v8M13 15l3-3 3 3"/></svg>
        </div>
        <h3 class="about-value-card__title">Same-Day Delivery</h3>
        <p class="about-value-card__desc">Order before 3 PM and get your items the same day, fresh from our oven to your door.</p>
      </div>
    </div>
  </div>
</section>

{{-- ── TIMELINE ── --}}
<section class="about-timeline">
  <div class="about-timeline__inner">
    <div class="section-header" style="margin-bottom:48px;">
      <h2 class="section-heading">Our Journey</h2>
      <span class="gold-rule gold-rule--center" aria-hidden="true"></span>
    </div>
    <div class="timeline">
      <div class="timeline-item">
        <div class="timeline-item__year">2008</div>
        <div class="timeline-item__dot" aria-hidden="true"></div>
        <div class="timeline-item__content">
          <h4>The Beginning</h4>
          <p>Azmeer's mother starts baking traditional mithai and cakes from her Gulberg home kitchen for neighbours and family events.</p>
        </div>
      </div>
      <div class="timeline-item">
        <div class="timeline-item__year">2012</div>
        <div class="timeline-item__dot" aria-hidden="true"></div>
        <div class="timeline-item__content">
          <h4>First Shop Opens</h4>
          <p>The first Azmeer Bakery outlet opens on Main Boulevard, Gulberg — famous for cardamom croissants and layered cakes.</p>
        </div>
      </div>
      <div class="timeline-item">
        <div class="timeline-item__year">2017</div>
        <div class="timeline-item__dot" aria-hidden="true"></div>
        <div class="timeline-item__content">
          <h4>Menu Expansion</h4>
          <p>Fusion menu launched blending South Asian flavours with European baking — gulab jamun cheesecake, chai-spiced crème brûlée.</p>
        </div>
      </div>
      <div class="timeline-item">
        <div class="timeline-item__year">2021</div>
        <div class="timeline-item__dot" aria-hidden="true"></div>
        <div class="timeline-item__content">
          <h4>Online Ordering</h4>
          <p>Launched same-day delivery across Lahore, bringing fresh-baked goodness directly to your doorstep.</p>
        </div>
      </div>
      <div class="timeline-item">
        <div class="timeline-item__year">2024</div>
        <div class="timeline-item__dot" aria-hidden="true"></div>
        <div class="timeline-item__content">
          <h4>Today</h4>
          <p>Three locations, 50,000+ loyal customers, and still baking every item by hand with the same love as day one.</p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ── CTA ── --}}
<section class="about-cta">
  <div class="about-cta__inner">
    <h2 class="about-cta__title">Ready to Taste the Difference?</h2>
    <p class="about-cta__sub">Order online or visit us — your next favourite bakery memory starts here.</p>
    <div class="about-cta__btns">
      <a href="{{ route('products.listing') }}" class="btn btn--cream">Shop Now</a>
      <a href="{{ route('contact') }}" class="btn btn--outline-light">Contact Us</a>
    </div>
  </div>
</section>

@endsection

@push('styles')
<style>
/* Shared hero (reused by contact too via include) */
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

.section-tag { display: inline-block; background: #fdf0e0; color: #b07d30; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; padding: 4px 10px; border-radius: 20px; margin-bottom: 12px; }

/* ── Intro ── */
.about-intro { padding: 72px clamp(16px,5vw,80px); }
.about-intro__inner { display: grid; grid-template-columns: 1fr 1fr; gap: 64px; max-width: 1100px; margin: 0 auto; align-items: center; }
@media (max-width: 840px) { .about-intro__inner { grid-template-columns: 1fr; } }
.about-intro__heading { font-family: var(--font-display); font-size: clamp(1.8rem, 3vw, 2.5rem); color: var(--clr-brown); line-height: 1.15; margin-bottom: 16px; }
.about-intro__text p { font-size: 15px; color: #666; line-height: 1.7; margin-bottom: 14px; }
.about-intro__image img { width: 100%; border-radius: 20px; object-fit: cover; aspect-ratio: 4/3; box-shadow: 0 16px 48px rgba(0,0,0,.1); }

/* ── Stats ── */
.about-stats-section { background: linear-gradient(135deg, #3d1a0b, #5c2d0a); padding: 48px 24px; }
.about-stats__inner { display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 0; max-width: 900px; margin: 0 auto; }
.about-stat-item { text-align: center; padding: 16px 40px; }
.about-stat-item__num { display: block; font-family: var(--font-display); font-size: clamp(2rem, 4vw, 3rem); color: #c8a24a; font-weight: 700; }
.about-stat-item__label { font-size: 13px; color: rgba(255,255,255,.65); font-weight: 500; }
.about-stat-sep { width: 1px; height: 48px; background: rgba(255,255,255,.15); }
@media (max-width: 600px) { .about-stat-sep { display: none; } .about-stat-item { width: 50%; } }

/* ── Values ── */
.about-values { padding: 80px clamp(16px,5vw,80px); background: #fdf8f2; }
.about-values__inner { max-width: 1100px; margin: 0 auto; }
.about-values__grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 24px; }
@media (max-width: 900px) { .about-values__grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 520px) { .about-values__grid { grid-template-columns: 1fr; } }
.about-value-card { background: #fff; border: 1px solid #ede8e0; border-radius: 16px; padding: 28px 24px; text-align: center; }
.about-value-card__icon { width: 56px; height: 56px; background: #fdf0e0; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #b07d30; margin: 0 auto 16px; }
.about-value-card__title { font-family: var(--font-display); font-size: 1.1rem; color: var(--clr-brown); margin-bottom: 8px; }
.about-value-card__desc { font-size: 13px; color: #888; line-height: 1.6; }

/* ── Timeline ── */
.about-timeline { padding: 80px clamp(16px,5vw,80px); }
.about-timeline__inner { max-width: 700px; margin: 0 auto; }
.timeline { position: relative; }
.timeline::before { content: ''; position: absolute; left: 90px; top: 0; bottom: 0; width: 2px; background: #ede8e0; }
.timeline-item { display: grid; grid-template-columns: 80px 20px 1fr; gap: 0 16px; align-items: start; padding-bottom: 36px; position: relative; }
.timeline-item:last-child { padding-bottom: 0; }
.timeline-item__year { font-family: var(--font-display); font-size: 1rem; font-weight: 700; color: #c8a24a; text-align: right; padding-top: 2px; }
.timeline-item__dot { width: 14px; height: 14px; background: #c8a24a; border-radius: 50%; border: 3px solid #fff; box-shadow: 0 0 0 2px #c8a24a; margin-top: 4px; flex-shrink: 0; }
.timeline-item__content h4 { font-family: var(--font-display); font-size: 1.05rem; color: var(--clr-brown); margin-bottom: 6px; }
.timeline-item__content p { font-size: 14px; color: #777; line-height: 1.6; }

/* ── CTA ── */
.about-cta { background: linear-gradient(135deg, #2b1207 0%, #4a1e08 100%); padding: 72px 24px; text-align: center; }
.about-cta__inner { max-width: 600px; margin: 0 auto; }
.about-cta__title { font-family: var(--font-display); font-size: clamp(1.8rem, 3.5vw, 2.5rem); color: #fff; margin-bottom: 12px; }
.about-cta__sub { font-size: 15px; color: rgba(255,255,255,.65); margin-bottom: 32px; line-height: 1.6; }
.about-cta__btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
.btn--outline-light { border: 2px solid rgba(255,255,255,.4); color: #fff; background: transparent; border-radius: 8px; padding: 11px 24px; font-weight: 700; font-size: 14px; transition: background .15s; text-decoration: none; display: inline-flex; align-items: center; }
.btn--outline-light:hover { background: rgba(255,255,255,.1); }
</style>
@endpush
