@extends('admin.layouts.app')
@section('title', isset($cta) ? 'Edit CTA' : 'Add CTA')
@section('breadcrumb', isset($cta) ? 'Edit CTA' : 'Add CTA')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">{{ isset($cta) ? 'Edit CTA Section' : 'Add CTA Section' }}</h1>
  <a href="{{ route('admin.homepage.cta.index') }}" class="btn btn--outline">Back</a>
</div>

<form method="POST"
      action="{{ isset($cta) ? route('admin.homepage.cta.update', $cta) : route('admin.homepage.cta.store') }}"
      enctype="multipart/form-data" novalidate>
  @csrf
  @if(isset($cta)) @method('PUT') @endif

  <div class="page-form-layout">
    <div class="page-form-main">
      <div class="admin-card">
        <div class="form-group">
          <label class="form-label">Title <span style="color:red">*</span></label>
          <input class="form-control @error('title') is-invalid @enderror" type="text" name="title"
                 value="{{ old('title', $cta->title ?? '') }}" required autofocus
                 placeholder="Order Custom Cakes for Any Occasion">
          @error('title')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Subtitle</label>
          <input class="form-control" type="text" name="subtitle"
                 value="{{ old('subtitle', $cta->subtitle ?? '') }}"
                 placeholder="Weddings, birthdays, corporate events — we bake it all.">
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Button Text</label>
            <input class="form-control" type="text" name="btn_text"
                   value="{{ old('btn_text', $cta->btn_text ?? '') }}" placeholder="Get a Quote">
          </div>
          <div class="form-group">
            <label class="form-label">Button URL</label>
            <input class="form-control" type="text" name="btn_url"
                   value="{{ old('btn_url', $cta->btn_url ?? '') }}" placeholder="/contact">
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
                   {{ old('is_active', $cta->is_active ?? true) ? 'checked' : '' }}>
            Active
          </label>
        </div>
        <div class="form-group">
          <label class="form-label">Sort Order</label>
          <input class="form-control" type="number" name="sort_order" min="0"
                 value="{{ old('sort_order', $cta->sort_order ?? 0) }}">
        </div>
        <button type="submit" class="btn btn--primary btn--full">
          {{ isset($cta) ? 'Update CTA' : 'Save CTA' }}
        </button>
      </div>
      <div class="admin-card">
        <h3 class="admin-card__title" style="margin-bottom:12px;">Background Image</h3>
        @if(isset($cta) && $cta->image)
          <img src="{{ Storage::url($cta->image) }}" alt=""
               style="width:100%;height:100px;object-fit:cover;border-radius:6px;margin-bottom:8px;">
        @endif
        <input class="form-control" type="file" name="image" accept=".jpg,.jpeg,.png,.webp">
        @error('image')<p class="form-error">{{ $message }}</p>@enderror
        <p style="font-size:11px;color:var(--clr-muted);margin-top:6px;">Recommended: 1600×500 px</p>
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
