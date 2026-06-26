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
    <div class="form-group">
      <label class="form-label">Image</label>
      <input class="form-control" type="file" name="image" accept="image/*" />
      @if(isset($category) && $category->image)
        <img src="{{ asset('storage/'.\->image) }}" alt="{{ $category->name }}" class="admin-img-preview" />
      @endif
    </div>
    <div class="form-group">
      <label class="form-label form-label--checkbox">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }} />
        Active
      </label>
    </div>
    <button type="submit" class="btn btn--primary">{{ isset($category) ? 'Update' : 'Create' }} Category</button>
  </form>
</div>
@endsection
