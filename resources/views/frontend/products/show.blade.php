@extends('frontend.layouts.app')

@section('title', $product->name.' — Azmeer Bakery')
@section('meta_description', Str::limit($product->description, 155))

@section('content')

  <!-- PRODUCT DETAIL -->
  <section class="detail-section">

    <!-- GALLERY -->
    <div class="product-gallery">
      <img id="mainImage"
           src="{{ $product->image ? asset('storage/'.\->image) : 'https://placehold.co/600x600/f3e2c7/5a3e2b?text='.urlencode($product->name) }}"
           alt="{{ $product->name }}"
           class="product-gallery__main" />
      <div class="product-gallery__thumbs">
        <img src="{{ $product->image ? asset('storage/'.\->image) : 'https://placehold.co/150x150/f3e2c7/5a3e2b?text='.urlencode($product->name) }}"
             alt="{{ $product->name }}"
             class="product-gallery__thumb product-gallery__thumb--active"
             data-full="{{ $product->image ? asset('storage/'.\->image) : '' }}" />
      </div>
    </div>

    <!-- PRODUCT INFO -->
    <div class="product-info">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="breadcrumb__link">Home</a>
        <span class="breadcrumb__sep" aria-hidden="true">/</span>
        @if($product->category)
          <a href="{{ route('products.category', $product->category->slug) }}" class="breadcrumb__link">{{ $product->category->name }}</a>
          <span class="breadcrumb__sep" aria-hidden="true">/</span>
        @endif
        <span class="breadcrumb__current">{{ $product->name }}</span>
      </nav>

      @if($product->badge)
        <span class="badge badge--detail">{{ $product->badge }}</span>
      @endif

      <h1 class="product-info__title">{{ $product->name }}</h1>

      @if($product->description)
        <p class="product-info__desc">{{ $product->description }}</p>
      @endif

      <div class="product-info__price-row">
        <span class="product-info__price" id="productPrice">
          @if($product->sale_price && $product->sale_price < $product->price)
            <span class="price-sale">Rs. {{ number_format($product->sale_price, 0) }}</span>
            <span class="price-original">Rs. {{ number_format($product->price, 0) }}</span>
          @else
            Rs. {{ number_format($product->price, 0) }}
          @endif
        </span>
      </div>

      <!-- QTY PICKER -->
      <div class="qty-picker" role="group" aria-label="Quantity">
        <button class="qty-btn" id="qtyMinus" aria-label="Decrease quantity">−</button>
        <span class="qty-value" id="qtyValue" aria-live="polite">1</span>
        <button class="qty-btn" id="qtyPlus" aria-label="Increase quantity">+</button>
      </div>

      <!-- ACTIONS -->
      <div class="product-info__actions">
        <button class="btn btn--primary btn--lg" id="addToCartBtn"
                data-product-id="{{ $product->id }}"
                data-product-name="{{ $product->name }}"
                data-product-price="{{ $product->sale_price ?? $product->price }}">
          Add to Cart
        </button>
        <button class="btn btn--outline btn--icon" id="wishlistBtn" aria-label="Add to wishlist">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="20" height="20">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
          </svg>
        </button>
      </div>

      <!-- DELIVERY INFO -->
      <div class="delivery-info-box">
        <div class="delivery-info-row">
          <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18"><rect x="1" y="6" width="15" height="9" rx="1"/><path d="M16 10h3l1 4H16"/><circle cx="5" cy="17" r="1.5"/><circle cx="14" cy="17" r="1.5"/></svg>
          <span>Free delivery on orders above Rs. 999</span>
        </div>
        <div class="delivery-info-row">
          <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18"><circle cx="10" cy="10" r="8"/><polyline points="10,5 10,10 13,13"/></svg>
          <span>Order before 3PM for same-day delivery</span>
        </div>
      </div>
    </div>
  </section>

  <!-- PRODUCT TABS -->
  <section class="product-tabs-section">
    <div class="product-tabs">
      <div class="tab-list" role="tablist">
        <button class="tab-btn tab-btn--active" role="tab" aria-selected="true"  aria-controls="tab-description" id="btn-description">Description</button>
        <button class="tab-btn"                role="tab" aria-selected="false" aria-controls="tab-delivery"    id="btn-delivery">Delivery Info</button>
        <button class="tab-btn"                role="tab" aria-selected="false" aria-controls="tab-reviews"     id="btn-reviews">Reviews</button>
      </div>
      <div class="tab-panels">
        <div class="tab-panel tab-panel--active" id="tab-description" role="tabpanel" aria-labelledby="btn-description">
          <p>{{ $product->description ?? 'No description available.' }}</p>
        </div>
        <div class="tab-panel" id="tab-delivery" role="tabpanel" aria-labelledby="btn-delivery" hidden>
          <ul>
            <li>Free delivery on orders above Rs. 999</li>
            <li>Same-day delivery available when ordered before 3:00 PM</li>
            <li>Delivery within Lahore: 2–4 hours</li>
            <li>Next-day delivery available for other cities</li>
          </ul>
        </div>
        <div class="tab-panel" id="tab-reviews" role="tabpanel" aria-labelledby="btn-reviews" hidden>
          <p>No reviews yet. Be the first to review this product!</p>
        </div>
      </div>
    </div>
  </section>

  <!-- RELATED PRODUCTS -->
  @if($relatedProducts->isNotEmpty())
  <section class="related-section">
    <div class="section-header section-header--left">
      <h2 class="section-heading">You May Also Like</h2>
      <span class="gold-rule" aria-hidden="true"></span>
    </div>
    <div class="product-grid-4">
      @foreach($relatedProducts as $related)
        <article class="product-card">
          <div class="product-card__image-wrap">
            <a href="{{ route('products.show', $related->slug) }}">
              <img src="{{ $related->image ? asset('storage/'.\->image) : 'https://placehold.co/600x600/f3e2c7/5a3e2b?text='.urlencode($related->name) }}"
                   alt="{{ $related->name }}" loading="lazy" />
            </a>
            @if($related->badge)
              <span class="product-card__badge badge">{{ $related->badge }}</span>
            @endif
          </div>
          <div class="product-card__body">
            <h3 class="product-card__name"><a href="{{ route('products.show', $related->slug) }}">{{ $related->name }}</a></h3>
            <p class="product-card__price">{{ $related->display_price }}</p>
            <button class="btn btn--cream btn--full">Add to Cart</button>
          </div>
        </article>
      @endforeach
    </div>
  </section>
  @endif

@endsection
