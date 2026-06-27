@extends('admin.layouts.app')
@section('title', 'About Section')
@section('breadcrumb', 'About Section')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">About Section</h1>
  <a href="{{ route('admin.homepage.index') }}" class="btn btn--outline">Back</a>
</div>

@if(session('success'))
  <div class="alert alert--success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('admin.homepage.about.update') }}" enctype="multipart/form-data" novalidate>
  @csrf @method('PUT')

  <div class="page-form-layout">
    <div class="page-form-main">
      <div class="admin-card">
        <div class="form-group">
          <label class="form-label">Heading <span style="color:red">*</span></label>
          <input class="form-control @error('heading') is-invalid @enderror" type="text" name="heading"
                 value="{{ old('heading', $about->heading) }}" required autofocus>
          @error('heading')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Sub-heading</label>
          <input class="form-control" type="text" name="subheading"
                 value="{{ old('subheading', $about->subheading) }}"
                 placeholder="Baking happiness since 1998">
        </div>
        <div class="form-group">
          <label class="form-label">Description</label>
          <textarea class="form-control" name="description" rows="8"
                    placeholder="Tell the story of your bakery…">{{ old('description', $about->description) }}</textarea>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Button Text</label>
            <input class="form-control" type="text" name="btn_text"
                   value="{{ old('btn_text', $about->btn_text) }}" placeholder="Read Our Story">
          </div>
          <div class="form-group">
            <label class="form-label">Button URL</label>
            <input class="form-control" type="text" name="btn_url"
                   value="{{ old('btn_url', $about->btn_url) }}" placeholder="/page/our-story">
          </div>
        </div>
      </div>

      <div class="admin-card">
        <h3 class="admin-card__title" style="margin-bottom:14px;">Stats / Achievements</h3>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Stat 1 Number</label>
            <input class="form-control" type="text" name="stat1_number"
                   value="{{ old('stat1_number', $about->stat1_number) }}" placeholder="25+">
          </div>
          <div class="form-group">
            <label class="form-label">Stat 1 Label</label>
            <input class="form-control" type="text" name="stat1_label"
                   value="{{ old('stat1_label', $about->stat1_label) }}" placeholder="Years of Excellence">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Stat 2 Number</label>
            <input class="form-control" type="text" name="stat2_number"
                   value="{{ old('stat2_number', $about->stat2_number) }}" placeholder="500+">
          </div>
          <div class="form-group">
            <label class="form-label">Stat 2 Label</label>
            <input class="form-control" type="text" name="stat2_label"
                   value="{{ old('stat2_label', $about->stat2_label) }}" placeholder="Menu Items">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Stat 3 Number</label>
            <input class="form-control" type="text" name="stat3_number"
                   value="{{ old('stat3_number', $about->stat3_number) }}" placeholder="10K+">
          </div>
          <div class="form-group">
            <label class="form-label">Stat 3 Label</label>
            <input class="form-control" type="text" name="stat3_label"
                   value="{{ old('stat3_label', $about->stat3_label) }}" placeholder="Happy Customers">
          </div>
        </div>
      </div>
    </div>

    <div class="page-form-sidebar">
      <div class="admin-card">
        <button type="submit" class="btn btn--primary btn--full">Save About Section</button>
      </div>
      <div class="admin-card">
        <h3 class="admin-card__title" style="margin-bottom:12px;">Section Image</h3>
        @if($about->image)
          <img src="{{ Storage::url($about->image) }}" alt=""
               style="width:100%;height:120px;object-fit:cover;border-radius:6px;margin-bottom:8px;">
        @endif
        <input class="form-control" type="file" name="image" accept=".jpg,.jpeg,.png,.webp">
        @error('image')<p class="form-error">{{ $message }}</p>@enderror
        <p style="font-size:11px;color:var(--clr-muted);margin-top:6px;">Recommended: 800×600 px</p>
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
