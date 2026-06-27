@extends('admin.layouts.app')
@section('title', 'Homepage Settings & SEO')
@section('breadcrumb', 'Homepage Settings')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">Homepage Settings &amp; SEO</h1>
  <a href="{{ route('admin.homepage.index') }}" class="btn btn--outline">Back</a>
</div>

@if(session('success'))
  <div class="alert alert--success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('admin.homepage.settings.update') }}" novalidate>
  @csrf @method('PUT')

  {{-- ── Tabs ──────────────────────────────────────────────── --}}
  <div class="stab-nav">
    <button type="button" class="stab-btn stab-btn--active" data-tab="sections">Sections</button>
    <button type="button" class="stab-btn" data-tab="headings">Headings &amp; Counts</button>
    <button type="button" class="stab-btn" data-tab="seo">SEO</button>
  </div>

  {{-- ── TAB: Sections ─────────────────────────────────────── --}}
  <div class="stab-panel stab-panel--active" id="tab-sections">
    <div class="admin-card">
      <h3 class="admin-card__title" style="margin-bottom:16px;">Show / Hide Sections</h3>
      <div class="toggle-grid">
        @foreach([
          'hero_active'           => 'Hero Slider',
          'categories_active'     => 'Category Grid',
          'bestsellers_active'    => 'Best Sellers',
          'about_active'          => 'About Section',
          'promos_active'         => 'Promotional Banners',
          'featured_bakery_active'=> 'Featured Bakery Products',
          'featured_sweets_active'=> 'Featured Sweets',
          'signature_active'      => 'Signature Dishes',
          'fresh_active'          => 'Fresh From The Oven',
          'why_choose_active'     => 'Why Choose Us',
          'cta_active'            => 'CTA Sections',
          'testimonials_active'   => 'Customer Testimonials',
          'instagram_active'      => 'Instagram Feed',
        ] as $field => $label)
        <label class="toggle-row">
          <span class="toggle-label">{{ $label }}</span>
          <input type="hidden" name="{{ $field }}" value="0">
          <input type="checkbox" name="{{ $field }}" value="1" class="toggle-check"
                 {{ old($field, $settings->{$field} ?? true) ? 'checked' : '' }}>
          <span class="toggle-ui"></span>
        </label>
        @endforeach
      </div>
    </div>
  </div>

  {{-- ── TAB: Headings & Counts ────────────────────────────── --}}
  <div class="stab-panel" id="tab-headings">

    {{-- Bestsellers --}}
    <div class="admin-card">
      <h3 class="admin-card__title" style="margin-bottom:14px;">Best Sellers Section</h3>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Heading</label>
          <input class="form-control @error('bestsellers_heading') is-invalid @enderror" type="text"
                 name="bestsellers_heading" value="{{ old('bestsellers_heading', $settings->bestsellers_heading) }}" required>
          @error('bestsellers_heading')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Sub-heading</label>
          <input class="form-control" type="text" name="bestsellers_subheading"
                 value="{{ old('bestsellers_subheading', $settings->bestsellers_subheading) }}"
                 placeholder="Optional tagline">
        </div>
      </div>
      <div class="form-group" style="max-width:160px;">
        <label class="form-label">Number of Products</label>
        <input class="form-control" type="number" name="bestsellers_count" min="1" max="12"
               value="{{ old('bestsellers_count', $settings->bestsellers_count) }}" required>
      </div>
    </div>

    {{-- Featured Bakery --}}
    <div class="admin-card">
      <h3 class="admin-card__title" style="margin-bottom:14px;">Featured Bakery Products</h3>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Heading</label>
          <input class="form-control @error('featured_bakery_heading') is-invalid @enderror" type="text"
                 name="featured_bakery_heading" value="{{ old('featured_bakery_heading', $settings->featured_bakery_heading) }}" required>
          @error('featured_bakery_heading')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Sub-heading</label>
          <input class="form-control" type="text" name="featured_bakery_subheading"
                 value="{{ old('featured_bakery_subheading', $settings->featured_bakery_subheading) }}">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Category Slug</label>
          <input class="form-control" type="text" name="featured_bakery_category"
                 value="{{ old('featured_bakery_category', $settings->featured_bakery_category) }}"
                 placeholder="bakery" required>
          <p class="form-hint" style="margin-top:4px;">Products from this category slug will be shown.</p>
        </div>
        <div class="form-group" style="max-width:160px;">
          <label class="form-label">Count</label>
          <input class="form-control" type="number" name="featured_bakery_count" min="1" max="12"
                 value="{{ old('featured_bakery_count', $settings->featured_bakery_count) }}" required>
        </div>
      </div>
    </div>

    {{-- Featured Sweets --}}
    <div class="admin-card">
      <h3 class="admin-card__title" style="margin-bottom:14px;">Featured Sweets</h3>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Heading</label>
          <input class="form-control @error('featured_sweets_heading') is-invalid @enderror" type="text"
                 name="featured_sweets_heading" value="{{ old('featured_sweets_heading', $settings->featured_sweets_heading) }}" required>
          @error('featured_sweets_heading')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Sub-heading</label>
          <input class="form-control" type="text" name="featured_sweets_subheading"
                 value="{{ old('featured_sweets_subheading', $settings->featured_sweets_subheading) }}">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Category Slug</label>
          <input class="form-control" type="text" name="featured_sweets_category"
                 value="{{ old('featured_sweets_category', $settings->featured_sweets_category) }}"
                 placeholder="sweets" required>
        </div>
        <div class="form-group" style="max-width:160px;">
          <label class="form-label">Count</label>
          <input class="form-control" type="number" name="featured_sweets_count" min="1" max="12"
                 value="{{ old('featured_sweets_count', $settings->featured_sweets_count) }}" required>
        </div>
      </div>
    </div>

    {{-- Signature Dishes --}}
    <div class="admin-card">
      <h3 class="admin-card__title" style="margin-bottom:14px;">Signature Dishes Section</h3>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Heading</label>
          <input class="form-control" type="text" name="signature_heading"
                 value="{{ old('signature_heading', $settings->signature_heading) }}" required>
        </div>
        <div class="form-group">
          <label class="form-label">Sub-heading</label>
          <input class="form-control" type="text" name="signature_subheading"
                 value="{{ old('signature_subheading', $settings->signature_subheading) }}">
        </div>
      </div>
    </div>

    {{-- Fresh From Oven --}}
    <div class="admin-card">
      <h3 class="admin-card__title" style="margin-bottom:14px;">Fresh From The Oven Section</h3>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Heading</label>
          <input class="form-control" type="text" name="fresh_heading"
                 value="{{ old('fresh_heading', $settings->fresh_heading) }}" required>
        </div>
        <div class="form-group">
          <label class="form-label">Sub-heading</label>
          <input class="form-control" type="text" name="fresh_subheading"
                 value="{{ old('fresh_subheading', $settings->fresh_subheading) }}">
        </div>
      </div>
      <div class="form-group" style="max-width:160px;">
        <label class="form-label">Count</label>
        <input class="form-control" type="number" name="fresh_count" min="1" max="12"
               value="{{ old('fresh_count', $settings->fresh_count) }}" required>
      </div>
    </div>

    {{-- Why Choose Us --}}
    <div class="admin-card">
      <h3 class="admin-card__title" style="margin-bottom:14px;">Why Choose Us Section</h3>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Heading</label>
          <input class="form-control" type="text" name="why_choose_heading"
                 value="{{ old('why_choose_heading', $settings->why_choose_heading) }}" required>
        </div>
        <div class="form-group">
          <label class="form-label">Sub-heading</label>
          <input class="form-control" type="text" name="why_choose_subheading"
                 value="{{ old('why_choose_subheading', $settings->why_choose_subheading) }}">
        </div>
      </div>
    </div>

    {{-- Testimonials --}}
    <div class="admin-card">
      <h3 class="admin-card__title" style="margin-bottom:14px;">Testimonials Section</h3>
      <div class="form-group" style="max-width:400px;">
        <label class="form-label">Section Heading</label>
        <input class="form-control" type="text" name="testimonials_heading"
               value="{{ old('testimonials_heading', $settings->testimonials_heading) }}" required>
      </div>
    </div>

    {{-- Instagram --}}
    <div class="admin-card">
      <h3 class="admin-card__title" style="margin-bottom:14px;">Instagram Feed Section</h3>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Section Heading</label>
          <input class="form-control" type="text" name="instagram_heading"
                 value="{{ old('instagram_heading', $settings->instagram_heading) }}" required>
        </div>
        <div class="form-group">
          <label class="form-label">Instagram Handle</label>
          <input class="form-control" type="text" name="instagram_handle"
                 value="{{ old('instagram_handle', $settings->instagram_handle) }}"
                 placeholder="@azmeerbakery">
        </div>
      </div>
    </div>

  </div>

  {{-- ── TAB: SEO ───────────────────────────────────────────── --}}
  <div class="stab-panel" id="tab-seo">
    <div class="admin-card">
      <h3 class="admin-card__title" style="margin-bottom:16px;">Homepage SEO</h3>

      <div class="form-group">
        <label class="form-label">SEO Title <span style="font-weight:400;color:var(--clr-muted);">(max 60 chars)</span></label>
        <input class="form-control" type="text" name="seo_title" maxlength="255"
               value="{{ old('seo_title', $settings->seo_title) }}"
               placeholder="Azmeer Bakery — Fresh Baked Goods in Lahore">
      </div>

      <div class="form-group">
        <label class="form-label">Meta Description <span style="font-weight:400;color:var(--clr-muted);">(max 160 chars)</span></label>
        <textarea class="form-control" name="seo_description" rows="3" maxlength="500"
                  placeholder="Order freshly baked breads, pastries, cakes and traditional sweets from Azmeer Bakery…">{{ old('seo_description', $settings->seo_description) }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Meta Keywords <span style="font-weight:400;color:var(--clr-muted);">(comma-separated)</span></label>
        <input class="form-control" type="text" name="seo_keywords"
               value="{{ old('seo_keywords', $settings->seo_keywords) }}"
               placeholder="bakery Lahore, fresh bread, cakes, sweets Pakistan">
      </div>

      <hr style="margin:20px 0;border-color:var(--clr-border);">
      <h4 style="font-size:14px;font-weight:700;margin-bottom:14px;">Open Graph (Social Sharing)</h4>

      <div class="form-group">
        <label class="form-label">OG Title</label>
        <input class="form-control" type="text" name="og_title"
               value="{{ old('og_title', $settings->og_title) }}"
               placeholder="Leave blank to use SEO Title">
      </div>

      <div class="form-group">
        <label class="form-label">OG Description</label>
        <textarea class="form-control" name="og_description" rows="3"
                  placeholder="Leave blank to use Meta Description">{{ old('og_description', $settings->og_description) }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">OG Image URL</label>
        <input class="form-control" type="text" name="og_image"
               value="{{ old('og_image', $settings->og_image) }}"
               placeholder="Paste full URL or storage path">
        <p style="font-size:11px;color:var(--clr-muted);margin-top:4px;">Recommended: 1200×630 px. Use Media Library to get URL.</p>
      </div>
    </div>
  </div>

  <div style="padding-top:8px;">
    <button type="submit" class="btn btn--primary">Save Settings</button>
    <a href="{{ route('admin.homepage.index') }}" class="btn btn--outline" style="margin-left:8px;">Cancel</a>
  </div>

</form>
@endsection

@push('styles')
<style>
  .stab-nav  { display:flex; gap:4px; border-bottom:2px solid var(--clr-border); margin-bottom:20px; }
  .stab-btn  { padding:10px 18px; border:none; background:none; font-size:13px; font-weight:600; color:var(--clr-muted); cursor:pointer; border-bottom:2px solid transparent; margin-bottom:-2px; transition:color .15s, border-color .15s; }
  .stab-btn--active { color:var(--clr-gold); border-bottom-color:var(--clr-gold); }
  .stab-panel  { display:none; }
  .stab-panel--active { display:block; }
  .stab-panel { display:flex; flex-direction:column; gap:20px; }
  .stab-panel--active { display:flex; }

  .toggle-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:12px; }
  .toggle-row  { display:flex; align-items:center; justify-content:space-between; padding:10px 14px;
                 border:1px solid var(--clr-border); border-radius:8px; cursor:pointer; }
  .toggle-row:hover { background:var(--clr-bg); }
  .toggle-label { font-size:14px; font-weight:500; }
  .toggle-check { display:none; }
  .toggle-ui {
    width:40px; height:22px; border-radius:11px; background:var(--clr-border);
    position:relative; transition:background .2s; flex-shrink:0;
  }
  .toggle-ui::after {
    content:''; position:absolute; top:3px; left:3px;
    width:16px; height:16px; border-radius:50%; background:#fff;
    transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.2);
  }
  .toggle-check:checked + .toggle-ui { background:var(--clr-gold); }
  .toggle-check:checked + .toggle-ui::after { transform:translateX(18px); }
  .form-hint { font-size:11px; color:var(--clr-muted); }
</style>
@endpush

@push('scripts')
<script>
(function(){
  const btns   = document.querySelectorAll('.stab-btn');
  const panels = document.querySelectorAll('.stab-panel');
  btns.forEach(btn => btn.addEventListener('click', () => {
    btns.forEach(b => b.classList.remove('stab-btn--active'));
    panels.forEach(p => p.classList.remove('stab-panel--active'));
    btn.classList.add('stab-btn--active');
    document.getElementById('tab-' + btn.dataset.tab).classList.add('stab-panel--active');
  }));
  // auto-activate tab with first error
  const firstErr = document.querySelector('.form-error');
  if (firstErr) {
    const panel = firstErr.closest('.stab-panel');
    if (panel) {
      const id  = panel.id.replace('tab-','');
      const btn = document.querySelector('[data-tab="'+id+'"]');
      if (btn) btn.click();
    }
  }
}());
</script>
@endpush
