@extends('frontend.layouts.app')

@section('title', $blogCategory->name.' — Azmeer Bakery Blog')
@section('meta_description', Str::limit($blogCategory->description ?: 'Browse articles in '.$blogCategory->name, 155))

@push('styles')
<style>
.blog-layout{display:grid;grid-template-columns:1fr 300px;gap:40px;max-width:var(--container-max);margin:0 auto;padding:60px var(--container-pad);}
@media(max-width:900px){.blog-layout{grid-template-columns:1fr;}}
.blog-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:24px;}
.blog-card{background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.06);transition:transform .2s,box-shadow .2s;}
.blog-card:hover{transform:translateY(-3px);box-shadow:0 8px 24px rgba(0,0,0,.12);}
.blog-card__img{aspect-ratio:16/9;overflow:hidden;}
.blog-card__img img{width:100%;height:100%;object-fit:cover;}
.blog-card__body{padding:20px;}
.blog-card__cat{font-size:11px;font-weight:700;color:var(--clr-primary);text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;}
.blog-card__title{font-size:17px;font-weight:700;color:var(--clr-heading);margin-bottom:8px;line-height:1.3;}
.blog-card__title a{text-decoration:none;color:inherit;}
.blog-card__title a:hover{color:var(--clr-primary);}
.blog-card__excerpt{font-size:13px;color:#777;line-height:1.6;margin-bottom:12px;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;}
.blog-card__meta{font-size:12px;color:#aaa;}
.sidebar-widget{background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,.05);padding:24px;margin-bottom:24px;}
.sidebar-widget h3{font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--clr-heading);margin-bottom:14px;padding-bottom:8px;border-bottom:2px solid var(--clr-primary);display:inline-block;}
</style>
@endpush

@section('content')
  <section class="page-banner">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}" class="breadcrumb__link">Home</a>
      <span class="breadcrumb__sep">/</span>
      <a href="{{ route('blog.index') }}" class="breadcrumb__link">Blog</a>
      <span class="breadcrumb__sep">/</span>
      <span class="breadcrumb__current">{{ $blogCategory->name }}</span>
    </nav>
    <h1 class="page-banner__title">{{ $blogCategory->name }}</h1>
    <span class="gold-rule gold-rule--center"></span>
    @if($blogCategory->description)<p style="margin-top:12px;color:#888;">{{ $blogCategory->description }}</p>@endif
  </section>

  <div class="blog-layout">
    <div>
      @if($posts->isEmpty())
        <div style="text-align:center;padding:60px 0;color:#888;"><p>No posts in this category yet. <a href="{{ route('blog.index') }}">View all posts</a></p></div>
      @else
        <div class="blog-grid">
          @foreach($posts as $post)
          <article class="blog-card">
            <div class="blog-card__img"><a href="{{ route('blog.show', $post->slug) }}"><img src="{{ $post->image_url ?? 'https://placehold.co/600x338/f3e2c7/5a3e2b?text='.urlencode($post->title) }}" alt="{{ $post->title }}" loading="lazy" /></a></div>
            <div class="blog-card__body">
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
      <div class="sidebar-widget">
        <h3>All Categories</h3>
        <ul style="list-style:none;padding:0;margin:0;">
          @foreach($categories as $cat)
          <li style="padding:7px 0;border-bottom:1px solid var(--clr-border);display:flex;justify-content:space-between;align-items:center;">
            <a href="{{ route('blog.category', $cat->slug) }}" style="text-decoration:none;color:{{ $cat->id === $blogCategory->id ? 'var(--clr-primary)' : '#444' }};font-weight:{{ $cat->id === $blogCategory->id ? '700' : '400' }};font-size:14px;">{{ $cat->name }}</a>
            <span style="font-size:11px;color:#aaa;">{{ $cat->published_posts_count }}</span>
          </li>
          @endforeach
        </ul>
      </div>
      @if($recentPosts->isNotEmpty())
      <div class="sidebar-widget">
        <h3>Recent Posts</h3>
        @foreach($recentPosts as $rp)
        <div style="display:flex;gap:10px;padding:8px 0;border-bottom:1px solid var(--clr-border);">
          <img src="{{ $rp->image_url ?? 'https://placehold.co/100x100/f3e2c7/5a3e2b?text=Blog' }}" alt="{{ $rp->title }}" loading="lazy" style="width:52px;height:52px;object-fit:cover;border-radius:6px;flex-shrink:0;" />
          <div>
            <a href="{{ route('blog.show', $rp->slug) }}" style="font-size:13px;font-weight:600;color:var(--clr-heading);text-decoration:none;line-height:1.4;">{{ Str::limit($rp->title, 55) }}</a>
            <span style="font-size:11px;color:#aaa;display:block;margin-top:2px;">{{ $rp->published_at?->format('d M Y') }}</span>
          </div>
        </div>
        @endforeach
      </div>
      @endif
    </aside>
  </div>
@endsection
