@extends('admin.layouts.app')
@section('title', 'Site Settings')
@section('breadcrumb', 'Site Settings')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">Site Settings</h1>
</div>

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" novalidate>
  @csrf @method('PUT')

  {{-- ── Tab navigation ───────────────────────────────────── --}}
  <div class="settings-tabs admin-card" style="padding:0; overflow:hidden;">
    <nav class="settings-tab-nav" role="tablist">
      <button type="button" class="stab stab--active" data-tab="general">General</button>
      <button type="button" class="stab" data-tab="contact">Contact</button>
      <button type="button" class="stab" data-tab="social">Social Media</button>
      <button type="button" class="stab" data-tab="business">Business</button>
      <button type="button" class="stab" data-tab="footer">Footer</button>
    </nav>

    {{-- ── General ───────────────────────────────────────── --}}
    <div id="tab-general" class="stab-panel stab-panel--active" style="padding:24px;">

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="website_name">Website Name <span class="req">*</span></label>
          <input class="form-control @error('website_name') is-invalid @enderror"
                 type="text" id="website_name" name="website_name"
                 value="{{ old('website_name', $settings->website_name) }}" required />
          @error('website_name')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="tagline">Tagline</label>
          <input class="form-control @error('tagline') is-invalid @enderror"
                 type="text" id="tagline" name="tagline"
                 value="{{ old('tagline', $settings->tagline) }}"
                 placeholder="Crafted with Love, Delivered Fresh" />
          @error('tagline')<p class="form-error">{{ $message }}</p>@enderror
        </div>
      </div>

      <div class="form-row form-row--3">
        {{-- Logo --}}
        <div class="form-group">
          <label class="form-label">Company Logo</label>
          @if($settings->logo)
            <img src="{{ Storage::url($settings->logo) }}" alt="Logo" class="settings-img-preview" />
          @endif
          <input class="form-control" type="file" name="logo" accept=".jpg,.jpeg,.png,.webp,.svg" />
          <p class="form-hint">Recommended: 300×100 px, transparent PNG or SVG</p>
        </div>
        {{-- Footer Logo --}}
        <div class="form-group">
          <label class="form-label">Footer Logo</label>
          @if($settings->footer_logo)
            <img src="{{ Storage::url($settings->footer_logo) }}" alt="Footer Logo" class="settings-img-preview" />
          @endif
          <input class="form-control" type="file" name="footer_logo" accept=".jpg,.jpeg,.png,.webp,.svg" />
          <p class="form-hint">Typically white/light version of the logo</p>
        </div>
        {{-- Favicon --}}
        <div class="form-group">
          <label class="form-label">Favicon</label>
          @if($settings->favicon)
            <img src="{{ Storage::url($settings->favicon) }}" alt="Favicon" style="width:32px;height:32px;margin-bottom:8px;display:block;" />
          @endif
          <input class="form-control" type="file" name="favicon" accept=".ico,.png" />
          <p class="form-hint">32×32 or 16×16 px .ico or .png</p>
        </div>
      </div>

    </div>

    {{-- ── Contact ───────────────────────────────────────── --}}
    <div id="tab-contact" class="stab-panel" style="padding:24px;">

      <div class="form-group">
        <label class="form-label" for="address">Street Address</label>
        <textarea class="form-control @error('address') is-invalid @enderror"
                  id="address" name="address" rows="2">{{ old('address', $settings->address) }}</textarea>
        @error('address')<p class="form-error">{{ $message }}</p>@enderror
      </div>

      <div class="form-row form-row--3">
        <div class="form-group">
          <label class="form-label" for="city">City</label>
          <input class="form-control @error('city') is-invalid @enderror"
                 type="text" id="city" name="city" value="{{ old('city', $settings->city) }}" />
          @error('city')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="province">Province</label>
          <input class="form-control @error('province') is-invalid @enderror"
                 type="text" id="province" name="province" value="{{ old('province', $settings->province) }}" />
          @error('province')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="country">Country</label>
          <input class="form-control @error('country') is-invalid @enderror"
                 type="text" id="country" name="country" value="{{ old('country', $settings->country) }}" />
          @error('country')<p class="form-error">{{ $message }}</p>@enderror
        </div>
      </div>

      <div class="form-row form-row--3">
        <div class="form-group">
          <label class="form-label" for="phone">Phone Number</label>
          <input class="form-control @error('phone') is-invalid @enderror"
                 type="text" id="phone" name="phone"
                 value="{{ old('phone', $settings->phone) }}" placeholder="+92 300 0000000" />
          @error('phone')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="whatsapp">WhatsApp Number</label>
          <input class="form-control @error('whatsapp') is-invalid @enderror"
                 type="text" id="whatsapp" name="whatsapp"
                 value="{{ old('whatsapp', $settings->whatsapp) }}" placeholder="+92 300 0000000" />
          @error('whatsapp')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="email">Email Address</label>
          <input class="form-control @error('email') is-invalid @enderror"
                 type="email" id="email" name="email"
                 value="{{ old('email', $settings->email) }}" placeholder="info@bakery.pk" />
          @error('email')<p class="form-error">{{ $message }}</p>@enderror
        </div>
      </div>

    </div>

    {{-- ── Social Media ──────────────────────────────────── --}}
    <div id="tab-social" class="stab-panel" style="padding:24px;">
      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="facebook_url">Facebook URL</label>
          <input class="form-control @error('facebook_url') is-invalid @enderror"
                 type="url" id="facebook_url" name="facebook_url"
                 value="{{ old('facebook_url', $settings->facebook_url) }}"
                 placeholder="https://facebook.com/yourbakery" />
          @error('facebook_url')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="instagram_url">Instagram URL</label>
          <input class="form-control @error('instagram_url') is-invalid @enderror"
                 type="url" id="instagram_url" name="instagram_url"
                 value="{{ old('instagram_url', $settings->instagram_url) }}"
                 placeholder="https://instagram.com/yourbakery" />
          @error('instagram_url')<p class="form-error">{{ $message }}</p>@enderror
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="youtube_url">YouTube URL</label>
          <input class="form-control @error('youtube_url') is-invalid @enderror"
                 type="url" id="youtube_url" name="youtube_url"
                 value="{{ old('youtube_url', $settings->youtube_url) }}"
                 placeholder="https://youtube.com/@yourbakery" />
          @error('youtube_url')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="tiktok_url">TikTok URL</label>
          <input class="form-control @error('tiktok_url') is-invalid @enderror"
                 type="url" id="tiktok_url" name="tiktok_url"
                 value="{{ old('tiktok_url', $settings->tiktok_url) }}"
                 placeholder="https://tiktok.com/@yourbakery" />
          @error('tiktok_url')<p class="form-error">{{ $message }}</p>@enderror
        </div>
      </div>
    </div>

    {{-- ── Business ──────────────────────────────────────── --}}
    <div id="tab-business" class="stab-panel" style="padding:24px;">

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="opening_time">Opening Time</label>
          <input class="form-control @error('opening_time') is-invalid @enderror"
                 type="time" id="opening_time" name="opening_time"
                 value="{{ old('opening_time', $settings->opening_time) }}" />
          @error('opening_time')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="closing_time">Closing Time</label>
          <input class="form-control @error('closing_time') is-invalid @enderror"
                 type="time" id="closing_time" name="closing_time"
                 value="{{ old('closing_time', $settings->closing_time) }}" />
          @error('closing_time')<p class="form-error">{{ $message }}</p>@enderror
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Weekly Holidays</label>
        <div class="holiday-checks">
          @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
            <label class="holiday-check">
              <input type="checkbox" name="weekly_holidays[]" value="{{ $day }}"
                {{ in_array($day, old('weekly_holidays', $settings->weekly_holidays ?? [])) ? 'checked' : '' }}>
              <span>{{ $day }}</span>
            </label>
          @endforeach
        </div>
        @error('weekly_holidays')<p class="form-error">{{ $message }}</p>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="map_embed">Google Map Embed Code</label>
        <textarea class="form-control @error('map_embed') is-invalid @enderror"
                  id="map_embed" name="map_embed" rows="4"
                  placeholder='Paste the full <iframe ...> embed code from Google Maps'>{{ old('map_embed', $settings->map_embed) }}</textarea>
        @error('map_embed')<p class="form-error">{{ $message }}</p>@enderror
        @if($settings->map_embed)
          <div class="settings-map-preview">{!! $settings->map_embed !!}</div>
        @endif
      </div>

    </div>

    {{-- ── Footer ────────────────────────────────────────── --}}
    <div id="tab-footer" class="stab-panel" style="padding:24px;">

      <div class="form-group">
        <label class="form-label" for="footer_description">Footer Description</label>
        <textarea class="form-control @error('footer_description') is-invalid @enderror"
                  id="footer_description" name="footer_description" rows="3"
                  placeholder="Short description shown in the website footer…">{{ old('footer_description', $settings->footer_description) }}</textarea>
        @error('footer_description')<p class="form-error">{{ $message }}</p>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="copyright_text">Copyright Text</label>
        <input class="form-control @error('copyright_text') is-invalid @enderror"
               type="text" id="copyright_text" name="copyright_text"
               value="{{ old('copyright_text', $settings->copyright_text) }}"
               placeholder="© 2025 Azmeer Bakery. All rights reserved." />
        @error('copyright_text')<p class="form-error">{{ $message }}</p>@enderror
      </div>

    </div>

    {{-- Save button --}}
    <div style="padding:16px 24px; border-top:1px solid var(--clr-border); background:var(--clr-bg);">
      <button type="submit" class="btn btn--primary">Save Settings</button>
    </div>
  </div>

