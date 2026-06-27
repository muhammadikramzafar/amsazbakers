@extends('admin.layouts.app')
@section('title', 'Homepage Manager')
@section('breadcrumb', 'Homepage Manager')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">Homepage Manager</h1>
  <a href="{{ route('admin.homepage.settings') }}" class="btn btn--primary">Settings &amp; SEO</a>
</div>

@if(session('success'))
  <div class="alert alert--success" style="margin-bottom:16px;">{{ session('success') }}</div>
@endif

<p style="color:var(--clr-muted);margin-bottom:20px;">Manage each homepage section. Click a section to add or edit its content.</p>

<div class="hp-grid">

  {{-- Hero Slides --}}
  <div class="hp-card">
    <div class="hp-card__icon hp-card__icon--gold">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="24" height="24">
        <rect x="2" y="5" width="20" height="14" rx="2"/><path d="M12 9v6M9 12l3-3 3 3"/>
      </svg>
    </div>
    <div class="hp-card__body">
      <h3 class="hp-card__title">Hero Slider</h3>
      <p class="hp-card__meta">{{ $counts['hero'] }} slide{{ $counts['hero'] !== 1 ? 's' : '' }}</p>
      <span class="badge {{ $settings->hero_active ? 'badge--active' : 'badge--inactive' }}">
        {{ $settings->hero_active ? 'Active' : 'Hidden' }}
      </span>
    </div>
    <a href="{{ route('admin.homepage.hero-slides.index') }}" class="hp-card__link">Manage &rarr;</a>
  </div>

  {{-- Promo Banners --}}
  <div class="hp-card">
    <div class="hp-card__icon hp-card__icon--blue">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="24" height="24">
        <path d="M4 5h16a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1z"/><path d="M4 14h8M4 17h5"/>
      </svg>
    </div>
    <div class="hp-card__body">
      <h3 class="hp-card__title">Promotional Banners</h3>
      <p class="hp-card__meta">{{ $counts['promos'] }} banner{{ $counts['promos'] !== 1 ? 's' : '' }}</p>
      <span class="badge {{ $settings->promos_active ? 'badge--active' : 'badge--inactive' }}">
        {{ $settings->promos_active ? 'Active' : 'Hidden' }}
      </span>
    </div>
    <a href="{{ route('admin.homepage.promo-banners.index') }}" class="hp-card__link">Manage &rarr;</a>
  </div>

  {{-- About Section --}}
  <div class="hp-card">
    <div class="hp-card__icon hp-card__icon--green">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="24" height="24">
        <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
      </svg>
    </div>
    <div class="hp-card__body">
      <h3 class="hp-card__title">About Section</h3>
      <p class="hp-card__meta">{{ $counts['about'] ? 'Content set' : 'Not configured' }}</p>
      <span class="badge {{ $settings->about_active ? 'badge--active' : 'badge--inactive' }}">
        {{ $settings->about_active ? 'Active' : 'Hidden' }}
      </span>
    </div>
    <a href="{{ route('admin.homepage.about.edit') }}" class="hp-card__link">Edit &rarr;</a>
  </div>

  {{-- Why Choose Us --}}
  <div class="hp-card">
    <div class="hp-card__icon hp-card__icon--purple">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="24" height="24">
        <path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/>
      </svg>
    </div>
    <div class="hp-card__body">
      <h3 class="hp-card__title">Why Choose Us</h3>
      <p class="hp-card__meta">{{ $counts['why_choose'] }} feature{{ $counts['why_choose'] !== 1 ? 's' : '' }}</p>
      <span class="badge {{ $settings->why_choose_active ? 'badge--active' : 'badge--inactive' }}">
        {{ $settings->why_choose_active ? 'Active' : 'Hidden' }}
      </span>
    </div>
    <a href="{{ route('admin.homepage.why-choose.index') }}" class="hp-card__link">Manage &rarr;</a>
  </div>

  {{-- Signature Dishes --}}
  <div class="hp-card">
    <div class="hp-card__icon hp-card__icon--orange">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="24" height="24">
        <path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/>
        <line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/>
        <line x1="14" y1="1" x2="14" y2="4"/>
      </svg>
    </div>
    <div class="hp-card__body">
      <h3 class="hp-card__title">Signature Dishes</h3>
      <p class="hp-card__meta">{{ $counts['signature'] }} dish{{ $counts['signature'] !== 1 ? 'es' : '' }}</p>
      <span class="badge {{ $settings->signature_active ? 'badge--active' : 'badge--inactive' }}">
        {{ $settings->signature_active ? 'Active' : 'Hidden' }}
      </span>
    </div>
    <a href="{{ route('admin.homepage.signature-dishes.index') }}" class="hp-card__link">Manage &rarr;</a>
  </div>

  {{-- Featured Products (Bakery + Sweets + Bestsellers) --}}
  <div class="hp-card">
    <div class="hp-card__icon hp-card__icon--teal">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="24" height="24">
        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
        <line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>
      </svg>
    </div>
    <div class="hp-card__body">
      <h3 class="hp-card__title">Featured Products</h3>
      <p class="hp-card__meta">Bakery · Sweets · Bestsellers sections</p>
      <span class="badge badge--active">Via Products</span>
    </div>
    <a href="{{ route('admin.homepage.settings') }}" class="hp-card__link">Configure &rarr;</a>
  </div>

  {{-- Testimonials --}}
  <div class="hp-card">
    <div class="hp-card__icon hp-card__icon--gold">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="24" height="24">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
      </svg>
    </div>
    <div class="hp-card__body">
      <h3 class="hp-card__title">Testimonials</h3>
      <p class="hp-card__meta">{{ $counts['testimonials'] }} review{{ $counts['testimonials'] !== 1 ? 's' : '' }}</p>
      <span class="badge {{ $settings->testimonials_active ? 'badge--active' : 'badge--inactive' }}">
        {{ $settings->testimonials_active ? 'Active' : 'Hidden' }}
      </span>
    </div>
    <a href="{{ route('admin.homepage.testimonials.index') }}" class="hp-card__link">Manage &rarr;</a>
  </div>

  {{-- Instagram Feed --}}
  <div class="hp-card">
    <div class="hp-card__icon hp-card__icon--pink">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="24" height="24">
        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
      </svg>
    </div>
    <div class="hp-card__body">
      <h3 class="hp-card__title">Instagram Feed</h3>
      <p class="hp-card__meta">{{ $counts['instagram'] }} photo{{ $counts['instagram'] !== 1 ? 's' : '' }}</p>
      <span class="badge {{ $settings->instagram_active ? 'badge--active' : 'badge--inactive' }}">
        {{ $settings->instagram_active ? 'Active' : 'Hidden' }}
      </span>
    </div>
    <a href="{{ route('admin.homepage.instagram.index') }}" class="hp-card__link">Manage &rarr;</a>
  </div>

  {{-- CTA Sections --}}
  <div class="hp-card">
    <div class="hp-card__icon hp-card__icon--red">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="24" height="24">
        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
      </svg>
    </div>
    <div class="hp-card__body">
      <h3 class="hp-card__title">CTA Sections</h3>
      <p class="hp-card__meta">{{ $counts['cta'] }} call-to-action{{ $counts['cta'] !== 1 ? 's' : '' }}</p>
      <span class="badge {{ $settings->cta_active ? 'badge--active' : 'badge--inactive' }}">
        {{ $settings->cta_active ? 'Active' : 'Hidden' }}
      </span>
    </div>
    <a href="{{ route('admin.homepage.cta.index') }}" class="hp-card__link">Manage &rarr;</a>
  </div>

