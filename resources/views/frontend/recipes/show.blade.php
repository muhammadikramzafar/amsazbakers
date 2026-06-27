@extends('frontend.layouts.app')

@section('title', ($recipe->seo_title ?: $recipe->title).' — Azmeer Bakery Recipes')
@section('meta_description', Str::limit($recipe->seo_description ?: $recipe->short_description ?: strip_tags($recipe->description), 155))

@push('styles')
<style>
.recipe-detail { max-width:var(--container-max); margin:0 auto; padding:60px var(--container-pad); }
.recipe-hero { display:grid; grid-template-columns:1fr 380px; gap:48px; align-items:start; margin-bottom:48px; }
@media(max-width:900px){ .recipe-hero { grid-template-columns:1fr; } }
.recipe-img-main { width:100%; border-radius:12px; object-fit:cover; aspect-ratio:16/9; }
.recipe-gallery-thumbs { display:flex; gap:8px; margin-top:10px; flex-wrap:wrap; }
.recipe-gallery-thumb { width:72px; height:72px; object-fit:cover; border-radius:8px; cursor:pointer; border:2px solid var(--clr-border); transition:border-color .15s; }
.recipe-gallery-thumb--active, .recipe-gallery-thumb:hover { border-color:var(--clr-primary); }
.recipe-info { }
.recipe-info__cat { font-size:12px; color:#aaa; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px; }
.recipe-info__title { font-size:clamp(24px,4vw,38px); font-weight:700; color:var(--clr-heading); line-height:1.2; margin-bottom:14px; }
.recipe-info__desc { color:#555; line-height:1.7; margin-bottom:24px; }
.recipe-meta-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:12px; margin-bottom:24px; }
.recipe-meta-card { background:var(--clr-bg, #faf7f2); border-radius:10px; padding:14px 16px; text-align:center; }
.recipe-meta-card__label { font-size:11px; color:#aaa; text-transform:uppercase; letter-spacing:.5px; display:block; margin-bottom:4px; }
.recipe-meta-card__value { font-size:15px; font-weight:700; color:var(--clr-heading); }
.diff-badge { display:inline-block; padding:3px 10px; border-radius:10px; font-size:12px; font-weight:600; }
.diff-easy   { background:#e8f8ef; color:#0a7340; }
.diff-medium { background:#fef9e8; color:#7a6200; }
.diff-hard   { background:#f8e8e8; color:#c0392b; }
.recipe-share { display:flex; gap:10px; align-items:center; margin-top:16px; flex-wrap:wrap; }
.recipe-share__label { font-size:13px; color:#888; font-weight:600; }
.share-btn { display:flex; align-items:center; gap:6px; padding:8px 16px; border-radius:8px; font-size:13px; font-weight:600; text-decoration:none; transition:opacity .15s; }
.share-btn:hover { opacity:.85; }
.share-btn--whatsapp { background:#25d366; color:#fff; }
.share-btn--facebook { background:#1877f2; color:#fff; }
.recipe-body { display:grid; grid-template-columns:300px 1fr; gap:48px; align-items:start; }
@media(max-width:900px){ .recipe-body { grid-template-columns:1fr; } }
.recipe-ingredients { background:#faf7f2; border-radius:12px; padding:28px; position:sticky; top:80px; }
.recipe-ingredients h2 { font-size:20px; font-weight:700; margin-bottom:20px; }
.ingredient-list { list-style:none; padding:0; margin:0; }
.ingredient-list li { padding:8px 0; border-bottom:1px solid rgba(0,0,0,.06); font-size:15px; color:#444; display:flex; align-items:flex-start; gap:8px; }
.ingredient-list li:last-child { border:none; }
.ingredient-list li::before { content:'•'; color:var(--clr-primary); font-weight:bold; flex-shrink:0; }
.recipe-steps h2 { font-size:24px; font-weight:700; margin-bottom:28px; }
.step-item { display:flex; gap:20px; margin-bottom:32px; align-items:flex-start; }
.step-num { width:40px; height:40px; border-radius:50%; background:var(--clr-primary); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:16px; flex-shrink:0; }
.step-text { flex:1; font-size:15px; color:#444; line-height:1.7; padding-top:8px; }
.recipe-notes { margin-top:40px; }
.notes-box { background:#fef9e8; border-left:4px solid #f59e0b; border-radius:0 8px 8px 0; padding:20px 24px; margin-bottom:20px; }
.notes-box h3 { font-size:16px; font-weight:700; margin-bottom:10px; color:#7a5c00; }
.notes-box p { color:#555; line-height:1.7; font-size:14px; margin:0; }
.video-wrapper { position:relative; padding-bottom:56.25%; height:0; overflow:hidden; border-radius:12px; margin-top:40px; }
.video-wrapper iframe { position:absolute; top:0; left:0; width:100%; height:100%; }
.recipe-related { margin-top:60px; padding-top:40px; border-top:1px solid var(--clr-border); }
.recipe-related-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
@media(max-width:700px){ .recipe-related-grid { grid-template-columns:1fr; } }
.recipe-card-sm { background:#fff; border-radius:10px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,.06); }
.recipe-card-sm img { width:100%; aspect-ratio:16/9; object-fit:cover; }
.recipe-card-sm__body { padding:14px; }
.recipe-card-sm__title { font-size:15px; font-weight:700; margin-bottom:6px; }
.recipe-card-sm__title a { text-decoration:none; color:var(--clr-heading); }
.recipe-card-sm__title a:hover { color:var(--clr-primary); }
.recipe-card-sm__meta { font-size:12px; color:#aaa; }
</style>
@endpush

@section('content')

  <!-- PAGE BANNER -->
  <section class="page-banner">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}" class="breadcrumb__link">Home</a>
      <span class="breadcrumb__sep" aria-hidden="true">/</span>
      <a href="{{ route('recipes.index') }}" class="breadcrumb__link">Recipes</a>
      @if($recipe->category)
        <span class="breadcrumb__sep" aria-hidden="true">/</span>
        <a href="{{ route('recipes.index', ['category' => $recipe->category->slug]) }}" class="breadcrumb__link">{{ $recipe->category->name }}</a>
      @endif
      <span class="breadcrumb__sep" aria-hidden="true">/</span>
      <span class="breadcrumb__current">{{ Str::limit($recipe->title, 40) }}</span>
    </nav>
    <h1 class="page-banner__title" style="font-size:clamp(18px,3vw,26px);">{{ $recipe->title }}</h1>
    <span class="gold-rule gold-rule--center" aria-hidden="true"></span>
  </section>

  <div class="recipe-detail">

    <!-- HERO: Image + Info -->
    <div class="recipe-hero">

      <!-- Gallery -->
      <div>
        @php $allImages = $recipe->all_images; @endphp
        <img id="mainImage"
             src="{{ $allImages[0] ?? 'https://placehold.co/900x500/f3e2c7/5a3e2b?text='.urlencode($recipe->title) }}"
             alt="{{ $recipe->title }}" class="recipe-img-main" />
        @if(count($allImages) > 1)
        <div class="recipe-gallery-thumbs">
          @foreach($allImages as $i => $url)
            <img src="{{ $url }}" alt="{{ $recipe->title }}"
                 class="recipe-gallery-thumb {{ $i === 0 ? 'recipe-gallery-thumb--active' : '' }}"
                 data-full="{{ $url }}" />
          @endforeach
        </div>
        @endif
      </div>

      <!-- Info sidebar -->
      <div class="recipe-info">
        @if($recipe->category)
          <p class="recipe-info__cat">{{ $recipe->category->name }}</p>
        @endif
        <h1 class="recipe-info__title">{{ $recipe->title }}</h1>
        @if($recipe->short_description)
          <p class="recipe-info__desc">{{ $recipe->short_description }}</p>
        @endif

        <!-- Meta cards -->
        <div class="recipe-meta-grid">
          @if($recipe->prep_time)
            <div class="recipe-meta-card">
              <span class="recipe-meta-card__label">Prep Time</span>
              <span class="recipe-meta-card__value">{{ $recipe->prep_time }}</span>
            </div>
          @endif
          @if($recipe->cook_time)
            <div class="recipe-meta-card">
              <span class="recipe-meta-card__label">Cook Time</span>
              <span class="recipe-meta-card__value">{{ $recipe->cook_time }}</span>
            </div>
          @endif
          @if($recipe->total_time)
            <div class="recipe-meta-card">
              <span class="recipe-meta-card__label">Total Time</span>
              <span class="recipe-meta-card__value">{{ $recipe->total_time }}</span>
            </div>
          @endif
          @if($recipe->servings)
            <div class="recipe-meta-card">
              <span class="recipe-meta-card__label">Servings</span>
              <span class="recipe-meta-card__value">{{ $recipe->servings }} persons</span>
            </div>
          @endif
          <div class="recipe-meta-card">
            <span class="recipe-meta-card__label">Difficulty</span>
            <span class="diff-badge diff-{{ $recipe->difficulty }}" style="margin-top:2px;">{{ $recipe->difficulty_label }}</span>
          </div>
        </div>

        <!-- Social share -->
        @php $shareUrl = urlencode(route('recipes.show', $recipe->slug)); $shareTitle = urlencode($recipe->title); @endphp
        <div class="recipe-share">
          <span class="recipe-share__label">Share:</span>
          <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank" rel="noopener" class="share-btn share-btn--whatsapp" aria-label="Share on WhatsApp">
            <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            WhatsApp
          </a>
          <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener" class="share-btn share-btn--facebook" aria-label="Share on Facebook">
            <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            Facebook
          </a>
        </div>
      </div>
    </div>

    <!-- BODY: Ingredients + Steps -->
    @if($recipe->ingredients || $recipe->instructions)
    <div class="recipe-body">

      <!-- Ingredients -->
      @if($recipe->ingredients)
      <div class="recipe-ingredients">
        <h2>Ingredients</h2>
        <ul class="ingredient-list">
          @foreach($recipe->ingredients_list as $ingredient)
            <li>{{ $ingredient }}</li>
          @endforeach
        </ul>

        @if($recipe->nutritional_info)
          <div style="margin-top:24px;padding-top:16px;border-top:1px solid var(--clr-border);">
            <h3 style="font-size:14px;font-weight:700;margin-bottom:8px;color:#888;text-transform:uppercase;letter-spacing:.5px;">Nutritional Info</h3>
            <p style="font-size:13px;color:#666;line-height:1.6;">{{ $recipe->nutritional_info }}</p>
          </div>
        @endif
      </div>
      @endif

      <!-- Instructions -->
      @if($recipe->instructions)
      <div class="recipe-steps">
        <h2>Step-by-Step Instructions</h2>
        @foreach($recipe->instructions_list as $i => $step)
          <div class="step-item">
            <div class="step-num">{{ $i + 1 }}</div>
            <p class="step-text">{{ $step }}</p>
          </div>
        @endforeach

        <!-- Chef Notes -->
        @if($recipe->chef_notes || $recipe->tips)
        <div class="recipe-notes">
          @if($recipe->chef_notes)
            <div class="notes-box">
              <h3>👨‍🍳 Chef's Notes</h3>
              <p>{{ $recipe->chef_notes }}</p>
            </div>
          @endif
          @if($recipe->tips)
            <div class="notes-box" style="border-color:#22c55e;background:#f0fdf4;">
              <h3 style="color:#166534;">💡 Tips & Tricks</h3>
              <p>{{ $recipe->tips }}</p>
            </div>
          @endif
        </div>
        @endif
      </div>
      @endif

    </div>
    @endif

    <!-- Full description (if no structured steps) -->
    @if($recipe->description && !$recipe->instructions)
      <div style="margin-top:40px;line-height:1.8;color:#444;font-size:15px;">
        {!! nl2br(e($recipe->description)) !!}
      </div>
    @endif

    <!-- VIDEO -->
    @if($recipe->video_url)
    @php
      preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([^\s&?]+)/', $recipe->video_url, $ytMatch);
      preg_match('/vimeo\.com\/(\d+)/', $recipe->video_url, $vimeoMatch);
    @endphp
    <div style="margin-top:48px;">
      <h2 style="font-size:22px;font-weight:700;margin-bottom:20px;">Watch the Recipe</h2>
      <div class="video-wrapper">
        @if(!empty($ytMatch[1]))
          <iframe src="https://www.youtube-nocookie.com/embed/{{ $ytMatch[1] }}" frameborder="0"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen title="{{ $recipe->title }}"></iframe>
        @elseif(!empty($vimeoMatch[1]))
          <iframe src="https://player.vimeo.com/video/{{ $vimeoMatch[1] }}" frameborder="0"
                  allow="autoplay; fullscreen; picture-in-picture" allowfullscreen title="{{ $recipe->title }}"></iframe>
        @endif
      </div>
    </div>
    @endif

    <!-- RELATED RECIPES -->
    @if($related->isNotEmpty())
    <div class="recipe-related">
      <div class="section-header section-header--left">
        <h2 class="section-heading">More Recipes</h2>
        <span class="gold-rule" aria-hidden="true"></span>
      </div>
      <div class="recipe-related-grid" style="margin-top:24px;">
        @foreach($related as $rel)
        <div class="recipe-card-sm">
          <a href="{{ route('recipes.show', $rel->slug) }}">
            <img src="{{ $rel->featured_image ? Storage::url($rel->featured_image) : 'https://placehold.co/600x338/f3e2c7/5a3e2b?text='.urlencode($rel->title) }}"
                 alt="{{ $rel->title }}" loading="lazy" />
          </a>
          <div class="recipe-card-sm__body">
            <h3 class="recipe-card-sm__title"><a href="{{ route('recipes.show', $rel->slug) }}">{{ $rel->title }}</a></h3>
            <div class="recipe-card-sm__meta" style="display:flex;gap:10px;align-items:center;">
              @if($rel->total_time)<span>{{ $rel->total_time }}</span>@endif
              <span class="diff-badge diff-{{ $rel->difficulty }}" style="font-size:10px;padding:1px 6px;">{{ $rel->difficulty_label }}</span>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif

  </div>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.recipe-gallery-thumb').forEach(t => {
  t.addEventListener('click', () => {
    document.querySelectorAll('.recipe-gallery-thumb').forEach(x => x.classList.remove('recipe-gallery-thumb--active'));
    t.classList.add('recipe-gallery-thumb--active');
    document.getElementById('mainImage').src = t.dataset.full || t.src;
  });
});
</script>
@endpush
