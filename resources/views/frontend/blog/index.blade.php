@extends('frontend.layouts.app')

@section('title', 'Blog — Azmeer Bakery')
@section('meta_description', 'Recipes, baking tips, and stories from the Azmeer Bakery kitchen.')

@section('content')

{{-- ── HERO ── --}}
<section class="pg-hero pg-hero--blog">
  <div class="pg-hero__inner">
    <p class="pg-hero__eyebrow">From our kitchen to your screen</p>
    <h1 class="pg-hero__title">The Azmeer Blog</h1>
    <p class="pg-hero__sub">Baking tips, behind-the-scenes stories, and everything we're loving right now.</p>
  </div>
</section>

{{-- ── FEATURED ── --}}
@if($featuredPosts->isNotEmpty() && !request()->filled('search'))
<section class="blog-featured-section">
  <div class="blog-featured-inner">
    <div class="blog-section-label">
      <svg viewBox="0 0 16 16" fill="#c8a24a" width="14" height="14"><path d="M8 1l1.9 3.8L14 5.6l-3 2.9.7 4.1L8 10.4l-3.7 2.2.7-4.1-3-2.9 4.1-.8z"/></svg>
      Featured Stories
    </div>
    <div class="blog-featured-grid">
      @foreach($featuredPosts as $i => $post)
        <article class="bfc {{ $i === 0 ? 'bfc--hero' : '' }}">
          <a href="{{ route('blog.show', $post->slug) }}" class="bfc__img-wrap">
            <img src="{{ $post->image_url ?? 'https://placehold.co/800x500/3d1a0b/c8a24a?text='.urlencode($post->title) }}"
                 alt="{{ $post->title }}" loading="lazy" />
            <div class="bfc__overlay">
              <span class="bfc__cat">{{ $post->category->name ?? 'Blog' }}</span>
              <h2 class="bfc__title">{{ $post->title }}</h2>
              @if($post->excerpt && $i === 0)<p class="bfc__excerpt">{{ Str::limit($post->excerpt, 120) }}</p>@endif
              <span class="bfc__date">{{ $post->published_at?->format('d M Y') }}</span>
            </div>
          </a>
        </article>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- ── MAIN LAYOUT ── --}}
