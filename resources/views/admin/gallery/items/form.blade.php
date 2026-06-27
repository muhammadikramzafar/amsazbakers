@extends('admin.layouts.app')
@section('title', isset($galleryItem) ? 'Edit Item' : 'Add Gallery Item')

@section('content')
<div class="admin-page">
  <div class="admin-page__header">
    <h1 class="admin-page__title">{{ isset($galleryItem) ? 'Edit Item' : 'Add to: '.$galleryAlbum->name }}</h1>
    <a href="{{ route('admin.gallery.items.index', $galleryAlbum) }}" class="btn btn--outline">Back to Album</a>
  </div>

  @if($errors->any())<div class="alert alert--error">{{ $errors->first() }}</div>@endif

  <form method="POST"
        action="{{ isset($galleryItem) ? route('admin.gallery.items.update', [$galleryAlbum, $galleryItem]) : route('admin.gallery.items.store', $galleryAlbum) }}"
        enctype="multipart/form-data">
    @csrf
    @if(isset($galleryItem)) @method('PUT') @endif

    <div style="display:grid;grid-template-columns:1fr 280px;gap:24px;align-items:start;">
      <div class="admin-card" style="padding:28px;">
        <div class="form-group">
          <label class="form-label">Item Type *</label>
          <select name="type" id="typeSelect" class="form-control" onchange="toggleType(this.value)">
            <option value="image" {{ old('type', $galleryItem->type ?? 'image') === 'image' ? 'selected':'' }}>Image</option>
            <option value="video" {{ old('type', $galleryItem->type ?? '') === 'video' ? 'selected':'' }}>Video</option>
          </select>
        </div>
        <div id="imageField" class="form-group">
          <label class="form-label">Image File</label>
          @if(isset($galleryItem) && $galleryItem->file_url)
            <img src="{{ $galleryItem->file_url }}" style="max-width:300px;border-radius:8px;margin-bottom:10px;display:block;" />
          @endif
          <input type="file" name="file_path" class="form-control" accept="image/*" />
        </div>
        <div id="videoField" class="form-group" style="display:none;">
          <label class="form-label">Video URL (YouTube / Vimeo)</label>
          <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $galleryItem->video_url ?? '') }}" placeholder="https://www.youtube.com/watch?v=..." />
        </div>
        <div class="form-group">
          <label class="form-label">Caption</label>
          <input type="text" name="caption" class="form-control" value="{{ old('caption', $galleryItem->caption ?? '') }}" />
        </div>
      </div>

      <div class="admin-card" style="padding:24px;">
        <div class="form-group">
          <label class="form-label">Sort Order</label>
          <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $galleryItem->sort_order ?? 0) }}" />
        </div>
        <div class="form-group">
          <label class="form-check">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', ($galleryItem->is_active ?? true) ? '1':'0') == '1' ? 'checked':'' }} />
            <span>Active</span>
          </label>
        </div>
        <button type="submit" class="btn btn--primary" style="width:100%;margin-top:8px;">
          {{ isset($galleryItem) ? 'Update Item' : 'Add Item' }}
        </button>
      </div>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
function toggleType(val) {
  document.getElementById('imageField').style.display = val === 'image' ? 'block' : 'none';
  document.getElementById('videoField').style.display = val === 'video' ? 'block' : 'none';
}
toggleType(document.getElementById('typeSelect').value);
</script>
@endpush
