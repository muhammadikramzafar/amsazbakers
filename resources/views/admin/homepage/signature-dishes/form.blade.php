@extends('admin.layouts.app')
@section('title', isset($dish) ? 'Edit Dish' : 'Add Dish')
@section('breadcrumb', isset($dish) ? 'Edit Dish' : 'Add Dish')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">{{ isset($dish) ? 'Edit Signature Dish' : 'Add Signature Dish' }}</h1>
  <a href="{{ route('admin.homepage.signature-dishes.index') }}" class="btn btn--outline">Back</a>
</div>

<form method="POST"
      action="{{ isset($dish) ? route('admin.homepage.signature-dishes.update', $dish) : route('admin.homepage.signature-dishes.store') }}"
      enctype="multipart/form-data" novalidate>
  @csrf
  @if(isset($dish)) @method('PUT') @endif

  <div class="page-form-layout">
    <div class="page-form-main">
      <div class="admin-card">
        <div class="form-group">
          <label class="form-label">Dish Name <span style="color:red">*</span></label>
          <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                 value="{{ old('name', $dish->name ?? '') }}" required autofocus>
          @error('name')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Description</label>
          <textarea class="form-control" name="description" rows="3"
                    placeholder="A short enticing description of this dish…">{{ old('description', $dish->description ?? '') }}</textarea>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Price (Rs.)</label>
            <input class="form-control" type="number" name="price" min="0" step="1"
                   value="{{ old('price', $dish->price ?? '') }}" placeholder="450">
          </div>
          <div class="form-group">
            <label class="form-label">Tag <span style="font-weight:400;color:var(--clr-muted);">(e.g. Chef's Pick, New, Popular)</span></label>
            <input class="form-control" type="text" name="tag"
                   value="{{ old('tag', $dish->tag ?? '') }}" placeholder="Chef's Pick">
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
                   {{ old('is_active', $dish->is_active ?? true) ? 'checked' : '' }}>
            Active
          </label>
        </div>
        <div class="form-group">
          <label class="form-label">Sort Order</label>
          <input class="form-control" type="number" name="sort_order" min="0"
                 value="{{ old('sort_order', $dish->sort_order ?? 0) }}">
        </div>
        <button type="submit" class="btn btn--primary btn--full">
          {{ isset($dish) ? 'Update Dish' : 'Save Dish' }}
        </button>
      </div>

      <div class="admin-card">
        <h3 class="admin-card__title" style="margin-bottom:12px;">Dish Image</h3>
        @if(isset($dish) && $dish->image)
          <img src="{{ Storage::url($dish->image) }}" alt=""
               style="width:100%;height:120px;object-fit:cover;border-radius:6px;margin-bottom:8px;">
        @endif
        <input class="form-control" type="file" name="image" accept=".jpg,.jpeg,.png,.webp">
        @error('image')<p class="form-error">{{ $message }}</p>@enderror
        <p style="font-size:11px;color:var(--clr-muted);margin-top:6px;">Recommended: 600×600 px</p>
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
