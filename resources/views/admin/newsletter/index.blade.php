@extends('admin.layouts.app')
@section('title', 'Newsletter Subscribers')

@section('content')
<div class="admin-page">
  <div class="admin-page__header">
    <div>
      <h1 class="admin-page__title">Newsletter Subscribers</h1>
      <p class="admin-page__sub">{{ $totalActive }} active subscriber{{ $totalActive != 1 ? 's' : '' }}</p>
    </div>
    <a href="{{ route('admin.newsletter.export') }}" class="btn btn--primary">Export CSV</a>
  </div>

  @if(session('success'))<div class="alert alert--success">{{ session('success') }}</div>@endif

  <form method="GET" class="admin-filters">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search email / name…" class="form-control" style="max-width:260px;" />
    <select name="status" class="filter-select">
      <option value="">All</option>
      <option value="active"       {{ request('status') === 'active'       ? 'selected':'' }}>Active</option>
      <option value="unsubscribed" {{ request('status') === 'unsubscribed' ? 'selected':'' }}>Unsubscribed</option>
    </select>
    <button type="submit" class="btn btn--primary">Filter</button>
    @if(request()->hasAny(['search','status']))<a href="{{ route('admin.newsletter.index') }}" class="btn btn--outline">Clear</a>@endif
  </form>

  <div class="admin-card">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Email</th>
          <th>Name</th>
          <th>Status</th>
          <th>Subscribed</th>
          <th style="width:80px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($subscribers as $sub)
        <tr>
          <td><strong>{{ $sub->email }}</strong></td>
          <td>{{ $sub->name ?? '—' }}</td>
          <td>
            <span class="badge {{ $sub->status === 'active' ? 'badge--success':'badge--grey' }}">
              {{ ucfirst($sub->status) }}
            </span>
          </td>
          <td>{{ $sub->created_at->format('d M Y') }}</td>
          <td>
            <form method="POST" action="{{ route('admin.newsletter.destroy', $sub) }}" onsubmit="return confirm('Remove subscriber?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn--sm btn--danger">Remove</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" class="admin-table__empty">No subscribers yet.</td></tr>
        @endforelse
      </tbody>
    </table>
    <div class="admin-card__footer">{{ $subscribers->withQueryString()->links() }}</div>
  </div>
</div>
@endsection
