@extends('admin.layouts.app')
@section('title', 'Menu Items')
@section('breadcrumb', 'Menu Items')
@section('content')
<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Menu Items</h1>
    <div style="margin-top:4px;display:flex;gap:8px;">
      <a href="{{ route('admin.menu.categories.index') }}" class="btn btn--sm btn--outline">Manage Categories</a>
    </div>
  </div>
  <a href="{{ route('admin.menu.items.create') }}" class="btn btn--primary">+ Add Item</a>
</div>

{{-- Filters --}}
<div class="admin-card" style="margin-bottom:16px;">
  <form method="GET" action="{{ route('admin.menu.items.index') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
    <div class="form-group" style="margin:0;flex:1;min-width:180px;">
      <input class="form-control" type="text" name="search" placeholder="Search by name or SKU…" value="{{ request('search') }}" />
    </div>
    <div class="form-group" style="margin:0;min-width:160px;">
      <select class="form-control" name="category_id">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group" style="margin:0;min-width:160px;">
      <select class="form-control" name="status">
        <option value="">All Status</option>
        <option value="active"           {{ request('status')=='active'           ? 'selected':'' }}>Active</option>
        <option value="inactive"         {{ request('status')=='inactive'         ? 'selected':'' }}>Inactive</option>
        <option value="featured"         {{ request('status')=='featured'         ? 'selected':'' }}>Featured</option>
        <option value="bestseller"       {{ request('status')=='bestseller'       ? 'selected':'' }}>Bestseller</option>
        <option value="chef_recommended" {{ request('status')=='chef_recommended' ? 'selected':'' }}>Chef's Pick</option>
        <option value="unavailable"      {{ request('status')=='unavailable'      ? 'selected':'' }}>Unavailable</option>
      </select>
    </div>
    <div style="display:flex;gap:8px;">
      <button type="submit" class="btn btn--primary btn--sm">Filter</button>
      <a href="{{ route('admin.menu.items.index') }}" class="btn btn--outline btn--sm">Reset</a>
    </div>
  </form>
</div>

<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr><th>Item</th><th>Category</th><th>Price</th><th>Labels</th><th>Status</th><th>Actions</th></tr>
    </thead>
    <tbody>
      @forelse($items as $item)
      <tr>
        <td>
          <div class="admin-table__product">
            @if($item->featured_image)
              <img src="{{ Storage::url($item->featured_image) }}" alt="{{ $item->name }}" class="admin-table__thumb" />
            @endif
            <div>
              <span>{{ $item->name }}</span>
              @if($item->sku)<br><small style="color:#aaa;font-family:monospace;">{{ $item->sku }}</small>@endif
            </div>
          </div>
        </td>
        <td>{{ $item->category->name ?? '—' }}</td>
        <td>
          @if($item->discount_price && $item->discount_price < $item->price)
            <span style="color:#c0392b;font-weight:600;">Rs.{{ number_format($item->discount_price,0) }}</span>
            <br><small style="text-decoration:line-through;color:#aaa;">Rs.{{ number_format($item->price,0) }}</small>
          @else
            Rs.{{ number_format($item->price,0) }}
          @endif
        </td>
        <td>
          @if($item->is_featured)<span class="badge" style="background:#fef3e8;color:#b36a00;font-size:10px;padding:1px 6px;margin:1px;">Featured</span>@endif
          @if($item->is_bestseller)<span class="badge" style="background:#fef9e8;color:#7a6200;font-size:10px;padding:1px 6px;margin:1px;">Bestseller</span>@endif
          @if($item->is_chef_recommended)<span class="badge" style="background:#e8f4fd;color:#1a6fa8;font-size:10px;padding:1px 6px;margin:1px;">Chef's Pick</span>@endif
          @if($item->is_seasonal)<span class="badge" style="background:#e8f8ef;color:#0a7340;font-size:10px;padding:1px 6px;margin:1px;">Seasonal</span>@endif
        </td>
        <td>
          <span class="badge badge--{{ $item->is_active ? 'active' : 'inactive' }}">{{ $item->is_active ? 'Active' : 'Inactive' }}</span>
          @if(!$item->is_available)<br><span class="badge" style="background:#f8e8e8;color:#c0392b;font-size:10px;margin-top:2px;">Unavailable</span>@endif
        </td>
        <td class="admin-table__actions">
          <a href="{{ route('admin.menu.items.edit', $item) }}" class="btn btn--sm btn--outline">Edit</a>
          <form method="POST" action="{{ route('admin.menu.items.destroy', $item) }}" onsubmit="return confirm('Delete this menu item?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn--sm btn--danger">Delete</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="admin-table__empty">No menu items yet.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="admin-pagination">{{ $items->links() }}</div>
</div>
@endsection
