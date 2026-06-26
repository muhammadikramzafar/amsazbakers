@extends('admin.layouts.app')
@section('title', 'Reservations')
@section('breadcrumb', 'Reservations')
@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">Reservations</h1>
</div>
<div class="admin-card">
  <table class="admin-table">
    <thead><tr><th>Name</th><th>Date</th><th>Time</th><th>Guests</th><th>Phone</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
      @forelse($reservations as $r)
      <tr>
        <td>{{ $r->name }}</td>
        <td>{{ $r->date }}</td>
        <td>{{ $r->time }}</td>
        <td>{{ $r->guests }}</td>
        <td>{{ $r->phone }}</td>
        <td><span class="badge badge--status badge--{{ $r->status }}">{{ ucfirst($r->status) }}</span></td>
        <td class="admin-table__actions">
          <a href="{{ route('admin.reservations.show', $r->id) }}" class="btn btn--sm btn--outline">View</a>
          <form method="POST" action="{{ route('admin.reservations.destroy', $r->id) }}" onsubmit="return confirm('Delete reservation?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn--sm btn--danger">Delete</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="7" class="admin-table__empty">No reservations yet.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="admin-pagination">{{ $reservations->links() }}</div>
</div>
@endsection