</form>
@endsection

@push('styles')
<style>
  .req { color:var(--clr-danger); }
  .form-hint { font-size:11px; color:var(--clr-muted); margin-top:4px; }
  .form-row--3 { grid-template-columns: repeat(3,1fr); }
  @media(max-width:900px){ .form-row--3 { grid-template-columns:1fr; } }

  /* Tab nav */
  .settings-tab-nav { display:flex; flex-wrap:wrap; border-bottom:1px solid var(--clr-border); gap:0; }
  .stab {
    padding:12px 20px; border:none; background:none; cursor:pointer;
    font-size:13px; font-weight:600; color:var(--clr-muted);
    border-bottom:2px solid transparent; margin-bottom:-1px;
    transition:color .15s, border-color .15s;
  }
  .stab:hover { color:var(--clr-brown); }
  .stab--active { color:var(--clr-gold); border-bottom-color:var(--clr-gold); }

  /* Panels */
  .stab-panel { display:none; }
  .stab-panel--active { display:block; }

  /* File previews */
  .settings-img-preview { display:block; height:56px; width:auto; margin-bottom:8px; border-radius:4px; border:1px solid var(--clr-border); background:#f8f9fa; padding:2px; }
  .settings-map-preview { margin-top:12px; border-radius:var(--radius); overflow:hidden; }
  .settings-map-preview iframe { width:100%; height:220px; border:0; display:block; }

  /* Holiday checkboxes */
  .holiday-checks { display:flex; flex-wrap:wrap; gap:10px 20px; }
  .holiday-check  { display:flex; align-items:center; gap:6px; cursor:pointer; font-size:13px; }
  .holiday-check input { accent-color:var(--clr-gold); width:15px; height:15px; }
</style>
@endpush

@push('scripts')
<script>
(function () {
  const tabs   = document.querySelectorAll('.stab');
  const panels = document.querySelectorAll('.stab-panel');

  function activate(tab) {
    tabs.forEach(t   => t.classList.remove('stab--active'));
    panels.forEach(p => p.classList.remove('stab-panel--active'));
    tab.classList.add('stab--active');
    document.getElementById('tab-' + tab.dataset.tab).classList.add('stab-panel--active');
  }

  tabs.forEach(tab => tab.addEventListener('click', () => activate(tab)));

  // Restore tab on validation error
  const firstError = document.querySelector('.form-error');
  if (firstError) {
    const panel = firstError.closest('.stab-panel');
    if (panel) {
      const id  = panel.id.replace('tab-', '');
      const btn = document.querySelector('.stab[data-tab="' + id + '"]');
      if (btn) activate(btn);
    }
  }
}());
</script>
@endpush
