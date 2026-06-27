@extends('admin.layouts.app')
@section('title', 'CTA Sections')
@section('breadcrumb', 'CTA Sections')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">CTA Sections</h1>
  <div style="display:flex;gap:8px;">
    <a href="{{ route('admin.homepage.index') }}" class="btn btn--outline">Back</a>
    <a href="{{ route('admin.homepage.cta.create') }}" class="btn btn--primary">+ Add CTA</a>
  </div>
</div>

@if(session('success'))
  <div class="alert alert--success">{{ session('success') }}</div>
@endif

<div class="admin-card" style="padding:0;overflow:hidden;">
  <table class="admin-table">
    <thead>
      <tr><th>Image</th><th>Title</th><th>Button</th><th>Order</th><th>Status</th><th>Actions</th></tr>
    </thead>
    <tbody>
      @forelse($ctas as $cta)
      <tr>
        <td>
          @if($cta->image)
            <img src="{{ Storage::url($cta->image) }}" alt="" style="width:80px;height:48px;object-fit:cover;border-radius:4px;">
          @else
            <span style="color:var(--clr-muted);font-size:12px;">No image</span>
          @endif
        </td>
        <td>
          <strong>{{ $cta->title }}</strong>
          @if($cta->subtitle)<br><small style="color:var(--clr-muted);">{{ Str::limit($cta->subtitle, 60) }}</small>@endif
        </td>
        <td style="font-size:12px;">{{ $cta->btn_text ?? '—' }}</td>
        <td>{{ $cta->sort_order }}</td>
        <td><span class="badge {{ $cta->is_active ? 'badge--active' : 'badge--inactive' }}">{{ $cta->is_active ? 'Active' : 'Hidden' }}</span></td>
        <td>
          <div class="admin-table__actions">
            <a href="{{ route('admin.homepage.cta.edit', $cta) }}" class="btn btn--sm btn--outline">Edit</a>
            <form method="POST" action="{{ route('admin.homepage.cta.destroy', $cta) }}" onsubmit="return confirm('Delete?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn--sm btn--danger">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="admin-table__empty">No CTA sections yet.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
