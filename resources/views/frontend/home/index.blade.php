@extends('frontend.layouts.app')

@section('title', $hp->seo_title ?: 'Azmeer Bakery — Crafted with Love, Delivered Fresh')

@if($hp->seo_description)
@section('meta_description', $hp->seo_description)
@endif

@section('content')

  {{-- ══════════════════════════════════════════════
       HERO SLIDER
       ══════════════════════════════════════════════ --}}
  @if($hp->hero_active)
  <section class="hero {{ $heroSlides->count() > 1 ? 'hero--slider' : '' }}" aria-label="Hero banner" id="heroSlider">
    @if($heroSlides->count())
      @foreach($heroSlides as $i => $slide)
      <div class="hero__slide {{ $i === 0 ? 'hero__slide--active' : '' }}" aria-hidden="{{ $i > 0 ? 'true' : 'false' }}">
        <div class="hero__bg" aria-hidden="true" style="background-image:url('{{ $slide->image ? Storage::url($slide->image) : asset('storage/figma/hero.jpg') }}')">
          <div class="hero__overlay"></div>
        </div>
        <div class="hero__content">
          <h1 class="hero__title">{{ $slide->title }}</h1>
          @if($slide->subtitle)
            <p class="hero__subtitle">{{ $slide->subtitle }}</p>
          @endif
          <div class="hero__actions">
            <a href="{{ $slide->btn1_url }}" class="btn btn--primary">{{ $slide->btn1_text }}</a>
            @if($slide->btn2_text)
              <a href="{{ $slide->btn2_url }}" class="btn btn--outline">{{ $slide->btn2_text }}</a>
            @endif
          </div>
        </div>
      </div>
      @endforeach
      @if($heroSlides->count() > 1)
      <div class="hero__dots" aria-label="Slide navigation">
        @foreach($heroSlides as $i => $slide)
          <button class="hero__dot {{ $i === 0 ? 'hero__dot--active' : '' }}" data-slide="{{ $i }}" aria-label="Go to slide {{ $i + 1 }}"></button>
        @endforeach
      </div>
      @endif
    @else
      {{-- Fallback: static hero with Figma design image --}}
      <div class="hero__slide hero__slide--active">
        <div class="hero__bg" aria-hidden="true" style="background-image:url('{{ asset('storage/figma/hero.jpg') }}')">
          <div class="hero__overlay"></div>
        </div>
        <div class="hero__content">
          <h1 class="hero__title">Crafted with Love,<br>Delivered Fresh</h1>
          <p class="hero__subtitle">Bringing the authentic taste of tradition fused with modern craftsmanship to your celebrations.</p>
          <div class="hero__actions">
            <a href="{{ route('products.listing') }}" class="btn btn--primary">Shop Now</a>
            <a href="{{ route('menu.index') }}" class="btn btn--outline">View Menu</a>
          </div>
        </div>
      </div>
    @endif
  </section>
  @endif

  {{-- ══════════════════════════════════════════════
       EXPLORE CATEGORIES
       ══════════════════════════════════════════════ --}}
  @if($hp->categories_active)
  @php
  $categoryImages = [
    'sweets'      => asset('storage/figma/cat-sweets.jpg'),
    'pizza'       => asset('storage/figma/cat-pizza.jpg'),
    'snacks'      => asset('storage/figma/cat-snacks.jpg'),
    'dairy'       => asset('storage/figma/cat-dairy.jpg'),
    'coffee-tea'  => asset('storage/figma/cat-coffee-tea.jpg'),
    'juices'      => asset('storage/figma/cat-juices.jpg'),
    'shakes'      => asset('storage/figma/cat-shakes.jpg'),
    'ice-cream'   => asset('storage/figma/cat-ice-cream.jpg'),
    'salad-chaat' => asset('storage/figma/cat-salad.jpg'),
    'fried-items' => asset('storage/figma/cat-fried.jpg'),
    'fast-food'   => asset('storage/figma/cat-fastfood.jpg'),
    'deals'       => asset('storage/figma/cat-deals.jpg'),
  ];
  @endphp
  <section class="category-section" aria-label="Product categories">
    <div class="section-header">
      <h2 class="section-heading">Explore Our Kitchen</h2>
      <span class="gold-rule gold-rule--center" aria-hidden="true"></span>
    </div>
    <div class="category-grid">
      <div class="category-row">
        @foreach([['sweets','Sweets'],['pizza','Pizza'],['snacks','Snacks'],['dairy','Dairy'],['coffee-tea','Coffee & Tea'],['juices','Juices']] as [$slug, $label])
        <article class="category-card" tabindex="0" role="link" aria-label="{{ $label }}"
                 onclick="window.location='{{ route('products.category', $slug) }}'"
                 style="background-image:url('{{ $categoryImages[$slug] }}')">
          <div class="category-card__overlay" aria-hidden="true"></div>
          <div class="category-card__label">{{ $label }}</div>
        </article>
        @endforeach
      </div>
      <div class="category-row">
        @foreach([['shakes','Shakes'],['ice-cream','Ice Cream & Dessert'],['salad-chaat','Salad & Chaat'],['fried-items','Fried Items'],['fast-food','Fast Food'],['deals','Deals']] as [$slug, $label])
        <article class="category-card" tabindex="0" role="link" aria-label="{{ $label }}"
                 onclick="window.location='{{ route('products.category', $slug) }}'"
                 style="background-image:url('{{ $categoryImages[$slug] }}')">
          <div class="category-card__overlay" aria-hidden="true"></div>
          <div class="category-card__label">{{ $label }}</div>
        </article>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  {{-- ══════════════════════════════════════════════
       BESTSELLERS
       ══════════════════════════════════════════════ --}}
  @php
  $fallbackBestsellers = [
    ['name' => 'Gulab Jamun Cheesecake', 'price' => 'Rs. 2,450', 'badge' => 'BESTSELLER', 'img' => asset('storage/figma/bs-gulab-jamun.jpg'),   'slug' => 'gulab-jamun-cheesecake'],
    ['name' => 'Saffron Cardamom Cake',  'price' => 'Rs. 3,200', 'badge' => null,          'img' => asset('storage/figma/bs-saffron-cake.jpg'),   'slug' => 'saffron-cardamom-cake'],
    ['name' => 'Pistachio Rose Pastry',  'price' => 'Rs. 450',   'badge' => 'NEW',         'img' => asset('storage/figma/bs-pistachio-rose.jpg'), 'slug' => 'pistachio-rose-pastry'],
    ['name' => 'Nutella Fudge Cake',     'price' => 'Rs. 2,800', 'badge' => null,          'img' => asset('storage/figma/bs-nutella-fudge.jpg'),  'slug' => 'nutella-fudge-cake'],
  ];
  @endphp
  @if($hp->bestsellers_active)
  <section class="bestsellers-section" aria-label="Bestselling products">
    <div class="section-header section-header--left">
      <h2 class="section-heading">{{ $hp->bestsellers_heading }}</h2>
      @if($hp->bestsellers_subheading)
        <p class="section-subheading">{{ $hp->bestsellers_subheading }}</p>
      @endif
      <span class="gold-rule" aria-hidden="true"></span>
    </div>
    <div class="product-grid-4">
      @if($featuredProducts->count())
        @foreach($featuredProducts as $product)
          <article class="product-card">
            <a class="product-card__link" href="{{ route('products.show', $product->slug) }}" aria-label="{{ $product->name }}"></a>
            <div class="product-card__image-wrap">
              <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('storage/figma/bs-gulab-jamun.jpg') }}"
                   alt="{{ $product->name }}" loading="lazy" />
              @if($product->badge)
                <span class="product-card__badge badge">{{ $product->badge }}</span>
              @endif
            </div>
            <div class="product-card__body">
              <h3 class="product-card__name">{{ $product->name }}</h3>
              <div class="product-card__stars" aria-label="5 stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
              <p class="product-card__price">{{ $product->display_price }}</p>
              <button class="btn btn--cream btn--full"
                      data-product="{{ $product->name }}"
                      data-price="{{ (int)($product->sale_price ?? $product->price) }}">{{ $product->cart_button_text }}</button>
            </div>
          </article>
        @endforeach
      @else
        @foreach($fallbackBestsellers as $item)
          <article class="product-card">
            <a class="product-card__link" href="{{ route('products.listing') }}" aria-label="{{ $item['name'] }}"></a>
            <div class="product-card__image-wrap">
              <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}" loading="lazy" />
              @if($item['badge'])
                <span class="product-card__badge badge">{{ $item['badge'] }}</span>
              @endif
            </div>
            <div class="product-card__body">
              <h3 class="product-card__name">{{ $item['name'] }}</h3>
              <div class="product-card__stars" aria-label="5 stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
              <p class="product-card__price">{{ $item['price'] }}</p>
              <button class="btn btn--cream btn--full"
                      data-product="{{ $item['name'] }}"
                      data-price="0">Chef, Make This!</button>
            </div>
          </article>
        @endforeach
      @endif
    </div>
  </section>
  @endif

  {{-- ══════════════════════════════════════════════
       FRESH FROM THE OVEN
       ══════════════════════════════════════════════ --}}
  @php
  $fallbackFresh = [
    ['name' => 'Margherita Pizza',  'desc' => 'San Marzano tomato sauce, mozzarella, and fresh basil.', 'price' => 'Rs. 1,250', 'img' => asset('storage/figma/fresh-margherita.jpg')],
    ['name' => 'Pepperoni Pizza',   'desc' => 'Spicy pepperoni, mozzarella, and a hint of oregano.',    'price' => 'Rs. 1,350', 'img' => asset('storage/figma/fresh-pepperoni.jpg')],
    ['name' => 'BBQ Chicken Pizza', 'desc' => 'Grilled chicken, BBQ sauce, red onion, and cilantro.',  'price' => 'Rs. 1,450', 'img' => asset('storage/figma/fresh-bbq.jpg')],
  ];
  @endphp
  @if($hp->fresh_active)
  <section class="fresh-section" aria-label="Fresh from the oven specials">
    <div class="section-header">
      <h2 class="section-heading">{{ $hp->fresh_heading }}</h2>
      @if($hp->fresh_subheading)
        <p class="section-subheading">{{ $hp->fresh_subheading }}</p>
      @endif
      <span class="gold-rule gold-rule--center" aria-hidden="true"></span>
    </div>
    <div class="fresh-grid">
      @if($freshProducts->count())
        @foreach($freshProducts as $idx => $product)
          @php $freshImgs = [asset('storage/figma/fresh-margherita.jpg'), asset('storage/figma/fresh-pepperoni.jpg'), asset('storage/figma/fresh-bbq.jpg')]; @endphp
          <article class="fresh-card">
            <div class="fresh-card__image">
              <img src="{{ $product->image ? asset('storage/'.$product->image) : ($freshImgs[$idx % 3] ?? $freshImgs[0]) }}"
                   alt="{{ $product->name }}" loading="lazy" />
            </div>
            <div class="fresh-card__body">
              <span class="badge badge--fresh">Fresh From Oven</span>
              <h3 class="fresh-card__name">{{ $product->name }}</h3>
              <p class="fresh-card__desc">{{ Str::limit($product->description, 80) }}</p>
              <p class="fresh-card__price">{{ $product->display_price }}</p>
              <button class="btn btn--cream btn--full"
                      data-product="{{ $product->name }}"
                      data-price="{{ $product->price }}">{{ $product->cart_button_text }}</button>
            </div>
          </article>
        @endforeach
      @else
        @foreach($fallbackFresh as $item)
          <article class="fresh-card">
            <div class="fresh-card__image">
              <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}" loading="lazy" />
            </div>
            <div class="fresh-card__body">
              <span class="badge badge--fresh">Fresh From Oven</span>
              <h3 class="fresh-card__name">{{ $item['name'] }}</h3>
              <p class="fresh-card__desc">{{ $item['desc'] }}</p>
              <p class="fresh-card__price">{{ $item['price'] }}</p>
              <button class="btn btn--cream btn--full"
                      data-product="{{ $item['name'] }}"
                      data-price="{{ (int) filter_var($item['price'], FILTER_SANITIZE_NUMBER_INT) }}">Chef, Make This!</button>
            </div>
          </article>
        @endforeach
      @endif
    </div>
  </section>
  @endif

  {{-- ══════════════════════════════════════════════
       MORE FROM OUR KITCHEN
       ══════════════════════════════════════════════ --}}
  @php
  $kitchenItems = [
    ['name' => 'Garlic Bread',          'desc' => 'Soft, buttery, and aromatic.',                      'price' => 'Rs. 450', 'img' => asset('storage/figma/more-garlic-bread.jpg')],
    ['name' => 'Calzone',               'desc' => 'Folded mozzarella and tomato sauce.',               'price' => 'Rs. 550', 'img' => asset('storage/figma/more-calzone.jpg')],
    ['name' => 'Focaccia',              'desc' => 'Rosemary, sea salt, and olive oil.',                'price' => 'Rs. 480', 'img' => asset('storage/figma/more-focaccia.jpg')],
    ['name' => 'Croissant',             'desc' => 'Flaky, buttery layers.',                            'price' => 'Rs. 320', 'img' => asset('storage/figma/more-croissant.jpg')],
    ['name' => 'Cinnamon Rolls',        'desc' => 'Soft dough with sweet cinnamon glaze.',             'price' => 'Rs. 380', 'img' => asset('storage/figma/more-cinnamon-rolls.jpg')],
    ['name' => 'Chocolate Chip Cookies','desc' => 'Warm, chewy, and full of dark chocolate.',          'price' => 'Rs. 420', 'img' => asset('storage/figma/more-choc-cookies.jpg')],
    ['name' => 'Monkey Bread',          'desc' => 'Pull-apart dough with caramelized sugar.',          'price' => 'Rs. 520', 'img' => asset('storage/figma/more-monkey-bread.jpg')],
    ['name' => 'Stuffed Breadsticks',   'desc' => 'Mozzarella and herbs inside a crispy crust.',      'price' => 'Rs. 480', 'img' => asset('storage/figma/more-breadsticks.jpg')],
  ];
  @endphp
  <section class="more-kitchen-section">
    <div class="section-header">
      <h2 class="section-heading">More From Our Kitchen</h2>
      <p class="section-subheading">Freshly baked favorites to pair with your pizzas</p>
      <span class="gold-rule gold-rule--center" aria-hidden="true"></span>
    </div>
    <div class="more-kitchen-grid">
      @foreach($kitchenItems as $item)
        <article class="kitchen-card">
          <div class="kitchen-card__img">
            <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}" loading="lazy" />
          </div>
          <div class="kitchen-card__body">
            <h3 class="kitchen-card__name">{{ $item['name'] }}</h3>
            <p class="kitchen-card__desc">{{ $item['desc'] }}</p>
            <p class="kitchen-card__price">{{ $item['price'] }}</p>
            <button class="btn btn--cream btn--full"
                    data-product="{{ $item['name'] }}"
                    data-price="{{ (int) filter_var($item['price'], FILTER_SANITIZE_NUMBER_INT) }}">Chef, Make This!</button>
          </div>
        </article>
      @endforeach
    </div>
  </section>

  {{-- ══════════════════════════════════════════════
       ABOUT SECTION
       ══════════════════════════════════════════════ --}}
  @if($hp->about_active && $about && ($about->description || $about->image))
  <section class="about-section">
    <div class="container">
      <div class="about-section__inner">
        @if($about->image)
        <div class="about-section__image">
          <img src="{{ Storage::url($about->image) }}" alt="{{ $about->heading }}" loading="lazy">
        </div>
        @endif
        <div class="about-section__content">
          <div class="section-header section-header--left">
            <h2 class="section-heading">{{ $about->heading }}</h2>
            @if($about->subheading)
              <p class="section-subheading">{{ $about->subheading }}</p>
            @endif
            <span class="gold-rule" aria-hidden="true"></span>
          </div>
          @if($about->description)
            <div class="about-section__text">{!! $about->description !!}</div>
          @endif
          @if($about->stat1_number || $about->stat2_number || $about->stat3_number)
          <div class="about-section__stats">
            @if($about->stat1_number)
            <div class="about-stat">
              <span class="about-stat__number">{{ $about->stat1_number }}</span>
              <span class="about-stat__label">{{ $about->stat1_label }}</span>
            </div>
            @endif
            @if($about->stat2_number)
            <div class="about-stat">
              <span class="about-stat__number">{{ $about->stat2_number }}</span>
              <span class="about-stat__label">{{ $about->stat2_label }}</span>
            </div>
            @endif
            @if($about->stat3_number)
            <div class="about-stat">
              <span class="about-stat__number">{{ $about->stat3_number }}</span>
              <span class="about-stat__label">{{ $about->stat3_label }}</span>
            </div>
            @endif
          </div>
          @endif
          @if($about->btn_text)
            <a href="{{ $about->btn_url ?? '#' }}" class="btn btn--primary" style="margin-top:16px;">{{ $about->btn_text }}</a>
          @endif
        </div>
      </div>
    </div>
  </section>
  @endif

  {{-- ══════════════════════════════════════════════
       PROMOTIONAL BANNERS
       ══════════════════════════════════════════════ --}}
  @if($hp->promos_active && $promoBanners->count())
  <section class="promo-banners-section">
    <div class="container">
      <div class="promo-banners-grid">
        @foreach($promoBanners as $banner)
        <article class="promo-banner-card" @if($banner->image) style="background-image:url('{{ Storage::url($banner->image) }}')" @endif>
          <div class="promo-banner-card__overlay"></div>
          <div class="promo-banner-card__body">
            <h3 class="promo-banner-card__title">{{ $banner->title }}</h3>
            @if($banner->subtitle)
              <p class="promo-banner-card__sub">{{ $banner->subtitle }}</p>
            @endif
            @if($banner->btn_text)
              <a href="{{ $banner->btn_url ?? '#' }}" class="btn btn--primary btn--sm" style="margin-top:12px;">{{ $banner->btn_text }}</a>
            @endif
          </div>
        </article>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  {{-- ══════════════════════════════════════════════
       FEATURED BAKERY PRODUCTS
       ══════════════════════════════════════════════ --}}
  @if($hp->featured_bakery_active && $featuredBakery->count())
  <section class="bestsellers-section featured-bakery-section" aria-label="Featured bakery products">
    <div class="section-header section-header--left">
      <h2 class="section-heading">{{ $hp->featured_bakery_heading }}</h2>
      @if($hp->featured_bakery_subheading)
        <p class="section-subheading">{{ $hp->featured_bakery_subheading }}</p>
      @endif
      <span class="gold-rule" aria-hidden="true"></span>
    </div>
    <div class="product-grid-4">
      @foreach($featuredBakery as $product)
        <article class="product-card">
          <a class="product-card__link" href="{{ route('products.show', $product->slug) }}" aria-label="{{ $product->name }}"></a>
          <div class="product-card__image-wrap">
            <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('storage/figma/bs-gulab-jamun.jpg') }}"
                 alt="{{ $product->name }}" loading="lazy" />
            @if($product->badge)
              <span class="product-card__badge badge">{{ $product->badge }}</span>
            @endif
          </div>
          <div class="product-card__body">
            <h3 class="product-card__name">{{ $product->name }}</h3>
            <p class="product-card__price">{{ $product->display_price }}</p>
            <button class="btn btn--cream btn--full"
                    data-product="{{ $product->name }}"
                    data-price="{{ (int)($product->sale_price ?? $product->price) }}">{{ $product->cart_button_text }}</button>
          </div>
        </article>
      @endforeach
    </div>
  </section>
  @endif

  {{-- ══════════════════════════════════════════════
       FEATURED SWEETS
       ══════════════════════════════════════════════ --}}
  @if($hp->featured_sweets_active && $featuredSweets->count())
  <section class="bestsellers-section featured-sweets-section" aria-label="Featured sweets">
    <div class="section-header section-header--left">
      <h2 class="section-heading">{{ $hp->featured_sweets_heading }}</h2>
      @if($hp->featured_sweets_subheading)
        <p class="section-subheading">{{ $hp->featured_sweets_subheading }}</p>
      @endif
      <span class="gold-rule" aria-hidden="true"></span>
    </div>
    <div class="product-grid-4">
      @foreach($featuredSweets as $product)
        <article class="product-card">
          <a class="product-card__link" href="{{ route('products.show', $product->slug) }}" aria-label="{{ $product->name }}"></a>
          <div class="product-card__image-wrap">
            <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('storage/figma/bs-saffron-cake.jpg') }}"
                 alt="{{ $product->name }}" loading="lazy" />
            @if($product->badge)
              <span class="product-card__badge badge">{{ $product->badge }}</span>
            @endif
          </div>
          <div class="product-card__body">
            <h3 class="product-card__name">{{ $product->name }}</h3>
            <p class="product-card__price">{{ $product->display_price }}</p>
            <button class="btn btn--cream btn--full"
                    data-product="{{ $product->name }}"
                    data-price="{{ (int)($product->sale_price ?? $product->price) }}">{{ $product->cart_button_text }}</button>
          </div>
        </article>
      @endforeach
    </div>
  </section>
  @endif

  {{-- ══════════════════════════════════════════════
       SIGNATURE DISHES
       ══════════════════════════════════════════════ --}}
  @if($hp->signature_active && $signatureDishes->count())
  <section class="signature-section">
    <div class="section-header">
      <h2 class="section-heading">{{ $hp->signature_heading }}</h2>
      @if($hp->signature_subheading)
        <p class="section-subheading">{{ $hp->signature_subheading }}</p>
      @endif
      <span class="gold-rule gold-rule--center" aria-hidden="true"></span>
    </div>
    <div class="signature-grid">
      @foreach($signatureDishes as $dish)
      <article class="signature-card">
        <div class="signature-card__image">
          <img src="{{ $dish->image ? Storage::url($dish->image) : asset('storage/figma/bs-gulab-jamun.jpg') }}"
               alt="{{ $dish->name }}" loading="lazy">
          @if($dish->tag)
            <span class="signature-card__tag">{{ $dish->tag }}</span>
          @endif
        </div>
        <div class="signature-card__body">
          <h3 class="signature-card__name">{{ $dish->name }}</h3>
          @if($dish->description)
            <p class="signature-card__desc">{{ $dish->description }}</p>
          @endif
          @if($dish->price)
            <p class="signature-card__price">Rs. {{ number_format($dish->price, 0) }}</p>
          @endif
        </div>
      </article>
      @endforeach
    </div>
  </section>
  @endif

  {{-- ══════════════════════════════════════════════
       WHY CHOOSE US
       ══════════════════════════════════════════════ --}}
  @if($hp->why_choose_active && $whyChooseFeatures->count())
  <section class="why-choose-section">
    <div class="section-header">
      <h2 class="section-heading">{{ $hp->why_choose_heading }}</h2>
      @if($hp->why_choose_subheading)
        <p class="section-subheading">{{ $hp->why_choose_subheading }}</p>
      @endif
      <span class="gold-rule gold-rule--center" aria-hidden="true"></span>
    </div>
    <div class="why-choose-grid">
      @foreach($whyChooseFeatures as $feature)
      <article class="why-choose-card">
        <div class="why-choose-card__icon">
          @include('frontend.partials.why-choose-icon', ['icon' => $feature->icon_name])
        </div>
        <h3 class="why-choose-card__title">{{ $feature->title }}</h3>
        @if($feature->description)
          <p class="why-choose-card__desc">{{ $feature->description }}</p>
        @endif
      </article>
      @endforeach
    </div>
  </section>
  @endif

  {{-- ══════════════════════════════════════════════
       CTA / PROMO BANNER
       ══════════════════════════════════════════════ --}}
  @if($hp->cta_active && $ctaSections->count())
    @foreach($ctaSections as $cta)
    <section class="promo-banner" aria-label="{{ $cta->title }}" @if($cta->image) style="background-image:url('{{ Storage::url($cta->image) }}')" @endif>
      <div class="promo-banner__inner">
        <div class="promo-banner__text">
          <p class="promo-banner__title">{{ $cta->title }}</p>
          @if($cta->subtitle)
            <p class="promo-banner__subtitle">{{ $cta->subtitle }}</p>
          @endif
        </div>
        @if($cta->btn_text)
          <a href="{{ $cta->btn_url ?? '#' }}" class="btn btn--primary">{{ $cta->btn_text }}</a>
        @endif
      </div>
    </section>
    @endforeach
  @else
  <section class="promo-banner" aria-label="Ramadan Collection">
    <div class="promo-banner__inner">
      <div class="promo-banner__text">
        <p class="promo-banner__title">The Ramadan Collection is Here</p>
        <p class="promo-banner__subtitle">Order for Iftar by 3:00 PM for same-day delivery.</p>
      </div>
      <a href="{{ route('products.category', 'deals') }}" class="btn btn--primary">View Collection</a>
    </div>
  </section>
  @endif

  {{-- ══════════════════════════════════════════════
       TESTIMONIALS — A Slice of Happiness
       ══════════════════════════════════════════════ --}}
  @if($hp->testimonials_active)
  <section class="testimonials-section" aria-label="Customer reviews">
    <div class="section-header">
      <h2 class="section-heading">{{ $hp->testimonials_heading }}</h2>
      <span class="gold-rule gold-rule--center" aria-hidden="true"></span>
    </div>
    <div class="testimonials-grid">
      @forelse($testimonials as $t)
        <article class="testimonial-card">
          <div class="stars stars--lg" aria-label="{{ $t->rating }} stars">
            {!! str_repeat('&#9733;', $t->rating) . str_repeat('&#9734;', 5 - $t->rating) !!}
          </div>
          <p class="testimonial-card__quote">"{{ $t->quote }}"</p>
          <div class="testimonial-card__author">
            @if($t->avatar)
              <img src="{{ Storage::url($t->avatar) }}" alt="{{ $t->customer_name }}" class="testimonial-card__avatar testimonial-card__avatar--img">
            @else
              <div class="testimonial-card__avatar"></div>
            @endif
            <div>
              <span class="testimonial-card__name">{{ $t->customer_name }}</span>
              @if($t->customer_role)
                <span class="testimonial-card__role">{{ $t->customer_role }}</span>
              @endif
            </div>
          </div>
        </article>
      @empty
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
      @endforelse
    </div>
  </section>
  @endif

  {{-- ══════════════════════════════════════════════
       INSTAGRAM FEED
       ══════════════════════════════════════════════ --}}
  <section class="instagram-section">
    <div class="instagram-section__header">
      <h2 class="instagram-section__title">Follow our Story <span>@AzmeerBakery</span></h2>
      <a href="https://www.instagram.com/azmeerbakery" target="_blank" rel="noopener" class="instagram-section__link">View on Instagram</a>
    </div>
    <div class="instagram-grid">
      @if($hp->instagram_active && $instagramPosts->count())
        @foreach($instagramPosts as $post)
        <a class="instagram-post" href="{{ $post->post_url ?? '#' }}" @if($post->post_url) target="_blank" rel="noopener" @endif aria-label="{{ $post->caption ?? 'Instagram post' }}">
          <img src="{{ Storage::url($post->image) }}" alt="{{ $post->caption }}" loading="lazy">
          <div class="instagram-post__overlay">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="28" height="28" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
          </div>
        </a>
        @endforeach
      @else
        @php $instaImgs = ['insta-1','insta-2','insta-3','insta-4','insta-5','insta-6']; @endphp
        @foreach($instaImgs as $img)
        <a class="instagram-post" href="https://www.instagram.com/azmeerbakery" target="_blank" rel="noopener" aria-label="View on Instagram">
          <img src="{{ asset('storage/figma/'.$img.'.jpg') }}" alt="Azmeer Bakery on Instagram" loading="lazy">
          <div class="instagram-post__overlay">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="28" height="28" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
          </div>
        </a>
        @endforeach
      @endif
    </div>
  </section>

