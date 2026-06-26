@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">Dashboard</h1>
</div>

<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-card__icon stat-card__icon--gold">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="24" height="24">
        <circle cx="10" cy="10" r="8"/><path d="M10 6v4l3 3"/>
      </svg>
    </div>
    <div>
      <p class="stat-card__label">Total Products</p>
      <p class="stat-card__value">{{ $stats['products'] }}</p>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-card__icon stat-card__icon--blue">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="24" height="24">
        <rect x="2" y="2" width="16" height="5" rx="1"/><rect x="2" y="9" width="7" height="9" rx="1"/>
        <rect x="11" y="9" width="7" height="9" rx="1"/>
      </svg>
    </div>
    <div>
      <p class="stat-card__label">Categories</p>
      <p class="stat-card__value">{{ $stats['categories'] }}</p>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-card__icon stat-card__icon--green">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="24" height="24">
        <rect x="2" y="3" width="16" height="14" rx="1"/><path d="M2 8h16M6 2v2M14 2v2"/>
      </svg>
    </div>
    <div>
      <p class="stat-card__label">Reservations</p>
      <p class="stat-card__value">{{ $stats['reservations'] }}</p>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-card__icon stat-card__icon--red">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" width="24" height="24">
        <path d="M4 4h12c.55 0 1 .45 1 1v8c0 .55-.45 1-1 1H4c-.55 0-1-.45-1-1V5c0-.55.45-1 1-1z"/><polyline points="3,4 10,11 17,4"/>
      </svg>
    </div>
    <div>
      <p class="stat-card__label">Unread Messages</p>
      <p class="stat-card__value">{{ $stats['unread_messages'] }}</p>
    </div>
  </div>
</div>

<div class="dashboard-grid">
  <!-- Recent Reservations -->
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
            <td><span class="badge badge--status badge--{{ $r->status }}">{{ ucfirst($r->status) }}</span></td>
          </tr>
        @empty
          <tr><td colspan="4" class="admin-table__empty">No reservations yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Recent Messages -->
  <div class="admin-card">
    <div class="admin-card__header">
      <h2 class="admin-card__title">Recent Messages</h2>
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
            <td><a href="{{ route('admin.contacts.show', $m->id) }}">{{ Str::limit($m->subject, 40) }}</a></td>
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
