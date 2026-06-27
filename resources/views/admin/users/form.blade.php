@extends('admin.layouts.app')
@section('title', isset($user) ? 'Edit User' : 'Add User')
@section('breadcrumb', isset($user) ? 'Edit User' : 'Add User')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">{{ isset($user) ? 'Edit User' : 'Create User' }}</h1>
  <a href="{{ route('admin.users.index') }}" class="btn btn--outline">Back to Users</a>
</div>

<div class="admin-card" style="max-width:560px">
  <form method="POST"
        action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}"
        novalidate>
    @csrf
    @if(isset($user)) @method('PUT') @endif

    <div class="form-group">
      <label class="form-label" for="name">Full Name <span class="form-required">*</span></label>
      <input class="form-control @error('name') is-invalid @enderror"
             type="text" id="name" name="name"
             value="{{ old('name', $user->name ?? '') }}"
             placeholder="Muhammad Ali" required />
      @error('name')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
      <label class="form-label" for="email">Email Address <span class="form-required">*</span></label>
      <input class="form-control @error('email') is-invalid @enderror"
             type="email" id="email" name="email"
             value="{{ old('email', $user->email ?? '') }}"
             placeholder="user@azmeerbakery.pk" required />
      @error('email')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
      <label class="form-label" for="role">Role <span class="form-required">*</span></label>
      <select class="form-control @error('role') is-invalid @enderror"
              id="role" name="role" required>
        <option value="">— Select a role —</option>
        @foreach($roles as $role)
          <option value="{{ $role }}"
            {{ old('role', $currentRole ?? '') === $role ? 'selected' : '' }}>
            {{ ucwords(str_replace('-', ' ', $role)) }}
          </option>
        @endforeach
      </select>
      @error('role')<p class="form-error">{{ $message }}</p>@enderror
      <p class="form-hint">
        <strong>Super Admin</strong> — full access.<br>
        <strong>Admin</strong> — manage content, no user management.<br>
        <strong>Content Editor</strong> — create and edit content only.
      </p>
    </div>

    <div class="form-divider"></div>

    <div class="form-group">
      <label class="form-label" for="password">
        Password
        @if(isset($user))
          <span class="form-hint-inline">— leave blank to keep current</span>
        @else
          <span class="form-required">*</span>
        @endif
      </label>
      <input class="form-control @error('password') is-invalid @enderror"
             type="password" id="password" name="password"
             autocomplete="new-password"
             {{ !isset($user) ? 'required' : '' }} />
      @error('password')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
      <label class="form-label" for="password_confirmation">Confirm Password</label>
      <input class="form-control"
             type="password" id="password_confirmation" name="password_confirmation"
             autocomplete="new-password" />
    </div>

    <button type="submit" class="btn btn--primary" style="margin-top:8px;">
      {{ isset($user) ? 'Update User' : 'Create User' }}
    </button>
  </form>
</div>
@endsection

@push('styles')
<style>
  .form-required   { color: #dc3545; }
  .form-hint       { font-size:12px; color:var(--clr-muted); margin-top:6px; line-height:1.6; }
  .form-hint-inline{ font-size:12px; color:var(--clr-muted); font-weight:400; }
  .form-divider    { border:none; border-top:1px solid var(--clr-border); margin:20px 0; }
</style>
@endpush
