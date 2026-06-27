@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')

{{-- Page header --}}
<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Dashboard</h1>
    <p class="dash-subtitle">Welcome back, {{ auth()->user()->name }}</p>
  </div>
  <span class="dash-date">{{ now()->format('l, d M Y') }}</span>
</div>

{{-- ── Stat cards ──────────────────────────────────────────── --}}
<div class="stats-grid stats-grid--5">

  {{-- Total Products --}}
  <div class="stat-card">
    <div class="stat-card__icon stat-card__icon--gold">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="22" height="22" aria-hidden="true">
        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 4h12"/>
        <circle cx="9" cy="19" r="1"/><circle cx="17" cy="19" r="1"/>
      </svg>
    </div>
    <div class="stat-card__body">
      <p class="stat-card__label">Total Products</p>
      <p class="stat-card__value">{{ number_format($stats['products']) }}</p>
      <p class="stat-card__meta">
        <a href="{{ route('admin.products.index') }}" class="stat-card__link">Manage &rarr;</a>
      </p>
    </div>
  </div>

  {{-- Total Blogs --}}
  <div class="stat-card">
    <div class="stat-card__icon stat-card__icon--blue">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="22" height="22" aria-hidden="true">
        <path d="M4 4h12a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1z"/>
        <path d="M6 8h8M6 11h6"/>
      </svg>
    </div>
    <div class="stat-card__body">
      <p class="stat-card__label">Total Blogs</p>
      <p class="stat-card__value">{{ number_format($stats['blogs']) }}</p>
      <p class="stat-card__meta stat-card__meta--soon">Module coming soon</p>
    </div>
  </div>

  {{-- Orders / Link Clicks --}}
  <div class="stat-card">
    <div class="stat-card__icon stat-card__icon--purple">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="22" height="22" aria-hidden="true">
        <path d="M10 3a7 7 0 1 0 0 14A7 7 0 0 0 10 3z"/>
        <path d="M10 7v3l2 2"/>
      </svg>
    </div>
    <div class="stat-card__body">
      <p class="stat-card__label">Orders / Link Clicks</p>
      <p class="stat-card__value">{{ number_format($stats['link_clicks']) }}</p>
      <p class="stat-card__meta stat-card__meta--soon">Tracking coming soon</p>
    </div>
  </div>

  {{-- Total Inquiries --}}
  <div class="stat-card">
    <div class="stat-card__icon stat-card__icon--green">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="22" height="22" aria-hidden="true">
        <path d="M4 4h12c.55 0 1 .45 1 1v8c0 .55-.45 1-1 1H4c-.55 0-1-.45-1-1V5c0-.55.45-1 1-1z"/>
        <polyline points="3,4 10,11 17,4"/>
      </svg>
    </div>
    <div class="stat-card__body">
      <p class="stat-card__label">Total Inquiries</p>
      <p class="stat-card__value">{{ number_format($stats['inquiries']) }}</p>
      <p class="stat-card__meta">
        @if($stats['unread_messages'])
          <span class="stat-card__badge">{{ $stats['unread_messages'] }} unread</span>
        @else
          <a href="{{ route('admin.contacts.index') }}" class="stat-card__link">View all &rarr;</a>
        @endif
      </p>
    </div>
  </div>

  {{-- Newsletter Subscribers --}}
  <div class="stat-card">
    <div class="stat-card__icon stat-card__icon--teal">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="22" height="22" aria-hidden="true">
        <path d="M16 12A6 6 0 0 0 4 12c0 2.5 2 4.5 2 6h8c0-1.5 2-3.5 2-6z"/>
        <path d="M10 2v1M4.5 4.5l.7.7M2 10H1M19 10h-1M14.8 5.2l.7-.7"/>
        <path d="M8 18h4"/>
      </svg>
    </div>
    <div class="stat-card__body">
      <p class="stat-card__label">Newsletter Subscribers</p>
      <p class="stat-card__value">{{ number_format($stats['subscribers']) }}</p>
      <p class="stat-card__meta stat-card__meta--soon">Module coming soon</p>
    </div>
  </div>

