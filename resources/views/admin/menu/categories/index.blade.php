@extends('admin.layouts.app')
@section('title', 'Menu Categories')
@section('breadcrumb', 'Menu Categories')
@section('content')
<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Menu Categories</h1>
    <p style="color:#888;font-size:13px;margin-top:2px;">Organise your restaurant menu into sections (Breakfast, Lunch, Dinner…)</p>
  </div>
  <a href="{{ route('admin.menu.categories.create') }}" class="btn btn--primary">+ Add Category</a>
</div>

<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr><th>Name</th><th>Items</th><th>Sort</th><th>Status</th><th>Actions</th></tr>
    </thead>
    <tbody>
      @forelse($categories as $cat)
      <tr>
        <td>
          <div style="display:flex;align-items:center;gap:10px;">
            @if($cat->image)
              <img src="{{ Storage::url($cat->image) }}" alt="" style="width:36px;height:36px;object-fit:cover;border-radius:6px;" />
            @endif
            <strong>{{ $cat->name }}</strong>
          </div>
        </td>
        <td>{{ $cat->menu_items_count }}</td>
        <td>{{ $cat->sort_order }}</td>
        <td><span class="badge badge--{{ $cat->is_active ? 'active' : 'inactive' }}">{{ $cat->is_active ? 'Active' : 'Inactive' }}</span></td>
        <td class="admin-table__actions">
          <a href="{{ route('admin.menu.categories.edit', $cat) }}" class="btn btn--sm btn--outline">Edit</a>
          <form method="POST" action="{{ route('admin.menu.categories.destroy', $cat) }}" onsubmit="return confirm('Delete this menu category?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn--sm btn--danger">Delete</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="5" class="admin-table__empty">No menu categories yet. <a href="{{ route('admin.menu.categories.create') }}">Add one.</a></td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
