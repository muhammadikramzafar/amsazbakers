@extends('frontend.layouts.app')

@section('title', isset($category) ? $category->name.' — Azmeer Bakery' : 'Shop All — Azmeer Bakery')

@section('content')

  <!-- PAGE BANNER -->
  <section class="page-banner">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}" class="breadcrumb__link">Home</a>
      <span class="breadcrumb__sep" aria-hidden="true">/</span>
      @if(isset($category))
        <a href="{{ route('products.listing') }}" class="breadcrumb__link">Products</a>
        <span class="breadcrumb__sep" aria-hidden="true">/</span>
        <span class="breadcrumb__current">{{ $category->name }}</span>
      @else
        <span class="breadcrumb__current">All Products</span>
      @endif
    </nav>
    <h1 class="page-banner__title">{{ isset($category) ? $category->name : 'Shop All' }}</h1>
    <span class="gold-rule gold-rule--center" aria-hidden="true"></span>
  </section>

  <!-- LISTING SECTION -->
  <section class="listing-section">

    <!-- SIDEBAR FILTERS -->
    <aside class="filter-sidebar" id="filterSidebar" aria-label="Product filters">
      <div class="filter-sidebar__header">
        <h2 class="filter-sidebar__title">Filters</h2>
        <button class="filter-sidebar__close" id="filterClose" aria-label="Close filters">&times;</button>
      </div>

      <form method="GET" action="{{ isset($category) ? route('products.category', $category->slug) : route('products.listing') }}">
        <!-- Price Range -->
        <div class="filter-group">
          <h3 class="filter-group__heading">Price Range</h3>
          <div class="price-range">
            <input type="number" name="min_price" class="price-range__input" placeholder="Min" value="{{ request('min_price') }}" min="0" />
            <span class="price-range__dash">—</span>
            <input type="number" name="max_price" class="price-range__input" placeholder="Max" value="{{ request('max_price') }}" min="0" />
          </div>
        </div>

        <!-- Categories -->
        @if(!isset($category))
        <div class="filter-group">
          <h3 class="filter-group__heading">Categories</h3>
          <ul class="filter-check-list">
            @foreach($categories as $cat)
            <li class="filter-check-list__item">
              <label class="filter-check">
                <input type="checkbox" name="categories[]" value="{{ $cat->slug }}"
                  {{ in_array($cat->slug, request()->get('categories', [])) ? 'checked' : '' }} />
                <span>{{ $cat->name }}</span>
                <span class="filter-check__count">({{ $cat->active_products_count }})</span>
              </label>
            </li>
            @endforeach
          </ul>
        </div>
        @endif

        <!-- Sort -->
        <div class="filter-group">
          <h3 class="filter-group__heading">Sort By</h3>
          <select name="sort" class="filter-select">
            <option value="" {{ !request('sort') ? 'selected' : '' }}>Default</option>
            <option value="price_asc"  {{ request('sort')=='price_asc'  ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Price: High to Low</option>
            <option value="newest"     {{ request('sort')=='newest'     ? 'selected' : '' }}>Newest First</option>
          </select>
        </div>

        <button type="submit" class="btn btn--primary btn--full" style="margin-top:16px;">Apply Filters</button>
      </form>
    </aside>

    <!-- PRODUCT GRID -->
    <div class="listing-main">
      <div class="listing-toolbar">
        <button class="filter-toggle-btn" id="filterToggle" aria-expanded="false" aria-controls="filterSidebar">
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="16" height="16">
            <line x1="2" y1="4" x2="14" y2="4"/><line x1="4" y1="8" x2="12" y2="8"/><line x1="6" y1="12" x2="10" y2="12"/>
          </svg>
          Filters
        </button>
        <p class="listing-count">{{ $products->total() }} products</p>
      </div>

      @if($products->isEmpty())
        <div class="listing-empty">
          <p>No products found. <a href="{{ route('products.listing') }}">Clear filters</a></p>
        </div>
      @else
        <div class="product-grid-3">
          @foreach($products as $product)
            <article class="product-card">
              <div class="product-card__image-wrap">
                <a href="{{ route('products.show', $product->slug) }}">
                  <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://placehold.co/600x600/f3e2c7/5a3e2b?text='.urlencode($product->name) }}"
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
                <button class="btn btn--cream btn--full">Add to Cart</button>
              </div>
            </article>
          @endforeach
        </div>

        <!-- PAGINATION -->
        <div class="pagination">
          {{ $products->withQueryString()->links() }}
        </div>
      @endif
    </div>

  </section>

@endsection
