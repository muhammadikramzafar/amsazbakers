@extends('admin.layouts.app')
@section('title', isset($category) ? 'Edit Category' : 'New Blog Category')

@section('content')
<div class="admin-page">
  <div class="admin-page__header">
    <h1 class="admin-page__title">{{ isset($category) ? 'Edit: '.$category->name : 'New Blog Category' }}</h1>
    <a href="{{ route('admin.blog.categories.index') }}" class="btn btn--outline">Back</a>
  </div>

  @if($errors->any())<div class="alert alert--error">{{ $errors->first() }}</div>@endif

  <form method="POST"
        action="{{ isset($category) ? route('admin.blog.categories.update', $category) : route('admin.blog.categories.store') }}"
        enctype="multipart/form-data">
    @csrf
    @if(isset($category)) @method('PUT') @endif

    <div style="display:grid;grid-template-columns:1fr 320px;gap:24px;align-items:start;">
      <div class="admin-card" style="padding:28px;">
        <div class="form-group">
          <label class="form-label">Category Name *</label>
          <input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required />
        </div>
        <div class="form-group">
          <label class="form-label">Slug</label>
          <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug ?? '') }}" placeholder="auto-generated from name" />
        </div>
        <div class="form-group">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
        </div>
        <div class="form-group">
          <label class="form-label">Color</label>
          <input type="color" name="color" value="{{ old('color', $category->color ?? '#5a3e2b') }}" style="height:38px;width:80px;" />
        </div>
      </div>

      <div class="admin-card" style="padding:24px;">
        <div class="form-group">
          <label class="form-label">Image</label>
          @if(isset($category) && $category->image_url)
            <img src="{{ $category->image_url }}" alt="" style="width:100%;border-radius:8px;margin-bottom:10px;" />
          @endif
          <input type="file" name="image" class="form-control" accept="image/*" />
        </div>
        <div class="form-group">
          <label class="form-label">Sort Order</label>
          <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $category->sort_order ?? 0) }}" />
        </div>
        <div class="form-group">
          <label class="form-check">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', ($category->is_active ?? true) ? '1' : '0') == '1' ? 'checked' : '' }} />
            <span>Active</span>
          </label>
        </div>
        <button type="submit" class="btn btn--primary" style="width:100%;margin-top:8px;">
          {{ isset($category) ? 'Update Category' : 'Create Category' }}
        </button>
      </div>
    </div>
  </form>
</div>
@endsection