<div class="blog-page-layout">

  {{-- Posts column --}}
  <div class="blog-posts-col">

    {{-- Search bar --}}
    <form method="GET" action="{{ route('blog.index') }}" class="blog-search-form">
      <div class="blog-search-wrap">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18" class="blog-search-icon" aria-hidden="true"><circle cx="9" cy="9" r="6"/><path d="m15 15 3 3"/></svg>
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search articles…" class="blog-search-input" />
      </div>
      <button type="submit" class="btn btn--primary" style="flex-shrink:0;">Search</button>
      @if($search ?? false)<a href="{{ route('blog.index') }}" class="btn btn--outline" style="flex-shrink:0;">Clear</a>@endif
    </form>

    @if($posts->isEmpty())
      <div class="blog-empty">
        <svg viewBox="0 0 48 48" fill="none" stroke="#ccc" stroke-width="1.5" width="48" height="48"><rect x="8" y="8" width="32" height="32" rx="4"/><line x1="15" y1="18" x2="33" y2="18"/><line x1="15" y1="25" x2="27" y2="25"/></svg>
        <p>No posts found.</p>
        <a href="{{ route('blog.index') }}" class="btn btn--outline">View All</a>
      </div>
    @else
      <div class="bcard-grid">
        @foreach($posts as $post)
          <article class="bcard">
            <a href="{{ route('blog.show', $post->slug) }}" class="bcard__img-wrap">
              <img src="{{ $post->image_url ?? 'https://placehold.co/600x380/3d1a0b/c8a24a?text='.urlencode($post->title) }}"
                   alt="{{ $post->title }}" loading="lazy" />
            </a>
            <div class="bcard__body">
              <div class="bcard__top">
                <span class="bcard__cat">{{ $post->category->name ?? 'Blog' }}</span>
                <span class="bcard__date">{{ $post->published_at?->format('d M Y') }}</span>
              </div>
              <h3 class="bcard__title"><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h3>
              @if($post->excerpt)<p class="bcard__excerpt">{{ Str::limit($post->excerpt, 130) }}</p>@endif
              <a href="{{ route('blog.show', $post->slug) }}" class="bcard__read-more">
                Read More
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><line x1="2" y1="8" x2="14" y2="8"/><polyline points="10,4 14,8 10,12"/></svg>
              </a>
            </div>
          </article>
        @endforeach
      </div>
      <div style="margin-top:40px;">{{ $posts->withQueryString()->links() }}</div>
    @endif
  </div>

  {{-- Sidebar --}}
  <aside class="blog-sidebar">

    @if($categories->isNotEmpty())
    <div class="blog-widget">
      <h3 class="blog-widget__title">Categories</h3>
      <ul class="blog-widget__cats">
        @foreach($categories as $cat)
          <li>
            <a href="{{ route('blog.category', $cat->slug) }}" class="blog-widget__cat-link">
              {{ $cat->name }}
              <span class="blog-widget__cat-count">{{ $cat->published_posts_count }}</span>
            </a>
          </li>
        @endforeach
      </ul>
    </div>
    @endif

    @if($recentPosts->isNotEmpty())
    <div class="blog-widget">
      <h3 class="blog-widget__title">Recent Posts</h3>
      <div class="blog-widget__recent">
        @foreach($recentPosts as $rp)
          <a href="{{ route('blog.show', $rp->slug) }}" class="blog-recent-item">
            <img src="{{ $rp->image_url ?? 'https://placehold.co/80x80/f3e2c7/5a3e2b?text=Blog' }}"
                 alt="{{ $rp->title }}" loading="lazy" class="blog-recent-item__img" />
            <div>
              <p class="blog-recent-item__title">{{ Str::limit($rp->title, 55) }}</p>
              <p class="blog-recent-item__date">{{ $rp->published_at?->format('d M Y') }}</p>
            </div>
          </a>
        @endforeach
      </div>
    </div>
    @endif

    @if($popularTags->isNotEmpty())
    <div class="blog-widget">
      <h3 class="blog-widget__title">Tags</h3>
      <div class="blog-tag-cloud">
        @foreach($popularTags as $tag)
          <a href="{{ route('blog.tag', $tag->slug) }}" class="blog-tag">{{ $tag->name }}</a>
        @endforeach
      </div>
    </div>
    @endif

    {{-- CTA widget --}}
    <div class="blog-widget blog-widget--cta">
      <p class="blog-widget__cta-label">Ready to order?</p>
      <p class="blog-widget__cta-text">Fresh bakes available now — same-day delivery across Lahore.</p>
      <a href="{{ route('products.listing') }}" class="btn btn--primary btn--full" style="margin-top:16px;justify-content:center;">Shop Now</a>
    </div>

  </aside>
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

