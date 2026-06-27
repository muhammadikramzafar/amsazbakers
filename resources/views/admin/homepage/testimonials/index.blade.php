@extends('admin.layouts.app')
@section('title', 'Testimonials')
@section('breadcrumb', 'Testimonials')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">Customer Testimonials</h1>
  <div style="display:flex;gap:8px;">
    <a href="{{ route('admin.homepage.index') }}" class="btn btn--outline">Back</a>
    <a href="{{ route('admin.homepage.testimonials.create') }}" class="btn btn--primary">+ Add Testimonial</a>
  </div>
</div>

@if(session('success'))
  <div class="alert alert--success">{{ session('success') }}</div>
@endif

<div class="admin-card" style="padding:0;overflow:hidden;">
  <table class="admin-table">
    <thead>
      <tr><th>Avatar</th><th>Customer</th><th>Quote</th><th>Rating</th><th>Order</th><th>Status</th><th>Actions</th></tr>
    </thead>
    <tbody>
      @forelse($testimonials as $t)
      <tr>
        <td>
          @if($t->avatar)
            <img src="{{ Storage::url($t->avatar) }}" alt="" style="width:40px;height:40px;object-fit:cover;border-radius:50%;">
          @else
            <div style="width:40px;height:40px;border-radius:50%;background:var(--clr-gold);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:14px;">{{ strtoupper(substr($t->customer_name, 0, 1)) }}</div>
          @endif
        </td>
        <td>
          <strong>{{ $t->customer_name }}</strong>
          @if($t->customer_role)<br><small style="color:var(--clr-muted);">{{ $t->customer_role }}</small>@endif
        </td>
        <td style="font-size:12px;max-width:300px;">{{ Str::limit($t->quote, 100) }}</td>
        <td style="color:#f59e0b;font-size:14px;">{{ str_repeat('★', $t->rating) }}{{ str_repeat('☆', 5 - $t->rating) }}</td>
        <td>{{ $t->sort_order }}</td>
        <td><span class="badge {{ $t->is_active ? 'badge--active' : 'badge--inactive' }}">{{ $t->is_active ? 'Active' : 'Hidden' }}</span></td>
        <td>
          <div class="admin-table__actions">
            <a href="{{ route('admin.homepage.testimonials.edit', $t) }}" class="btn btn--sm btn--outline">Edit</a>
            <form method="POST" action="{{ route('admin.homepage.testimonials.destroy', $t) }}" onsubmit="return confirm('Delete?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn--sm btn--danger">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="7" class="admin-table__empty">No testimonials yet.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
