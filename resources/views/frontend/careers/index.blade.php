@extends('frontend.layouts.app')

@section('title', 'Careers — Azmeer Bakery')
@section('meta_description', 'Join the Azmeer Bakery team. Browse open positions and apply online.')

@push('styles')
<style>
.careers-wrap { max-width:var(--container-max); margin:0 auto; padding:60px var(--container-pad); }
.job-card { background:#fff; border-radius:12px; padding:28px; box-shadow:0 2px 12px rgba(0,0,0,.06); margin-bottom:20px; display:flex; justify-content:space-between; align-items:flex-start; gap:20px; transition:box-shadow .2s; }
.job-card:hover { box-shadow:0 6px 24px rgba(0,0,0,.1); }
@media(max-width:640px){ .job-card { flex-direction:column; } }
.job-card__title { font-size:20px; font-weight:700; color:var(--clr-heading); margin-bottom:8px; }
.job-card__title a { text-decoration:none; color:inherit; }
.job-card__title a:hover { color:var(--clr-primary); }
.job-meta { display:flex; gap:14px; flex-wrap:wrap; margin-bottom:10px; }
.job-meta-item { display:flex; align-items:center; gap:5px; font-size:13px; color:#888; }
.job-type { display:inline-block; padding:3px 12px; border-radius:12px; font-size:12px; font-weight:700; }
.job-type--full-time  { background:#e8f8ef; color:#0a7340; }
.job-type--part-time  { background:#fef9e8; color:#7a6200; }
.job-type--contract   { background:#e8f4fd; color:#1a6fa8; }
.job-type--internship { background:#f3e2c7; color:#5a3e2b; }
.job-card__excerpt { font-size:14px; color:#555; line-height:1.6; max-width:600px; }
.job-card__actions { flex-shrink:0; text-align:right; }
.job-expired { color:#e74c3c; font-size:12px; font-weight:600; margin-top:6px; }
</style>
@endpush

@section('content')
  <section class="page-banner">
    <nav class="breadcrumb"><a href="{{ route('home') }}" class="breadcrumb__link">Home</a><span class="breadcrumb__sep">/</span><span class="breadcrumb__current">Careers</span></nav>
    <h1 class="page-banner__title">Careers</h1>
    <span class="gold-rule gold-rule--center"></span>
    <p style="margin-top:12px;color:#888;max-width:480px;margin-left:auto;margin-right:auto;">
      Join the Azmeer Bakery family. We're always looking for passionate people to help us bring joy through food.
    </p>
  </section>

  <div class="careers-wrap">
    @if($listings->isEmpty())
      <div style="text-align:center;padding:80px 20px;color:#aaa;">
        <p style="font-size:18px;margin-bottom:12px;">No open positions at the moment.</p>
        <p>Check back soon or <a href="{{ route('contact') }}" style="color:var(--clr-primary);">send us your resume</a>.</p>
      </div>
    @else
      @foreach($listings as $listing)
      <div class="job-card">
        <div style="flex:1;">
          <h2 class="job-card__title"><a href="{{ route('careers.show', $listing->slug) }}">{{ $listing->title }}</a></h2>
          <div class="job-meta">
            <span class="job-type job-type--{{ $listing->type }}">{{ $listing->type_label }}</span>
            @if($listing->department)<span class="job-meta-item">🏢 {{ $listing->department }}</span>@endif
            @if($listing->location)<span class="job-meta-item">📍 {{ $listing->location }}</span>@endif
            @if($listing->salary_range)<span class="job-meta-item">💰 {{ $listing->salary_range }}</span>@endif
          </div>
          <p class="job-card__excerpt">{{ Str::limit(strip_tags($listing->description), 180) }}</p>
          @if($listing->application_deadline)
            @if($listing->is_expired)
              <span class="job-expired">⚠ Applications closed</span>
            @else
              <span style="font-size:12px;color:#888;">Deadline: {{ $listing->application_deadline->format('d M Y') }}</span>
            @endif
          @endif
        </div>
        <div class="job-card__actions">
          <a href="{{ route('careers.show', $listing->slug) }}" class="btn btn--primary">View & Apply</a>
        </div>
      </div>
      @endforeach
    @endif
  </div>
@endsection
