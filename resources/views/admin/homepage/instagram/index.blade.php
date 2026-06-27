@extends('admin.layouts.app')
@section('title', 'Instagram Feed')
@section('breadcrumb', 'Instagram Feed')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">Instagram Feed</h1>
  <div style="display:flex;gap:8px;">
    <a href="{{ route('admin.homepage.index') }}" class="btn btn--outline">Back</a>
    <a href="{{ route('admin.homepage.instagram.create') }}" class="btn btn--primary">+ Add Photo</a>
  </div>
</div>

@if(session('success'))
  <div class="alert alert--success">{{ session('success') }}</div>
@endif

<div class="insta-grid">
  @forelse($posts as $post)
  <div class="insta-card">
    <div class="insta-card__thumb">
      <img src="{{ Storage::url($post->image) }}" alt="{{ $post->caption }}" loading="lazy">
      <div class="insta-card__overlay">
        <a href="{{ route('admin.homepage.instagram.edit', $post) }}" class="btn btn--sm btn--outline" style="color:#fff;border-color:rgba(255,255,255,.6);">Edit</a>
        <form method="POST" action="{{ route('admin.homepage.instagram.destroy', $post) }}" onsubmit="return confirm('Delete?')">
          @csrf @method('DELETE')
          <button type="submit" class="btn btn--sm btn--danger">Delete</button>
        </form>
      </div>
    </div>
    <div class="insta-card__body">
      <span class="badge {{ $post->is_active ? 'badge--active' : 'badge--inactive' }}">{{ $post->is_active ? 'Active' : 'Hidden' }}</span>
      <span style="font-size:11px;color:var(--clr-muted);">Order: {{ $post->sort_order }}</span>
    </div>
  </div>
  @empty
  <div style="grid-column:1/-1;text-align:center;padding:60px;color:var(--clr-muted);">
    No photos yet. <a href="{{ route('admin.homepage.instagram.create') }}">Upload the first one.</a>
  </div>
  @endforelse
</div>
@endsection

@push('styles')
<style>
  .insta-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:12px; }
  .insta-card { border-radius:var(--radius); overflow:hidden; border:1px solid var(--clr-border); background:var(--clr-card); }
  .insta-card__thumb { position:relative; padding-top:100%; }
  .insta-card__thumb img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; }
  .insta-card__overlay {
    position:absolute; inset:0; background:rgba(0,0,0,.5);
    display:flex; flex-direction:column; align-items:center; justify-content:center; gap:6px;
    opacity:0; transition:opacity .15s;
  }
  .insta-card:hover .insta-card__overlay { opacity:1; }
  .insta-card__body { padding:8px 10px; display:flex; align-items:center; justify-content:space-between; }
</style>
@endpush
