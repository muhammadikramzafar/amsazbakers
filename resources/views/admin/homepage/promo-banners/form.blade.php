@extends('admin.layouts.app')
@section('title', isset($banner) ? 'Edit Banner' : 'Add Banner')
@section('breadcrumb', isset($banner) ? 'Edit Banner' : 'Add Banner')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">{{ isset($banner) ? 'Edit Banner' : 'Add Promo Banner' }}</h1>
  <a href="{{ route('admin.homepage.promo-banners.index') }}" class="btn btn--outline">Back</a>
</div>

<form method="POST"
      action="{{ isset($banner) ? route('admin.homepage.promo-banners.update', $banner) : route('admin.homepage.promo-banners.store') }}"
      enctype="multipart/form-data" novalidate>
  @csrf
  @if(isset($banner)) @method('PUT') @endif

  <div class="page-form-layout">
    <div class="page-form-main">
      <div class="admin-card">
        <div class="form-group">
          <label class="form-label">Title <span style="color:red">*</span></label>
          <input class="form-control @error('title') is-invalid @enderror" type="text" name="title"
                 value="{{ old('title', $banner->title ?? '') }}" placeholder="Special Eid Offer" required autofocus>
          @error('title')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Subtitle</label>
          <input class="form-control" type="text" name="subtitle"
                 value="{{ old('subtitle', $banner->subtitle ?? '') }}"
                 placeholder="20% off on all sweet boxes this season">
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Button Text</label>
            <input class="form-control" type="text" name="btn_text"
                   value="{{ old('btn_text', $banner->btn_text ?? '') }}" placeholder="Order Now">
          </div>
          <div class="form-group">
            <label class="form-label">Button URL</label>
            <input class="form-control" type="text" name="btn_url"
                   value="{{ old('btn_url', $banner->btn_url ?? '') }}" placeholder="/products">
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
                   {{ old('is_active', $banner->is_active ?? true) ? 'checked' : '' }}>
            Active
          </label>
        </div>
        <div class="form-group">
          <label class="form-label">Sort Order</label>
          <input class="form-control" type="number" name="sort_order" min="0"
                 value="{{ old('sort_order', $banner->sort_order ?? 0) }}">
        </div>
        <button type="submit" class="btn btn--primary btn--full">
          {{ isset($banner) ? 'Update Banner' : 'Save Banner' }}
        </button>
      </div>

      <div class="admin-card">
        <h3 class="admin-card__title" style="margin-bottom:12px;">Banner Image</h3>
        @if(isset($banner) && $banner->image)
          <img src="{{ Storage::url($banner->image) }}" alt=""
               style="width:100%;height:100px;object-fit:cover;border-radius:6px;margin-bottom:8px;">
        @endif
        <input class="form-control" type="file" name="image" accept=".jpg,.jpeg,.png,.webp">
        @error('image')<p class="form-error">{{ $message }}</p>@enderror
        <p style="font-size:11px;color:var(--clr-muted);margin-top:6px;">Recommended: 600×400 px</p>
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
