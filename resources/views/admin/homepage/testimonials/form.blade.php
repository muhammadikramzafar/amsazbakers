@extends('admin.layouts.app')
@section('title', isset($testimonial) ? 'Edit Testimonial' : 'Add Testimonial')
@section('breadcrumb', isset($testimonial) ? 'Edit Testimonial' : 'Add Testimonial')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">{{ isset($testimonial) ? 'Edit Testimonial' : 'Add Testimonial' }}</h1>
  <a href="{{ route('admin.homepage.testimonials.index') }}" class="btn btn--outline">Back</a>
</div>

<form method="POST"
      action="{{ isset($testimonial) ? route('admin.homepage.testimonials.update', $testimonial) : route('admin.homepage.testimonials.store') }}"
      enctype="multipart/form-data" novalidate>
  @csrf
  @if(isset($testimonial)) @method('PUT') @endif

  <div class="page-form-layout">
    <div class="page-form-main">
      <div class="admin-card">
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Customer Name <span style="color:red">*</span></label>
            <input class="form-control @error('customer_name') is-invalid @enderror" type="text" name="customer_name"
                   value="{{ old('customer_name', $testimonial->customer_name ?? '') }}" required autofocus>
            @error('customer_name')<p class="form-error">{{ $message }}</p>@enderror
          </div>
          <div class="form-group">
            <label class="form-label">Role / Location</label>
            <input class="form-control" type="text" name="customer_role"
                   value="{{ old('customer_role', $testimonial->customer_role ?? '') }}"
                   placeholder="Regular Customer, Lahore">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Quote / Review <span style="color:red">*</span></label>
          <textarea class="form-control @error('quote') is-invalid @enderror" name="quote" rows="5"
                    placeholder="The best bakery in Lahore! Their cakes are absolutely divine…">{{ old('quote', $testimonial->quote ?? '') }}</textarea>
          @error('quote')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Rating <span style="color:red">*</span></label>
          <div class="star-rating">
            @for($i = 5; $i >= 1; $i--)
              <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}"
                     {{ old('rating', $testimonial->rating ?? 5) == $i ? 'checked' : '' }}>
              <label for="star{{ $i }}" title="{{ $i }} stars">★</label>
            @endfor
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
                   {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}>
            Active
          </label>
        </div>
        <div class="form-group">
          <label class="form-label">Sort Order</label>
          <input class="form-control" type="number" name="sort_order" min="0"
                 value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}">
        </div>
        <button type="submit" class="btn btn--primary btn--full">
          {{ isset($testimonial) ? 'Update Testimonial' : 'Save Testimonial' }}
        </button>
      </div>
      <div class="admin-card">
        <h3 class="admin-card__title" style="margin-bottom:12px;">Customer Avatar</h3>
        @if(isset($testimonial) && $testimonial->avatar)
          <img src="{{ Storage::url($testimonial->avatar) }}" alt=""
               style="width:80px;height:80px;object-fit:cover;border-radius:50%;margin-bottom:8px;">
        @endif
        <input class="form-control" type="file" name="avatar" accept=".jpg,.jpeg,.png,.webp">
        <p style="font-size:11px;color:var(--clr-muted);margin-top:6px;">Optional. Square image recommended.</p>
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

  /* Star rating input */
  .star-rating { display:flex; flex-direction:row-reverse; gap:4px; }
  .star-rating input { display:none; }
  .star-rating label {
    font-size:32px; cursor:pointer; color:var(--clr-border);
    transition:color .1s;
  }
  .star-rating input:checked ~ label,
  .star-rating label:hover,
  .star-rating label:hover ~ label { color:#f59e0b; }
</style>
@endpush
