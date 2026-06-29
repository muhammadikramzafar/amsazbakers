@extends('frontend.layouts.app')

@section('title', 'Recipes — Azmeer Bakery')
@section('meta_description', 'Discover delicious recipes from Azmeer Bakery — from classic Pakistani sweets to artisan breads, cakes and seasonal specials.')

@section('content')

{{-- ── HERO ── --}}
<section class="pg-hero pg-hero--recipes">
  <div class="pg-hero__inner">
    <p class="pg-hero__eyebrow">Step-by-step from our kitchen</p>
    <h1 class="pg-hero__title">Recipes</h1>
    <p class="pg-hero__sub">Bake, cook and create — every recipe perfected in the Azmeer kitchen and shared with love.</p>
  </div>
</section>

<div class="recipes-page-wrap">

  {{-- ── SEARCH + FILTER BAR ── --}}
  <div class="recipes-toolbar">
    <form method="GET" action="{{ route('recipes.index') }}" class="recipes-search-form">
      <div class="recipes-search-wrap">
        <svg class="recipes-search-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18" aria-hidden="true"><circle cx="9" cy="9" r="6"/><path d="m15 15 3 3"/></svg>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search recipes…" class="recipes-search-input" />
        @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}" />@endif
        @if(request('difficulty'))<input type="hidden" name="difficulty" value="{{ request('difficulty') }}" />@endif
      </div>
      <button type="submit" class="btn btn--primary" style="flex-shrink:0;">Search</button>
      @if(request()->hasAny(['search','category','difficulty','featured']))
        <a href="{{ route('recipes.index') }}" class="btn btn--outline" style="flex-shrink:0;">Clear</a>
      @endif
    </form>

    <div class="recipes-filter-pills">
      <a href="{{ route('recipes.index') }}"
         class="rpill {{ !request('category') && !request('difficulty') ? 'rpill--active' : '' }}">All</a>
      @foreach($categories as $cat)
        <a href="{{ route('recipes.index', ['category' => $cat->slug]) }}"
           class="rpill {{ request('category') === $cat->slug ? 'rpill--active' : '' }}">
          {{ $cat->name }}@if($cat->published_count > 0)<sup>{{ $cat->published_count }}</sup>@endif
        </a>
      @endforeach
      <span class="rpill-sep" aria-hidden="true"></span>
      <a href="{{ route('recipes.index', array_merge(request()->except(['difficulty']), ['difficulty' => 'easy'])) }}"
         class="rpill rpill--diff rpill--easy {{ request('difficulty') === 'easy' ? 'rpill--active' : '' }}">Easy</a>
      <a href="{{ route('recipes.index', array_merge(request()->except(['difficulty']), ['difficulty' => 'medium'])) }}"
         class="rpill rpill--diff rpill--medium {{ request('difficulty') === 'medium' ? 'rpill--active' : '' }}">Medium</a>
      <a href="{{ route('recipes.index', array_merge(request()->except(['difficulty']), ['difficulty' => 'hard'])) }}"
         class="rpill rpill--diff rpill--hard {{ request('difficulty') === 'hard' ? 'rpill--active' : '' }}">Hard</a>
    </div>
  </div>

  {{-- ── FEATURED RECIPES ── --}}
  @if($featuredRecipes->isNotEmpty() && !request()->filled('search') && !request()->filled('category') && !request()->filled('difficulty'))
  <div class="recipes-featured">
    <div class="recipes-section-label">
      <svg viewBox="0 0 16 16" fill="#c8a24a" width="14" height="14"><path d="M8 1l1.9 3.8L14 5.6l-3 2.9.7 4.1L8 10.4l-3.7 2.2.7-4.1-3-2.9 4.1-.8z"/></svg>
      Featured Recipes
    </div>
    <div class="rfeatured-grid">
      @foreach($featuredRecipes as $i => $rec)
        <article class="rfc {{ $i === 0 ? 'rfc--hero' : '' }}">
          <a href="{{ route('recipes.show', $rec->slug) }}" class="rfc__img-wrap">
            <img src="{{ $rec->featured_image ? Storage::url($rec->featured_image) : 'https://placehold.co/800x500/3d1a0b/c8a24a?text='.urlencode($rec->title) }}"
                 alt="{{ $rec->title }}" loading="lazy" />
            <div class="rfc__overlay">
              <span class="rfc__cat">{{ $rec->category->name ?? '' }}</span>
              <h2 class="rfc__title">{{ $rec->title }}</h2>
              <div class="rfc__meta">
                @if($rec->total_time)<span>⏱ {{ $rec->total_time }}</span>@endif
                @if($rec->servings)<span>🍽 {{ $rec->servings }} servings</span>@endif
                <span class="diff-pill diff-pill--{{ $rec->difficulty }}">{{ $rec->difficulty_label }}</span>
              </div>
            </div>
          </a>
        </article>
      @endforeach
    </div>
  </div>
  @endif

  {{-- ── RECIPE GRID ── --}}
  @if($recipes->isEmpty())
    <div class="recipes-empty">
      <svg viewBox="0 0 48 48" fill="none" stroke="#ccc" stroke-width="1.5" width="48" height="48"><circle cx="24" cy="24" r="20"/><path d="M16 24h16M24 16v16"/></svg>
      <p>No recipes found.</p>
      <a href="{{ route('recipes.index') }}" class="btn btn--outline">Browse All</a>
    </div>
  @else
    @if($featuredRecipes->isNotEmpty() && !request()->filled('search') && !request()->filled('category') && !request()->filled('difficulty'))
    <div class="recipes-section-label" style="margin-top:48px;">All Recipes</div>
    @endif
    <div class="rcard-grid">
      @foreach($recipes as $rec)
        <article class="rcard">
          <a href="{{ route('recipes.show', $rec->slug) }}" class="rcard__img-wrap">
            <img src="{{ $rec->featured_image ? Storage::url($rec->featured_image) : 'https://placehold.co/600x400/3d1a0b/c8a24a?text='.urlencode($rec->title) }}"
                 alt="{{ $rec->title }}" loading="lazy" />
            @if($rec->is_featured)<span class="rcard__badge">★ Featured</span>@endif
            <span class="diff-pill diff-pill--{{ $rec->difficulty }} rcard__diff">{{ $rec->difficulty_label }}</span>
          </a>
          <div class="rcard__body">
            <p class="rcard__cat">{{ $rec->category->name ?? '' }}</p>
            <h3 class="rcard__title"><a href="{{ route('recipes.show', $rec->slug) }}">{{ $rec->title }}</a></h3>
            @if($rec->short_description)<p class="rcard__desc">{{ Str::limit($rec->short_description, 100) }}</p>@endif
            <div class="rcard__meta">
              @if($rec->total_time)
                <span class="rcard__meta-item">
                  <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="13" height="13"><circle cx="8" cy="8" r="6"/><polyline points="8,4.5 8,8 10.5,10"/></svg>
                  {{ $rec->total_time }}
                </span>
              @endif
              @if($rec->servings)
                <span class="rcard__meta-item">
                  <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="13" height="13"><path d="M5 2v5a3 3 0 0 0 6 0V2"/><line x1="8" y1="9" x2="8" y2="14"/><line x1="5" y1="14" x2="11" y2="14"/></svg>
                  {{ $rec->servings }} servings
                </span>
              @endif
              <a href="{{ route('recipes.show', $rec->slug) }}" class="rcard__cta">View Recipe →</a>
            </div>
          </div>
        </article>
      @endforeach
    </div>
    <div class="pagination" style="margin-top:48px;">{{ $recipes->withQueryString()->links() }}</div>
  @endif

