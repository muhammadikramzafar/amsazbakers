@extends('frontend.layouts.app')

@section('title', 'Azmeer Bakery — Crafted with Love, Delivered Fresh')

@section('content')

  <!-- HERO -->
  <section class="hero" aria-label="Hero banner">
    <div class="hero__bg" aria-hidden="true">
      <div class="hero__overlay"></div>
    </div>
    <div class="hero__content">
      <h1 class="hero__title">Crafted with Love, Delivered Fresh</h1>
      <p class="hero__subtitle">Bringing the authentic taste of tradition fused with modern craftsmanship to your celebrations.</p>
      <div class="hero__actions">
        <a href="{{ route('products.listing') }}" class="btn btn--primary">Shop Now</a>
        <a href="{{ route('products.listing') }}" class="btn btn--outline">View Menu</a>
      </div>
    </div>
  </section>

  <!-- EXPLORE CATEGORIES -->
  <section class="category-section" aria-label="Product categories">
    <div class="section-header">
      <h2 class="section-heading">Explore Our Kitchen</h2>
      <span class="gold-rule gold-rule--center" aria-hidden="true"></span>
    </div>
    <div class="category-grid">
      <div class="category-row">
        @foreach([['sweets','Sweets'],['pizza','Pizza'],['snacks','Snacks'],['dairy','Dairy'],['coffee-tea','Coffee &amp; Tea'],['juices','Juices']] as [$slug, $label])
        <article class="category-card" tabindex="0" role="link" aria-label="{{ $label }}"
                 onclick="window.location='{{ route('products.category', $slug) }}'">
          <div class="category-card__overlay" aria-hidden="true"></div>
          <div class="category-card__label">{{ $label }}</div>
        </article>
        @endforeach
      </div>
      <div class="category-row">
        @foreach([['shakes','Shakes'],['ice-cream','Ice Cream &amp; Dessert'],['salad-chaat','Salad &amp; Chaat'],['fried-items','Fried Items'],['fast-food','Fast Food'],['deals','Deals']] as [$slug, $label])
        <article class="category-card" tabindex="0" role="link" aria-label="{{ $label }}"
                 onclick="window.location='{{ route('products.category', $slug) }}'">
          <div class="category-card__overlay" aria-hidden="true"></div>
          <div class="category-card__label">{{ $label }}</div>
        </article>
        @endforeach
      </div>
    </div>
  </section>

  <!-- BESTSELLERS -->
  <section class="bestsellers-section" aria-label="Bestselling products">
    <div class="section-header section-header--left">
      <h2 class="section-heading">Bestsellers</h2>
      <p class="section-subheading">Our most loved creations</p>
      <span class="gold-rule" aria-hidden="true"></span>
    </div>
    <div class="product-grid-4">
      @forelse($featuredProducts as $product)
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
            <h3 class="product-card__name">
              <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
            </h3>
            <p class="product-card__price">{{ $product->display_price }}</p>
            <button class="btn btn--cream btn--full">Add to Cart</button>
          </div>
        </article>
      @empty
        <article class="product-card">
          <div class="product-card__image-wrap">
            <img src="https://placehold.co/600x600/f3e2c7/5a3e2b?text=Gulab+Jamun+Cheesecake" alt="Gulab Jamun Cheesecake" loading="lazy" />
            <span class="product-card__badge badge">Bestseller</span>
          </div>
          <div class="product-card__body">
            <h3 class="product-card__name">Gulab Jamun Cheesecake</h3>
            <p class="product-card__price">Rs. 2,450</p>
            <button class="btn btn--cream btn--full">Add to Cart</button>
          </div>
        </article>
        <article class="product-card">
          <div class="product-card__image-wrap">
            <img src="https://placehold.co/600x600/f3e2c7/5a3e2b?text=Saffron+Cardamom+Cake" alt="Saffron Cardamom Cake" loading="lazy" />
          </div>
          <div class="product-card__body">
            <h3 class="product-card__name">Saffron Cardamom Cake</h3>
            <p class="product-card__price">Rs. 3,200</p>
            <button class="btn btn--cream btn--full">Add to Cart</button>
          </div>
        </article>
        <article class="product-card">
          <div class="product-card__image-wrap">
            <img src="https://placehold.co/600x600/f3e2c7/5a3e2b?text=Pistachio+Rose+Pastry" alt="Pistachio Rose Pastry" loading="lazy" />
            <span class="product-card__badge badge">New</span>
          </div>
          <div class="product-card__body">
            <h3 class="product-card__name">Pistachio Rose Pastry</h3>
            <p class="product-card__price">Rs. 450</p>
            <button class="btn btn--cream btn--full">Add to Cart</button>
          </div>
        </article>
        <article class="product-card">
          <div class="product-card__image-wrap">
            <img src="https://placehold.co/600x600/f3e2c7/5a3e2b?text=Nutella+Fudge+Cake" alt="Nutella Fudge Cake" loading="lazy" />
          </div>
          <div class="product-card__body">
            <h3 class="product-card__name">Nutella Fudge Cake</h3>
            <p class="product-card__price">Rs. 2,800</p>
            <button class="btn btn--cream btn--full">Add to Cart</button>
          </div>
        </article>
      @endforelse
    </div>
  </section>

  <!-- FRESH FROM THE OVEN -->
  <section class="fresh-section" aria-label="Fresh from the oven specials">
    <div class="section-header">
      <h2 class="section-heading">Fresh From The Oven</h2>
      <p class="section-subheading">Today's special spotlights</p>
      <span class="gold-rule gold-rule--center" aria-hidden="true"></span>
    </div>
    <div class="fresh-grid">
      @forelse($freshProducts as $product)
        <article class="fresh-card">
          <div class="fresh-card__image">
            <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://placehold.co/600x400/f3e2c7/5a3e2b?text='.urlencode($product->name) }}"
                 alt="{{ $product->name }}" loading="lazy" />
          </div>
          <div class="fresh-card__body">
            <span class="badge badge--fresh">Fresh From Oven</span>
            <h3 class="fresh-card__name">{{ $product->name }}</h3>
            <p class="fresh-card__desc">{{ Str::limit($product->description, 80) }}</p>
            <p class="fresh-card__price">{{ $product->display_price }}</p>
            <button class="btn btn--cream btn--full">Add to Cart</button>
          </div>
        </article>
      @empty
        <article class="fresh-card">
          <div class="fresh-card__image"><img src="https://placehold.co/600x400/f3e2c7/5a3e2b?text=Margherita+Pizza" alt="Margherita Pizza" loading="lazy" /></div>
          <div class="fresh-card__body">
            <span class="badge badge--fresh">Fresh From Oven</span>
            <h3 class="fresh-card__name">Margherita Pizza</h3>
            <p class="fresh-card__desc">San Marzano tomato sauce, mozzarella, and fresh basil.</p>
            <p class="fresh-card__price">Rs. 1,250</p>
            <button class="btn btn--cream btn--full">Add to Cart</button>
          </div>
        </article>
        <article class="fresh-card">
          <div class="fresh-card__image"><img src="https://placehold.co/600x400/f3e2c7/5a3e2b?text=Pepperoni+Pizza" alt="Pepperoni Pizza" loading="lazy" /></div>
          <div class="fresh-card__body">
            <span class="badge badge--fresh">Fresh From Oven</span>
            <h3 class="fresh-card__name">Pepperoni Pizza</h3>
            <p class="fresh-card__desc">Spicy pepperoni, mozzarella, and a hint of oregano.</p>
            <p class="fresh-card__price">Rs. 1,350</p>
            <button class="btn btn--cream btn--full">Add to Cart</button>
          </div>
        </article>
        <article class="fresh-card">
          <div class="fresh-card__image"><img src="https://placehold.co/600x400/f3e2c7/5a3e2b?text=BBQ+Chicken+Pizza" alt="BBQ Chicken Pizza" loading="lazy" /></div>
          <div class="fresh-card__body">
            <span class="badge badge--fresh">Fresh From Oven</span>
            <h3 class="fresh-card__name">BBQ Chicken Pizza</h3>
            <p class="fresh-card__desc">Grilled chicken, BBQ sauce, red onion, and cilantro.</p>
            <p class="fresh-card__price">Rs. 1,450</p>
            <button class="btn btn--cream btn--full">Add to Cart</button>
          </div>
        </article>
      @endforelse
    </div>
  </section>

  <!-- PROMO BANNER -->
  <section class="promo-banner" aria-label="Promotion">
    <div class="promo-banner__inner">
      <div class="promo-banner__text">
        <p class="promo-banner__title">Special Deals Collection</p>
        <p class="promo-banner__subtitle">Order before 3:00 PM for same-day delivery.</p>
      </div>
      <a href="{{ route('products.category', 'deals') }}" class="btn btn--primary">View Deals</a>
    </div>
  </section>

  <!-- TESTIMONIALS -->
  <section class="testimonials-section" aria-label="Customer reviews">
    <div class="section-header">
      <h2 class="section-heading">A Slice of Happiness</h2>
      <span class="gold-rule gold-rule--center" aria-hidden="true"></span>
    </div>
    <div class="testimonials-grid">
      <article class="testimonial-card">
        <div class="stars stars--lg" aria-label="5 stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <p class="testimonial-card__quote">"The Gulab Jamun Cheesecake was the star of our dinner party. Absolutely sublime and unique!"</p>
        <div class="testimonial-card__author">
          <div class="testimonial-card__avatar"></div>
          <span class="testimonial-card__name">Sarah Mansoor</span>
        </div>
      </article>
      <article class="testimonial-card">
        <div class="stars stars--lg" aria-label="5 stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <p class="testimonial-card__quote">"Every cake is a masterpiece. Ordered for my wedding anniversary and everyone was blown away!"</p>
        <div class="testimonial-card__author">
          <div class="testimonial-card__avatar"></div>
          <span class="testimonial-card__name">Ahmed Raza</span>
        </div>
      </article>
      <article class="testimonial-card">
        <div class="stars stars--lg" aria-label="5 stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <p class="testimonial-card__quote">"Fast delivery and gorgeous packaging. The Pistachio Rose Pastry is my weekly indulgence!"</p>
        <div class="testimonial-card__author">
          <div class="testimonial-card__avatar"></div>
          <span class="testimonial-card__name">Nadia Khan</span>
        </div>
      </article>
    </div>
  </section>

@endsection
