@extends('admin.layouts.app')
@section('title', 'Message Detail')
@section('breadcrumb', 'Message Detail')
@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">Message from {{ $message->name }}</h1>
  <a href="{{ route('admin.contacts.index') }}" class="btn btn--outline">Back</a>
</div>
<div class="admin-card" style="max-width:640px">
  <dl class="detail-list">
    <div class="detail-list__row"><dt>Name</dt><dd>{{ $message->name }}</dd></div>
    <div class="detail-list__row"><dt>Email</dt><dd><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></dd></div>
    <div class="detail-list__row"><dt>Phone</dt><dd>{{ $message->phone ?? '—' }}</dd></div>
    <div class="detail-list__row"><dt>Subject</dt><dd>{{ $message->subject ?? '—' }}</dd></div>
    <div class="detail-list__row"><dt>Message</dt><dd style="white-space:pre-wrap">{{ $message->message }}</dd></div>
    <div class="detail-list__row"><dt>Received</dt><dd>{{ $message->created_at->format('d M Y H:i') }}</dd></div>
  </dl>
</div>
@endsection