/* ── Featured ── */
.blog-featured-section { padding: 48px clamp(16px,5vw,80px) 32px; }
.blog-featured-inner { max-width: var(--container-max); margin: 0 auto; }
.blog-section-label { display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #a08060; margin-bottom: 20px; }
.blog-featured-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 16px; }
@media (max-width: 760px) { .blog-featured-grid { grid-template-columns: 1fr; } }
.bfc { border-radius: 16px; overflow: hidden; }
.bfc__img-wrap { display: block; position: relative; text-decoration: none; }
.bfc__img-wrap img { width: 100%; object-fit: cover; display: block; transition: transform .4s; }
.bfc:hover .bfc__img-wrap img { transform: scale(1.03); }
.bfc--hero .bfc__img-wrap img { height: 380px; }
.bfc .bfc__img-wrap img { height: 182px; }
.bfc__overlay {
  position: absolute; inset: 0;
  background: linear-gradient(to top, rgba(30,10,3,.88) 0%, rgba(30,10,3,.1) 65%, transparent 100%);
  display: flex; flex-direction: column; justify-content: flex-end; padding: 24px;
}
.bfc__cat { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #c8a24a; margin-bottom: 6px; }
.bfc__title { font-family: var(--font-display); font-size: 1.2rem; color: #fff; line-height: 1.25; margin-bottom: 8px; }
.bfc--hero .bfc__title { font-size: 1.7rem; }
.bfc__excerpt { font-size: 13px; color: rgba(255,255,255,.7); line-height: 1.5; margin-bottom: 10px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.bfc__date { font-size: 12px; color: rgba(255,255,255,.5); }

/* ── Page layout ── */
.blog-page-layout { display: grid; grid-template-columns: 1fr 300px; gap: 40px; max-width: var(--container-max); margin: 0 auto; padding: 48px clamp(16px,5vw,80px) 80px; }
@media (max-width: 960px) { .blog-page-layout { grid-template-columns: 1fr; } }

/* ── Search ── */
.blog-search-form { display: flex; gap: 10px; margin-bottom: 32px; }
.blog-search-wrap { position: relative; flex: 1; }
.blog-search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #aaa; }
.blog-search-input { width: 100%; padding: 11px 14px 11px 38px; border: 1.5px solid #ddd6cc; border-radius: 10px; font-size: 14px; background: #fdfaf6; color: var(--clr-brown); font-family: inherit; box-sizing: border-box; }
.blog-search-input:focus { outline: none; border-color: var(--clr-primary); }

/* ── Blog cards ── */
.bcard-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px,1fr)); gap: 24px; }
.bcard { background: #fff; border: 1px solid #ede8e0; border-radius: 16px; overflow: hidden; transition: transform .2s, box-shadow .2s; display: flex; flex-direction: column; }
.bcard:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,.1); }
.bcard__img-wrap { display: block; aspect-ratio: 16/10; overflow: hidden; text-decoration: none; }
.bcard__img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.bcard:hover .bcard__img-wrap img { transform: scale(1.05); }
.bcard__body { padding: 20px; display: flex; flex-direction: column; flex: 1; }
.bcard__top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
.bcard__cat { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #b07d30; background: #fdf0e0; padding: 2px 8px; border-radius: 10px; }
.bcard__date { font-size: 11px; color: #bbb; }
.bcard__title { font-family: var(--font-display); font-size: 1.05rem; color: var(--clr-brown); line-height: 1.35; margin-bottom: 8px; }
.bcard__title a { text-decoration: none; color: inherit; }
.bcard__title a:hover { color: var(--clr-primary); }
.bcard__excerpt { font-size: 13px; color: #888; line-height: 1.6; flex: 1; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 14px; }
.bcard__read-more { display: flex; align-items: center; gap: 5px; font-size: 13px; font-weight: 700; color: var(--clr-primary); text-decoration: none; margin-top: auto; }
.bcard__read-more:hover { gap: 8px; }

/* ── Sidebar ── */
.blog-sidebar { display: flex; flex-direction: column; gap: 20px; }
.blog-widget { background: #fff; border: 1px solid #ede8e0; border-radius: 14px; padding: 22px; }
.blog-widget__title { font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: .1em; color: #a08060; padding-bottom: 10px; border-bottom: 2px solid #fdf0e0; margin-bottom: 14px; }
.blog-widget__cats { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 2px; }
.blog-widget__cat-link { display: flex; justify-content: space-between; align-items: center; padding: 7px 8px; border-radius: 8px; font-size: 13px; color: var(--clr-brown); text-decoration: none; transition: background .12s; }
.blog-widget__cat-link:hover { background: #fdf5ec; color: var(--clr-primary); }
.blog-widget__cat-count { font-size: 11px; background: #f5ede0; color: #a08060; padding: 1px 7px; border-radius: 12px; }
.blog-widget__recent { display: flex; flex-direction: column; gap: 12px; }
.blog-recent-item { display: flex; gap: 12px; text-decoration: none; align-items: flex-start; }
.blog-recent-item__img { width: 52px; height: 52px; object-fit: cover; border-radius: 8px; flex-shrink: 0; }
.blog-recent-item__title { font-size: 13px; font-weight: 600; color: var(--clr-brown); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.blog-recent-item:hover .blog-recent-item__title { color: var(--clr-primary); }
.blog-recent-item__date { font-size: 11px; color: #bbb; margin-top: 3px; }
.blog-tag-cloud { display: flex; flex-wrap: wrap; gap: 6px; }
.blog-tag { padding: 4px 12px; border-radius: 14px; background: #f5ede0; color: var(--clr-brown); font-size: 12px; text-decoration: none; transition: background .15s; }
.blog-tag:hover { background: var(--clr-primary); color: #fff; }
.blog-widget--cta { background: linear-gradient(135deg, #3d1a0b, #5c2d0a); border: none; text-align: center; }
.blog-widget__cta-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #c8a24a; margin-bottom: 8px; }
.blog-widget__cta-text { font-size: 13px; color: rgba(255,255,255,.7); line-height: 1.5; }

.blog-empty { text-align: center; padding: 80px 24px; color: #aaa; display: flex; flex-direction: column; align-items: center; gap: 16px; }
.blog-empty p { font-size: 16px; }
</style>
@endpush
