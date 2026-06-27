@extends('frontend.layouts.app')

@section('title', $jobListing->title.' — Careers — Azmeer Bakery')
@section('meta_description', Str::limit(strip_tags($jobListing->description), 155))

@push('styles')
<style>
.careers-detail { max-width:var(--container-max); margin:0 auto; padding:60px var(--container-pad); display:grid; grid-template-columns:1fr 340px; gap:40px; align-items:start; }
@media(max-width:900px){ .careers-detail { grid-template-columns:1fr; } }
.job-heading { font-size:clamp(24px,4vw,36px); font-weight:700; color:var(--clr-heading); margin-bottom:12px; }
.job-meta { display:flex; gap:14px; flex-wrap:wrap; margin-bottom:24px; }
.job-type { display:inline-block; padding:4px 14px; border-radius:12px; font-size:13px; font-weight:700; }
.job-type--full-time  { background:#e8f8ef; color:#0a7340; }
.job-type--part-time  { background:#fef9e8; color:#7a6200; }
.job-type--contract   { background:#e8f4fd; color:#1a6fa8; }
.job-type--internship { background:#f3e2c7; color:#5a3e2b; }
.job-meta-item { display:flex; align-items:center; gap:5px; font-size:13px; color:#888; }
.job-section { margin-bottom:32px; }
.job-section h2 { font-size:18px; font-weight:700; color:var(--clr-heading); margin-bottom:12px; padding-bottom:8px; border-bottom:2px solid var(--clr-primary); display:inline-block; }
.job-section p, .job-section li { font-size:15px; color:#444; line-height:1.8; }
.job-section ul { padding-left:20px; margin:0; }
.req-list { list-style:none; padding:0; margin:0; }
.req-list li { padding:6px 0; border-bottom:1px solid var(--clr-border); font-size:15px; color:#444; display:flex; gap:8px; align-items:flex-start; }
.req-list li::before { content:'✓'; color:var(--clr-primary); font-weight:bold; flex-shrink:0; }
.apply-card { background:#fff; border-radius:12px; padding:28px; box-shadow:0 4px 20px rgba(0,0,0,.08); position:sticky; top:80px; }
.apply-card h2 { font-size:20px; font-weight:700; margin-bottom:4px; }
.apply-card p { font-size:13px; color:#888; margin-bottom:20px; }
</style>
@endpush

@section('content')
  <section class="page-banner">
    <nav class="breadcrumb"><a href="{{ route('home') }}" class="breadcrumb__link">Home</a><span class="breadcrumb__sep">/</span><a href="{{ route('careers.index') }}" class="breadcrumb__link">Careers</a><span class="breadcrumb__sep">/</span><span class="breadcrumb__current">{{ Str::limit($jobListing->title, 40) }}</span></nav>
    <span class="gold-rule gold-rule--center"></span>
  </section>

  <div class="careers-detail">
    <div>
      <h1 class="job-heading">{{ $jobListing->title }}</h1>
      <div class="job-meta">
        <span class="job-type job-type--{{ $jobListing->type }}">{{ $jobListing->type_label }}</span>
        @if($jobListing->department)<span class="job-meta-item">🏢 {{ $jobListing->department }}</span>@endif
        @if($jobListing->location)<span class="job-meta-item">📍 {{ $jobListing->location }}</span>@endif
        @if($jobListing->salary_range)<span class="job-meta-item">💰 {{ $jobListing->salary_range }}</span>@endif
        @if($jobListing->application_deadline)
          <span class="job-meta-item" style="{{ $jobListing->is_expired ? 'color:#e74c3c;' : '' }}">
            📅 {{ $jobListing->is_expired ? 'Closed' : 'Deadline: '.$jobListing->application_deadline->format('d M Y') }}
          </span>
        @endif
      </div>

      <div class="job-section">
        <h2>Job Description</h2>
        <div style="font-size:15px;color:#444;line-height:1.8;">{!! nl2br(e($jobListing->description)) !!}</div>
      </div>

      @if($jobListing->requirements)
      <div class="job-section">
        <h2>Requirements</h2>
        <ul class="req-list">
          @foreach(explode("\n", trim($jobListing->requirements)) as $req)
            @if(trim($req))<li>{{ trim($req) }}</li>@endif
          @endforeach
        </ul>
      </div>
      @endif

      @if($jobListing->benefits)
      <div class="job-section">
        <h2>Benefits</h2>
        <div style="font-size:15px;color:#444;line-height:1.8;">{!! nl2br(e($jobListing->benefits)) !!}</div>
      </div>
      @endif
    </div>

    <!-- Apply Card -->
    <div class="apply-card">
      @if($jobListing->is_expired)
        <h2>Applications Closed</h2>
        <p>This position is no longer accepting applications.</p>
        <a href="{{ route('careers.index') }}" class="btn btn--outline" style="width:100%;text-align:center;">View Other Positions</a>
      @else
        <h2>Apply Now</h2>
        <p>Interested in joining us? Fill out the form below.</p>

        @if(session('success'))
          <div class="alert alert--success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
          <div class="alert alert--error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('careers.apply', $jobListing->slug) }}" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label class="form-label">Full Name *</label>
            <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" required />
          </div>
          <div class="form-group">
            <label class="form-label">Email Address *</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required />
          </div>
          <div class="form-group">
            <label class="form-label">Phone Number</label>
            <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" />
          </div>
          <div class="form-group">
            <label class="form-label">Cover Letter</label>
            <textarea name="cover_letter" class="form-control" rows="4" placeholder="Tell us about yourself and why you want to join Azmeer Bakery…">{{ old('cover_letter') }}</textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Resume / CV * <span style="color:#aaa;font-weight:400;">(PDF, DOC, DOCX — max 5MB)</span></label>
            <input type="file" name="resume" class="form-control" accept=".pdf,.doc,.docx" required />
          </div>
          <button type="submit" class="btn btn--primary" style="width:100%;margin-top:8px;">Submit Application</button>
        </form>
      @endif
    </div>
  </div>
@endsection
