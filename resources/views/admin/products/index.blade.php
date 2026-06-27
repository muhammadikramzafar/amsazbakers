@extends('admin.layouts.app')
@section('title', 'Products')
@section('breadcrumb', 'Products')
@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">Products</h1>
  <a href="{{ route('admin.products.create') }}" class="btn btn--primary">+ Add Product</a>
</div>

{{-- Filters --}}
<div class="admin-card" style="margin-bottom:16px;">
  <form method="GET" action="{{ route('admin.products.index') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
    <div class="form-group" style="margin:0;flex:1;min-width:180px;">
      <input class="form-control" type="text" name="search" placeholder="Search by name or SKU…"
             value="{{ request('search') }}" />
    </div>
    <div class="form-group" style="margin:0;min-width:160px;">
      <select class="form-control" name="category_id">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group" style="margin:0;min-width:140px;">
      <select class="form-control" name="status">
        <option value="">All Status</option>
        <option value="active"     {{ request('status')=='active'     ? 'selected':'' }}>Active</option>
        <option value="inactive"   {{ request('status')=='inactive'   ? 'selected':'' }}>Inactive</option>
        <option value="featured"   {{ request('status')=='featured'   ? 'selected':'' }}>Featured</option>
        <option value="bestseller" {{ request('status')=='bestseller' ? 'selected':'' }}>Bestseller</option>
        <option value="unavailable"{{ request('status')=='unavailable'? 'selected':'' }}>Unavailable</option>
      </select>
    </div>
    <div style="display:flex;gap:8px;">
      <button type="submit" class="btn btn--primary btn--sm">Filter</button>
      <a href="{{ route('admin.products.index') }}" class="btn btn--outline btn--sm">Reset</a>
    </div>
  </form>
</div>

<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Product</th>
        <th>SKU</th>
        <th>Category</th>
        <th>Price</th>
        <th>Flags</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($products as $product)
      <tr>
        <td>
          <div class="admin-table__product">
            @if($product->image)
              <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="admin-table__thumb" />
            @endif
            <span>{{ $product->name }}</span>
          </div>
        </td>
        <td style="font-family:monospace;font-size:12px;color:#888;">{{ $product->sku ?? '—' }}</td>
        <td>
          {{ $product->category->name ?? '—' }}
          @if($product->subcategory)
            <br><small style="color:#888;">↳ {{ $product->subcategory->name }}</small>
          @endif
        </td>
        <td>
          @if($product->sale_price && $product->sale_price < $product->price)
            <span style="color:#c0392b;font-weight:600;">Rs.{{ number_format($product->sale_price,0) }}</span>
            <br><small style="text-decoration:line-through;color:#aaa;">Rs.{{ number_format($product->price,0) }}</small>
          @else
            Rs.{{ number_format($product->price,0) }}
          @endif
        </td>
        <td>
          <div style="display:flex;gap:4px;flex-wrap:wrap;">
            @if($product->is_featured)
              <span class="badge" style="background:#fef3e8;color:#b36a00;font-size:10px;padding:1px 6px;">Featured</span>
            @endif
            @if($product->is_bestseller)
              <span class="badge" style="background:#fef9e8;color:#7a6200;font-size:10px;padding:1px 6px;">Bestseller</span>
            @endif
            @if($product->is_seasonal)
              <span class="badge" style="background:#e8f8ef;color:#0a7340;font-size:10px;padding:1px 6px;">Seasonal</span>
            @endif
          </div>
        </td>
        <td>
          <span class="badge badge--{{ $product->is_active ? 'active' : 'inactive' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span>
          @if(!$product->is_available)
            <br><span class="badge" style="background:#f8e8e8;color:#c0392b;font-size:10px;margin-top:2px;">Unavailable</span>
          @endif
        </td>
        <td class="admin-table__actions">
          <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn--sm btn--outline">Edit</a>
          <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" onsubmit="return confirm('Delete this product?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn--sm btn--danger">Delete</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="7" class="admin-table__empty">No products found.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="admin-pagination">{{ $products->links() }}</div>
</div>
@endsection
