@extends('admin.layouts.app')
@section('title', 'Recipes')
@section('breadcrumb', 'Recipes')
@section('content')
<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Recipes</h1>
    <div style="margin-top:4px;">
      <a href="{{ route('admin.recipe-categories.index') }}" class="btn btn--sm btn--outline">Manage Categories</a>
    </div>
  </div>
  <a href="{{ route('admin.recipes.create') }}" class="btn btn--primary">+ Add Recipe</a>
</div>

{{-- Filters --}}
<div class="admin-card" style="margin-bottom:16px;">
  <form method="GET" action="{{ route('admin.recipes.index') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
    <div class="form-group" style="margin:0;flex:1;min-width:200px;">
      <input class="form-control" type="text" name="search" placeholder="Search recipes…" value="{{ request('search') }}" />
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
        <option value="published"   {{ request('status')=='published'   ? 'selected':'' }}>Published</option>
        <option value="unpublished" {{ request('status')=='unpublished' ? 'selected':'' }}>Unpublished</option>
        <option value="featured"    {{ request('status')=='featured'    ? 'selected':'' }}>Featured</option>
      </select>
    </div>
    <div style="display:flex;gap:8px;">
      <button type="submit" class="btn btn--primary btn--sm">Filter</button>
      <a href="{{ route('admin.recipes.index') }}" class="btn btn--outline btn--sm">Reset</a>
    </div>
  </form>
</div>

<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr><th>Recipe</th><th>Category</th><th>Difficulty</th><th>Time</th><th>Status</th><th>Actions</th></tr>
    </thead>
    <tbody>
      @forelse($recipes as $recipe)
      <tr>
        <td>
          <div class="admin-table__product">
            @if($recipe->featured_image)
              <img src="{{ Storage::url($recipe->featured_image) }}" alt="{{ $recipe->title }}" class="admin-table__thumb" />
            @endif
            <div>
              <span>{{ $recipe->title }}</span>
              @if($recipe->is_featured)<br><span class="badge" style="background:#fef3e8;color:#b36a00;font-size:10px;padding:1px 6px;">Featured</span>@endif
            </div>
          </div>
        </td>
        <td>{{ $recipe->category->name ?? '—' }}</td>
        <td>
          <span class="badge" style="background:{{ $recipe->difficulty === 'easy' ? '#e8f8ef;color:#0a7340' : ($recipe->difficulty === 'hard' ? '#f8e8e8;color:#c0392b' : '#fef9e8;color:#7a6200') }};font-size:11px;padding:2px 8px;border-radius:12px;">
            {{ $recipe->difficulty_label }}
          </span>
        </td>
        <td>
          @if($recipe->total_time)
            <span style="font-size:13px;">{{ $recipe->total_time }}</span>
          @else
            —
          @endif
        </td>
        <td>
          <span class="badge badge--{{ $recipe->is_published ? 'active' : 'inactive' }}">
            {{ $recipe->is_published ? 'Published' : 'Draft' }}
          </span>
        </td>
        <td class="admin-table__actions">
          <a href="{{ route('recipes.show', $recipe->slug) }}" class="btn btn--sm btn--outline" target="_blank">View</a>
          <a href="{{ route('admin.recipes.edit', $recipe) }}" class="btn btn--sm btn--outline">Edit</a>
          <form method="POST" action="{{ route('admin.recipes.destroy', $recipe) }}" onsubmit="return confirm('Delete this recipe?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn--sm btn--danger">Delete</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="admin-table__empty">No recipes yet. <a href="{{ route('admin.recipes.create') }}">Add one.</a></td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="admin-pagination">{{ $recipes->links() }}</div>
</div>
@endsection
