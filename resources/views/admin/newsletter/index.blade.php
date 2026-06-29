@extends('admin.layouts.app')
@section('title', 'Newsletter Subscribers')
@section('breadcrumb', 'Newsletter')

@section('content')
<div class="admin-page">

  {{-- Header --}}
  <div class="admin-page__header">
    <div>
      <h1 class="admin-page__title">Newsletter Subscribers</h1>
      <p class="admin-page__sub">Manage your mailing list and export contacts</p>
    </div>
    <a href="{{ route('admin.newsletter.export') }}" class="btn btn--primary">
      <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M8 2v8"/><polyline points="5,7 8,10 11,7"/><rect x="2" y="11" width="12" height="3" rx="1"/></svg>
      Export CSV
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert--success">
      <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M3 8l4 4 6-6"/></svg>
      {{ session('success') }}
    </div>
  @endif

  {{-- Stats --}}
  @php
    $totalCount       = $subscribers->total() ?? 0;
    $activeCount      = $totalActive ?? 0;
    $unsubCount       = $totalCount - $activeCount;
  @endphp
  <div class="nl-stats">
    <div class="nl-stat">
      <div class="nl-stat__num">{{ number_format($totalCount) }}</div>
      <div class="nl-stat__label">Total Subscribers</div>
    </div>
    <div class="nl-stat nl-stat--green">
      <div class="nl-stat__num">{{ number_format($activeCount) }}</div>
      <div class="nl-stat__label">Active</div>
    </div>
    <div class="nl-stat nl-stat--grey">
      <div class="nl-stat__num">{{ number_format($unsubCount) }}</div>
      <div class="nl-stat__label">Unsubscribed</div>
    </div>
  </div>

  {{-- Filters --}}
  <form method="GET" class="admin-filters">
    <svg viewBox="0 0 16 16" fill="none" stroke="#aaa" stroke-width="1.5" width="16" height="16"><circle cx="7" cy="7" r="5"/><path d="m11 11 3 3"/></svg>
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search email or name…"
           class="form-control" style="max-width:240px;font-size:13px;" />
    <select name="status" class="filter-select">
      <option value="">All Statuses</option>
      <option value="active"       {{ request('status') === 'active'       ? 'selected':'' }}>Active</option>
      <option value="unsubscribed" {{ request('status') === 'unsubscribed' ? 'selected':'' }}>Unsubscribed</option>
    </select>
    <button type="submit" class="btn btn--primary btn--sm">Filter</button>
    @if(request()->hasAny(['search','status']))
      <a href="{{ route('admin.newsletter.index') }}" class="btn btn--outline btn--sm">Clear</a>
    @endif
  </form>

  {{-- Table --}}
  <div class="admin-card" style="padding:0;overflow:hidden;">
    <table class="admin-table">
      <thead>
        <tr>
          <th style="padding-left:20px;">Email</th>
          <th>Name</th>
          <th>Status</th>
          <th>Subscribed On</th>
          <th style="width:80px;text-align:right;padding-right:20px;">Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($subscribers as $sub)
        <tr>
          <td style="padding-left:20px;">
            <div style="display:flex;align-items:center;gap:10px;">
              <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#c8a24a,#8b5e3c);display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:700;flex-shrink:0;">
                {{ strtoupper(substr($sub->email, 0, 1)) }}
              </div>
              <div>
                <div style="font-weight:600;font-size:13px;">{{ $sub->email }}</div>
              </div>
            </div>
          </td>
          <td style="color:var(--clr-muted);font-size:13px;">{{ $sub->name ?? '—' }}</td>
          <td>
            <span class="badge {{ $sub->status === 'active' ? 'badge--success' : 'badge--grey' }}">
              {{ ucfirst($sub->status) }}
            </span>
          </td>
          <td style="font-size:13px;color:var(--clr-muted);white-space:nowrap;">
            {{ $sub->created_at->format('d M Y') }}
          </td>
          <td style="text-align:right;padding-right:20px;">
            <form method="POST" action="{{ route('admin.newsletter.destroy', $sub) }}"
                  onsubmit="return confirm('Remove {{ addslashes($sub->email) }} from the list?')" style="display:inline;">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn--sm btn--danger" title="Remove subscriber">
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" width="12" height="12"><polyline points="2,4 14,4"/><path d="M5 4V2h6v2"/><path d="M3 4l1 10h8l1-10"/></svg>
              </button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" style="text-align:center;padding:60px 24px;color:var(--clr-muted);">
            <svg viewBox="0 0 48 48" fill="none" stroke="#ddd" stroke-width="1.5" width="40" height="40" style="display:block;margin:0 auto 12px;"><path d="M8 12h32M8 24h20M8 36h14"/><circle cx="38" cy="34" r="8"/><path d="M34 34h8M38 30v8"/></svg>
            No subscribers yet. Share your website to grow your list!
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
    @if($subscribers->hasPages())
      <div class="admin-card__footer" style="padding:12px 20px;">
        {{ $subscribers->withQueryString()->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
