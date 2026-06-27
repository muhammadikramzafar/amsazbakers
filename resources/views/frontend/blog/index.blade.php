@extends('frontend.layouts.app')

@section('title', 'Blog — Azmeer Bakery')
@section('meta_description', 'Recipes, baking tips, and stories from the Azmeer Bakery kitchen.')

@push('styles')
<style>
.blog-layout { display:grid; grid-template-columns:1fr 300px; gap:40px; max-width:var(--container-max); margin:0 auto; padding:60px var(--container-pad); }
@media(max-width:900px){ .blog-layout { grid-template-columns:1fr; } }
.blog-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:24px; }
.blog-card { background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.06); transition:transform .2s,box-shadow .2s; }
.blog-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,0,0,.12); }
.blog-card__img { aspect-ratio:16/9; overflow:hidden; }
.blog-card__img img { width:100%; height:100%; object-fit:cover; transition:transform .4s; }
.blog-card:hover .blog-card__img img { transform:scale(1.04); }
.blog-card__body { padding:20px; }
.blog-card__cat { font-size:11px; font-weight:700; color:var(--clr-primary); text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px; }
.blog-card__title { font-size:17px; font-weight:700; color:var(--clr-heading); margin-bottom:8px; line-height:1.3; }
.blog-card__title a { text-decoration:none; color:inherit; }
.blog-card__title a:hover { color:var(--clr-primary); }
.blog-card__excerpt { font-size:13px; color:#777; line-height:1.6; margin-bottom:12px; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; }
.blog-card__meta { font-size:12px; color:#aaa; display:flex; gap:12px; }
.blog-card--featured { grid-column:span 2; display:grid; grid-template-columns:1fr 1fr; }
@media(max-width:700px){ .blog-card--featured { grid-column:span 1; grid-template-columns:1fr; } }
.blog-card--featured .blog-card__img { aspect-ratio:auto; min-height:220px; }
.blog-card--featured .blog-card__title { font-size:20px; }
.sidebar-widget { background:#fff; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,.05); padding:24px; margin-bottom:24px; }
.sidebar-widget h3 { font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:var(--clr-heading); margin-bottom:14px; padding-bottom:8px; border-bottom:2px solid var(--clr-primary); display:inline-block; }
.tag-cloud { display:flex; flex-wrap:wrap; gap:6px; }
.tag-cloud a { padding:4px 10px; border-radius:14px; background:#f3e2c7; color:#5a3e2b; font-size:12px; text-decoration:none; }
.tag-cloud a:hover { background:var(--clr-primary); color:#fff; }
</style>
@endpush

@section('content')
  <section class="page-banner">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}" class="breadcrumb__link">Home</a>
      <span class="breadcrumb__sep">/</span>
      <span class="breadcrumb__current">Blog</span>
    </nav>
    <h1 class="page-banner__title">Blog</h1>
    <span class="gold-rule gold-rule--center"></span>
    <p style="margin-top:12px;color:#888;">Recipes, baking tips &amp; stories from our kitchen.</p>
  </section>

  @if($featuredPosts->isNotEmpty() && !request()->filled('search'))
  <div style="max-width:var(--container-max);margin:0 auto;padding:60px var(--container-pad) 0;">
    <div class="section-header section-header--left"><h2 class="section-heading">Featured</h2><span class="gold-rule"></span></div>
    <div class="blog-grid" style="margin-top:24px;">
      @foreach($featuredPosts as $i => $post)
        <article class="blog-card {{ $i === 0 ? 'blog-card--featured' : '' }}">
          <div class="blog-card__img"><a href="{{ route('blog.show', $post->slug) }}"><img src="{{ $post->image_url ?? 'https://placehold.co/800x450/f3e2c7/5a3e2b?text='.urlencode($post->title) }}" alt="{{ $post->title }}" loading="lazy" /></a></div>
          <div class="blog-card__body">
            <p class="blog-card__cat">{{ $post->category->name ?? 'Blog' }}</p>
            <h2 class="blog-card__title"><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h2>
            @if($post->excerpt)<p class="blog-card__excerpt">{{ $post->excerpt }}</p>@endif
            <div class="blog-card__meta"><span>{{ $post->published_at?->format('d M Y') }}</span></div>
          </div>
        </article>
      @endforeach
    </div>
  </div>
  @endif

  <div class="blog-layout">
    <div>
      <form method="GET" action="{{ route('blog.index') }}" style="display:flex;gap:8px;margin-bottom:32px;">
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search articles…" class="form-control" />
        <button type="submit" class="btn btn--primary">Search</button>
        @if($search ?? false)<a href="{{ route('blog.index') }}" class="btn btn--outline">Clear</a>@endif
      </form>
      @if($posts->isEmpty())
        <div style="text-align:center;padding:60px 0;color:#888;"><p>No posts found. <a href="{{ route('blog.index') }}">View all</a></p></div>
      @else
        <div class="blog-grid">
          @foreach($posts as $post)
          <article class="blog-card">
            <div class="blog-card__img"><a href="{{ route('blog.show', $post->slug) }}"><img src="{{ $post->image_url ?? 'https://placehold.co/600x338/f3e2c7/5a3e2b?text='.urlencode($post->title) }}" alt="{{ $post->title }}" loading="lazy" /></a></div>
            <div class="blog-card__body">
              <p class="blog-card__cat">{{ $post->category->name ?? 'Blog' }}</p>
              <h2 class="blog-card__title"><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h2>
              @if($post->excerpt)<p class="blog-card__excerpt">{{ $post->excerpt }}</p>@endif
              <div class="blog-card__meta"><span>{{ $post->published_at?->format('d M Y') }}</span></div>
            </div>
          </article>
          @endforeach
        </div>
        <div style="margin-top:40px;">{{ $posts->withQueryString()->links() }}</div>
      @endif
    </div>
    <aside>
      @if($categories->isNotEmpty())
      <div class="sidebar-widget">
        <h3>Categories</h3>
        <ul style="list-style:none;padding:0;margin:0;">
          @foreach($categories as $cat)
          <li style="padding:7px 0;border-bottom:1px solid var(--clr-border);display:flex;justify-content:space-between;align-items:center;">
            <a href="{{ route('blog.category', $cat->slug) }}" style="text-decoration:none;color:#444;font-size:14px;">{{ $cat->name }}</a>
            <span style="font-size:11px;color:#aaa;">{{ $cat->published_posts_count }}</span>
          </li>
          @endforeach
        </ul>
      </div>
      @endif
      @if($recentPosts->isNotEmpty())
      <div class="sidebar-widget">
        <h3>Recent Posts</h3>
        @foreach($recentPosts as $rp)
        <div style="display:flex;gap:10px;padding:8px 0;border-bottom:1px solid var(--clr-border);">
          <img src="{{ $rp->image_url ?? 'https://placehold.co/100x100/f3e2c7/5a3e2b?text=Blog' }}" alt="{{ $rp->title }}" loading="lazy" style="width:56px;height:56px;object-fit:cover;border-radius:6px;flex-shrink:0;" />
          <div>
            <a href="{{ route('blog.show', $rp->slug) }}" style="font-size:13px;font-weight:600;color:var(--clr-heading);text-decoration:none;">{{ Str::limit($rp->title, 55) }}</a>
            <span style="font-size:11px;color:#aaa;display:block;margin-top:2px;">{{ $rp->published_at?->format('d M Y') }}</span>
          </div>
        </div>
        @endforeach
      </div>
      @endif
      @if($popularTags->isNotEmpty())
      <div class="sidebar-widget">
        <h3>Tags</h3>
        <div class="tag-cloud">@foreach($popularTags as $tag)<a href="{{ route('blog.tag', $tag->slug) }}">{{ $tag->name }}</a>@endforeach</div>
      </div>
      @endif
    </aside>
  </div>
@endsection
