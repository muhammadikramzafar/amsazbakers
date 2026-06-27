@extends('frontend.layouts.app')

@section('title', 'Recipes — Azmeer Bakery')
@section('meta_description', 'Discover delicious recipes from Azmeer Bakery — from classic Pakistani sweets to artisan breads, cakes and seasonal specials.')

@push('styles')
<style>
.recipe-hero-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:24px; margin-bottom:60px; }
@media(max-width:900px){ .recipe-hero-grid { grid-template-columns:1fr 1fr; } }
@media(max-width:560px){ .recipe-hero-grid { grid-template-columns:1fr; } }
.recipe-card { background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.06); transition:transform .2s,box-shadow .2s; position:relative; }
.recipe-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,0,0,.12); }
.recipe-card--featured { grid-column:span 2; }
@media(max-width:560px){ .recipe-card--featured { grid-column:span 1; } }
.recipe-card__img { aspect-ratio:16/9; overflow:hidden; }
.recipe-card--featured .recipe-card__img { aspect-ratio:21/9; }
.recipe-card__img img { width:100%; height:100%; object-fit:cover; transition:transform .4s; }
.recipe-card:hover .recipe-card__img img { transform:scale(1.04); }
.recipe-card__feat-badge { position:absolute; top:12px; left:12px; background:var(--clr-primary); color:#fff; font-size:11px; font-weight:700; padding:3px 10px; border-radius:12px; }
.recipe-card__body { padding:20px; }
.recipe-card__cat { font-size:11px; color:#aaa; text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px; }
.recipe-card__title { font-size:18px; font-weight:700; color:var(--clr-heading); margin-bottom:8px; line-height:1.3; }
.recipe-card__title a { text-decoration:none; color:inherit; }
.recipe-card__title a:hover { color:var(--clr-primary); }
.recipe-card__desc { font-size:13px; color:#777; line-height:1.5; margin-bottom:12px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.recipe-card__meta { display:flex; gap:16px; flex-wrap:wrap; }
.recipe-card__meta-item { display:flex; align-items:center; gap:5px; font-size:12px; color:#999; }
.recipe-card__meta-item svg { width:14px; height:14px; flex-shrink:0; }
.diff-badge { display:inline-block; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:600; }
.diff-easy   { background:#e8f8ef; color:#0a7340; }
.diff-medium { background:#fef9e8; color:#7a6200; }
.diff-hard   { background:#f8e8e8; color:#c0392b; }
.recipe-filters { display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:32px; }
.recipe-cat-btn { padding:7px 18px; border:2px solid var(--clr-border); background:#fff; border-radius:24px; font-size:13px; font-weight:500; cursor:pointer; text-decoration:none; color:inherit; transition:all .2s; }
.recipe-cat-btn:hover, .recipe-cat-btn--active { background:var(--clr-primary); border-color:var(--clr-primary); color:#fff; }
.recipe-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:24px; }
</style>
@endpush

@section('content')

  <!-- PAGE BANNER -->
  <section class="page-banner">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}" class="breadcrumb__link">Home</a>
      <span class="breadcrumb__sep" aria-hidden="true">/</span>
      <span class="breadcrumb__current">Recipes</span>
    </nav>
    <h1 class="page-banner__title">Recipes</h1>
    <span class="gold-rule gold-rule--center" aria-hidden="true"></span>
    <p style="margin-top:12px;color:#888;max-width:480px;margin-left:auto;margin-right:auto;">
      Bake, cook and create — step-by-step recipes straight from the Azmeer kitchen.
    </p>
  </section>

  <div style="max-width:var(--container-max);margin:0 auto;padding:60px var(--container-pad);">

    <!-- FEATURED RECIPES (shown only on default/no-filter view) -->
    @if($featuredRecipes->isNotEmpty() && !request()->filled('search') && !request()->filled('category') && !request()->filled('difficulty'))
    <div style="margin-bottom:60px;">
      <div class="section-header section-header--left">
        <h2 class="section-heading">Featured Recipes</h2>
        <span class="gold-rule" aria-hidden="true"></span>
      </div>
      <div class="recipe-hero-grid" style="margin-top:24px;">
        @foreach($featuredRecipes as $i => $rec)
          <article class="recipe-card {{ $i === 0 ? 'recipe-card--featured' : '' }}" style="position:relative;">
            @if($rec->is_featured)<span class="recipe-card__feat-badge">★ Featured</span>@endif
            <div class="recipe-card__img">
              <a href="{{ route('recipes.show', $rec->slug) }}">
                <img src="{{ $rec->featured_image ? Storage::url($rec->featured_image) : 'https://placehold.co/800x450/f3e2c7/5a3e2b?text='.urlencode($rec->title) }}"
                     alt="{{ $rec->title }}" loading="lazy" />
              </a>
            </div>
            <div class="recipe-card__body">
              <p class="recipe-card__cat">{{ $rec->category->name ?? '' }}</p>
              <h2 class="recipe-card__title"><a href="{{ route('recipes.show', $rec->slug) }}">{{ $rec->title }}</a></h2>
              @if($rec->short_description)<p class="recipe-card__desc">{{ $rec->short_description }}</p>@endif
              <div class="recipe-card__meta">
                @if($rec->total_time)
                  <span class="recipe-card__meta-item">
                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="10" cy="10" r="8"/><polyline points="10,5 10,10 13,13"/></svg>
                    {{ $rec->total_time }}
                  </span>
                @endif
                @if($rec->servings)
                  <span class="recipe-card__meta-item">
                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M10 2c-4.4 0-8 3.6-8 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8z"/><path d="M10 6v4l3 2"/></svg>
                    {{ $rec->servings }} servings
                  </span>
                @endif
                <span class="diff-badge diff-{{ $rec->difficulty }}">{{ $rec->difficulty_label }}</span>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </div>
    @endif

    <!-- SEARCH & FILTERS -->
    <div style="margin-bottom:28px;">
      <form method="GET" action="{{ route('recipes.index') }}" style="display:flex;gap:8px;max-width:520px;margin-bottom:20px;">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search recipes…" class="form-control" />
        @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}" />@endif
        @if(request('difficulty'))<input type="hidden" name="difficulty" value="{{ request('difficulty') }}" />@endif
        <button type="submit" class="btn btn--primary">Search</button>
        @if(request()->hasAny(['search','category','difficulty','featured']))
          <a href="{{ route('recipes.index') }}" class="btn btn--outline">Clear</a>
        @endif
      </form>

      <div class="recipe-filters">
        <a href="{{ route('recipes.index') }}"
           class="recipe-cat-btn {{ !request('category') ? 'recipe-cat-btn--active' : '' }}">All</a>
        @foreach($categories as $cat)
          <a href="{{ route('recipes.index', ['category' => $cat->slug]) }}"
             class="recipe-cat-btn {{ request('category') === $cat->slug ? 'recipe-cat-btn--active' : '' }}">
            {{ $cat->name }}
            @if($cat->published_count > 0)<span style="font-size:10px;opacity:.7;">({{ $cat->published_count }})</span>@endif
          </a>
        @endforeach

        <span style="color:var(--clr-border);margin:0 4px;">|</span>

        <a href="{{ route('recipes.index', array_merge(request()->except(['difficulty']), ['difficulty' => 'easy'])) }}"
           class="recipe-cat-btn {{ request('difficulty') === 'easy' ? 'recipe-cat-btn--active' : '' }}">Easy</a>
        <a href="{{ route('recipes.index', array_merge(request()->except(['difficulty']), ['difficulty' => 'medium'])) }}"
           class="recipe-cat-btn {{ request('difficulty') === 'medium' ? 'recipe-cat-btn--active' : '' }}">Medium</a>
        <a href="{{ route('recipes.index', array_merge(request()->except(['difficulty']), ['difficulty' => 'hard'])) }}"
           class="recipe-cat-btn {{ request('difficulty') === 'hard' ? 'recipe-cat-btn--active' : '' }}">Hard</a>
      </div>
    </div>

    <!-- RECIPE GRID -->
    @if($recipes->isEmpty())
      <div class="listing-empty" style="text-align:center;padding:60px 0;">
        <p>No recipes found. <a href="{{ route('recipes.index') }}">Browse all recipes</a></p>
      </div>
    @else
      <div class="recipe-grid">
        @foreach($recipes as $rec)
          <article class="recipe-card" style="position:relative;">
            @if($rec->is_featured)<span class="recipe-card__feat-badge">★ Featured</span>@endif
            <div class="recipe-card__img">
              <a href="{{ route('recipes.show', $rec->slug) }}">
                <img src="{{ $rec->featured_image ? Storage::url($rec->featured_image) : 'https://placehold.co/600x400/f3e2c7/5a3e2b?text='.urlencode($rec->title) }}"
                     alt="{{ $rec->title }}" loading="lazy" />
              </a>
            </div>
            <div class="recipe-card__body">
              <p class="recipe-card__cat">{{ $rec->category->name ?? '' }}</p>
              <h2 class="recipe-card__title"><a href="{{ route('recipes.show', $rec->slug) }}">{{ $rec->title }}</a></h2>
              @if($rec->short_description)<p class="recipe-card__desc">{{ $rec->short_description }}</p>@endif
              <div class="recipe-card__meta">
                @if($rec->total_time)
                  <span class="recipe-card__meta-item">
                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="10" cy="10" r="8"/><polyline points="10,5 10,10 13,13"/></svg>
                    {{ $rec->total_time }}
                  </span>
                @endif
                @if($rec->servings)<span class="recipe-card__meta-item">{{ $rec->servings }} servings</span>@endif
                <span class="diff-badge diff-{{ $rec->difficulty }}">{{ $rec->difficulty_label }}</span>
              </div>
            </div>
          </article>
        @endforeach
      </div>

      <div class="pagination" style="margin-top:40px;">
        {{ $recipes->withQueryString()->links() }}
      </div>
    @endif

  </div>

@endsection
