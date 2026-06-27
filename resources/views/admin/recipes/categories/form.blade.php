@extends('admin.layouts.app')
@section('title', isset($recipeCategory) ? 'Edit Recipe Category' : 'Add Recipe Category')
@section('breadcrumb', isset($recipeCategory) ? 'Edit Recipe Category' : 'Add Recipe Category')
@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">{{ isset($recipeCategory) ? 'Edit' : 'Add' }} Recipe Category</h1>
  <a href="{{ route('admin.recipe-categories.index') }}" class="btn btn--outline">Back</a>
</div>
<div class="admin-card" style="max-width:640px">
  <form method="POST"
        action="{{ isset($recipeCategory) ? route('admin.recipe-categories.update', $recipeCategory) : route('admin.recipe-categories.store') }}"
        enctype="multipart/form-data">
    @csrf
    @if(isset($recipeCategory)) @method('PUT') @endif

    <div class="form-group">
      <label class="form-label">Category Name *</label>
      <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
             value="{{ old('name', $recipeCategory->name ?? '') }}" required />
      @error('name')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
      <label class="form-label">Description</label>
      <textarea class="form-control" name="description" rows="3">{{ old('description', $recipeCategory->description ?? '') }}</textarea>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input class="form-control" type="number" name="sort_order" min="0"
               value="{{ old('sort_order', $recipeCategory->sort_order ?? 0) }}" />
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Image</label>
      <input class="form-control" type="file" name="image" accept="image/*" />
      @if(isset($recipeCategory) && $recipeCategory->image)
        <img src="{{ Storage::url($recipeCategory->image) }}" alt="{{ $recipeCategory->name }}" class="admin-img-preview" />
      @endif
    </div>

    <div class="form-group">
      <label class="form-label form-label--checkbox">
        <input type="checkbox" name="is_active" value="1"
               {{ old('is_active', $recipeCategory->is_active ?? true) ? 'checked' : '' }} />
        Active
      </label>
    </div>

    <button type="submit" class="btn btn--primary">
      {{ isset($recipeCategory) ? 'Update Category' : 'Create Category' }}
    </button>
  </form>
</div>
@endsection
