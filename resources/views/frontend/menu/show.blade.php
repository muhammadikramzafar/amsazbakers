@extends('frontend.layouts.app')

@section('title', $menuItem->name.' — Azmeer Bakery Menu')
@section('meta_description', Str::limit($menuItem->short_description ?: strip_tags($menuItem->description), 155))

@push('styles')
<style>
.menu-detail { display:grid; grid-template-columns:1fr 1fr; gap:48px; max-width:var(--container-max); margin:0 auto; padding:60px var(--container-pad); align-items:start; }
@media(max-width:768px){ .menu-detail { grid-template-columns:1fr; gap:32px; } }
.menu-gallery__main { width:100%; aspect-ratio:4/3; object-fit:cover; border-radius:12px; }
.menu-gallery__thumbs { display:flex; gap:8px; margin-top:10px; flex-wrap:wrap; }
.menu-gallery__thumb { width:72px; height:72px; object-fit:cover; border-radius:8px; cursor:pointer; border:2px solid var(--clr-border); transition:border-color .15s; }
.menu-gallery__thumb--active, .menu-gallery__thumb:hover { border-color:var(--clr-primary); }
.menu-info__badges { display:flex; gap:6px; flex-wrap:wrap; margin-bottom:12px; }
.menu-info__badge { font-size:11px; font-weight:700; padding:3px 10px; border-radius:12px; }
.menu-info__title { font-size:clamp(26px,4vw,36px); font-weight:700; color:var(--clr-heading); margin:8px 0 12px; line-height:1.2; }
.menu-info__desc { color:#555; line-height:1.7; margin-bottom:20px; }
.menu-info__meta { display:flex; gap:20px; flex-wrap:wrap; margin-bottom:24px; padding:16px 0; border-top:1px solid var(--clr-border); border-bottom:1px solid var(--clr-border); }
.menu-info__meta-item { display:flex; flex-direction:column; gap:3px; }
.menu-info__meta-label { font-size:11px; color:#aaa; text-transform:uppercase; letter-spacing:.5px; }
.menu-info__meta-value { font-size:15px; font-weight:600; color:var(--clr-heading); }
.menu-info__price-row { margin-bottom:20px; }
.menu-info__price { font-size:32px; font-weight:800; color:var(--clr-primary); }
.menu-info__price-orig { font-size:18px; text-decoration:line-through; color:#aaa; margin-left:10px; }
.menu-tabs { margin-top:60px; max-width:var(--container-max); margin-left:auto; margin-right:auto; padding:0 var(--container-pad) 60px; }
.allergen-box { background:#fef9e8; border-left:3px solid #f59e0b; padding:12px 16px; border-radius:4px; margin-top:12px; font-size:14px; }
.menu-related { padding:0 var(--container-pad) 60px; max-width:var(--container-max); margin:0 auto; }
</style>
@endpush

@section('content')

  <!-- PAGE BANNER -->
  <section class="page-banner">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}" class="breadcrumb__link">Home</a>
      <span class="breadcrumb__sep" aria-hidden="true">/</span>
      <a href="{{ route('menu.index') }}" class="breadcrumb__link">Menu</a>
      @if($menuItem->category)
        <span class="breadcrumb__sep" aria-hidden="true">/</span>
        <a href="{{ route('menu.index', ['category' => $menuItem->category->slug]) }}" class="breadcrumb__link">{{ $menuItem->category->name }}</a>
      @endif
      <span class="breadcrumb__sep" aria-hidden="true">/</span>
      <span class="breadcrumb__current">{{ $menuItem->name }}</span>
    </nav>
    <h1 class="page-banner__title" style="font-size:clamp(20px,3vw,28px);">{{ $menuItem->name }}</h1>
    <span class="gold-rule gold-rule--center" aria-hidden="true"></span>
  </section>

  <!-- DETAIL GRID -->
  <div class="menu-detail">

    <!-- Gallery -->
    <div>
      @php $allImages = $menuItem->all_images; @endphp
      <img id="mainImage"
           src="{{ $allImages[0] ?? 'https://placehold.co/800x600/f3e2c7/5a3e2b?text='.urlencode($menuItem->name) }}"
           alt="{{ $menuItem->name }}" class="menu-gallery__main" />
      @if(count($allImages) > 1)
      <div class="menu-gallery__thumbs">
        @foreach($allImages as $i => $url)
          <img src="{{ $url }}" alt="{{ $menuItem->name }}"
               class="menu-gallery__thumb {{ $i === 0 ? 'menu-gallery__thumb--active' : '' }}"
               data-full="{{ $url }}" />
        @endforeach
      </div>
      @endif
    </div>

    <!-- Info -->
    <div>
      <!-- Badges -->
      <div class="menu-info__badges">
        @if($menuItem->is_chef_recommended)<span class="menu-info__badge" style="background:#e8f4fd;color:#1a6fa8;">👨‍🍳 Chef's Pick</span>@endif
        @if($menuItem->is_bestseller)<span class="menu-info__badge" style="background:#fef9e8;color:#7a6200;">🔥 Bestseller</span>@endif
        @if($menuItem->is_featured)<span class="menu-info__badge" style="background:#fef3e8;color:#b36a00;">★ Featured</span>@endif
        @if($menuItem->is_seasonal)<span class="menu-info__badge" style="background:#e8f8ef;color:#0a7340;">🌿 Seasonal</span>@endif
      </div>

      <h1 class="menu-info__title">{{ $menuItem->name }}</h1>

      @if($menuItem->short_description)
        <p class="menu-info__desc">{{ $menuItem->short_description }}</p>
      @endif

      <!-- Meta info -->
      @if($menuItem->preparation_time || $menuItem->serving_size || $menuItem->calories)
      <div class="menu-info__meta">
        @if($menuItem->preparation_time)
          <div class="menu-info__meta-item">
            <span class="menu-info__meta-label">Prep Time</span>
            <span class="menu-info__meta-value">{{ $menuItem->preparation_time }}</span>
          </div>
        @endif
        @if($menuItem->serving_size)
          <div class="menu-info__meta-item">
            <span class="menu-info__meta-label">Serving</span>
            <span class="menu-info__meta-value">{{ $menuItem->serving_size }}</span>
          </div>
        @endif
        @if($menuItem->calories)
          <div class="menu-info__meta-item">
            <span class="menu-info__meta-label">Calories</span>
            <span class="menu-info__meta-value">{{ $menuItem->calories }} kcal</span>
          </div>
        @endif
      </div>
      @endif

      <!-- Price -->
      <div class="menu-info__price-row">
        @if($menuItem->discount_price && $menuItem->discount_price < $menuItem->price)
          <span class="menu-info__price">Rs. {{ number_format($menuItem->discount_price, 0) }}</span>
          <span class="menu-info__price-orig">Rs. {{ number_format($menuItem->price, 0) }}</span>
        @else
          <span class="menu-info__price">Rs. {{ number_format($menuItem->price, 0) }}</span>
        @endif
      </div>

      @if(!$menuItem->is_available)
        <p style="color:#e74c3c;font-weight:600;margin-bottom:16px;">⚠ Currently not available</p>
      @endif

      <!-- Allergens -->
      @if($menuItem->allergens)
        <div class="allergen-box">
          <strong>Allergen Information:</strong> {{ $menuItem->allergens }}
        </div>
      @endif

      @if($menuItem->sku)
        <p style="margin-top:16px;font-size:13px;color:#aaa;">Item Code: {{ $menuItem->sku }}</p>
      @endif
    </div>
  </div>

  <!-- TABS -->
  @if($menuItem->description || $menuItem->ingredients || $menuItem->nutritional_info)
  <div class="menu-tabs">
    <div class="product-tabs">
      <div class="tab-list" role="tablist">
        @if($menuItem->description)
          <button class="tab-btn tab-btn--active" role="tab" aria-selected="true" aria-controls="tab-desc" id="btn-desc">Description</button>
        @endif
        @if($menuItem->ingredients)
          <button class="tab-btn {{ !$menuItem->description ? 'tab-btn--active' : '' }}" role="tab" aria-controls="tab-ingr" id="btn-ingr">Ingredients</button>
        @endif
        @if($menuItem->nutritional_info)
          <button class="tab-btn" role="tab" aria-controls="tab-nutr" id="btn-nutr">Nutrition</button>
        @endif
      </div>
      <div class="tab-panels">
        @if($menuItem->description)
          <div class="tab-panel tab-panel--active" id="tab-desc" role="tabpanel" aria-labelledby="btn-desc">
            {!! nl2br(e($menuItem->description)) !!}
          </div>
        @endif
        @if($menuItem->ingredients)
          <div class="tab-panel {{ !$menuItem->description ? 'tab-panel--active' : '' }}" id="tab-ingr" role="tabpanel" aria-labelledby="btn-ingr" {{ $menuItem->description ? 'hidden' : '' }}>
            <p>{{ $menuItem->ingredients }}</p>
          </div>
        @endif
        @if($menuItem->nutritional_info)
          <div class="tab-panel" id="tab-nutr" role="tabpanel" aria-labelledby="btn-nutr" hidden>
            <p>{{ $menuItem->nutritional_info }}</p>
          </div>
        @endif
      </div>
    </div>
  </div>
  @endif

  <!-- RELATED ITEMS -->
  @if($related->isNotEmpty())
  <div class="menu-related">
    <div class="section-header section-header--left">
      <h2 class="section-heading">You Might Also Like</h2>
      <span class="gold-rule" aria-hidden="true"></span>
    </div>
    <div class="menu-grid" style="margin-top:24px;">
      @foreach($related as $item)
        @include('frontend.menu._card', ['item' => $item])
      @endforeach
    </div>
  </div>
  @endif

@endsection

@push('scripts')
<script>
document.querySelectorAll('.menu-gallery__thumb').forEach(t => {
  t.addEventListener('click', () => {
    document.querySelectorAll('.menu-gallery__thumb').forEach(x => x.classList.remove('menu-gallery__thumb--active'));
    t.classList.add('menu-gallery__thumb--active');
    document.getElementById('mainImage').src = t.dataset.full || t.src;
  });
});
</script>
@endpush