@endsection

@if($hp->seo_keywords)
@push('styles')
<meta name="keywords" content="{{ $hp->seo_keywords }}">
@endpush
@endif

@if($hp->og_title || $hp->og_description || $hp->og_image)
@push('styles')
<meta property="og:title"       content="{{ $hp->og_title ?: $hp->seo_title ?: config('app.name') }}">
<meta property="og:description" content="{{ $hp->og_description ?: $hp->seo_description }}">
@if($hp->og_image)<meta property="og:image" content="{{ $hp->og_image }}">@endif
@endpush
@endif

@push('styles')
<style>
/* ── Hero ─────────────────────────────────────────── */
/* Override style.css display:flex so slides fill full width */
.hero { position:relative; overflow:hidden; min-height:600px; display:block !important; width:100%; padding:0 !important; }
.hero__slide { position:absolute; inset:0; width:100%; min-height:600px; opacity:0; transition:opacity .6s ease; pointer-events:none; }
.hero__slide--active { opacity:1; pointer-events:auto; position:relative; width:100%; min-height:600px; display:block; }
.hero__bg { position:absolute; inset:0; width:100%; height:100%; background-size:cover; background-position:center; background-repeat:no-repeat; }
.hero__overlay { position:absolute; inset:0; background:rgba(0,0,0,.32); }
.hero__content { position:relative; z-index:2; max-width:720px; padding:140px clamp(20px,5.5vw,80px) 80px; display:flex; flex-direction:column; gap:32px; }
.hero__title { font-size:72px; font-weight:700; color:#fff; line-height:1; margin:0 0 24px; }
.hero__subtitle { font-size:20px; color:rgba(255,255,255,.9); margin:0 0 32px; line-height:1.5; }
.hero__actions { display:flex; gap:16px; flex-wrap:wrap; }
.hero__dots { position:absolute; bottom:24px; left:50%; transform:translateX(-50%); display:flex; gap:8px; z-index:10; }
.hero__dot { width:10px; height:10px; border-radius:50%; background:rgba(255,255,255,.5); border:none; cursor:pointer; transition:background .2s; }
.hero__dot--active { background:#fff; }
@media(max-width:768px) { .hero__content { padding:80px 24px; } .hero__title { font-size:42px; } }

/* ── Categories ─────────────────────────────────── */
.category-card {
  background-size:cover;
  background-position:center;
  cursor:pointer;
}
.category-card__overlay {
  position:absolute;
  inset:0;
  background:rgba(0,0,0,.18);
  border-radius:inherit;
  transition:background .2s;
}
.category-card:hover .category-card__overlay { background:rgba(0,0,0,.32); }

/* ── Product card stars ─────────────────────────── */
.product-card__stars { color:#c8a24a; font-size:12px; margin:4px 0 2px; letter-spacing:1px; }

/* ── Fresh From Oven — circular images ─────────── */
.fresh-card__image {
  width:280px;
  height:280px;
  border-radius:50%;
  overflow:hidden;
  margin:0 auto 24px;
  flex-shrink:0;
}
.fresh-card__image img {
  width:100%;
  height:100%;
  object-fit:cover;
}
.fresh-card {
  display:flex;
  flex-direction:column;
  align-items:center;
  text-align:center;
}
.fresh-grid {
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:48px;
  max-width:1200px;
  margin:48px auto 0;
  padding:0 24px;
}
@media(max-width:900px) { .fresh-grid { grid-template-columns:1fr; } .fresh-card__image { width:220px; height:220px; } }

/* ── More From Kitchen ──────────────────────────── */
.more-kitchen-section { padding:80px 24px; max-width:1280px; margin:0 auto; }
.more-kitchen-grid {
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:24px;
  margin-top:48px;
}
.kitchen-card { display:flex; flex-direction:column; align-items:center; text-align:center; gap:12px; }
.kitchen-card__img { width:100%; aspect-ratio:4/3; border-radius:12px; overflow:hidden; }
.kitchen-card__img img { width:100%; height:100%; object-fit:cover; transition:transform .4s; border-radius:12px; }
.kitchen-card:hover .kitchen-card__img img { transform:scale(1.05); }
.kitchen-card__name  { font-size:18px; font-weight:700; color:#5a3e2b; margin:0; }
.kitchen-card__desc  { font-size:13px; color:rgba(90,62,43,.6); margin:0; }
.kitchen-card__price { font-size:16px; font-weight:700; color:#5a3e2b; margin:0; }
@media(max-width:900px) { .more-kitchen-grid { grid-template-columns:repeat(2,1fr); } }
@media(max-width:480px) { .more-kitchen-grid { grid-template-columns:1fr; } }

/* ── Instagram section ──────────────────────────── */
.instagram-section { padding:64px 80px; max-width:1440px; margin:0 auto; }
.instagram-section__header { display:flex; align-items:center; justify-content:space-between; margin-bottom:32px; }
.instagram-section__title { font-size:28px; font-weight:600; color:#5a3e2b; margin:0; }
.instagram-section__title span { font-style:italic; }
.instagram-section__link { font-size:14px; font-weight:700; color:#c8a24a; text-decoration:none; }
.instagram-grid { display:grid; grid-template-columns:repeat(6,1fr); gap:16px; }
.instagram-post { display:block; position:relative; aspect-ratio:1; overflow:hidden; border-radius:8px; }
.instagram-post img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; transition:transform .4s; }
.instagram-post:hover img { transform:scale(1.08); }
.instagram-post__overlay { position:absolute; inset:0; background:rgba(0,0,0,.35); display:flex; align-items:center; justify-content:center; opacity:0; transition:opacity .2s; color:#fff; }
.instagram-post:hover .instagram-post__overlay { opacity:1; }
@media(max-width:900px) { .instagram-section { padding:48px 24px; } .instagram-grid { grid-template-columns:repeat(3,1fr); } }
@media(max-width:480px) { .instagram-grid { grid-template-columns:repeat(2,1fr); } }

/* ── About, Promo Banners, Signature, Why Choose ── */
.about-section { padding:64px 0; }
.about-section__inner { display:grid; grid-template-columns:1fr 1fr; gap:48px; align-items:center; max-width:1200px; margin:0 auto; padding:0 24px; }
.about-section__image img { width:100%; border-radius:12px; object-fit:cover; max-height:480px; }
.about-section__text { font-size:15px; line-height:1.8; color:#555; margin-top:16px; }
.about-section__stats { display:flex; gap:32px; margin-top:24px; padding-top:24px; border-top:1px solid var(--border-color, #e9e0d5); }
.about-stat { text-align:center; }
.about-stat__number { display:block; font-size:32px; font-weight:800; color:var(--clr-gold, #c8a24a); }
.about-stat__label  { font-size:12px; color:#777; margin-top:4px; display:block; }
@media(max-width:768px) { .about-section__inner { grid-template-columns:1fr; } }

.promo-banners-section { padding:40px 0; }
.promo-banners-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:20px; max-width:1200px; margin:0 auto; padding:0 24px; }
.promo-banner-card { min-height:220px; border-radius:12px; background:#5a3e2b center/cover no-repeat; position:relative; overflow:hidden; display:flex; align-items:flex-end; }
.promo-banner-card__overlay { position:absolute; inset:0; background:linear-gradient(to top, rgba(0,0,0,.7) 0%, rgba(0,0,0,.1) 60%); }
.promo-banner-card__body { position:relative; padding:24px; color:#fff; }
.promo-banner-card__title { font-size:22px; font-weight:700; line-height:1.3; }
.promo-banner-card__sub   { font-size:14px; opacity:.85; margin-top:6px; }

.signature-section { padding:64px 24px; max-width:1200px; margin:0 auto; }
.signature-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:24px; margin-top:32px; }
.signature-card { border-radius:12px; overflow:hidden; background:#fff; box-shadow:0 2px 12px rgba(0,0,0,.08); transition:transform .2s, box-shadow .2s; }
.signature-card:hover { transform:translateY(-4px); box-shadow:0 8px 24px rgba(0,0,0,.12); }
.signature-card__image { position:relative; padding-top:80%; overflow:hidden; }
.signature-card__image img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; transition:transform .4s; }
.signature-card:hover .signature-card__image img { transform:scale(1.05); }
.signature-card__tag { position:absolute; top:12px; right:12px; background:var(--clr-gold,#c8a24a); color:#fff; font-size:11px; font-weight:700; padding:3px 10px; border-radius:20px; }
.signature-card__body { padding:16px; }
.signature-card__name  { font-size:16px; font-weight:700; color:var(--clr-brown,#5a3e2b); }
.signature-card__desc  { font-size:13px; color:#777; margin-top:6px; line-height:1.5; }
.signature-card__price { font-size:15px; font-weight:700; color:var(--clr-gold,#c8a24a); margin-top:8px; }

.why-choose-section { padding:64px 24px; background:var(--clr-cream,#fff6e5); text-align:center; }
.why-choose-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:24px; max-width:1200px; margin:32px auto 0; }
.why-choose-card { padding:32px 20px; background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,.06); }
.why-choose-card__icon { width:56px; height:56px; margin:0 auto 16px; background:var(--clr-cream,#fff6e5); border-radius:14px; display:flex; align-items:center; justify-content:center; color:var(--clr-gold,#c8a24a); }
.why-choose-card__title { font-size:15px; font-weight:700; color:var(--clr-brown,#5a3e2b); }
.why-choose-card__desc  { font-size:13px; color:#777; margin-top:8px; line-height:1.6; }

.testimonial-card__avatar--img { width:40px; height:40px; border-radius:50%; object-fit:cover; }
.testimonial-card__role { display:block; font-size:12px; color:var(--clr-muted,#777); }
</style>
@endpush

@push('scripts')
<script>
(function () {
  const slider = document.getElementById('heroSlider');
  if (!slider) return;
  const slides = slider.querySelectorAll('.hero__slide');
  const dots   = slider.querySelectorAll('.hero__dot');
  if (slides.length <= 1) return;
  let current = 0;
  function goTo(n) {
    slides[current].classList.remove('hero__slide--active');
    dots[current]?.classList.remove('hero__dot--active');
    slides[current].setAttribute('aria-hidden', 'true');
    current = (n + slides.length) % slides.length;
    slides[current].classList.add('hero__slide--active');
    dots[current]?.classList.add('hero__dot--active');
    slides[current].setAttribute('aria-hidden', 'false');
  }
  dots.forEach((dot, i) => dot.addEventListener('click', () => goTo(i)));
  const timer = setInterval(() => goTo(current + 1), 5000);
  slider.addEventListener('mouseenter', () => clearInterval(timer));
}());
</script>
@endpush
