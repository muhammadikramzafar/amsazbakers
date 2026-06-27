@extends('admin.layouts.app')
@section('title', 'Why Choose Us')
@section('breadcrumb', 'Why Choose Us')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">Why Choose Us Features</h1>
  <div style="display:flex;gap:8px;">
    <a href="{{ route('admin.homepage.index') }}" class="btn btn--outline">Back</a>
    <a href="{{ route('admin.homepage.why-choose.create') }}" class="btn btn--primary">+ Add Feature</a>
  </div>
</div>

@if(session('success'))
  <div class="alert alert--success">{{ session('success') }}</div>
@endif

<div class="admin-card" style="padding:0;overflow:hidden;">
  <table class="admin-table">
    <thead>
      <tr><th>Icon</th><th>Title</th><th>Description</th><th>Order</th><th>Status</th><th>Actions</th></tr>
    </thead>
    <tbody>
      @forelse($features as $feature)
      <tr>
        <td style="font-size:12px;font-weight:600;color:var(--clr-gold);">{{ $feature->icon_name }}</td>
        <td><strong>{{ $feature->title }}</strong></td>
        <td style="font-size:12px;color:var(--clr-muted);">{{ Str::limit($feature->description, 80) }}</td>
        <td>{{ $feature->sort_order }}</td>
        <td><span class="badge {{ $feature->is_active ? 'badge--active' : 'badge--inactive' }}">{{ $feature->is_active ? 'Active' : 'Hidden' }}</span></td>
        <td>
          <div class="admin-table__actions">
            <a href="{{ route('admin.homepage.why-choose.edit', $feature) }}" class="btn btn--sm btn--outline">Edit</a>
            <form method="POST" action="{{ route('admin.homepage.why-choose.destroy', $feature) }}" onsubmit="return confirm('Delete?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn--sm btn--danger">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="admin-table__empty">No features yet.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
