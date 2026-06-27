@extends('admin.layouts.app')
@section('title', isset($page) ? 'Edit Page' : 'New Page')
@section('breadcrumb', isset($page) ? 'Edit Page' : 'New Page')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">{{ isset($page) ? 'Edit Page' : 'Create Page' }}</h1>
  <a href="{{ route('admin.pages.index') }}" class="btn btn--outline">Back to Pages</a>
</div>

<form method="POST"
      action="{{ isset($page) ? route('admin.pages.update', $page->id) : route('admin.pages.store') }}"
      enctype="multipart/form-data" novalidate>
  @csrf
  @if(isset($page)) @method('PUT') @endif

  <div class="page-form-layout">

    {{-- ── Main content ────────────────────────────────── --}}
    <div class="page-form-main">

      <div class="admin-card">
        <div class="form-group">
          <label class="form-label" for="title">Page Title <span class="req">*</span></label>
          <input class="form-control @error('title') is-invalid @enderror"
                 type="text" id="title" name="title"
                 value="{{ old('title', $page->title ?? '') }}"
                 placeholder="About Us" required autofocus />
          @error('title')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="slug">
            Slug <span class="req">*</span>
            <span class="form-hint-inline">— URL: /page/<span id="slugPreview">{{ old('slug', $page->slug ?? '') }}</span></span>
          </label>
          <input class="form-control @error('slug') is-invalid @enderror"
                 type="text" id="slug" name="slug"
                 value="{{ old('slug', $page->slug ?? '') }}"
                 placeholder="about-us" required />
          @error('slug')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="short_description">Short Description</label>
          <textarea class="form-control @error('short_description') is-invalid @enderror"
                    id="short_description" name="short_description" rows="2"
                    placeholder="One or two sentences shown in listings and meta…">{{ old('short_description', $page->short_description ?? '') }}</textarea>
          @error('short_description')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="description">
            Detailed Description
            <span class="form-hint-inline">— HTML supported</span>
          </label>
          <textarea class="form-control form-control--code @error('description') is-invalid @enderror"
                    id="description" name="description" rows="14"
                    placeholder="<h2>Section heading</h2>&#10;<p>Your content here…</p>">{{ old('description', $page->description ?? '') }}</textarea>
          @error('description')<p class="form-error">{{ $message }}</p>@enderror
        </div>
      </div>

      {{-- SEO --}}
      <div class="admin-card">
        <h3 class="admin-card__title" style="margin-bottom:16px;">SEO</h3>

        <div class="form-group">
          <label class="form-label" for="seo_title">SEO Title</label>
          <input class="form-control @error('seo_title') is-invalid @enderror"
                 type="text" id="seo_title" name="seo_title"
                 value="{{ old('seo_title', $page->seo_title ?? '') }}"
                 placeholder="About Us — Azmeer Bakery" />
          @error('seo_title')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="meta_description">Meta Description</label>
          <textarea class="form-control @error('meta_description') is-invalid @enderror"
                    id="meta_description" name="meta_description" rows="2"
                    placeholder="Short description for search engine results (max 160 chars)…">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
          @error('meta_description')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="meta_keywords">Meta Keywords</label>
          <input class="form-control @error('meta_keywords') is-invalid @enderror"
                 type="text" id="meta_keywords" name="meta_keywords"
                 value="{{ old('meta_keywords', $page->meta_keywords ?? '') }}"
                 placeholder="bakery, Lahore, fresh bread, cakes" />
          @error('meta_keywords')<p class="form-error">{{ $message }}</p>@enderror
        </div>
      </div>
    </div>

    {{-- ── Sidebar ─────────────────────────────────────── --}}
    <div class="page-form-sidebar">

      {{-- Publish --}}
      <div class="admin-card">
        <h3 class="admin-card__title" style="margin-bottom:12px;">Publish</h3>
        <div class="form-group">
          <label class="form-label" for="status">Status</label>
          <select class="form-control" id="status" name="status">
            <option value="published" {{ old('status', $page->status ?? 'published') === 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft"     {{ old('status', $page->status ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
          </select>
        </div>
        <button type="submit" class="btn btn--primary btn--full">
          {{ isset($page) ? 'Update Page' : 'Publish Page' }}
        </button>
        @if(isset($page))
          <a href="{{ route('pages.show', $page->slug) }}" target="_blank"
             class="btn btn--outline btn--full" style="margin-top:8px;">Preview</a>
        @endif
      </div>

      {{-- Banner image --}}
      <div class="admin-card">
        <h3 class="admin-card__title" style="margin-bottom:12px;">Banner Image</h3>
        @if(isset($page) && $page->banner_image)
          <img src="{{ Storage::url($page->banner_image) }}" alt="Banner"
               class="settings-img-preview" style="height:100px;width:100%;object-fit:cover;" />
        @endif
        <input class="form-control" type="file" name="banner_image" accept=".jpg,.jpeg,.png,.webp" />
        @error('banner_image')<p class="form-error">{{ $message }}</p>@enderror
        <p class="form-hint" style="margin-top:6px;">Recommended: 1440×480 px</p>
      </div>

    </div>
  </div>
</form>
@endsection

@push('styles')
<style>
  .req { color:var(--clr-danger); }
  .form-hint-inline { font-size:11px; color:var(--clr-muted); font-weight:400; }
  .form-hint { font-size:11px; color:var(--clr-muted); }
  .settings-img-preview { display:block; border-radius:var(--radius); border:1px solid var(--clr-border); margin-bottom:8px; }
  .form-control--code { font-family: 'Courier New', monospace; font-size:13px; }

  /* Two-column layout */
  .page-form-layout { display:grid; grid-template-columns:1fr 280px; gap:20px; align-items:start; }
  .page-form-main   { display:flex; flex-direction:column; gap:20px; }
  .page-form-sidebar{ display:flex; flex-direction:column; gap:20px; }
  @media(max-width:900px) { .page-form-layout { grid-template-columns:1fr; } }
</style>
@endpush

@push('scripts')
<script>
(function () {
  const titleEl = document.getElementById('title');
  const slugEl  = document.getElementById('slug');
  const preview = document.getElementById('slugPreview');

  function slugify(str) {
    return str.toLowerCase().trim()
      .replace(/[^a-z0-9\s-]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-');
  }

  // Only auto-generate slug on create (not edit)
  @if(!isset($page))
  titleEl.addEventListener('input', () => {
    const s = slugify(titleEl.value);
    slugEl.value = s;
    preview.textContent = s;
  });
  @endif

  slugEl.addEventListener('input', () => {
    preview.textContent = slugEl.value;
  });
}());
</script>
@endpush
