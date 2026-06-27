@extends('admin.layouts.app')
@section('title', 'Gallery Albums')

@section('content')
<div class="admin-page">
  <div class="admin-page__header">
    <div>
      <h1 class="admin-page__title">Gallery Albums</h1>
      <p class="admin-page__sub">{{ $albums->total() }} albums</p>
    </div>
    <a href="{{ route('admin.gallery.albums.create') }}" class="btn btn--primary">+ New Album</a>
  </div>

  @if(session('success'))<div class="alert alert--success">{{ session('success') }}</div>@endif

  <div class="admin-card">
    <table class="admin-table">
      <thead>
        <tr>
          <th style="width:60px;">Cover</th>
          <th>Album Name</th>
          <th>Type</th>
          <th>Items</th>
          <th>Order</th>
          <th>Active</th>
          <th style="width:160px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($albums as $album)
        <tr>
          <td>
            @if($album->cover_image_url)
              <img src="{{ $album->cover_image_url }}" style="width:44px;height:44px;object-fit:cover;border-radius:6px;" />
            @else
              <div style="width:44px;height:44px;border-radius:6px;background:#f3e2c7;display:flex;align-items:center;justify-content:center;">📷</div>
            @endif
          </td>
          <td><strong>{{ $album->name }}</strong></td>
          <td>
            <span class="badge {{ match($album->type){ 'photos'=>'badge--success','videos'=>'badge--warning',default=>'badge--grey' } }}">
              {{ ucfirst($album->type) }}
            </span>
          </td>
          <td>{{ $album->items_count }}</td>
          <td>{{ $album->sort_order }}</td>
          <td><span class="badge {{ $album->is_active ? 'badge--success':'badge--grey' }}">{{ $album->is_active ? 'Active':'Inactive' }}</span></td>
          <td class="admin-table__actions">
            <a href="{{ route('admin.gallery.items.index', $album) }}" class="btn btn--sm btn--outline">Items ({{ $album->items_count }})</a>
            <a href="{{ route('admin.gallery.albums.edit', $album) }}" class="btn btn--sm btn--outline">Edit</a>
            <form method="POST" action="{{ route('admin.gallery.albums.destroy', $album) }}" onsubmit="return confirm('Delete album and all items?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn--sm btn--danger">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="admin-table__empty">No albums yet. <a href="{{ route('admin.gallery.albums.create') }}">Add one.</a></td></tr>
        @endforelse
      </tbody>
    </table>
    <div class="admin-card__footer">{{ $albums->links() }}</div>
  </div>
</div>
@endsection
