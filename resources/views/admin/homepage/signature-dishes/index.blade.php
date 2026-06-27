@extends('admin.layouts.app')
@section('title', 'Signature Dishes')
@section('breadcrumb', 'Signature Dishes')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">Signature Dishes</h1>
  <div style="display:flex;gap:8px;">
    <a href="{{ route('admin.homepage.index') }}" class="btn btn--outline">Back</a>
    <a href="{{ route('admin.homepage.signature-dishes.create') }}" class="btn btn--primary">+ Add Dish</a>
  </div>
</div>

@if(session('success'))
  <div class="alert alert--success">{{ session('success') }}</div>
@endif

<div class="admin-card" style="padding:0;overflow:hidden;">
  <table class="admin-table">
    <thead>
      <tr><th>Image</th><th>Name</th><th>Price</th><th>Tag</th><th>Order</th><th>Status</th><th>Actions</th></tr>
    </thead>
    <tbody>
      @forelse($dishes as $dish)
      <tr>
        <td>
          @if($dish->image)
            <img src="{{ Storage::url($dish->image) }}" alt="" style="width:60px;height:60px;object-fit:cover;border-radius:6px;">
          @else
            <span style="color:var(--clr-muted);font-size:12px;">No image</span>
          @endif
        </td>
        <td>
          <strong>{{ $dish->name }}</strong>
          @if($dish->description)<br><small style="color:var(--clr-muted);">{{ Str::limit($dish->description, 60) }}</small>@endif
        </td>
        <td>{{ $dish->price ? 'Rs. ' . number_format($dish->price, 0) : '—' }}</td>
        <td>{{ $dish->tag ?? '—' }}</td>
        <td>{{ $dish->sort_order }}</td>
        <td><span class="badge {{ $dish->is_active ? 'badge--active' : 'badge--inactive' }}">{{ $dish->is_active ? 'Active' : 'Hidden' }}</span></td>
        <td>
          <div class="admin-table__actions">
            <a href="{{ route('admin.homepage.signature-dishes.edit', $dish) }}" class="btn btn--sm btn--outline">Edit</a>
            <form method="POST" action="{{ route('admin.homepage.signature-dishes.destroy', $dish) }}" onsubmit="return confirm('Delete?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn--sm btn--danger">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="7" class="admin-table__empty">No signature dishes yet.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
