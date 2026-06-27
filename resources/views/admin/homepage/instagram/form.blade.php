@extends('admin.layouts.app')
@section('title', isset($post) ? 'Edit Photo' : 'Add Photo')
@section('breadcrumb', isset($post) ? 'Edit Photo' : 'Add Photo')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">{{ isset($post) ? 'Edit Instagram Photo' : 'Add Instagram Photo' }}</h1>
  <a href="{{ route('admin.homepage.instagram.index') }}" class="btn btn--outline">Back</a>
</div>

<form method="POST"
      action="{{ isset($post) ? route('admin.homepage.instagram.update', $post) : route('admin.homepage.instagram.store') }}"
      enctype="multipart/form-data" novalidate>
  @csrf
  @if(isset($post)) @method('PUT') @endif

  <div class="admin-card" style="max-width:560px;">
    <div class="form-group">
      <label class="form-label">Photo {{ !isset($post) ? '(required)' : '(leave blank to keep existing)' }}</label>
      @if(isset($post) && $post->image)
        <img src="{{ Storage::url($post->image) }}" alt="" style="width:120px;height:120px;object-fit:cover;border-radius:8px;margin-bottom:8px;display:block;">
      @endif
      <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" accept=".jpg,.jpeg,.png,.webp"
             {{ !isset($post) ? 'required' : '' }}>
      @error('image')<p class="form-error">{{ $message }}</p>@enderror
      <p style="font-size:11px;color:var(--clr-muted);margin-top:4px;">Square image recommended (e.g. 600×600 px)</p>
    </div>
    <div class="form-group">
      <label class="form-label">Caption</label>
      <input class="form-control" type="text" name="caption"
             value="{{ old('caption', $post->caption ?? '') }}"
             placeholder="Fresh croissants every morning 🥐 #azmeerbakery">
    </div>
    <div class="form-group">
      <label class="form-label">Instagram Post URL</label>
      <input class="form-control" type="url" name="post_url"
             value="{{ old('post_url', $post->post_url ?? '') }}"
             placeholder="https://www.instagram.com/p/…">
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input class="form-control" type="number" name="sort_order" min="0"
               value="{{ old('sort_order', $post->sort_order ?? 0) }}">
      </div>
      <div class="form-group" style="display:flex;align-items:flex-end;padding-bottom:2px;">
        <label class="form-label--checkbox">
          <input type="hidden" name="is_active" value="0">
          <input type="checkbox" name="is_active" value="1"
                 {{ old('is_active', $post->is_active ?? true) ? 'checked' : '' }}>
          Active
        </label>
      </div>
    </div>
    <button type="submit" class="btn btn--primary">{{ isset($post) ? 'Update Photo' : 'Upload Photo' }}</button>
  </div>
</form>
@endsection
