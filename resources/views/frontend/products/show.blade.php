@extends('frontend.layouts.app')

@section('title', $product->name.' — Azmeer Bakery')
@section('meta_description', Str::limit($product->short_description ?: $product->description, 155))

@section('content')

  {{-- ══════════════════════════════════════════════
       PRODUCT DETAIL
  ══════════════════════════════════════════════ --}}
  <section class="detail-section">

    {{-- GALLERY --}}
    <div class="product-gallery">
      @php $allImages = $product->all_images; @endphp
      <img id="mainImage"
           src="{{ $allImages[0] ?? 'https://placehold.co/600x600/f3e2c7/5a3e2b?text='.urlencode($product->name) }}"
           alt="{{ $product->name }}"
           class="product-gallery__main" />
      @if(count($allImages) > 1)
      <div class="product-gallery__thumbs">
        @foreach($allImages as $i => $imgUrl)
          <img src="{{ $imgUrl }}"
               alt="{{ $product->name }} — image {{ $i + 1 }}"
               class="product-gallery__thumb {{ $i === 0 ? 'product-gallery__thumb--active' : '' }}"
               data-full="{{ $imgUrl }}" />
        @endforeach
      </div>
      @else
      <div class="product-gallery__thumbs">
        <img src="{{ $allImages[0] ?? 'https://placehold.co/150x150/f3e2c7/5a3e2b?text='.urlencode($product->name) }}"
             alt="{{ $product->name }}"
             class="product-gallery__thumb product-gallery__thumb--active"
             data-full="{{ $allImages[0] ?? '' }}" />
      </div>
      @endif
    </div>

    {{-- PRODUCT INFO --}}
    <div class="product-info">

      {{-- Breadcrumb + category tag --}}
      <div class="pi-top">
        <nav class="breadcrumb" aria-label="Breadcrumb">
          <a href="{{ route('home') }}" class="breadcrumb__link">Home</a>
          <span class="breadcrumb__sep" aria-hidden="true">/</span>
          <a href="{{ route('products.listing') }}" class="breadcrumb__link">Products</a>
          @if($product->category)
            <span class="breadcrumb__sep" aria-hidden="true">/</span>
            <a href="{{ route('products.category', $product->category->slug) }}" class="breadcrumb__link">{{ $product->category->name }}</a>
          @endif
          <span class="breadcrumb__sep" aria-hidden="true">/</span>
          <span class="breadcrumb__current">{{ $product->name }}</span>
        </nav>
        @if($product->badge)
          <span class="badge pi-badge">{{ $product->badge }}</span>
        @endif
      </div>

      {{-- Title + desc --}}
      <div class="pi-header">
        <h1 class="product-info__title">{{ $product->name }}</h1>
        @php $desc = $product->short_description ?: $product->description; @endphp
        @if($desc)
          <p class="product-info__desc">{{ $desc }}</p>
        @endif
      </div>

      {{-- Price --}}
      <div class="pi-price-row">
        <span class="pi-price" id="productPrice">
          @if($product->sale_price && $product->sale_price < $product->price)
            <span class="pi-price__sale">Rs. {{ number_format($product->sale_price, 0) }}</span>
            <span class="pi-price__original">Rs. {{ number_format($product->price, 0) }}</span>
          @else
            <span class="pi-price__regular">Rs. {{ number_format($product->price, 0) }}</span>
          @endif
        </span>
        @if($product->is_available)
          <span class="pi-stock pi-stock--in">
            <span class="pi-stock__dot"></span> In Stock
          </span>
        @else
          <span class="pi-stock pi-stock--out">
            <span class="pi-stock__dot"></span> Out of Stock
          </span>
        @endif
      </div>

      <div class="pi-divider"></div>

      {{-- Qty + Add to Cart row --}}
      <div class="pi-actions">
        <div class="pi-qty" role="group" aria-label="Quantity">
          <button class="pi-qty__btn" id="qtyMinus" aria-label="Decrease quantity">
            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.5" width="14" height="14"><line x1="2" y1="8" x2="14" y2="8"/></svg>
          </button>
          <span class="pi-qty__value" id="qtyValue" aria-live="polite">1</span>
          <button class="pi-qty__btn" id="qtyPlus" aria-label="Increase quantity">
            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.5" width="14" height="14"><line x1="8" y1="2" x2="8" y2="14"/><line x1="2" y1="8" x2="14" y2="8"/></svg>
          </button>
        </div>

        <button class="btn btn--primary pi-add-btn" id="addToCartBtn"
                data-product="{{ $product->name }}"
                data-price="{{ (int)($product->sale_price ?? $product->price) }}">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18" aria-hidden="true">
            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
            <line x1="3" y1="6" x2="21" y2="6"/>
            <path d="M16 10a4 4 0 0 1-8 0"/>
          </svg>
          {{ $product->cart_button_text }}
        </button>

        <button class="pi-wishlist-btn" id="wishlistBtn" aria-label="Add to wishlist" title="Add to wishlist">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="20" height="20">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
          </svg>
        </button>
      </div>

      <div class="pi-divider"></div>

      {{-- Delivery info --}}
      <div class="pi-delivery">
        <div class="pi-delivery__item">
          <div class="pi-delivery__icon">
            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18"><rect x="1" y="6" width="15" height="9" rx="1"/><path d="M16 10h3l1 4H16"/><circle cx="5" cy="17" r="1.5"/><circle cx="14" cy="17" r="1.5"/></svg>
          </div>
          <div>
            <p class="pi-delivery__label">Free Delivery</p>
            <p class="pi-delivery__sub">On orders above Rs. 999</p>
          </div>
        </div>
        <div class="pi-delivery__item">
          <div class="pi-delivery__icon">
            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="18" height="18"><circle cx="10" cy="10" r="8"/><polyline points="10,5 10,10 13,13"/></svg>
          </div>
          <div>
            <p class="pi-delivery__label">Same-Day Delivery</p>
            <p class="pi-delivery__sub">Order before 3:00 PM</p>
          </div>
        </div>
      </div>

      {{-- Recipe teaser (if a recipe was matched) --}}
      @if($recipe)
      <a href="{{ route('recipes.show', $recipe->slug) }}" class="pi-recipe-link">
        <div class="pi-recipe-link__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22">
            <path d="M3 11l19-9-9 19-2-8-8-2z"/>
          </svg>
        </div>
        <div class="pi-recipe-link__body">
          <span class="pi-recipe-link__label">Recipe Available</span>
          <span class="pi-recipe-link__title">{{ $recipe->title }}</span>
          @if($recipe->prep_time || $recipe->cook_time)
            <span class="pi-recipe-link__meta">
              @if($recipe->prep_time) Prep {{ $recipe->prep_time }}min @endif
              @if($recipe->prep_time && $recipe->cook_time) &middot; @endif
              @if($recipe->cook_time) Cook {{ $recipe->cook_time }}min @endif
              @if($recipe->difficulty) &middot; {{ $recipe->difficulty_label }} @endif
            </span>
          @endif
        </div>
        <svg class="pi-recipe-link__arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16" aria-hidden="true">
          <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
        </svg>
      </a>
      @endif

      @if($product->sku)
        <p class="pi-sku">SKU: {{ $product->sku }}</p>
      @endif

    </div>
  </section>

  {{-- ══════════════════════════════════════════════
       PRODUCT TABS
  ══════════════════════════════════════════════ --}}
  <section class="product-tabs-section">
    <div class="product-tabs">
      <div class="tab-list" role="tablist">
        <button class="tab-btn tab-btn--active" role="tab" aria-selected="true" aria-controls="tab-description" id="btn-description">Description</button>
        @if($product->ingredients || $product->nutritional_info || $product->allergens)
          <button class="tab-btn" role="tab" aria-selected="false" aria-controls="tab-ingredients" id="btn-ingredients">Ingredients</button>
        @endif
        <button class="tab-btn" role="tab" aria-selected="false" aria-controls="tab-delivery" id="btn-delivery">Delivery Info</button>
        <button class="tab-btn" role="tab" aria-selected="false" aria-controls="tab-reviews" id="btn-reviews">Reviews</button>
      </div>
      <div class="tab-panels">
        <div class="tab-panel tab-panel--active" id="tab-description" role="tabpanel" aria-labelledby="btn-description">
          @if($product->full_description)
            {!! nl2br(e($product->full_description)) !!}
          @elseif($product->description)
            <p>{{ $product->description }}</p>
          @else
            <p>No description available.</p>
          @endif
        </div>

        @if($product->ingredients || $product->nutritional_info || $product->allergens)
        <div class="tab-panel" id="tab-ingredients" role="tabpanel" aria-labelledby="btn-ingredients" hidden>
          @if($product->ingredients)
            <h4 style="margin-bottom:8px;">Ingredients</h4>
            <p>{{ $product->ingredients }}</p>
          @endif
          @if($product->nutritional_info)
            <h4 style="margin-top:16px;margin-bottom:8px;">Nutritional Information</h4>
            <p>{{ $product->nutritional_info }}</p>
          @endif
          @if($product->allergens)
            <div style="margin-top:16px;padding:12px 16px;background:#fef9e8;border-left:3px solid #f59e0b;border-radius:4px;">
              <strong>Allergen Info:</strong> {{ $product->allergens }}
            </div>
          @endif
        </div>
        @endif

        <div class="tab-panel" id="tab-delivery" role="tabpanel" aria-labelledby="btn-delivery" hidden>
          <ul style="padding-left:20px;line-height:2;">
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

  {{-- ══════════════════════════════════════════════
       RECIPE SECTION
  ══════════════════════════════════════════════ --}}
  @if($recipe)
  <section class="recipe-section">
    <div class="recipe-section__inner">

      {{-- Left: recipe image + meta --}}
      <div class="recipe-section__visual">
        @if($recipe->featured_image)
          <div class="recipe-section__img-wrap">
            <img src="{{ Storage::url($recipe->featured_image) }}" alt="{{ $recipe->title }}" loading="lazy" />
          </div>
        @else
          <div class="recipe-section__img-placeholder">
            <svg viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.5" width="56" height="56" aria-hidden="true">
              <path d="M32 6C17.641 6 6 17.641 6 32s11.641 26 26 26 26-11.641 26-26S46.359 6 32 6z"/>
              <path d="M32 20v12l8 4"/>
            </svg>
          </div>
        @endif

        <div class="recipe-section__meta-pills">
          @if($recipe->prep_time)
          <div class="recipe-meta-pill">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="16" height="16"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
            <div>
              <span class="recipe-meta-pill__label">Prep</span>
              <span class="recipe-meta-pill__value">{{ $recipe->prep_time }} min</span>
            </div>
          </div>
          @endif
          @if($recipe->cook_time)
          <div class="recipe-meta-pill">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="16" height="16"><path d="M12 2a5 5 0 0 0-5 5v3H5a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V11a1 1 0 0 0-1-1h-2V7a5 5 0 0 0-5-5z"/></svg>
            <div>
              <span class="recipe-meta-pill__label">Cook</span>
              <span class="recipe-meta-pill__value">{{ $recipe->cook_time }} min</span>
            </div>
          </div>
          @endif
          @if($recipe->servings)
          <div class="recipe-meta-pill">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="16" height="16"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <div>
              <span class="recipe-meta-pill__label">Serves</span>
              <span class="recipe-meta-pill__value">{{ $recipe->servings }}</span>
            </div>
          </div>
          @endif
          @if($recipe->difficulty)
          <div class="recipe-meta-pill">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="16" height="16"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26 12,2"/></svg>
            <div>
              <span class="recipe-meta-pill__label">Difficulty</span>
              <span class="recipe-meta-pill__value">{{ $recipe->difficulty_label }}</span>
            </div>
          </div>
          @endif
        </div>
      </div>

      {{-- Right: content --}}
      <div class="recipe-section__content">
        <div class="recipe-section__tag">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M3 11l19-9-9 19-2-8-8-2z"/></svg>
          Recipe
        </div>

        <h2 class="recipe-section__title">{{ $recipe->title }}</h2>

        @if($recipe->short_description)
          <p class="recipe-section__desc">{{ $recipe->short_description }}</p>
        @endif

        {{-- Ingredients preview --}}
        @php $ingredientsList = $recipe->ingredients_list; @endphp
        @if(!empty($ingredientsList))
        <div class="recipe-ingredients">
          <h3 class="recipe-ingredients__heading">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            Ingredients
          </h3>
          <ul class="recipe-ingredients__list">
            @foreach(array_slice($ingredientsList, 0, 6) as $ingredient)
              <li class="recipe-ingredients__item">
                <span class="recipe-ingredients__dot" aria-hidden="true"></span>
                {{ $ingredient }}
              </li>
            @endforeach
            @if(count($ingredientsList) > 6)
              <li class="recipe-ingredients__more">
                + {{ count($ingredientsList) - 6 }} more ingredients…
              </li>
            @endif
          </ul>
        </div>
        @endif

        {{-- Instructions preview --}}
        @php $steps = $recipe->instructions_list; @endphp
        @if(!empty($steps))
        <div class="recipe-steps">
          <h3 class="recipe-steps__heading">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
            How to Make It
          </h3>
          <ol class="recipe-steps__list">
            @foreach(array_slice($steps, 0, 3) as $step)
              <li class="recipe-steps__item">{{ $step }}</li>
            @endforeach
          </ol>
          @if(count($steps) > 3)
            <p class="recipe-steps__more">{{ count($steps) - 3 }} more steps in the full recipe…</p>
          @endif
        </div>
        @endif

        @if($recipe->chef_notes)
        <div class="recipe-chef-note">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18" aria-hidden="true"><path d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
          <div>
            <strong>Chef's Note:</strong>
            {{ Str::limit($recipe->chef_notes, 140) }}
          </div>
        </div>
        @endif

        <div class="recipe-section__actions">
          <a href="{{ route('recipes.show', $recipe->slug) }}" class="btn btn--primary">
            View Full Recipe
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </a>
          <a href="{{ route('recipes.index') }}" class="btn btn--outline">All Recipes</a>
        </div>
      </div>

    </div>
  </section>
  @endif

  {{-- ══════════════════════════════════════════════
       RELATED PRODUCTS
  ══════════════════════════════════════════════ --}}
  @if($relatedProducts->isNotEmpty())
  <section class="related-section">
    <div class="section-header section-header--left">
      <h2 class="section-heading">You May Also Like</h2>
      <span class="gold-rule" aria-hidden="true"></span>
    </div>
    <div class="product-grid-4">
      @foreach($relatedProducts as $related)
        <article class="product-card">
          <a class="product-card__link" href="{{ route('products.show', $related->slug) }}" aria-label="{{ $related->name }}"></a>
          <div class="product-card__image-wrap">
            <img src="{{ $related->image ? Storage::url($related->image) : 'https://placehold.co/600x600/f3e2c7/5a3e2b?text='.urlencode($related->name) }}"
                 alt="{{ $related->name }}" loading="lazy" />
            @if($related->badge)
              <span class="product-card__badge badge">{{ $related->badge }}</span>
            @endif
          </div>
          <div class="product-card__body">
            <h3 class="product-card__name">{{ $related->name }}</h3>
            <p class="product-card__price">{{ $related->display_price }}</p>
            <button class="btn btn--cream btn--full"
                    data-product="{{ $related->name }}"
                    data-price="{{ (int)($related->sale_price ?? $related->price) }}">{{ $related->cart_button_text }}</button>
          </div>
        </article>
      @endforeach
    </div>
  </section>
  @endif