</div>

{{-- ── Quick Actions ───────────────────────────────────────── --}}
<div class="admin-card quick-actions-card">
  <h2 class="admin-card__title" style="margin-bottom:16px;">Quick Actions</h2>
  <div class="quick-actions">

    <a href="{{ route('admin.products.create') }}" class="quick-action">
      <div class="quick-action__icon quick-action__icon--gold">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20">
          <path d="M10 4v12M4 10h12"/>
        </svg>
      </div>
      <span>Add Product</span>
    </a>

    <a href="{{ route('admin.categories.create') }}" class="quick-action">
      <div class="quick-action__icon quick-action__icon--blue">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20">
          <rect x="2" y="2" width="16" height="5" rx="1"/><path d="M2 9h7v9H2zM11 9h7v9h-7z"/>
        </svg>
      </div>
      <span>Add Category</span>
    </a>

    <a href="{{ route('admin.reservations.index') }}" class="quick-action">
      <div class="quick-action__icon quick-action__icon--green">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20">
          <rect x="2" y="3" width="16" height="14" rx="1"/><path d="M2 8h16M6 2v2M14 2v2"/>
        </svg>
      </div>
      <span>Reservations</span>
    </a>

    <a href="{{ route('admin.contacts.index') }}" class="quick-action">
      <div class="quick-action__icon quick-action__icon--red">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20">
          <path d="M4 4h12c.55 0 1 .45 1 1v8c0 .55-.45 1-1 1H4c-.55 0-1-.45-1-1V5c0-.55.45-1 1-1z"/>
          <polyline points="3,4 10,11 17,4"/>
        </svg>
      </div>
      <span>Messages
        @if($stats['unread_messages'])
          <span class="qa-badge">{{ $stats['unread_messages'] }}</span>
        @endif
      </span>
    </a>

    @if(auth()->user()->hasRole('super-admin'))
    <a href="{{ route('admin.users.create') }}" class="quick-action">
      <div class="quick-action__icon quick-action__icon--purple">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20">
          <path d="M14 12c2 .5 4 2 4 4v1H2v-1c0-2 2-3.5 4-4"/>
          <circle cx="10" cy="7" r="3.5"/>
          <path d="M14 5l2 2-2 2"/>
        </svg>
      </div>
      <span>Add User</span>
    </a>
    @endif

    <a href="{{ route('home') }}" target="_blank" rel="noopener" class="quick-action">
      <div class="quick-action__icon quick-action__icon--teal">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20">
          <path d="M11 3h6v6"/><path d="M17 3l-8 8"/>
          <path d="M9 5H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-5"/>
        </svg>
      </div>
      <span>View Site</span>
    </a>

  </div>
</div>

{{-- ── Recent activity ─────────────────────────────────────── --}}
<div class="dashboard-grid">

  {{-- Recent Reservations --}}
  <div class="admin-card">
    <div class="admin-card__header">
      <h2 class="admin-card__title">Recent Reservations</h2>
      <a href="{{ route('admin.reservations.index') }}" class="admin-card__link">View All</a>
    </div>
    <table class="admin-table">
      <thead>
        <tr><th>Name</th><th>Date</th><th>Guests</th><th>Status</th></tr>
      </thead>
      <tbody>
        @forelse($recentReservations as $r)
          <tr>
            <td>{{ $r->name }}</td>
            <td>{{ $r->date }}</td>
            <td>{{ $r->guests }}</td>
            <td><span class="badge badge--{{ $r->status }}">{{ ucfirst($r->status) }}</span></td>
          </tr>
        @empty
          <tr><td colspan="4" class="admin-table__empty">No reservations yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Recent Messages --}}
  <div class="admin-card">
    <div class="admin-card__header">
      <h2 class="admin-card__title">Recent Inquiries</h2>
      <a href="{{ route('admin.contacts.index') }}" class="admin-card__link">View All</a>
    </div>
    <table class="admin-table">
      <thead>
        <tr><th>Name</th><th>Subject</th><th>Date</th></tr>
      </thead>
      <tbody>
        @forelse($recentMessages as $m)
          <tr class="{{ !$m->is_read ? 'admin-table__row--unread' : '' }}">
            <td>{{ $m->name }}</td>
            <td>
              <a href="{{ route('admin.contacts.show', $m->id) }}" class="dash-msg-link">
                {{ Str::limit($m->subject, 36) }}
              </a>
            </td>
            <td>{{ $m->created_at->format('d M') }}</td>
          </tr>
        @empty
          <tr><td colspan="3" class="admin-table__empty">No messages yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

