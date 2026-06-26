@extends('admin.layouts.app')
@section('title', 'Contact Messages')
@section('breadcrumb', 'Messages')
@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">Contact Messages</h1>
</div>
<div class="admin-card">
  <table class="admin-table">
    <thead><tr><th>Name</th><th>Subject</th><th>Date</th><th>Read</th><th>Actions</th></tr></thead>
    <tbody>
      @forelse($messages as $msg)
      <tr class="{{ !$msg->is_read ? 'admin-table__row--unread' : '' }}">
        <td>{{ $msg->name }}</td>
        <td>{{ Str::limit($msg->subject, 50) }}</td>
        <td>{{ $msg->created_at->format('d M Y') }}</td>
        <td>{{ $msg->is_read ? 'Yes' : 'No' }}</td>
        <td class="admin-table__actions">
          <a href="{{ route('admin.contacts.show', $msg->id) }}" class="btn btn--sm btn--outline">View</a>
          <form method="POST" action="{{ route('admin.contacts.destroy', $msg->id) }}" onsubmit="return confirm('Delete message?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn--sm btn--danger">Delete</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="5" class="admin-table__empty">No messages yet.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="admin-pagination">{{ $messages->links() }}</div>
</div>
@endsection
