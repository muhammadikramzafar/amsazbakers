@extends('admin.layouts.app')
@section('title', 'Categories')
@section('breadcrumb', 'Categories')
@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">Categories</h1>
  <a href="{{ route('admin.categories.create') }}" class="btn btn--primary">+ Add Category</a>
</div>
<div class="admin-card">
  <table class="admin-table">
    <thead><tr><th>Name</th><th>Products</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
      @forelse($categories as $cat)
      <tr>
        <td>{{ $cat->name }}</td>
        <td>{{ $cat->products_count }}</td>
        <td><span class="badge badge--{{ $cat->is_active ? 'active' : 'inactive' }}">{{ $cat->is_active ? 'Active' : 'Inactive' }}</span></td>
        <td class="admin-table__actions">
          <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn--sm btn--outline">Edit</a>
          <form method="POST" action="{{ route('admin.categories.destroy', $cat->id) }}" onsubmit="return confirm('Delete this category?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn--sm btn--danger">Delete</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="4" class="admin-table__empty">No categories yet.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
