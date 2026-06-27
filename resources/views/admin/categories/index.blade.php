@extends('admin.layouts.app')
@section('title', 'Categories')
@section('breadcrumb', 'Categories')
@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">Categories</h1>
  <a href="{{ route('admin.categories.create') }}" class="btn btn--primary">+ Add Category / Subcategory</a>
</div>

<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Type</th>
        <th>Products</th>
        <th>Status</th>
        <th>Sort</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($topLevel as $cat)
      <tr>
        <td>
          <div style="display:flex;align-items:center;gap:10px;">
            @if($cat->image)
              <img src="{{ Storage::url($cat->image) }}" alt="" style="width:36px;height:36px;object-fit:cover;border-radius:4px;" />
            @endif
            <strong>{{ $cat->name }}</strong>
          </div>
        </td>
        <td><span class="badge" style="background:#e8f4fd;color:#1a6fa8;padding:2px 8px;border-radius:12px;font-size:11px;">Category</span></td>
        <td>{{ $cat->products_count }}</td>
        <td><span class="badge badge--{{ $cat->is_active ? 'active' : 'inactive' }}">{{ $cat->is_active ? 'Active' : 'Inactive' }}</span></td>
        <td>{{ $cat->sort_order }}</td>
        <td class="admin-table__actions">
          <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn--sm btn--outline">Edit</a>
          <form method="POST" action="{{ route('admin.categories.destroy', $cat->id) }}" onsubmit="return confirm('Delete this category? All subcategories will also be removed.')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn--sm btn--danger">Delete</button>
          </form>
        </td>
      </tr>
      @foreach($cat->children as $sub)
      <tr style="background:#fafafa;">
        <td>
          <div style="display:flex;align-items:center;gap:10px;padding-left:24px;">
            <span style="color:#ccc;margin-right:4px;">↳</span>
            @if($sub->image)
              <img src="{{ Storage::url($sub->image) }}" alt="" style="width:28px;height:28px;object-fit:cover;border-radius:4px;" />
            @endif
            {{ $sub->name }}
          </div>
        </td>
        <td><span class="badge" style="background:#fef3e8;color:#b36a00;padding:2px 8px;border-radius:12px;font-size:11px;">Subcategory</span></td>
        <td>{{ $sub->products_count }}</td>
        <td><span class="badge badge--{{ $sub->is_active ? 'active' : 'inactive' }}">{{ $sub->is_active ? 'Active' : 'Inactive' }}</span></td>
        <td>{{ $sub->sort_order }}</td>
        <td class="admin-table__actions">
          <a href="{{ route('admin.categories.edit', $sub->id) }}" class="btn btn--sm btn--outline">Edit</a>
          <form method="POST" action="{{ route('admin.categories.destroy', $sub->id) }}" onsubmit="return confirm('Delete this subcategory?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn--sm btn--danger">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
      @empty
      <tr><td colspan="6" class="admin-table__empty">No categories yet. <a href="{{ route('admin.categories.create') }}">Add one now.</a></td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