@endsection

@push('styles')
<style>
/* ═══════════════════════════════════════════════
   PRODUCT INFO PANEL REDESIGN
═══════════════════════════════════════════════ */

/* Override global gap — tighter stacking */
.product-info { gap: 0 !important; display: flex; flex-direction: column; }

/* Top: breadcrumb + badge */
.pi-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  margin-bottom: 16px;
  flex-wrap: wrap;
}
.pi-badge {
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .06em;
  padding: 4px 10px;
  border-radius: 20px;
  white-space: nowrap;
}

/* Header: title + desc */
.pi-header { margin-bottom: 20px; }
.pi-header .product-info__title { margin-bottom: 10px; }
.pi-header .product-info__desc  { margin: 0; }

/* Price row */
.pi-price-row {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 20px;
  flex-wrap: wrap;
}
.pi-price { display: flex; align-items: baseline; gap: 10px; }
.pi-price__regular {
  font-size: 2rem;
  font-weight: 800;
  color: #5a3e2b;
}
.pi-price__sale {
  font-size: 2rem;
  font-weight: 800;
  color: #c8323c;
}
.pi-price__original {
  font-size: 1.1rem;
  font-weight: 500;
  color: #aaa;
  text-decoration: line-through;
}
.pi-stock {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  font-weight: 600;
  padding: 4px 12px;
  border-radius: 20px;
}
.pi-stock--in  { background: #f0faf4; color: #2d7a4b; }
.pi-stock--out { background: #fef2f2; color: #b91c1c; }
.pi-stock__dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: currentColor;
  flex-shrink: 0;
}

/* Divider */
.pi-divider {
  height: 1px;
  background: #f0e6d3;
  margin: 20px 0;
}

/* Qty + Add to Cart + Wishlist */
.pi-actions {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
  margin-bottom: 0;
}

.pi-qty {
  display: inline-flex;
  align-items: center;
  gap: 0;
  border: 1.5px solid #e8d9c5;
  border-radius: 10px;
  background: #fff;
  overflow: hidden;
  flex-shrink: 0;
  height: 48px;
}
.pi-qty__btn {
  width: 44px;
  height: 48px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: transparent;
  border: none;
  cursor: pointer;
  color: #5a3e2b;
  transition: background .15s;
  flex-shrink: 0;
}
.pi-qty__btn:hover { background: #fdf5ec; }
.pi-qty__value {
  min-width: 40px;
  text-align: center;
  font-size: 16px;
  font-weight: 700;
  color: #2c1a0e;
  border-left: 1.5px solid #e8d9c5;
  border-right: 1.5px solid #e8d9c5;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  user-select: none;
}

.pi-add-btn {
  flex: 1;
  min-width: 160px;
  height: 48px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  font-size: 15px;
  font-weight: 700;
  letter-spacing: .03em;
}

.pi-wishlist-btn {
  width: 48px;
  height: 48px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1.5px solid #e8d9c5;
  border-radius: 10px;
  background: #fff;
  cursor: pointer;
  color: #5a3e2b;
  transition: border-color .15s, background .15s, color .15s;
  flex-shrink: 0;
}
.pi-wishlist-btn:hover,
.pi-wishlist-btn.is-active {
  border-color: #c8323c;
  color: #c8323c;
  background: #fef2f2;
}
.pi-wishlist-btn.is-active svg { fill: #c8323c; }

/* Delivery info */
.pi-delivery {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
}
.pi-delivery__item {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  background: #fdf8f2;
  border: 1px solid #f0e6d3;
  border-radius: 10px;
  padding: 12px 14px;
}
.pi-delivery__icon {
  width: 34px;
  height: 34px;
  border-radius: 8px;
  background: #fff;
  border: 1px solid #f0e6d3;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  color: #c8a24a;
}
.pi-delivery__label {
  font-size: 13px;
  font-weight: 700;
  color: #2c1a0e;
  margin: 0 0 2px;
  line-height: 1.2;
}
.pi-delivery__sub {
  font-size: 12px;
  color: #8b7355;
  margin: 0;
  line-height: 1.3;
}

/* Recipe teaser link */
.pi-recipe-link {
  display: flex;
  align-items: center;
  gap: 14px;
  background: linear-gradient(135deg, #2c1a0e 0%, #4a2c1a 100%);
  border-radius: 12px;
  padding: 16px 18px;
  text-decoration: none;
  color: #fff;
  transition: transform .2s ease, box-shadow .2s ease;
  position: relative;
  overflow: hidden;
}
.pi-recipe-link::before {
  content: '';
  position: absolute;
  top: -20px;
  right: -20px;
  width: 80px;
  height: 80px;
  border-radius: 50%;
  background: rgba(200,162,74,.15);
  pointer-events: none;
}
.pi-recipe-link:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(44,26,14,.3);
  color: #fff;
}
.pi-recipe-link__icon {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  background: rgba(200,162,74,.2);
  border: 1px solid rgba(200,162,74,.3);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #c8a24a;
  flex-shrink: 0;
}
.pi-recipe-link__body {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 2px;
  min-width: 0;
}
.pi-recipe-link__label {
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .08em;
  color: #c8a24a;
  line-height: 1;
}
.pi-recipe-link__title {
  font-size: 15px;
  font-weight: 700;
  color: #fff;
  line-height: 1.2;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.pi-recipe-link__meta {
  font-size: 12px;
  color: rgba(255,255,255,.55);
  line-height: 1;
}
.pi-recipe-link__arrow {
  color: rgba(255,255,255,.5);
  flex-shrink: 0;
  transition: transform .2s;
}
.pi-recipe-link:hover .pi-recipe-link__arrow { transform: translateX(4px); color: #c8a24a; }

/* SKU */
.pi-sku { font-size: 12px; color: #bbb; margin: 12px 0 0; }

/* ═══════════════════════════════════════════════
   RECIPE SECTION
═══════════════════════════════════════════════ */
.recipe-section {
  padding: 80px clamp(20px, 5.5vw, 80px);
  background: linear-gradient(135deg, #2c1a0e 0%, #5a3e2b 100%);
  color: #fff;
  position: relative;
  overflow: hidden;
}

.recipe-section::before {
  content: '';
  position: absolute;
  top: -60px;
  right: -60px;
  width: 320px;
  height: 320px;
  border-radius: 50%;
  background: rgba(200,162,74,.08);
  pointer-events: none;
}
.recipe-section::after {
  content: '';
  position: absolute;
  bottom: -80px;
  left: 10%;
  width: 200px;
  height: 200px;
  border-radius: 50%;
  background: rgba(200,162,74,.05);
  pointer-events: none;
}

.recipe-section__inner {
  display: grid;
  grid-template-columns: 380px 1fr;
  gap: 64px;
  align-items: start;
  position: relative;
  z-index: 1;
  max-width: 1200px;
  margin: 0 auto;
}

@media (max-width: 900px) {
  .recipe-section__inner { grid-template-columns: 1fr; gap: 40px; }
}

/* Visual column */
.recipe-section__img-wrap {
  border-radius: 20px;
  overflow: hidden;
  aspect-ratio: 4/3;
  box-shadow: 0 20px 60px rgba(0,0,0,.4);
}
.recipe-section__img-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.recipe-section__img-placeholder {
  aspect-ratio: 4/3;
  border-radius: 20px;
  background: rgba(255,255,255,.08);
  border: 1px dashed rgba(255,255,255,.2);
  display: flex;
  align-items: center;
  justify-content: center;
  color: rgba(255,255,255,.3);
}

.recipe-section__meta-pills {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
  margin-top: 20px;
}

.recipe-meta-pill {
  display: flex;
  align-items: center;
  gap: 10px;
  background: rgba(255,255,255,.08);
  border: 1px solid rgba(255,255,255,.12);
  border-radius: 12px;
  padding: 10px 14px;
  color: rgba(255,255,255,.9);
  backdrop-filter: blur(4px);
}
.recipe-meta-pill svg { flex-shrink: 0; color: #c8a24a; }
.recipe-meta-pill__label {
  display: block;
  font-size: 10px;
  text-transform: uppercase;
  letter-spacing: .06em;
  color: rgba(255,255,255,.5);
  line-height: 1;
  margin-bottom: 2px;
}
.recipe-meta-pill__value {
  display: block;
  font-size: 14px;
  font-weight: 700;
  line-height: 1;
}

/* Content column */
.recipe-section__tag {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .1em;
  color: #c8a24a;
  background: rgba(200,162,74,.15);
  border: 1px solid rgba(200,162,74,.3);
  border-radius: 20px;
  padding: 4px 12px;
  margin-bottom: 16px;
}

.recipe-section__title {
  font-family: var(--font-display, 'Fraunces', serif);
  font-size: clamp(1.8rem, 3vw, 2.6rem);
  font-weight: 600;
  color: #fff;
  line-height: 1.1;
  margin: 0 0 16px;
}

.recipe-section__desc {
  font-size: 15px;
  line-height: 1.7;
  color: rgba(255,255,255,.75);
  margin: 0 0 28px;
}

/* Ingredients */
.recipe-ingredients { margin-bottom: 28px; }
.recipe-ingredients__heading,
.recipe-steps__heading {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .06em;
  color: #c8a24a;
  margin-bottom: 14px;
}

.recipe-ingredients__list {
  list-style: none;
  margin: 0;
  padding: 0;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
}

@media (max-width: 560px) { .recipe-ingredients__list { grid-template-columns: 1fr; } }

.recipe-ingredients__item {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  color: rgba(255,255,255,.85);
  line-height: 1.4;
}

.recipe-ingredients__dot {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: #c8a24a;
  flex-shrink: 0;
}

.recipe-ingredients__more {
  font-size: 12px;
  color: rgba(255,255,255,.45);
  font-style: italic;
  grid-column: 1 / -1;
}

/* Steps */
.recipe-steps { margin-bottom: 24px; }

.recipe-steps__list {
  margin: 0;
  padding: 0;
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 10px;
  counter-reset: steps;
}

.recipe-steps__item {
  display: flex;
  gap: 12px;
  font-size: 14px;
  color: rgba(255,255,255,.8);
  line-height: 1.6;
  counter-increment: steps;
}

.recipe-steps__item::before {
  content: counter(steps);
  flex-shrink: 0;
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background: rgba(200,162,74,.25);
  border: 1px solid rgba(200,162,74,.4);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11px;
  font-weight: 800;
  color: #c8a24a;
  margin-top: 2px;
}

.recipe-steps__more {
  font-size: 12px;
  color: rgba(255,255,255,.4);
  font-style: italic;
  margin-top: 6px;
}

/* Chef note */
.recipe-chef-note {
  display: flex;
  gap: 12px;
  align-items: flex-start;
  background: rgba(255,255,255,.06);
  border-left: 3px solid #c8a24a;
  border-radius: 0 10px 10px 0;
  padding: 14px 16px;
  margin-bottom: 28px;
  font-size: 14px;
  color: rgba(255,255,255,.75);
  line-height: 1.6;
}
.recipe-chef-note svg { flex-shrink: 0; margin-top: 2px; color: #c8a24a; }
.recipe-chef-note strong { color: #c8a24a; }

/* Actions */
.recipe-section__actions {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}
.recipe-section__actions .btn--primary {
  display: inline-flex;
  align-items: center;
  gap: 8px;
}
.recipe-section__actions .btn--outline {
  border-color: rgba(255,255,255,.3);
  color: rgba(255,255,255,.8);
}
.recipe-section__actions .btn--outline:hover {
  border-color: #c8a24a;
  color: #c8a24a;
  background: transparent;
}

/* Related section spacing */
.related-section {
  padding: 64px clamp(20px, 5.5vw, 80px);
}
</style>
@endpush

@push('scripts')
<script>
// Gallery thumbnail switcher
document.querySelectorAll('.product-gallery__thumb').forEach(thumb => {
  thumb.addEventListener('click', () => {
    document.querySelectorAll('.product-gallery__thumb').forEach(t => t.classList.remove('product-gallery__thumb--active'));
    thumb.classList.add('product-gallery__thumb--active');
    document.getElementById('mainImage').src = thumb.dataset.full || thumb.src;
  });
});

// Qty picker
let qty = 1;
const qtyValue = document.getElementById('qtyValue');
document.getElementById('qtyMinus')?.addEventListener('click', () => {
  if (qty > 1) { qty--; qtyValue.textContent = qty; }
});
document.getElementById('qtyPlus')?.addEventListener('click', () => {
  qty++;
  qtyValue.textContent = qty;
});

// Add to Cart (detail page — respects qty)
document.getElementById('addToCartBtn')?.addEventListener('click', function () {
  const name  = this.dataset.product || 'Item';
  const price = parseInt(this.dataset.price, 10) || 0;
  if (typeof cart !== 'undefined') {
    cart.add(name, price, qty);
    if (typeof showToast !== 'undefined') showToast(`"${name}" × ${qty} added to cart!`);
  }
  const orig = this.innerHTML;
  this.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="18" height="18"><polyline points="20,6 9,17 4,12"/></svg> Added!';
  this.style.background = '#2d7a4b';
  setTimeout(() => { this.innerHTML = orig; this.style.background = ''; }, 1400);
});

// Wishlist toggle (cosmetic)
document.getElementById('wishlistBtn')?.addEventListener('click', function () {
  this.classList.toggle('is-active');
});
</script>
@endpush
