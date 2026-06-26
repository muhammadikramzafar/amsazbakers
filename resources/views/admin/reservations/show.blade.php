@extends('admin.layouts.app')
@section('title', 'Reservation Detail')
@section('breadcrumb', 'Reservation Detail')
@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">Reservation #{{ $reservation->id }}</h1>
  <a href="{{ route('admin.reservations.index') }}" class="btn btn--outline">Back</a>
</div>
<div class="admin-card" style="max-width:600px">
  <dl class="detail-list">
    <div class="detail-list__row"><dt>Name</dt><dd>{{ $reservation->name }}</dd></div>
    <div class="detail-list__row"><dt>Email</dt><dd>{{ $reservation->email }}</dd></div>
    <div class="detail-list__row"><dt>Phone</dt><dd>{{ $reservation->phone }}</dd></div>
    <div class="detail-list__row"><dt>Date</dt><dd>{{ $reservation->date }}</dd></div>
    <div class="detail-list__row"><dt>Time</dt><dd>{{ $reservation->time }}</dd></div>
    <div class="detail-list__row"><dt>Guests</dt><dd>{{ $reservation->guests }}</dd></div>
    <div class="detail-list__row"><dt>Message</dt><dd>{{ $reservation->message ?? '—' }}</dd></div>
    <div class="detail-list__row"><dt>Status</dt><dd><span class="badge badge--{{ $reservation->status }}">{{ ucfirst($reservation->status) }}</span></dd></div>
    <div class="detail-list__row"><dt>Received</dt><dd>{{ $reservation->created_at->format('d M Y H:i') }}</dd></div>
  </dl>
</div>
@endsection
