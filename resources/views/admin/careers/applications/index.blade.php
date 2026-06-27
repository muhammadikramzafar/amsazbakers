@extends('admin.layouts.app')
@section('title', 'Job Applications')

@section('content')
<div class="admin-page">
  <div class="admin-page__header">
    <div>
      <h1 class="admin-page__title">Job Applications</h1>
      <p class="admin-page__sub">{{ $applications->total() }} applications</p>
    </div>
    <a href="{{ route('admin.careers.listings.index') }}" class="btn btn--outline">← Job Listings</a>
  </div>

  @if(session('success'))<div class="alert alert--success">{{ session('success') }}</div>@endif

  <form method="GET" class="admin-filters">
    <select name="job_id" class="filter-select">
      <option value="">All Positions</option>
      @foreach($listings as $l)
        <option value="{{ $l->id }}" {{ request('job_id') == $l->id ? 'selected':'' }}>{{ $l->title }}</option>
      @endforeach
    </select>
    <select name="status" class="filter-select">
      <option value="">All Statuses</option>
      <option value="pending"     {{ request('status') === 'pending'     ? 'selected':'' }}>Pending</option>
      <option value="reviewing"   {{ request('status') === 'reviewing'   ? 'selected':'' }}>Under Review</option>
      <option value="shortlisted" {{ request('status') === 'shortlisted' ? 'selected':'' }}>Shortlisted</option>
      <option value="rejected"    {{ request('status') === 'rejected'    ? 'selected':'' }}>Rejected</option>
    </select>
    <button type="submit" class="btn btn--primary">Filter</button>
    @if(request()->hasAny(['job_id','status']))<a href="{{ route('admin.careers.applications.index') }}" class="btn btn--outline">Clear</a>@endif
  </form>

  <div class="admin-card">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Applicant</th>
          <th>Position</th>
          <th>Phone</th>
          <th>Resume</th>
          <th>Applied</th>
          <th>Status</th>
          <th style="width:100px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($applications as $app)
        <tr>
          <td>
            <strong>{{ $app->full_name }}</strong><br>
            <span style="font-size:12px;color:#888;">{{ $app->email }}</span>
          </td>
          <td>{{ $app->job->title ?? '—' }}</td>
          <td>{{ $app->phone ?? '—' }}</td>
          <td>
            @if($app->resume_url)
              <a href="{{ $app->resume_url }}" target="_blank" class="btn btn--sm btn--outline">Download</a>
            @else —
            @endif
          </td>
          <td>{{ $app->created_at->format('d M Y') }}</td>
          <td>
            <span class="badge" style="background:{{ $app->status_color }}20;color:{{ $app->status_color }};border:1px solid {{ $app->status_color }}40;">
              {{ $app->status_label }}
            </span>
          </td>
          <td class="admin-table__actions">
            <a href="{{ route('admin.careers.applications.show', $app) }}" class="btn btn--sm btn--outline">View</a>
            <form method="POST" action="{{ route('admin.careers.applications.destroy', $app) }}" onsubmit="return confirm('Delete application?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn--sm btn--danger">Del</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="admin-table__empty">No applications found.</td></tr>
        @endforelse
      </tbody>
    </table>
    <div class="admin-card__footer">{{ $applications->withQueryString()->links() }}</div>
  </div>
</div>
@endsection
