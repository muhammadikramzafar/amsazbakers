@extends('admin.layouts.app')
@section('title', 'Gallery Items — '.$galleryAlbum->name)

@section('content')
<div class="admin-page">
  <div class="admin-page__header">
    <div>
      <h1 class="admin-page__title">{{ $galleryAlbum->name }}</h1>
      <p class="admin-page__sub">{{ $items->total() }} items</p>
    </div>
    <div style="display:flex;gap:10px;">
      <a href="{{ route('admin.gallery.albums.index') }}" class="btn btn--outline">← Albums</a>
      <a href="{{ route('admin.gallery.items.create', $galleryAlbum) }}" class="btn btn--primary">+ Add Item</a>
    </div>
  </div>

  @if(session('success'))<div class="alert alert--success">{{ session('success') }}</div>@endif

  <div class="admin-card">
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px;padding:20px;">
      @forelse($items as $item)
      <div style="background:#faf7f2;border-radius:10px;overflow:hidden;border:1px solid var(--clr-border);">
        <div style="aspect-ratio:4/3;overflow:hidden;position:relative;background:#eee;">
          @if($item->type === 'image' && $item->file_url)
            <img src="{{ $item->file_url }}" style="width:100%;height:100%;object-fit:cover;" />
          @elseif($item->type === 'video')
            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#222;color:#fff;font-size:32px;">▶</div>
          @else
            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#aaa;">No image</div>
          @endif
          <span class="badge {{ $item->is_active ? 'badge--success':'badge--grey' }}" style="position:absolute;top:8px;left:8px;">{{ $item->type }}</span>
        </div>
        <div style="padding:12px;">
          @if($item->caption)<p style="font-size:13px;color:#555;margin:0 0 10px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $item->caption }}</p>@endif
          <p style="font-size:11px;color:#aaa;margin:0 0 10px;">Order: {{ $item->sort_order }}</p>
          <div style="display:flex;gap:6px;">
            <a href="{{ route('admin.gallery.items.edit', [$galleryAlbum, $item]) }}" class="btn btn--sm btn--outline" style="flex:1;text-align:center;">Edit</a>
            <form method="POST" action="{{ route('admin.gallery.items.destroy', [$galleryAlbum, $item]) }}" onsubmit="return confirm('Delete?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn--sm btn--danger">Del</button>
            </form>
          </div>
        </div>
      </div>
      @empty
      <div style="grid-column:1/-1;text-align:center;padding:40px;color:#aaa;">
        No items yet. <a href="{{ route('admin.gallery.items.create', $galleryAlbum) }}">Add the first item.</a>
      </div>
      @endforelse
    </div>
    <div class="admin-card__footer">{{ $items->links() }}</div>
  </div>
</div>
@endsection
