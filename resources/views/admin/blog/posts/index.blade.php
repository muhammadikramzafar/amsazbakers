@extends('admin.layouts.app')
@section('title', 'Blog Posts')

@section('content')
<div class="admin-page">
  <div class="admin-page__header">
    <div>
      <h1 class="admin-page__title">Blog Posts</h1>
      <p class="admin-page__sub">{{ $posts->total() }} posts</p>
    </div>
    <div style="display:flex;gap:10px;">
      <a href="{{ route('admin.blog.tags.index') }}" class="btn btn--outline">Manage Tags</a>
      <a href="{{ route('admin.blog.categories.index') }}" class="btn btn--outline">Manage Categories</a>
      <a href="{{ route('admin.blog.posts.create') }}" class="btn btn--primary">+ New Post</a>
    </div>
  </div>

  @if(session('success'))<div class="alert alert--success">{{ session('success') }}</div>@endif

  <!-- Filters -->
  <form method="GET" class="admin-filters">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts…" class="form-control" style="max-width:240px;" />
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
    <button type="submit" class="btn btn--primary">Filter</button>
    @if(request()->hasAny(['search','status','category_id']))
      <a href="{{ route('admin.blog.posts.index') }}" class="btn btn--outline">Clear</a>
    @endif
  </form>

  <div class="admin-card">
    <table class="admin-table">
      <thead>
        <tr>
          <th style="width:60px;">Image</th>
          <th>Title</th>
          <th>Category</th>
          <th>Status</th>
          <th>Published</th>
          <th>Views</th>
          <th style="width:130px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($posts as $post)
        <tr>
          <td>
            @if($post->image_url)
              <img src="{{ $post->image_url }}" alt="" style="width:44px;height:44px;object-fit:cover;border-radius:6px;" />
            @else
              <div style="width:44px;height:44px;border-radius:6px;background:#f3e2c7;display:flex;align-items:center;justify-content:center;font-size:18px;">📝</div>
            @endif
          </td>
          <td>
            <strong>{{ $post->title }}</strong>
            @if($post->is_featured)<span class="badge badge--warning" style="margin-left:6px;">Featured</span>@endif
          </td>
          <td>{{ $post->category->name ?? '—' }}</td>
          <td>
            <span class="badge {{ match($post->status){ 'published'=>'badge--success','draft'=>'badge--grey',default=>'badge--warning' } }}">
              {{ ucfirst($post->status) }}
            </span>
          </td>
          <td>{{ $post->published_at?->format('d M Y') ?? '—' }}</td>
          <td>{{ number_format($post->views_count) }}</td>
          <td class="admin-table__actions">
            @if($post->status === 'published')
              <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn--sm btn--outline">View</a>
            @endif
            <a href="{{ route('admin.blog.posts.edit', $post) }}" class="btn btn--sm btn--outline">Edit</a>
            <form method="POST" action="{{ route('admin.blog.posts.destroy', $post) }}" onsubmit="return confirm('Delete this post?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn--sm btn--danger">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="admin-table__empty">No posts yet. <a href="{{ route('admin.blog.posts.create') }}">Create one.</a></td></tr>
        @endforelse
      </tbody>
    </table>
    <div class="admin-card__footer">{{ $posts->withQueryString()->links() }}</div>
  </div>
</div>
@endsection
