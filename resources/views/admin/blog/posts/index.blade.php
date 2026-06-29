@extends('admin.layouts.app')
@section('title', 'Blog Posts')
@section('breadcrumb', 'Blog → Posts')

@section('content')
<div class="admin-page">

  {{-- Header --}}
  <div class="admin-page__header">
    <div>
      <h1 class="admin-page__title">Blog Posts</h1>
      <p class="admin-page__sub">{{ $posts->total() }} post{{ $posts->total() != 1 ? 's' : '' }} total</p>
    </div>
    <div class="admin-page__actions">
      <a href="{{ route('admin.blog.tags.index') }}" class="btn btn--outline btn--sm">
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" width="14" height="14"><path d="M2 8l5-5 7 7-5 5z"/><circle cx="5" cy="5" r="1.5" fill="currentColor" stroke="none"/></svg>
        Tags
      </a>
      <a href="{{ route('admin.blog.categories.index') }}" class="btn btn--outline btn--sm">
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" width="14" height="14"><rect x="2" y="2" width="5" height="5" rx="1"/><rect x="9" y="2" width="5" height="5" rx="1"/><rect x="2" y="9" width="5" height="5" rx="1"/><rect x="9" y="9" width="5" height="5" rx="1"/></svg>
        Categories
      </a>
      <a href="{{ route('admin.blog.posts.create') }}" class="btn btn--primary">
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><line x1="8" y1="2" x2="8" y2="14"/><line x1="2" y1="8" x2="14" y2="8"/></svg>
        New Post
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert--success">
      <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M3 8l4 4 6-6"/></svg>
      {{ session('success') }}
    </div>
  @endif

  {{-- Filters --}}
  <form method="GET" class="admin-filters">
    <svg viewBox="0 0 16 16" fill="none" stroke="#aaa" stroke-width="1.5" width="16" height="16"><circle cx="7" cy="7" r="5"/><path d="m11 11 3 3"/></svg>
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title or slug…"
           class="form-control" style="max-width:220px;font-size:13px;" />
    <select name="status" class="filter-select">
      <option value="">All Statuses</option>
      <option value="published" {{ request('status') === 'published' ? 'selected':'' }}>Published</option>
      <option value="draft"     {{ request('status') === 'draft'     ? 'selected':'' }}>Draft</option>
      <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected':'' }}>Scheduled</option>
    </select>
    <select name="category_id" class="filter-select">
      <option value="">All Categories</option>
      @foreach($categories as $cat)
        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected':'' }}>{{ $cat->name }}</option>
      @endforeach
    </select>
    <button type="submit" class="btn btn--primary btn--sm">Filter</button>
    @if(request()->hasAny(['search','status','category_id']))
      <a href="{{ route('admin.blog.posts.index') }}" class="btn btn--outline btn--sm">Clear</a>
    @endif
  </form>

  {{-- Table --}}
  <div class="admin-card" style="padding:0;overflow:hidden;">
    <table class="admin-table">
      <thead>
        <tr>
          <th style="width:56px;padding-left:20px;">Cover</th>
          <th>Title</th>
          <th>Category</th>
          <th>Status</th>
          <th>Published</th>
          <th>Views</th>
          <th style="width:150px;text-align:right;padding-right:20px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($posts as $post)
        <tr>
          <td style="padding-left:20px;">
            @if($post->image_url)
              <img src="{{ $post->image_url }}" alt="" class="admin-thumb" />
            @else
              <div class="admin-thumb-placeholder">📝</div>
            @endif
          </td>
          <td>
            <div style="font-weight:600;color:var(--clr-text);max-width:340px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
              {{ $post->title }}
            </div>
            <div style="font-size:11px;color:var(--clr-muted);margin-top:2px;">
              /blog/{{ $post->slug }}
              @if($post->is_featured)
                &nbsp;·&nbsp;<span style="color:#c8a24a;font-weight:700;">★ Featured</span>
              @endif
            </div>
          </td>
          <td>
            @if($post->category)
              <span class="badge badge--blue">{{ $post->category->name }}</span>
            @else
              <span style="color:var(--clr-muted);">—</span>
            @endif
          </td>
          <td>
            <span class="badge {{ match($post->status){ 'published'=>'badge--success','draft'=>'badge--grey',default=>'badge--warning' } }}">
              {{ ucfirst($post->status) }}
            </span>
          </td>
          <td style="font-size:13px;color:var(--clr-muted);white-space:nowrap;">
            {{ $post->published_at?->format('d M Y') ?? '—' }}
          </td>
          <td style="font-size:13px;color:var(--clr-muted);">
            {{ number_format($post->views_count ?? 0) }}
          </td>
          <td style="text-align:right;padding-right:20px;">
            <div class="admin-table__actions" style="justify-content:flex-end;">
              @if($post->status === 'published')
                <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn--sm btn--outline" title="View live">
                  <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" width="13" height="13"><path d="M6 3H3a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h9a1 1 0 0 0 1-1v-3"/><path d="M10 2h4v4"/><line x1="14" y1="2" x2="7" y2="9"/></svg>
                </a>
              @endif
              <a href="{{ route('admin.blog.posts.edit', $post) }}" class="btn btn--sm btn--outline">Edit</a>
              <form method="POST" action="{{ route('admin.blog.posts.destroy', $post) }}"
                    onsubmit="return confirm('Delete «{{ addslashes($post->title) }}»?')" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn--sm btn--danger">Delete</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" style="text-align:center;padding:48px 24px;color:var(--clr-muted);">
            <svg viewBox="0 0 48 48" fill="none" stroke="#ddd" stroke-width="1.5" width="40" height="40" style="display:block;margin:0 auto 12px;"><rect x="8" y="8" width="32" height="32" rx="4"/><line x1="15" y1="18" x2="33" y2="18"/><line x1="15" y1="25" x2="27" y2="25"/></svg>
            No posts yet. <a href="{{ route('admin.blog.posts.create') }}" style="color:var(--clr-gold);">Write the first one →</a>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
    @if($posts->hasPages())
      <div class="admin-card__footer" style="padding:12px 20px;">
        {{ $posts->withQueryString()->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
