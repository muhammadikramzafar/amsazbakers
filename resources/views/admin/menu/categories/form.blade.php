@extends('admin.layouts.app')
@section('title', isset($menuCategory) ? 'Edit Menu Category' : 'Add Menu Category')
@section('breadcrumb', isset($menuCategory) ? 'Edit Menu Category' : 'Add Menu Category')
@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">{{ isset($menuCategory) ? 'Edit' : 'Add' }} Menu Category</h1>
  <a href="{{ route('admin.menu.categories.index') }}" class="btn btn--outline">Back</a>
</div>
<div class="admin-card" style="max-width:640px">
  <form method="POST"
        action="{{ isset($menuCategory) ? route('admin.menu.categories.update', $menuCategory) : route('admin.menu.categories.store') }}"
        enctype="multipart/form-data">
    @csrf
    @if(isset($menuCategory)) @method('PUT') @endif

    <div class="form-group">
      <label class="form-label">Category Name *</label>
      <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
             value="{{ old('name', $menuCategory->name ?? '') }}" required />
      @error('name')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
      <label class="form-label">Description</label>
      <textarea class="form-control" name="description" rows="3">{{ old('description', $menuCategory->description ?? '') }}</textarea>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input class="form-control" type="number" name="sort_order" min="0"
               value="{{ old('sort_order', $menuCategory->sort_order ?? 0) }}" />
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Image</label>
      <input class="form-control" type="file" name="image" accept="image/*" />
      @if(isset($menuCategory) && $menuCategory->image)
        <img src="{{ Storage::url($menuCategory->image) }}" alt="{{ $menuCategory->name }}" class="admin-img-preview" />
      @endif
    </div>

    <div class="form-group">
      <label class="form-label form-label--checkbox">
        <input type="checkbox" name="is_active" value="1"
               {{ old('is_active', $menuCategory->is_active ?? true) ? 'checked' : '' }} />
        Active (visible on menu page)
      </label>
    </div>

    <button type="submit" class="btn btn--primary">
      {{ isset($menuCategory) ? 'Update Category' : 'Create Category' }}
    </button>
  </form>
</div>
@endsection
