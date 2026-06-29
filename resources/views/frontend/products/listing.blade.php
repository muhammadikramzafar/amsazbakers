@extends('frontend.layouts.app')

@section('title', isset($category) ? $category->name.' — Azmeer Bakery' : 'Shop All — Azmeer Bakery')

@section('content')

  @php
    /* Category slug → figma image map */
    $catImageMap = [
      'pizza'       => asset('storage/figma/cat-pizza.jpg'),
      'sweets'      => asset('storage/figma/cat-sweets.jpg'),
      'snacks'      => asset('storage/figma/cat-snacks.jpg'),
      'coffee-tea'  => asset('storage/figma/cat-coffee-tea.jpg'),
      'dairy'       => asset('storage/figma/cat-dairy.jpg'),
      'ice-cream'   => asset('storage/figma/cat-ice-cream.jpg'),
      'deals'       => asset('storage/figma/cat-deals.jpg'),
      'shakes'      => asset('storage/figma/cat-shakes.jpg'),
      'fried-items' => asset('storage/figma/cat-fried.jpg'),
      'juices'      => asset('storage/figma/cat-juices.jpg'),
      'salad-chaat' => asset('storage/figma/cat-salad.jpg'),
      'fast-food'   => asset('storage/figma/cat-fastfood.jpg'),
    ];

    $bannerImage = null;
    if (isset($category)) {
        if ($category->image) {
            $bannerImage = Storage::url($category->image);
        } elseif (isset($catImageMap[$category->slug])) {
            $bannerImage = $catImageMap[$category->slug];
        }
    }
    $bannerTitle = isset($category) ? $category->name : 'Shop All';
    $hasImage    = !empty($bannerImage);
  @endphp

  <!-- PAGE BANNER -->
  <section class="cat-banner {{ $hasImage ? 'cat-banner--has-image' : '' }}"
           @if($hasImage) style="--banner-img: url('{{ $bannerImage }}')" @endif>
    @if($hasImage)
      <div class="cat-banner__overlay" aria-hidden="true"></div>
    @endif
    <div class="cat-banner__content">
      <nav class="breadcrumb cat-banner__breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="breadcrumb__link">Home</a>
        <span class="breadcrumb__sep" aria-hidden="true">/</span>
        @if(isset($category))
          <a href="{{ route('products.listing') }}" class="breadcrumb__link">All Products</a>
          <span class="breadcrumb__sep" aria-hidden="true">/</span>
          @if($category->is_subcategory && $category->parent)
            <a href="{{ route('products.category', $category->parent->slug) }}" class="breadcrumb__link">{{ $category->parent->name }}</a>
            <span class="breadcrumb__sep" aria-hidden="true">/</span>
          @endif
          <span class="breadcrumb__current">{{ $category->name }}</span>
        @else
          <span class="breadcrumb__current">All Products</span>
        @endif
      </nav>
      <h1 class="cat-banner__title">{{ $bannerTitle }}</h1>
      @if(isset($category) && $category->description)
        <p class="cat-banner__desc">{{ $category->description }}</p>
      @endif
      <span class="gold-rule gold-rule--center cat-banner__rule" aria-hidden="true"></span>
    </div>
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

        <!-- Categories — always visible, active category highlighted -->
        <div class="filter-group">
          <h3 class="filter-group__heading">Categories</h3>
          <ul class="filter-check-list">
            <li class="filter-check-list__item">
              <a href="{{ route('products.listing') }}"
                 class="filter-check-list__link {{ !isset($category) ? 'filter-check-list__link--active' : '' }}">
                All Products
              </a>
            </li>
            @foreach($topCategories as $cat)
            <li class="filter-check-list__item">
              <a href="{{ route('products.category', $cat->slug) }}"
                 class="filter-check-list__link {{ isset($category) && $category->slug === $cat->slug ? 'filter-check-list__link--active' : '' }}">
                {{ $cat->name }}
                <span class="filter-check__count">({{ $cat->active_products_count }})</span>
              </a>
            </li>
            @endforeach
          </ul>
        </div>

        <!-- Subcategories (shown when inside a parent category) -->
        @if(isset($category) && !$category->is_subcategory && $category->children->isNotEmpty())
        <div class="filter-group">
          <h3 class="filter-group__heading">{{ $category->name }}</h3>
          <ul class="filter-check-list">
            @foreach($category->children as $sub)
            <li class="filter-check-list__item">
              <a href="{{ route('products.category', $sub->slug) }}" class="filter-check-list__link">
                {{ $sub->name }}
                <span class="filter-check__count">({{ $sub->active_products_count ?? '' }})</span>
              </a>
            </li>
            @endforeach
          </ul>
        </div>
        @endif

        <!-- Product Labels -->
        <div class="filter-group">
          <h3 class="filter-group__heading">Labels</h3>
          <ul class="filter-check-list">
            <li class="filter-check-list__item">
              <label class="filter-check">
                <input type="checkbox" name="featured" value="1" {{ request('featured') ? 'checked' : '' }} />
                <span>Featured</span>
              </label>
            </li>
            <li class="filter-check-list__item">
              <label class="filter-check">
                <input type="checkbox" name="bestseller" value="1" {{ request('bestseller') ? 'checked' : '' }} />
                <span>Bestsellers</span>
              </label>
            </li>
          </ul>
        </div>

        <div style="margin-top:14px;display:flex;flex-direction:column;gap:6px;">
          <button type="submit" class="btn btn--primary btn--full" style="font-size:13px;padding:8px 12px;">Apply Filters</button>
          @if(request()->hasAny(['min_price','max_price','featured','bestseller']))
            <a href="{{ isset($category) ? route('products.category', $category->slug) : route('products.listing') }}"
               class="btn btn--outline btn--full" style="font-size:12px;padding:7px 12px;">Clear Filters</a>
          @endif
        </div>
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
        <form method="GET" action="{{ isset($category) ? route('products.category', $category->slug) : route('products.listing') }}" class="toolbar-sort-form">
          @foreach(request()->except('sort') as $key => $val)
            @if(is_array($val))
              @foreach($val as $v)<input type="hidden" name="{{ $key }}[]" value="{{ $v }}">@endforeach
            @else
              <input type="hidden" name="{{ $key }}" value="{{ $val }}">
            @endif
          @endforeach
          <label class="toolbar-sort-label" for="toolbarSort">Sort:</label>
          <select id="toolbarSort" name="sort" class="toolbar-sort-select" onchange="this.form.submit()">
            <option value=""           {{ !request('sort')                  ? 'selected' : '' }}>Default</option>
            <option value="price_asc"  {{ request('sort') === 'price_asc'  ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
            <option value="newest"     {{ request('sort') === 'newest'     ? 'selected' : '' }}>Newest First</option>
          </select>
        </form>
      </div>

      @if($products->isEmpty())
        <div class="listing-empty">
          <p>No products found. <a href="{{ route('products.listing') }}">Browse all products</a></p>
        </div>
      @else
        <div class="product-grid-3">
          @foreach($products as $product)
            <article class="product-card">
              {{-- Stretched link — covers the full card --}}
              <a class="product-card__link" href="{{ route('products.show', $product->slug) }}" aria-label="{{ $product->name }}"></a>

              <div class="product-card__image-wrap">
                <img src="{{ $product->image ? Storage::url($product->image) : 'https://placehold.co/600x600/f3e2c7/5a3e2b?text='.urlencode($product->name) }}"
                     alt="{{ $product->name }}" loading="lazy" />
                @if($product->badge)
                  <span class="product-card__badge badge">{{ $product->badge }}</span>
                @endif
              </div>
              <div class="product-card__body">
                <p class="product-card__category">{{ $product->category->name ?? '' }}</p>
                <h3 class="product-card__name">{{ $product->name }}</h3>
                <p class="product-card__price">{{ $product->display_price }}</p>
                <button class="btn btn--cream btn--full"
                        data-product="{{ $product->name }}"
                        data-price="{{ (int)($product->sale_price ?? $product->price) }}">{{ $product->cart_button_text }}</button>
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
