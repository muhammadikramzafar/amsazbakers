@extends('admin.layouts.app')
@section('title', 'Users')
@section('breadcrumb', 'Users')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">Users</h1>
  <a href="{{ route('admin.users.create') }}" class="btn btn--primary">+ Add User</a>
</div>

<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Created</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $user)
        <tr>
          <td>
            <div class="admin-table__user">
              <span class="admin-table__avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
              <span>{{ $user->name }}</span>
              @if($user->id === auth()->id())
                <span class="badge badge--active" style="margin-left:4px;">You</span>
              @endif
            </div>
          </td>
          <td>{{ $user->email }}</td>
          <td>
            @foreach($user->roles as $role)
              <span class="badge role-badge role-badge--{{ $role->name }}">{{ $role->name }}</span>
            @endforeach
          </td>
          <td>{{ $user->created_at->format('d M Y') }}</td>
          <td class="admin-table__actions">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn--sm btn--outline">Edit</a>
            @if($user->id !== auth()->id())
              <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                    onsubmit="return confirm('Delete {{ addslashes($user->name) }}? This cannot be undone.')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn--sm btn--danger">Delete</button>
              </form>
            @endif
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="admin-table__empty">No users found.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="admin-pagination">{{ $users->links() }}</div>
</div>
@endsection

@push('styles')
<style>
  .admin-table__user { display:flex; align-items:center; gap:10px; }
  .admin-table__avatar {
    width:30px; height:30px; border-radius:50%;
    background:var(--clr-gold); color:#fff;
    font-size:12px; font-weight:700;
    display:inline-flex; align-items:center; justify-content:center;
    flex-shrink:0;
  }
  .role-badge { text-transform:capitalize; }
  .role-badge--super-admin { background:#fde68a; color:#92400e; }
  .role-badge--admin       { background:#dbeafe; color:#1e40af; }
  .role-badge--content-editor { background:#d1fae5; color:#065f46; }
</style>
@endpush
