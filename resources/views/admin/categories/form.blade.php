@extends('admin.layouts.app')
@section('title', isset($category) ? 'Edit Category' : 'Add Category')
@section('breadcrumb', isset($category) ? 'Edit Category' : 'Add Category')
@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">{{ isset($category) ? 'Edit' : 'Add' }} Category</h1>
  <a href="{{ route('admin.categories.index') }}" class="btn btn--outline">Back</a>
</div>
<div class="admin-card" style="max-width:640px">
  <form method="POST"
        action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}"
        enctype="multipart/form-data">
    @csrf
    @if(isset($category)) @method('PUT') @endif

    {{-- Parent category (leave empty for top-level) --}}
    <div class="form-group">
      <label class="form-label">Parent Category</label>
      <select class="form-control @error('parent_id') is-invalid @enderror" name="parent_id">
        <option value="">— None (top-level category) —</option>
        @foreach($parents as $parent)
          <option value="{{ $parent->id }}"
            {{ old('parent_id', $category->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
            {{ $parent->name }}
          </option>
        @endforeach
      </select>
      <p class="form-hint">Select a parent to create this as a subcategory.</p>
      @error('parent_id')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
      <label class="form-label">Name *</label>
      <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
             value="{{ old('name', $category->name ?? '') }}" required />
      @error('name')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
      <label class="form-label">Description</label>
      <textarea class="form-control" name="description" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Icon (class / emoji)</label>
        <input class="form-control" type="text" name="icon"
               value="{{ old('icon', $category->icon ?? '') }}" placeholder="e.g. 🎂 or fa-cake" />
      </div>
      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input class="form-control" type="number" name="sort_order" min="0"
               value="{{ old('sort_order', $category->sort_order ?? 0) }}" />
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Image</label>
      <input class="form-control" type="file" name="image" accept="image/*" />
      @if(isset($category) && $category->image)
        <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="admin-img-preview" />
      @endif
    </div>

    <div class="form-group">
      <label class="form-label form-label--checkbox">
        <input type="checkbox" name="is_active" value="1"
               {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }} />
        Active (visible on frontend)
      </label>
    </div>

    <button type="submit" class="btn btn--primary">{{ isset($category) ? 'Update' : 'Create' }} Category</button>
  </form>
</div>
@endsection
