@extends('admin.layouts.app')
@section('title', 'Hero Slides')
@section('breadcrumb', 'Hero Slides')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">Hero Slides</h1>
  <div style="display:flex;gap:8px;">
    <a href="{{ route('admin.homepage.index') }}" class="btn btn--outline">Back</a>
    <a href="{{ route('admin.homepage.hero-slides.create') }}" class="btn btn--primary">+ Add Slide</a>
  </div>
</div>

@if(session('success'))
  <div class="alert alert--success">{{ session('success') }}</div>
@endif

<div class="admin-card" style="padding:0;overflow:hidden;">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Image</th>
        <th>Title</th>
        <th>Buttons</th>
        <th>Order</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($slides as $slide)
      <tr>
        <td>
          @if($slide->image)
            <img src="{{ Storage::url($slide->image) }}" alt="" style="width:80px;height:48px;object-fit:cover;border-radius:4px;">
          @else
            <span style="color:var(--clr-muted);font-size:12px;">No image</span>
          @endif
        </td>
        <td>
          <strong>{{ $slide->title }}</strong>
          @if($slide->subtitle)<br><small style="color:var(--clr-muted);">{{ Str::limit($slide->subtitle, 60) }}</small>@endif
        </td>
        <td style="font-size:12px;">
          <span>{{ $slide->btn1_text }}</span>
          @if($slide->btn2_text)<br><span>{{ $slide->btn2_text }}</span>@endif
        </td>
        <td>{{ $slide->sort_order }}</td>
        <td>
          <span class="badge {{ $slide->is_active ? 'badge--active' : 'badge--inactive' }}">
            {{ $slide->is_active ? 'Active' : 'Hidden' }}
          </span>
        </td>
        <td>
          <div class="admin-table__actions">
            <a href="{{ route('admin.homepage.hero-slides.edit', $slide) }}" class="btn btn--sm btn--outline">Edit</a>
            <form method="POST" action="{{ route('admin.homepage.hero-slides.destroy', $slide) }}"
                  onsubmit="return confirm('Delete this slide?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn--sm btn--danger">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="admin-table__empty">No slides yet. <a href="{{ route('admin.homepage.hero-slides.create') }}">Add the first one.</a></td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
