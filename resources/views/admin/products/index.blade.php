@extends('admin.layouts.app')
@section('title', 'Products')
@section('breadcrumb', 'Products')
@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">Products</h1>
  <a href="{{ route('admin.products.create') }}" class="btn btn--primary">+ Add Product</a>
</div>
<div class="admin-card">
  <table class="admin-table">
    <thead><tr><th>Product</th><th>Category</th><th>Price</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
      @forelse($products as $product)
      <tr>
        <td>
          <div class="admin-table__product">
            @if($product->image)
              <img src="{{ asset('storage/'.\->image) }}" alt="{{ $product->name }}" class="admin-table__thumb" />
            @endif
            <span>{{ $product->name }}</span>
          </div>
        </td>
        <td>{{ $product->category->name ?? '—' }}</td>
        <td>{{ $product->display_price }}</td>
        <td><span class="badge badge--{{ $product->is_active ? 'active' : 'inactive' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span></td>
        <td class="admin-table__actions">
          <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn--sm btn--outline">Edit</a>
          <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" onsubmit="return confirm('Delete this product?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn--sm btn--danger">Delete</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="5" class="admin-table__empty">No products yet.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="admin-pagination">{{ $products->links() }}</div>
</div>
@endsection