</div>

@endsection

@push('styles')
<style>
  /* ── Header meta ─────────────────────────────── */
  .dash-subtitle { font-size: 13px; color: var(--clr-muted); margin-top: 2px; }
  .dash-date     { font-size: 13px; color: var(--clr-muted); }

  /* ── 5-column stat grid ───────────────────────── */
  .stats-grid--5 { grid-template-columns: repeat(5, 1fr); }
  @media (max-width: 1200px) { .stats-grid--5 { grid-template-columns: repeat(3, 1fr); } }
  @media (max-width: 768px)  { .stats-grid--5 { grid-template-columns: repeat(2, 1fr); } }
  @media (max-width: 480px)  { .stats-grid--5 { grid-template-columns: 1fr; } }

  /* ── Stat card extras ─────────────────────────── */
  .stat-card__body    { flex: 1; min-width: 0; }
  .stat-card__icon--purple { background: #ede9fe; color: #7c3aed; }
  .stat-card__icon--teal   { background: #ccfbf1; color: #0d9488; }
  .stat-card__meta    { font-size: 12px; margin-top: 4px; }
  .stat-card__meta--soon { color: var(--clr-muted); font-style: italic; }
  .stat-card__link    { color: var(--clr-gold); text-decoration: none; font-weight: 500; }
  .stat-card__link:hover { text-decoration: underline; }
  .stat-card__badge   { background: #fee2e2; color: #dc2626; border-radius: 100px; padding: 1px 7px; font-size: 11px; font-weight: 600; }

  /* ── Quick actions ────────────────────────────── */
  .quick-actions { display: flex; flex-wrap: wrap; gap: 12px; }
  .quick-action  {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 18px; border-radius: var(--radius);
    background: var(--clr-bg); border: 1px solid var(--clr-border);
    text-decoration: none; color: var(--clr-text);
    font-size: 13px; font-weight: 600;
    transition: box-shadow .15s, border-color .15s;
  }
  .quick-action:hover { border-color: var(--clr-gold); box-shadow: 0 2px 8px rgba(200,162,74,.15); }
  .quick-action__icon {
    width: 36px; height: 36px; border-radius: 8px;
    display: grid; place-items: center; flex-shrink: 0;
  }
  .quick-action__icon--gold   { background: #fdf3dc; color: var(--clr-gold); }
  .quick-action__icon--blue   { background: #dbeafe; color: #2563eb; }
  .quick-action__icon--green  { background: #dcfce7; color: #16a34a; }
  .quick-action__icon--red    { background: #fee2e2; color: #dc2626; }
  .quick-action__icon--purple { background: #ede9fe; color: #7c3aed; }
  .quick-action__icon--teal   { background: #ccfbf1; color: #0d9488; }
  .qa-badge {
    background: #dc2626; color: #fff;
    border-radius: 100px; font-size: 10px; font-weight: 700;
    padding: 1px 6px; margin-left: 4px;
  }

  .dash-msg-link { color: inherit; text-decoration: none; }
  .dash-msg-link:hover { color: var(--clr-gold); }
</style>
@endpush
