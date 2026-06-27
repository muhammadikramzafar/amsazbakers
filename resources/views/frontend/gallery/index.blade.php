@extends('frontend.layouts.app')

@section('title', 'Gallery — Azmeer Bakery')
@section('meta_description', 'Browse our photo gallery — cakes, pastries, sweets and our beautiful bakery.')

@push('styles')
<style>
.album-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:24px; max-width:var(--container-max); margin:0 auto; padding:60px var(--container-pad); }
.album-card { background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.06); transition:transform .2s,box-shadow .2s; }
.album-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,0,0,.12); }
.album-card__img { aspect-ratio:4/3; overflow:hidden; position:relative; }
.album-card__img img { width:100%; height:100%; object-fit:cover; transition:transform .4s; }
.album-card:hover .album-card__img img { transform:scale(1.05); }
.album-card__type { position:absolute; top:10px; right:10px; padding:3px 10px; border-radius:12px; font-size:11px; font-weight:700; color:#fff; }
.album-card__type--photos { background:#5a3e2b; }
.album-card__type--videos { background:#e74c3c; }
.album-card__type--mixed  { background:#7a6200; }
.album-card__body { padding:18px; }
.album-card__name { font-size:17px; font-weight:700; color:var(--clr-heading); margin-bottom:6px; }
.album-card__name a { text-decoration:none; color:inherit; }
.album-card__name a:hover { color:var(--clr-primary); }
.album-card__count { font-size:13px; color:#aaa; }
.album-card__desc { font-size:13px; color:#777; margin-top:6px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
</style>
@endpush

@section('content')
  <section class="page-banner">
    <nav class="breadcrumb"><a href="{{ route('home') }}" class="breadcrumb__link">Home</a><span class="breadcrumb__sep">/</span><span class="breadcrumb__current">Gallery</span></nav>
    <h1 class="page-banner__title">Gallery</h1>
    <span class="gold-rule gold-rule--center"></span>
    <p style="margin-top:12px;color:#888;">A glimpse of what we craft with love every day.</p>
  </section>

  @if($albums->isEmpty())
    <div style="text-align:center;padding:80px 20px;color:#aaa;">Gallery albums coming soon.</div>
  @else
    <div class="album-grid">
      @foreach($albums as $album)
      <div class="album-card">
        <div class="album-card__img">
          <a href="{{ route('gallery.show', $album->slug) }}">
            <img src="{{ $album->cover_image_url ?? 'https://placehold.co/600x450/f3e2c7/5a3e2b?text='.urlencode($album->name) }}"
                 alt="{{ $album->name }}" loading="lazy" />
          </a>
          <span class="album-card__type album-card__type--{{ $album->type }}">{{ ucfirst($album->type) }}</span>
        </div>
        <div class="album-card__body">
          <div class="album-card__name"><a href="{{ route('gallery.show', $album->slug) }}">{{ $album->name }}</a></div>
          <p class="album-card__count">{{ $album->active_items_count }} item{{ $album->active_items_count != 1 ? 's' : '' }}</p>
          @if($album->description)<p class="album-card__desc">{{ $album->description }}</p>@endif
        </div>
      </div>
      @endforeach
    </div>
  @endif
@endsection