</div>
@endsection

@push('styles')
<style>
  .hp-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:16px; }
  .hp-card {
    background:var(--clr-card); border:1px solid var(--clr-border);
    border-radius:var(--radius); padding:20px; box-shadow:var(--shadow);
    display:flex; flex-direction:column; gap:12px;
    transition:box-shadow .15s;
  }
  .hp-card:hover { box-shadow:0 4px 16px rgba(0,0,0,.1); }
  .hp-card__icon {
    width:48px; height:48px; border-radius:12px;
    display:grid; place-items:center; flex-shrink:0;
  }
  .hp-card__icon--gold   { background:#fdf3dc; color:var(--clr-gold); }
  .hp-card__icon--blue   { background:#dbeafe; color:#2563eb; }
  .hp-card__icon--green  { background:#dcfce7; color:#16a34a; }
  .hp-card__icon--purple { background:#ede9fe; color:#7c3aed; }
  .hp-card__icon--orange { background:#ffedd5; color:#ea580c; }
  .hp-card__icon--teal   { background:#ccfbf1; color:#0d9488; }
  .hp-card__icon--pink   { background:#fce7f3; color:#db2777; }
  .hp-card__icon--red    { background:#fee2e2; color:#dc2626; }
  .hp-card__title { font-size:15px; font-weight:700; margin-bottom:4px; }
  .hp-card__meta  { font-size:12px; color:var(--clr-muted); margin-bottom:6px; }
  .hp-card__link  {
    display:inline-block; font-size:13px; font-weight:600;
    color:var(--clr-gold); text-decoration:none; margin-top:auto;
  }
  .hp-card__link:hover { color:var(--clr-brown); }
</style>
@endpush
