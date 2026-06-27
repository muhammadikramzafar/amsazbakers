@extends('admin.layouts.app')
@section('title', 'Recipe Categories')
@section('breadcrumb', 'Recipe Categories')
@section('content')
<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Recipe Categories</h1>
    <div style="margin-top:4px;">
      <a href="{{ route('admin.recipes.index') }}" class="btn btn--sm btn--outline">← All Recipes</a>
    </div>
  </div>
  <a href="{{ route('admin.recipe-categories.create') }}" class="btn btn--primary">+ Add Category</a>
</div>

<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr><th>Name</th><th>Recipes</th><th>Sort</th><th>Status</th><th>Actions</th></tr>
    </thead>
    <tbody>
      @forelse($categories as $cat)
      <tr>
        <td>
          <div style="display:flex;align-items:center;gap:10px;">
            @if($cat->image)
              <img src="{{ Storage::url($cat->image) }}" alt="" style="width:36px;height:36px;object-fit:cover;border-radius:6px;" />
            @endif
            <strong>{{ $cat->name }}</strong>
          </div>
        </td>
        <td>{{ $cat->recipes_count }}</td>
        <td>{{ $cat->sort_order }}</td>
        <td><span class="badge badge--{{ $cat->is_active ? 'active' : 'inactive' }}">{{ $cat->is_active ? 'Active' : 'Inactive' }}</span></td>
        <td class="admin-table__actions">
          <a href="{{ route('admin.recipe-categories.edit', $cat) }}" class="btn btn--sm btn--outline">Edit</a>
          <form method="POST" action="{{ route('admin.recipe-categories.destroy', $cat) }}" onsubmit="return confirm('Delete this recipe category?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn--sm btn--danger">Delete</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="5" class="admin-table__empty">No recipe categories yet. <a href="{{ route('admin.recipe-categories.create') }}">Add one.</a></td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
