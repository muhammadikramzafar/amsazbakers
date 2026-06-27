@extends('frontend.layouts.app')

@section('title', 'Our Menu — Azmeer Bakery')
@section('meta_description', 'Explore Azmeer Bakery\'s full menu — breakfast, lunch, dinner, bakery items, sweets, beverages and seasonal specials. Order online or dine in.')

@push('styles')
<style>
.menu-cats { display:flex; gap:10px; flex-wrap:wrap; justify-content:center; margin-bottom:32px; }
.menu-cat-btn { padding:8px 20px; border:2px solid var(--clr-border); background:#fff; border-radius:24px; cursor:pointer; font-size:14px; font-weight:500; transition:all .2s; text-decoration:none; color:inherit; }
.menu-cat-btn:hover, .menu-cat-btn--active { background:var(--clr-primary); border-color:var(--clr-primary); color:#fff; }
.menu-search-bar { max-width:520px; margin:0 auto 36px; display:flex; gap:8px; }
.menu-search-bar input { flex:1; }
.menu-labels { display:flex; gap:8px; flex-wrap:wrap; justify-content:center; margin-bottom:28px; }
.menu-label-link { padding:6px 14px; border-radius:16px; font-size:12px; font-weight:600; text-decoration:none; border:1.5px solid; transition:all .15s; }
.menu-label-link--featured  { color:#b36a00; border-color:#b36a00; }
.menu-label-link--featured:hover  { background:#b36a00; color:#fff; }
.menu-label-link--bestseller{ color:#7a6200; border-color:#7a6200; }
.menu-label-link--bestseller:hover{ background:#7a6200; color:#fff; }
.menu-label-link--chef      { color:#1a6fa8; border-color:#1a6fa8; }
.menu-label-link--chef:hover{ background:#1a6fa8; color:#fff; }
.menu-label-link--seasonal  { color:#0a7340; border-color:#0a7340; }
.menu-label-link--seasonal:hover{ background:#0a7340; color:#fff; }
.menu-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:24px; }
.menu-card { background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.06); transition:transform .2s,box-shadow .2s; }
.menu-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,0,0,.12); }
.menu-card__img { aspect-ratio:4/3; overflow:hidden; position:relative; }
.menu-card__img img { width:100%; height:100%; object-fit:cover; }
.menu-card__badges { position:absolute; top:10px; left:10px; display:flex; gap:4px; flex-wrap:wrap; }
.menu-card__badge { font-size:10px; font-weight:700; padding:2px 8px; border-radius:10px; }
.menu-card__badge--featured  { background:#f59e0b; color:#fff; }
.menu-card__badge--bestseller{ background:#ef4444; color:#fff; }
.menu-card__badge--chef      { background:#3b82f6; color:#fff; }
.menu-card__badge--seasonal  { background:#22c55e; color:#fff; }
.menu-card__body { padding:16px; }
.menu-card__cat  { font-size:11px; color:#aaa; text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px; }
.menu-card__name { font-size:17px; font-weight:700; margin-bottom:6px; color:var(--clr-heading); }
.menu-card__name a { text-decoration:none; color:inherit; }
.menu-card__name a:hover { color:var(--clr-primary); }
.menu-card__desc { font-size:13px; color:#777; margin-bottom:12px; line-height:1.5; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.menu-card__footer { display:flex; align-items:center; justify-content:space-between; }
.menu-card__price { font-size:18px; font-weight:700; color:var(--clr-primary); }
.menu-card__price-orig { font-size:13px; text-decoration:line-through; color:#aaa; margin-left:6px; }
.menu-card__meta { font-size:12px; color:#aaa; display:flex; gap:8px; margin-top:6px; }
.menu-card__meta svg { width:13px; height:13px; flex-shrink:0; }
.section-spotlight { padding:60px 0 0; }
.section-spotlight + .section-spotlight { padding-top:40px; }
</style>
@endpush

@section('content')

  <!-- PAGE BANNER -->
  <section class="page-banner">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}" class="breadcrumb__link">Home</a>
      <span class="breadcrumb__sep" aria-hidden="true">/</span>
      <span class="breadcrumb__current">Menu</span>
    </nav>
    <h1 class="page-banner__title">Our Menu</h1>
    <span class="gold-rule gold-rule--center" aria-hidden="true"></span>
  </section>

  <!-- FEATURED ITEMS -->
  @if($featuredItems->isNotEmpty() && !request()->filled('search') && !request()->filled('category') && !request()->filled('label'))
  <section class="section-spotlight" style="padding:60px var(--container-pad) 0;max-width:var(--container-max);margin:0 auto;">
    <div class="section-header section-header--left">
      <h2 class="section-heading">Featured Items</h2>
      <span class="gold-rule" aria-hidden="true"></span>
    </div>
    <div class="menu-grid" style="margin-top:24px;">
      @foreach($featuredItems as $item)
        @include('frontend.menu._card', ['item' => $item])
      @endforeach
    </div>
  </section>
  @endif

  <!-- BEST SELLERS -->
  @if($bestSellers->isNotEmpty() && !request()->filled('search') && !request()->filled('category') && !request()->filled('label'))
  <section class="section-spotlight" style="padding:40px var(--container-pad) 0;max-width:var(--container-max);margin:0 auto;">
    <div class="section-header section-header--left">
      <h2 class="section-heading">Best Sellers</h2>
      <span class="gold-rule" aria-hidden="true"></span>
    </div>
    <div class="menu-grid" style="margin-top:24px;">
      @foreach($bestSellers as $item)
        @include('frontend.menu._card', ['item' => $item])
      @endforeach
    </div>
  </section>
  @endif

  <!-- FULL MENU LISTING -->
  <section style="padding:60px var(--container-pad);max-width:var(--container-max);margin:0 auto;">

    <!-- Search -->
    <div class="menu-search-bar">
      <form method="GET" action="{{ route('menu.index') }}" style="display:flex;gap:8px;width:100%;">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search menu items…" class="form-control" />
        @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}" />@endif
        <button type="submit" class="btn btn--primary">Search</button>
        @if(request()->hasAny(['search','category','label','sort']))
          <a href="{{ route('menu.index') }}" class="btn btn--outline">Clear</a>
        @endif
      </form>
    </div>

    <!-- Category tabs -->
    @if($categories->isNotEmpty())
    <div class="menu-cats">
      <a href="{{ route('menu.index') }}"
         class="menu-cat-btn {{ !request('category') && !request('label') ? 'menu-cat-btn--active' : '' }}">All</a>
      @foreach($categories as $cat)
        <a href="{{ route('menu.index', ['category' => $cat->slug]) }}"
           class="menu-cat-btn {{ request('category') === $cat->slug ? 'menu-cat-btn--active' : '' }}">
          {{ $cat->name }}
          @if($cat->active_items_count > 0)
            <span style="font-size:11px;opacity:.7;">({{ $cat->active_items_count }})</span>
          @endif
        </a>
      @endforeach
    </div>
    @endif

    <!-- Label filters -->
    <div class="menu-labels">
      <a href="{{ route('menu.index', array_merge(request()->except('label'), ['label' => 'featured'])) }}"
         class="menu-label-link menu-label-link--featured {{ request('label') === 'featured' ? 'menu-cat-btn--active' : '' }}"
         style="{{ request('label') === 'featured' ? 'background:#b36a00;color:#fff;' : '' }}">★ Featured</a>
      <a href="{{ route('menu.index', array_merge(request()->except('label'), ['label' => 'bestseller'])) }}"
         class="menu-label-link menu-label-link--bestseller {{ request('label') === 'bestseller' ? 'menu-cat-btn--active' : '' }}"
         style="{{ request('label') === 'bestseller' ? 'background:#7a6200;color:#fff;' : '' }}">🔥 Bestseller</a>
      <a href="{{ route('menu.index', array_merge(request()->except('label'), ['label' => 'chef_recommended'])) }}"
         class="menu-label-link menu-label-link--chef {{ request('label') === 'chef_recommended' ? 'menu-cat-btn--active' : '' }}"
         style="{{ request('label') === 'chef_recommended' ? 'background:#1a6fa8;color:#fff;' : '' }}">👨‍🍳 Chef's Pick</a>
      <a href="{{ route('menu.index', array_merge(request()->except('label'), ['label' => 'seasonal'])) }}"
         class="menu-label-link menu-label-link--seasonal {{ request('label') === 'seasonal' ? 'menu-cat-btn--active' : '' }}"
         style="{{ request('label') === 'seasonal' ? 'background:#0a7340;color:#fff;' : '' }}">🌿 Seasonal</a>
    </div>

    <!-- Sort -->
    <div style="display:flex;justify-content:flex-end;margin-bottom:20px;">
      <form method="GET" action="{{ route('menu.index') }}">
        @foreach(request()->except('sort') as $key => $val)
          <input type="hidden" name="{{ $key }}" value="{{ $val }}" />
        @endforeach
        <select name="sort" class="filter-select" onchange="this.form.submit()" style="min-width:160px;">
          <option value=""          {{ !request('sort') ? 'selected':'' }}>Default Order</option>
          <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected':'' }}>Price: Low → High</option>
          <option value="price_desc"{{ request('sort')=='price_desc'? 'selected':'' }}>Price: High → Low</option>
        </select>
      </form>
    </div>

    <!-- Grid -->
    @if($items->isEmpty())
      <div class="listing-empty" style="text-align:center;padding:60px 0;">
        <p>No menu items found. <a href="{{ route('menu.index') }}">Browse full menu</a></p>
      </div>
    @else
      <div class="menu-grid">
        @foreach($items as $item)
          @include('frontend.menu._card', ['item' => $item])
        @endforeach
      </div>
      <div class="pagination" style="margin-top:40px;">
        {{ $items->withQueryString()->links() }}
      </div>
    @endif

  </section>

@endsection
