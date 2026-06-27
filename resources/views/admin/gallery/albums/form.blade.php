@extends('admin.layouts.app')
@section('title', isset($album) ? 'Edit Album' : 'New Album')

@section('content')
<div class="admin-page">
  <div class="admin-page__header">
    <h1 class="admin-page__title">{{ isset($album) ? 'Edit: '.$album->name : 'New Gallery Album' }}</h1>
    <a href="{{ route('admin.gallery.albums.index') }}" class="btn btn--outline">Back</a>
  </div>

  @if($errors->any())<div class="alert alert--error">{{ $errors->first() }}</div>@endif

  <form method="POST"
        action="{{ isset($album) ? route('admin.gallery.albums.update', $album) : route('admin.gallery.albums.store') }}"
        enctype="multipart/form-data">
    @csrf
    @if(isset($album)) @method('PUT') @endif

    <div style="display:grid;grid-template-columns:1fr 300px;gap:24px;align-items:start;">
      <div class="admin-card" style="padding:28px;">
        <div class="form-group">
          <label class="form-label">Album Name *</label>
          <input type="text" name="name" class="form-control" value="{{ old('name', $album->name ?? '') }}" required />
        </div>
        <div class="form-group">
          <label class="form-label">Slug</label>
          <input type="text" name="slug" class="form-control" value="{{ old('slug', $album->slug ?? '') }}" placeholder="auto-generated" />
        </div>
        <div class="form-group">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control" rows="4">{{ old('description', $album->description ?? '') }}</textarea>
        </div>
        <div class="form-group">
          <label class="form-label">Album Type *</label>
          <select name="type" class="form-control">
            <option value="photos"  {{ old('type', $album->type ?? 'photos') === 'photos'  ? 'selected':'' }}>Photos</option>
            <option value="videos"  {{ old('type', $album->type ?? '') === 'videos'  ? 'selected':'' }}>Videos</option>
            <option value="mixed"   {{ old('type', $album->type ?? '') === 'mixed'   ? 'selected':'' }}>Mixed (Photos + Videos)</option>
          </select>
        </div>
      </div>

      <div class="admin-card" style="padding:24px;">
        <div class="form-group">
          <label class="form-label">Cover Image</label>
          @if(isset($album) && $album->cover_image_url)
            <img src="{{ $album->cover_image_url }}" style="width:100%;border-radius:8px;margin-bottom:10px;" />
          @endif
          <input type="file" name="cover_image" class="form-control" accept="image/*" />
        </div>
        <div class="form-group">
          <label class="form-label">Sort Order</label>
          <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $album->sort_order ?? 0) }}" />
        </div>
        <div class="form-group">
          <label class="form-check">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', ($album->is_active ?? true) ? '1':'0') == '1' ? 'checked':'' }} />
            <span>Active</span>
          </label>
        </div>
        <button type="submit" class="btn btn--primary" style="width:100%;margin-top:8px;">
          {{ isset($album) ? 'Update Album' : 'Create Album' }}
        </button>
      </div>
    </div>
  </form>
</div>
@endsection
