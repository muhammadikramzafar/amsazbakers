@extends('admin.layouts.app')
@section('title', 'Job Listings')

@section('content')
<div class="admin-page">
  <div class="admin-page__header">
    <div>
      <h1 class="admin-page__title">Job Listings</h1>
      <p class="admin-page__sub">{{ $listings->total() }} positions</p>
    </div>
    <div style="display:flex;gap:10px;">
      <a href="{{ route('admin.careers.applications.index') }}" class="btn btn--outline">View Applications</a>
      <a href="{{ route('admin.careers.listings.create') }}" class="btn btn--primary">+ New Position</a>
    </div>
  </div>

  @if(session('success'))<div class="alert alert--success">{{ session('success') }}</div>@endif

  <div class="admin-card">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Position</th>
          <th>Department</th>
          <th>Type</th>
          <th>Location</th>
          <th>Applications</th>
          <th>Deadline</th>
          <th>Active</th>
          <th style="width:120px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($listings as $listing)
        <tr>
          <td><strong>{{ $listing->title }}</strong></td>
          <td>{{ $listing->department ?? '—' }}</td>
          <td>
            <span class="badge {{ match($listing->type){ 'full-time'=>'badge--success','part-time'=>'badge--warning','internship'=>'badge--grey',default=>'badge--grey' } }}">
              {{ $listing->type_label }}
            </span>
          </td>
          <td>{{ $listing->location ?? '—' }}</td>
          <td>
            <a href="{{ route('admin.careers.applications.index', ['job_id' => $listing->id]) }}" style="text-decoration:none;color:var(--clr-primary);">
              {{ $listing->applications_count }}
            </a>
          </td>
          <td>
            @if($listing->application_deadline)
              <span style="{{ $listing->is_expired ? 'color:#e74c3c;' : '' }}">{{ $listing->application_deadline->format('d M Y') }}</span>
            @else
              —
            @endif
          </td>
          <td><span class="badge {{ $listing->is_active ? 'badge--success':'badge--grey' }}">{{ $listing->is_active ? 'Active':'Inactive' }}</span></td>
          <td class="admin-table__actions">
            <a href="{{ route('admin.careers.listings.edit', $listing) }}" class="btn btn--sm btn--outline">Edit</a>
            <form method="POST" action="{{ route('admin.careers.listings.destroy', $listing) }}" onsubmit="return confirm('Delete this listing?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn--sm btn--danger">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" class="admin-table__empty">No job listings. <a href="{{ route('admin.careers.listings.create') }}">Create one.</a></td></tr>
        @endforelse
      </tbody>
    </table>
    <div class="admin-card__footer">{{ $listings->links() }}</div>
  </div>
</div>
@endsection
