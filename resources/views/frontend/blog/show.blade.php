@extends('frontend.layouts.app')

@section('title', ($blogPost->seo_title ?: $blogPost->title).' — Azmeer Bakery Blog')
@section('meta_description', Str::limit($blogPost->seo_description ?: $blogPost->excerpt ?: strip_tags($blogPost->content), 155))

@push('styles')
<style>
.blog-show-layout { display:grid; grid-template-columns:1fr 300px; gap:40px; max-width:var(--container-max); margin:0 auto; padding:60px var(--container-pad); }
@media(max-width:900px){ .blog-show-layout { grid-template-columns:1fr; } }
.article-cat { font-size:12px; font-weight:700; color:var(--clr-primary); text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px; display:block; text-decoration:none; }
.article-cat:hover { text-decoration:underline; }
.article-title { font-size:clamp(26px,4vw,40px); font-weight:700; color:var(--clr-heading); line-height:1.25; margin-bottom:16px; }
.article-meta { display:flex; gap:16px; flex-wrap:wrap; font-size:13px; color:#aaa; margin-bottom:20px; padding-bottom:20px; border-bottom:1px solid var(--clr-border); }
.article-tags { display:flex; gap:6px; flex-wrap:wrap; margin-bottom:20px; }
.article-tag { padding:3px 10px; border-radius:12px; background:#f3e2c7; color:#5a3e2b; font-size:12px; text-decoration:none; }
.article-tag:hover { background:var(--clr-primary); color:#fff; }
.article-content { font-size:15px; line-height:1.8; color:#333; }
.article-content h2 { font-size:22px; font-weight:700; margin:28px 0 12px; color:var(--clr-heading); }
.article-content h3 { font-size:18px; font-weight:700; margin:24px 0 10px; color:var(--clr-heading); }
.article-content p { margin-bottom:16px; }
.article-content img { max-width:100%; border-radius:8px; }
.article-content ul, .article-content ol { margin:16px 0 16px 24px; }
.article-content li { margin-bottom:6px; }
.article-content blockquote { border-left:4px solid var(--clr-primary); margin:24px 0; padding:16px 20px; background:#faf7f2; font-style:italic; border-radius:0 8px 8px 0; }
.post-nav { display:flex; gap:16px; margin-top:40px; padding-top:32px; border-top:1px solid var(--clr-border); }
.post-nav-btn { flex:1; padding:16px; background:#fff; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,.06); text-decoration:none; color:inherit; }
.post-nav-btn:hover { box-shadow:0 4px 16px rgba(0,0,0,.12); }
.post-nav-btn--next { text-align:right; }
.post-nav-label { font-size:11px; color:#aaa; text-transform:uppercase; letter-spacing:.5px; display:block; margin-bottom:4px; }
.post-nav-title { font-size:14px; font-weight:600; color:var(--clr-heading); }
.related-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-top:20px; }
@media(max-width:600px){ .related-grid { grid-template-columns:1fr; } }
.related-card img { width:100%;aspect-ratio:16/9;object-fit:cover;border-radius:8px; }
.related-card a { font-size:13px;font-weight:600;color:var(--clr-heading);text-decoration:none;display:block;margin-top:6px; }
.related-card a:hover { color:var(--clr-primary); }
.sidebar-widget { background:#fff; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,.05); padding:24px; margin-bottom:24px; }
.sidebar-widget h3 { font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--clr-heading);margin-bottom:14px;padding-bottom:8px;border-bottom:2px solid var(--clr-primary);display:inline-block; }
</style>
@endpush

@section('content')
  <section class="page-banner">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}" class="breadcrumb__link">Home</a>
      <span class="breadcrumb__sep">/</span>
      <a href="{{ route('blog.index') }}" class="breadcrumb__link">Blog</a>
      @if($blogPost->category)
        <span class="breadcrumb__sep">/</span>
        <a href="{{ route('blog.category', $blogPost->category->slug) }}" class="breadcrumb__link">{{ $blogPost->category->name }}</a>
      @endif
    </nav>
    <span class="gold-rule gold-rule--center"></span>
  </section>

  <div class="blog-show-layout">
    <article>
      @if($blogPost->category)
        <a href="{{ route('blog.category', $blogPost->category->slug) }}" class="article-cat">{{ $blogPost->category->name }}</a>
      @endif
      <h1 class="article-title">{{ $blogPost->title }}</h1>
      <div class="article-meta">
        @if($blogPost->author)<span>By {{ $blogPost->author->name }}</span>@endif
        <span>{{ $blogPost->published_at?->format('d M Y') }}</span>
        <span>{{ number_format($blogPost->views_count) }} views</span>
      </div>
      @if($blogPost->tags->isNotEmpty())
        <div class="article-tags">
          @foreach($blogPost->tags as $tag)
            <a href="{{ route('blog.tag', $tag->slug) }}" class="article-tag">{{ $tag->name }}</a>
          @endforeach
        </div>
      @endif

      @if($blogPost->image_url)
        <img src="{{ $blogPost->image_url }}" alt="{{ $blogPost->title }}" style="width:100%;border-radius:12px;margin-bottom:32px;" />
      @endif

      <div class="article-content">{!! $blogPost->content !!}</div>

      @php $url = urlencode(url()->current()); $ttl = urlencode($blogPost->title); @endphp
      <div style="display:flex;gap:10px;align-items:center;margin:32px 0;">
        <span style="font-size:13px;color:#888;font-weight:600;">Share:</span>
        <a href="https://wa.me/?text={{ $ttl }}%20{{ $url }}" target="_blank" style="display:flex;align-items:center;gap:5px;padding:8px 14px;background:#25d366;color:#fff;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;">WhatsApp</a>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}" target="_blank" style="display:flex;align-items:center;gap:5px;padding:8px 14px;background:#1877f2;color:#fff;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;">Facebook</a>
      </div>

      @if($prevPost || $nextPost)
      <nav class="post-nav">
        @if($prevPost)
          <a href="{{ route('blog.show', $prevPost->slug) }}" class="post-nav-btn">
            <span class="post-nav-label">← Previous</span>
            <span class="post-nav-title">{{ Str::limit($prevPost->title, 60) }}</span>
          </a>
        @endif
        @if($nextPost)
          <a href="{{ route('blog.show', $nextPost->slug) }}" class="post-nav-btn post-nav-btn--next">
            <span class="post-nav-label">Next →</span>
            <span class="post-nav-title">{{ Str::limit($nextPost->title, 60) }}</span>
          </a>
        @endif
      </nav>
      @endif

      @if($related->isNotEmpty())
      <div style="margin-top:48px;">
        <div class="section-header section-header--left">
          <h2 class="section-heading">Related Posts</h2>
          <span class="gold-rule"></span>
        </div>
        <div class="related-grid">
          @foreach($related as $rel)
          <div class="related-card">
            <a href="{{ route('blog.show', $rel->slug) }}">
              <img src="{{ $rel->image_url ?? 'https://placehold.co/400x225/f3e2c7/5a3e2b?text='.urlencode($rel->title) }}" alt="{{ $rel->title }}" loading="lazy" />
            </a>
            <a href="{{ route('blog.show', $rel->slug) }}">{{ Str::limit($rel->title, 60) }}</a>
            <span style="font-size:11px;color:#aaa;">{{ $rel->published_at?->format('d M Y') }}</span>
          </div>
          @endforeach
        </div>
      </div>
      @endif
    </article>

    <aside>
      <div class="sidebar-widget">
        <h3>Recent Posts</h3>
        @foreach(\App\Models\BlogPost::published()->orderByDesc('published_at')->take(5)->get() as $rp)
        <div style="display:flex;gap:10px;padding:8px 0;border-bottom:1px solid var(--clr-border);">
          <img src="{{ $rp->image_url ?? 'https://placehold.co/100x100/f3e2c7/5a3e2b?text=Blog' }}" alt="{{ $rp->title }}" loading="lazy" style="width:52px;height:52px;object-fit:cover;border-radius:6px;flex-shrink:0;" />
          <div>
            <a href="{{ route('blog.show', $rp->slug) }}" style="font-size:13px;font-weight:600;color:var(--clr-heading);text-decoration:none;line-height:1.4;display:block;">{{ Str::limit($rp->title, 55) }}</a>
            <span style="font-size:11px;color:#aaa;display:block;margin-top:2px;">{{ $rp->published_at?->format('d M Y') }}</span>
          </div>
        </div>
        @endforeach
      </div>

      <div class="sidebar-widget">
        <h3>Categories</h3>
        <ul style="list-style:none;padding:0;margin:0;">
          @foreach(\App\Models\BlogCategory::active()->withCount('publishedPosts')->orderBy('sort_order')->get() as $cat)
          <li style="padding:6px 0;border-bottom:1px solid var(--clr-border);display:flex;justify-content:space-between;">
            <a href="{{ route('blog.category', $cat->slug) }}" style="text-decoration:none;color:#444;font-size:14px;">{{ $cat->name }}</a>
            <span style="font-size:11px;color:#aaa;">{{ $cat->published_posts_count }}</span>
          </li>
          @endforeach
        </ul>
      </div>
    </aside>
  </div>
@endsection
