<article class="menu-card">
  <div class="menu-card__img">
    <a href="{{ route('menu.show', $item->slug) }}">
      <img src="{{ $item->featured_image ? Storage::url($item->featured_image) : 'https://placehold.co/400x300/f3e2c7/5a3e2b?text='.urlencode($item->name) }}"
           alt="{{ $item->name }}" loading="lazy" />
    </a>
    @if($item->is_featured || $item->is_bestseller || $item->is_chef_recommended || $item->is_seasonal)
      <div class="menu-card__badges">
        @if($item->is_chef_recommended)<span class="menu-card__badge menu-card__badge--chef">Chef's Pick</span>@endif
        @if($item->is_bestseller)<span class="menu-card__badge menu-card__badge--bestseller">Bestseller</span>@endif
        @if($item->is_featured)<span class="menu-card__badge menu-card__badge--featured">Featured</span>@endif
        @if($item->is_seasonal)<span class="menu-card__badge menu-card__badge--seasonal">Seasonal</span>@endif
      </div>
    @endif
  </div>
  <div class="menu-card__body">
    <p class="menu-card__cat">{{ $item->category->name ?? '' }}</p>
    <h3 class="menu-card__name">
      <a href="{{ route('menu.show', $item->slug) }}">{{ $item->name }}</a>
    </h3>
    @if($item->short_description)
      <p class="menu-card__desc">{{ $item->short_description }}</p>
    @endif
    <div class="menu-card__meta">
      @if($item->preparation_time)
        <span style="display:flex;align-items:center;gap:3px;">
          <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="10" cy="10" r="8"/><polyline points="10,5 10,10 13,13"/></svg>
          {{ $item->preparation_time }}
        </span>
      @endif
      @if($item->calories)
        <span>{{ $item->calories }} kcal</span>
      @endif
      @if($item->serving_size)
        <span>{{ $item->serving_size }}</span>
      @endif
    </div>
    <div class="menu-card__footer">
      <div>
        @if($item->discount_price && $item->discount_price < $item->price)
          <span class="menu-card__price">Rs. {{ number_format($item->discount_price, 0) }}</span>
          <span class="menu-card__price-orig">Rs. {{ number_format($item->price, 0) }}</span>
        @else
          <span class="menu-card__price">Rs. {{ number_format($item->price, 0) }}</span>
        @endif
      </div>
      @if(!$item->is_available)
        <span style="font-size:11px;color:#e74c3c;font-weight:600;">Currently Unavailable</span>
      @endif
    </div>
  </div>
</article>
