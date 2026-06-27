@extends('admin.layouts.app')
@section('title', 'Application — '.$application->full_name)

@section('content')
<div class="admin-page">
  <div class="admin-page__header">
    <h1 class="admin-page__title">Application: {{ $application->full_name }}</h1>
    <a href="{{ route('admin.careers.applications.index') }}" class="btn btn--outline">Back</a>
  </div>

  @if(session('success'))<div class="alert alert--success">{{ session('success') }}</div>@endif

  <div style="display:grid;grid-template-columns:1fr 320px;gap:24px;align-items:start;">

    <div>
      <div class="admin-card" style="padding:28px;margin-bottom:20px;">
        <h2 style="font-size:16px;font-weight:700;margin-bottom:16px;">Applicant Details</h2>
        <table style="width:100%;border-collapse:collapse;">
          <tr><td style="padding:8px 0;color:#888;width:140px;">Full Name</td><td><strong>{{ $application->full_name }}</strong></td></tr>
          <tr><td style="padding:8px 0;color:#888;">Email</td><td><a href="mailto:{{ $application->email }}">{{ $application->email }}</a></td></tr>
          <tr><td style="padding:8px 0;color:#888;">Phone</td><td>{{ $application->phone ?? '—' }}</td></tr>
          <tr><td style="padding:8px 0;color:#888;">Position</td><td>{{ $application->job->title ?? '—' }}</td></tr>
          <tr><td style="padding:8px 0;color:#888;">Applied</td><td>{{ $application->created_at->format('d M Y, h:i A') }}</td></tr>
          <tr><td style="padding:8px 0;color:#888;">Resume</td>
              <td>@if($application->resume_url)<a href="{{ $application->resume_url }}" target="_blank" class="btn btn--sm btn--outline">Download Resume</a>@else —@endif</td></tr>
        </table>
      </div>

      @if($application->cover_letter)
      <div class="admin-card" style="padding:28px;margin-bottom:20px;">
        <h2 style="font-size:16px;font-weight:700;margin-bottom:12px;">Cover Letter</h2>
        <p style="white-space:pre-line;color:#444;line-height:1.7;">{{ $application->cover_letter }}</p>
      </div>
      @endif
    </div>

    <div class="admin-card" style="padding:24px;">
      <h2 style="font-size:16px;font-weight:700;margin-bottom:16px;">Update Status</h2>
      <form method="POST" action="{{ route('admin.careers.applications.update', $application) }}">
        @csrf @method('PUT')
        <div class="form-group">
          <label class="form-label">Status</label>
          <select name="status" class="form-control">
            <option value="pending"     {{ $application->status === 'pending'     ? 'selected':'' }}>Pending</option>
            <option value="reviewing"   {{ $application->status === 'reviewing'   ? 'selected':'' }}>Under Review</option>
            <option value="shortlisted" {{ $application->status === 'shortlisted' ? 'selected':'' }}>Shortlisted</option>
            <option value="rejected"    {{ $application->status === 'rejected'    ? 'selected':'' }}>Rejected</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Internal Notes</label>
          <textarea name="notes" class="form-control" rows="5" placeholder="Internal notes (not visible to applicant)">{{ $application->notes }}</textarea>
        </div>
        <button type="submit" class="btn btn--primary" style="width:100%;">Update Status</button>
      </form>
    </div>
  </div>
</div>
@endsection