</div>

@endsection

@push('styles')
<style>
.pg-hero {
  position: relative;
  padding: 80px 24px 72px;
  text-align: center;
  background: linear-gradient(135deg, #2b1207 0%, #4a1e08 50%, #3d1a0b 100%);
  overflow: hidden;
}
.pg-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23c8a24a' fill-opacity='0.06'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.pg-hero__inner { position: relative; max-width: 640px; margin: 0 auto; }
.pg-hero__eyebrow { font-size: 13px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: #c8a24a; margin-bottom: 12px; }
.pg-hero__title { font-family: var(--font-display); font-size: clamp(2.4rem, 5vw, 3.5rem); color: #fff; margin-bottom: 16px; line-height: 1.1; }
.pg-hero__sub { font-size: 16px; color: rgba(255,255,255,.65); line-height: 1.6; }

/* ── Page wrap ── */
.recipes-page-wrap { max-width: var(--container-max); margin: 0 auto; padding: 48px clamp(16px,5vw,80px) 80px; }

/* ── Toolbar ── */
.recipes-toolbar { margin-bottom: 36px; }
.recipes-search-form { display: flex; gap: 10px; max-width: 560px; margin-bottom: 20px; }
.recipes-search-wrap { position: relative; flex: 1; }
.recipes-search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #aaa; }
.recipes-search-input { width: 100%; padding: 11px 14px 11px 38px; border: 1.5px solid #ddd6cc; border-radius: 10px; font-size: 14px; background: #fdfaf6; color: var(--clr-brown); font-family: inherit; box-sizing: border-box; }
.recipes-search-input:focus { outline: none; border-color: var(--clr-primary); }

/* ── Filter pills ── */
.recipes-filter-pills { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; }
.rpill {
  display: inline-flex; align-items: center; gap: 4px;
  padding: 6px 16px; border-radius: 24px; font-size: 13px; font-weight: 500;
  border: 1.5px solid #ddd6cc; background: #fff; color: var(--clr-brown);
  text-decoration: none; transition: all .15s; cursor: pointer;
}
.rpill sup { font-size: 10px; opacity: .6; }
.rpill:hover { border-color: var(--clr-primary); color: var(--clr-primary); }
.rpill--active { background: var(--clr-primary); border-color: var(--clr-primary); color: #fff; font-weight: 700; }
.rpill--active:hover { color: #fff; }
.rpill-sep { width: 1px; height: 24px; background: #ddd6cc; margin: 0 4px; }
.rpill--easy.rpill--active   { background: #1a7a47; border-color: #1a7a47; }
.rpill--medium.rpill--active { background: #7a6200; border-color: #7a6200; }
.rpill--hard.rpill--active   { background: #c0392b; border-color: #c0392b; }

/* ── Section label ── */
.recipes-section-label { display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #a08060; margin-bottom: 20px; }

/* ── Featured grid ── */
.recipes-featured { margin-bottom: 24px; }
.rfeatured-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 16px; }
@media (max-width: 760px) { .rfeatured-grid { grid-template-columns: 1fr; } }
.rfc { border-radius: 16px; overflow: hidden; }
.rfc__img-wrap { display: block; position: relative; text-decoration: none; height: 100%; }
.rfc .rfc__img-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .4s; }
.rfc:hover .rfc__img-wrap img { transform: scale(1.04); }
.rfc--hero .rfc__img-wrap { min-height: 360px; }
.rfc .rfc__img-wrap { min-height: 180px; }
.rfc__overlay {
  position: absolute; inset: 0;
  background: linear-gradient(to top, rgba(30,10,3,.85) 0%, rgba(30,10,3,.15) 60%, transparent 100%);
  display: flex; flex-direction: column; justify-content: flex-end; padding: 24px;
}
.rfc__cat { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #c8a24a; margin-bottom: 6px; }
.rfc__title { font-family: var(--font-display); font-size: 1.3rem; color: #fff; line-height: 1.25; margin-bottom: 10px; }
.rfc--hero .rfc__title { font-size: 1.7rem; }
.rfc__meta { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; font-size: 12px; color: rgba(255,255,255,.75); }

/* ── Recipe cards ── */
.rcard-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px,1fr)); gap: 24px; }
.rcard { background: #fff; border: 1px solid #ede8e0; border-radius: 16px; overflow: hidden; transition: transform .2s, box-shadow .2s; }
.rcard:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,.1); }
.rcard__img-wrap { display: block; position: relative; aspect-ratio: 16/10; overflow: hidden; text-decoration: none; }
.rcard__img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.rcard:hover .rcard__img-wrap img { transform: scale(1.05); }
.rcard__badge { position: absolute; top: 10px; left: 10px; background: var(--clr-primary); color: #fff; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 12px; }
.rcard__diff { position: absolute; top: 10px; right: 10px; }
.rcard__body { padding: 18px 20px; }
.rcard__cat { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #b07d30; margin-bottom: 4px; }
.rcard__title { font-family: var(--font-display); font-size: 1.1rem; color: var(--clr-brown); margin-bottom: 6px; line-height: 1.3; }
.rcard__title a { text-decoration: none; color: inherit; }
.rcard__title a:hover { color: var(--clr-primary); }
.rcard__desc { font-size: 13px; color: #888; line-height: 1.55; margin-bottom: 12px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.rcard__meta { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.rcard__meta-item { display: flex; align-items: center; gap: 4px; font-size: 12px; color: #999; }
.rcard__cta { margin-left: auto; font-size: 12px; font-weight: 700; color: var(--clr-primary); text-decoration: none; white-space: nowrap; }
.rcard__cta:hover { text-decoration: underline; }

/* ── Difficulty pills ── */
.diff-pill { display: inline-block; padding: 2px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; }
.diff-pill--easy   { background: #e8f8ef; color: #0a7340; }
.diff-pill--medium { background: #fef9e8; color: #7a6200; }
.diff-pill--hard   { background: #f8e8e8; color: #c0392b; }

.recipes-empty { text-align: center; padding: 80px 24px; color: #aaa; display: flex; flex-direction: column; align-items: center; gap: 16px; }
.recipes-empty p { font-size: 16px; }
</style>
@endpush
