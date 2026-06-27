@extends('admin.layouts.app')
@section('title', 'Blog Categories')

@section('content')
<div class="admin-page">
  <div class="admin-page__header">
    <div>
      <h1 class="admin-page__title">Blog Categories</h1>
      <p class="admin-page__sub">{{ $categories->total() }} categories</p>
    </div>
    <a href="{{ route('admin.blog.categories.create') }}" class="btn btn--primary">+ New Category</a>
  </div>

  @if(session('success'))<div class="alert alert--success">{{ session('success') }}</div>@endif

  <div class="admin-card">
    <table class="admin-table">
      <thead>
        <tr>
          <th style="width:60px;">Image</th>
          <th>Name</th>
          <th>Slug</th>
          <th>Posts</th>
          <th>Order</th>
          <th>Active</th>
          <th style="width:120px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($categories as $cat)
        <tr>
          <td>
            @if($cat->image_url)
              <img src="{{ $cat->image_url }}" alt="{{ $cat->name }}" style="width:44px;height:44px;object-fit:cover;border-radius:6px;" />
            @else
              <div style="width:44px;height:44px;border-radius:6px;background:{{ $cat->color ?? '#5a3e2b' }};opacity:.3;"></div>
            @endif
          </td>
          <td>
            <div style="display:flex;align-items:center;gap:8px;">
              <span style="width:12px;height:12px;border-radius:50%;background:{{ $cat->color ?? '#5a3e2b' }};flex-shrink:0;"></span>
              <strong>{{ $cat->name }}</strong>
            </div>
          </td>
          <td><code style="font-size:12px;color:#888;">{{ $cat->slug }}</code></td>
          <td>{{ $cat->posts_count }}</td>
          <td>{{ $cat->sort_order }}</td>
          <td>
            <span class="badge {{ $cat->is_active ? 'badge--success' : 'badge--grey' }}">
              {{ $cat->is_active ? 'Active' : 'Inactive' }}
            </span>
          </td>
          <td class="admin-table__actions">
            <a href="{{ route('admin.blog.categories.edit', $cat) }}" class="btn btn--sm btn--outline">Edit</a>
            <form method="POST" action="{{ route('admin.blog.categories.destroy', $cat) }}" onsubmit="return confirm('Delete this category?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn--sm btn--danger">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="admin-table__empty">No categories yet. <a href="{{ route('admin.blog.categories.create') }}">Add one.</a></td></tr>
        @endforelse
      </tbody>
    </table>
    <div class="admin-card__footer">{{ $categories->links() }}</div>
  </div>
</div>
@endsection
