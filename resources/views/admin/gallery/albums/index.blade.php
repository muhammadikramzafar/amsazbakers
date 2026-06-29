@extends('admin.layouts.app')
@section('title', 'Gallery Albums')
@section('breadcrumb', 'Gallery → Albums')

@section('content')
<div class="admin-page">

  {{-- Header --}}
  <div class="admin-page__header">
    <div>
      <h1 class="admin-page__title">Gallery Albums</h1>
      <p class="admin-page__sub">{{ $albums->total() }} album{{ $albums->total() != 1 ? 's' : '' }}</p>
    </div>
    <a href="{{ route('admin.gallery.albums.create') }}" class="btn btn--primary">
      <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><line x1="8" y1="2" x2="8" y2="14"/><line x1="2" y1="8" x2="14" y2="8"/></svg>
      New Album
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert--success">
      <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M3 8l4 4 6-6"/></svg>
      {{ session('success') }}
    </div>
  @endif

  @if($albums->isEmpty())
    <div class="admin-card" style="text-align:center;padding:60px 24px;color:var(--clr-muted);">
      <svg viewBox="0 0 48 48" fill="none" stroke="#ddd" stroke-width="1.5" width="48" height="48" style="display:block;margin:0 auto 16px;"><rect x="4" y="10" width="40" height="30" rx="3"/><circle cx="16" cy="21" r="4"/><path d="M4 34l10-10 8 8 6-6 16 14"/></svg>
      <p style="font-size:15px;margin-bottom:16px;">No albums yet.</p>
      <a href="{{ route('admin.gallery.albums.create') }}" class="btn btn--primary">Create First Album</a>
    </div>
  @else
    <div class="album-grid">
      @foreach($albums as $album)
        <div class="album-card">
          <div class="album-card__cover">
            @if($album->cover_image_url)
              <img src="{{ $album->cover_image_url }}" alt="{{ $album->name }}" />
            @else
              <div class="album-card__cover-empty">
                @if($album->type === 'videos')
                  <svg viewBox="0 0 40 40" fill="none" stroke="#c8a24a" stroke-width="1.5" width="40" height="40"><rect x="3" y="8" width="34" height="24" rx="3"/><polygon points="16,14 16,26 28,20" fill="#c8a24a" stroke="none"/></svg>
                @else
                  <svg viewBox="0 0 40 40" fill="none" stroke="#c8a24a" stroke-width="1.5" width="40" height="40"><rect x="3" y="8" width="34" height="24" rx="3"/><circle cx="13" cy="17" r="3.5"/><path d="M3 28l10-10 8 8 6-6 10 10"/></svg>
                @endif
              </div>
            @endif
            <span class="album-card__type-badge badge {{ $album->type === 'videos' ? 'badge--blue' : 'badge--success' }}">
              {{ ucfirst($album->type ?? 'Photos') }}
            </span>
          </div>
          <div class="album-card__body">
            <div class="album-card__name">{{ $album->name }}</div>
            <div class="album-card__meta">
              {{ $album->items_count }} item{{ $album->items_count != 1 ? 's' : '' }}
              &nbsp;·&nbsp;
              <span class="{{ $album->is_active ? 'badge badge--success' : 'badge badge--grey' }}" style="font-size:10px;padding:1px 6px;">
                {{ $album->is_active ? 'Active' : 'Inactive' }}
              </span>
            </div>
            <div class="album-card__actions">
              <a href="{{ route('admin.gallery.items.index', $album) }}" class="btn btn--sm btn--outline" style="flex:1;justify-content:center;">
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" width="12" height="12"><rect x="2" y="2" width="5" height="5" rx="1"/><rect x="9" y="2" width="5" height="5" rx="1"/><rect x="2" y="9" width="5" height="5" rx="1"/><rect x="9" y="9" width="5" height="5" rx="1"/></svg>
                Items ({{ $album->items_count }})
              </a>
              <a href="{{ route('admin.gallery.albums.edit', $album) }}" class="btn btn--sm btn--outline">Edit</a>
              <form method="POST" action="{{ route('admin.gallery.albums.destroy', $album) }}"
                    onsubmit="return confirm('Delete album «{{ addslashes($album->name) }}» and all its items?')" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn--sm btn--danger" title="Delete">
                  <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" width="12" height="12"><polyline points="2,4 14,4"/><path d="M5 4V2h6v2"/><path d="M3 4l1 10h8l1-10"/></svg>
                </button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    @if($albums->hasPages())
      <div style="margin-top:20px;">{{ $albums->links() }}</div>
    @endif
  @endif

</div>
@endsection
