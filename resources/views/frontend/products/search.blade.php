@extends('frontend.layouts.app')

@section('title', $q ? 'Search: '.e($q).' — Azmeer Bakery' : 'Search — Azmeer Bakery')

@section('content')

  <!-- PAGE BANNER -->
  <section class="page-banner">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}" class="breadcrumb__link">Home</a>
      <span class="breadcrumb__sep" aria-hidden="true">/</span>
      <span class="breadcrumb__current">Search</span>
    </nav>
    <h1 class="page-banner__title">Search Products</h1>
    <span class="gold-rule gold-rule--center" aria-hidden="true"></span>
  </section>

  <!-- SEARCH BAR -->
  <section style="padding:32px var(--container-pad) 0;max-width:var(--container-max);margin:0 auto;">
    <form method="GET" action="{{ route('products.search') }}" style="display:flex;gap:12px;max-width:600px;margin:0 auto;">
      <input type="text" name="q" value="{{ e($q) }}" placeholder="Search for breads, cakes, sweets…"
             class="form-control" style="flex:1;" autofocus />
      <button type="submit" class="btn btn--primary">Search</button>
    </form>
  </section>

  <!-- LISTING SECTION -->
  <section class="listing-section">

    <!-- SIDEBAR FILTERS -->
    <aside class="filter-sidebar" id="filterSidebar" aria-label="Product filters">
      <div class="filter-sidebar__header">
        <h2 class="filter-sidebar__title">Filters</h2>
        <button class="filter-sidebar__close" id="filterClose" aria-label="Close filters">&times;</button>
      </div>

      <form method="GET" action="{{ route('products.search') }}">
        <input type="hidden" name="q" value="{{ e($q) }}" />

        <!-- Categories -->
        <div class="filter-group">
          <h3 class="filter-group__heading">Categories</h3>
          <ul class="filter-check-list">
            @foreach($topCategories as $cat)
            <li class="filter-check-list__item">
              <label class="filter-check">
                <input type="checkbox" name="categories[]" value="{{ $cat->slug }}"
                  {{ in_array($cat->slug, request()->get('categories', [])) ? 'checked' : '' }} />
                <span>{{ $cat->name }}</span>
              </label>
            </li>
            @endforeach
          </ul>
        </div>

        <!-- Sort -->
        <div class="filter-group">
          <h3 class="filter-group__heading">Sort By</h3>
          <select name="sort" class="filter-select">
            <option value="" {{ !request('sort') ? 'selected' : '' }}>Relevance</option>
            <option value="price_asc"  {{ request('sort')=='price_asc'  ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Price: High to Low</option>
            <option value="newest"     {{ request('sort')=='newest'     ? 'selected' : '' }}>Newest First</option>
          </select>
        </div>

        <button type="submit" class="btn btn--primary btn--full" style="margin-top:16px;">Apply</button>
      </form>
    </aside>

    <!-- RESULTS GRID -->
    <div class="listing-main">
      <div class="listing-toolbar">
        <button class="filter-toggle-btn" id="filterToggle" aria-expanded="false" aria-controls="filterSidebar">
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="16" height="16">
            <line x1="2" y1="4" x2="14" y2="4"/><line x1="4" y1="8" x2="12" y2="8"/><line x1="6" y1="12" x2="10" y2="12"/>
          </svg>
          Filters
        </button>
        @if($q && is_object($products) && method_exists($products, 'total'))
          <p class="listing-count">{{ $products->total() }} result{{ $products->total() !== 1 ? 's' : '' }} for "{{ e($q) }}"</p>
        @else
          <p class="listing-count">Enter a search term above</p>
        @endif
      </div>

      @if(!$q || strlen(trim($q)) < 2)
        <div class="listing-empty">
          <p>Please enter at least 2 characters to search.</p>
        </div>
      @elseif(is_object($products) && $products->isEmpty())
        <div class="listing-empty">
          <p>No products found for "<strong>{{ e($q) }}</strong>". <a href="{{ route('products.listing') }}">Browse all products</a></p>
        </div>
      @else
        <div class="product-grid-3">
          @foreach($products as $product)
            <article class="product-card">
              <div class="product-card__image-wrap">
                <a href="{{ route('products.show', $product->slug) }}">
                  <img src="{{ $product->image ? Storage::url($product->image) : 'https://placehold.co/600x600/f3e2c7/5a3e2b?text='.urlencode($product->name) }}"
                       alt="{{ $product->name }}" loading="lazy" />
                </a>
                @if($product->badge)
                  <span class="product-card__badge badge">{{ $product->badge }}</span>
                @endif
              </div>
              <div class="product-card__body">
                <p class="product-card__category">{{ $product->category->name ?? '' }}</p>
                <h3 class="product-card__name">
                  <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                </h3>
                <p class="product-card__price">{{ $product->display_price }}</p>
                <button class="btn btn--cream btn--full"
                        data-product="{{ $product->name }}"
                        data-price="{{ (int)($product->sale_price ?? $product->price) }}">{{ $product->cart_button_text }}</button>
              </div>
            </article>
          @endforeach
        </div>

        @if(is_object($products) && method_exists($products, 'links'))
          <div class="pagination">
            {{ $products->withQueryString()->links() }}
          </div>
        @endif
      @endif
    </div>

  </section>

@endsection
