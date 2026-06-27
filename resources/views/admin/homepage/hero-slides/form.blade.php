@extends('admin.layouts.app')
@section('title', isset($slide) ? 'Edit Slide' : 'Add Slide')
@section('breadcrumb', isset($slide) ? 'Edit Slide' : 'Add Slide')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">{{ isset($slide) ? 'Edit Slide' : 'Add Hero Slide' }}</h1>
  <a href="{{ route('admin.homepage.hero-slides.index') }}" class="btn btn--outline">Back</a>
</div>

<form method="POST"
      action="{{ isset($slide) ? route('admin.homepage.hero-slides.update', $slide) : route('admin.homepage.hero-slides.store') }}"
      enctype="multipart/form-data" novalidate>
  @csrf
  @if(isset($slide)) @method('PUT') @endif

  <div class="page-form-layout">
    <div class="page-form-main">
      <div class="admin-card">
        <div class="form-group">
          <label class="form-label">Title <span style="color:red">*</span></label>
          <input class="form-control @error('title') is-invalid @enderror" type="text" name="title"
                 value="{{ old('title', $slide->title ?? '') }}" placeholder="Fresh Baked Every Morning" required autofocus>
          @error('title')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Subtitle</label>
          <input class="form-control" type="text" name="subtitle"
                 value="{{ old('subtitle', $slide->subtitle ?? '') }}"
                 placeholder="Discover handcrafted bakery delights…">
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Button 1 Text <span style="color:red">*</span></label>
            <input class="form-control @error('btn1_text') is-invalid @enderror" type="text" name="btn1_text"
                   value="{{ old('btn1_text', $slide->btn1_text ?? 'Shop Now') }}" required>
            @error('btn1_text')<p class="form-error">{{ $message }}</p>@enderror
          </div>
          <div class="form-group">
            <label class="form-label">Button 1 URL <span style="color:red">*</span></label>
            <input class="form-control @error('btn1_url') is-invalid @enderror" type="text" name="btn1_url"
                   value="{{ old('btn1_url', $slide->btn1_url ?? '/products') }}" required>
            @error('btn1_url')<p class="form-error">{{ $message }}</p>@enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Button 2 Text <span style="color:var(--clr-muted);">(optional)</span></label>
            <input class="form-control" type="text" name="btn2_text"
                   value="{{ old('btn2_text', $slide->btn2_text ?? '') }}" placeholder="Our Story">
          </div>
          <div class="form-group">
            <label class="form-label">Button 2 URL</label>
            <input class="form-control" type="text" name="btn2_url"
                   value="{{ old('btn2_url', $slide->btn2_url ?? '') }}" placeholder="/page/our-story">
          </div>
        </div>
      </div>
    </div>

    <div class="page-form-sidebar">
      <div class="admin-card">
        <h3 class="admin-card__title" style="margin-bottom:12px;">Publish</h3>
        <div class="form-group">
          <label class="form-label--checkbox">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1"
                   {{ old('is_active', $slide->is_active ?? true) ? 'checked' : '' }}>
            Active (show on homepage)
          </label>
        </div>
        <div class="form-group">
          <label class="form-label">Sort Order</label>
          <input class="form-control" type="number" name="sort_order" min="0"
                 value="{{ old('sort_order', $slide->sort_order ?? 0) }}">
        </div>
        <button type="submit" class="btn btn--primary btn--full">
          {{ isset($slide) ? 'Update Slide' : 'Save Slide' }}
        </button>
      </div>

      <div class="admin-card">
        <h3 class="admin-card__title" style="margin-bottom:12px;">Background Image</h3>
        @if(isset($slide) && $slide->image)
          <img src="{{ Storage::url($slide->image) }}" alt="Slide image"
               style="width:100%;height:120px;object-fit:cover;border-radius:6px;margin-bottom:8px;">
        @endif
        <input class="form-control" type="file" name="image" accept=".jpg,.jpeg,.png,.webp">
        @error('image')<p class="form-error">{{ $message }}</p>@enderror
        <p style="font-size:11px;color:var(--clr-muted);margin-top:6px;">Recommended: 1920×800 px</p>
      </div>
    </div>
  </div>
</form>
@endsection

@push('styles')
<style>
  .page-form-layout { display:grid; grid-template-columns:1fr 260px; gap:20px; align-items:start; }
  .page-form-main   { display:flex; flex-direction:column; gap:20px; }
  .page-form-sidebar{ display:flex; flex-direction:column; gap:20px; }
  @media(max-width:900px) { .page-form-layout { grid-template-columns:1fr; } }
</style>
@endpush
