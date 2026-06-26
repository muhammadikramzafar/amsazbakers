@extends('admin.layouts.app')
@section('title', isset($product) ? 'Edit Product' : 'Add Product')
@section('breadcrumb', isset($product) ? 'Edit Product' : 'Add Product')
@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">{{ isset($product) ? 'Edit' : 'Add' }} Product</h1>
  <a href="{{ route('admin.products.index') }}" class="btn btn--outline">Back</a>
</div>
<div class="admin-card" style="max-width:720px">
  <form method="POST"
        action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
        enctype="multipart/form-data">
    @csrf
    @if(isset($product)) @method('PUT') @endif
    <div class="form-group">
      <label class="form-label">Category *</label>
      <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" required>
        <option value="">Select category</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
            {{ $cat->name }}
          </option>
        @endforeach
      </select>
      @error('category_id')<p class="form-error">{{ $message }}</p>@enderror
    </div>
    <div class="form-group">
      <label class="form-label">Product Name *</label>
      <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
             value="{{ old('name', $product->name ?? '') }}" required />
      @error('name')<p class="form-error">{{ $message }}</p>@enderror
    </div>
    <div class="form-group">
      <label class="form-label">Description</label>
      <textarea class="form-control" name="description" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Price (Rs.) *</label>
        <input class="form-control @error('price') is-invalid @enderror" type="number" name="price" step="0.01" min="0"
               value="{{ old('price', $product->price ?? '') }}" required />
        @error('price')<p class="form-error">{{ $message }}</p>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Sale Price (Rs.)</label>
        <input class="form-control" type="number" name="sale_price" step="0.01" min="0"
               value="{{ old('sale_price', $product->sale_price ?? '') }}" />
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Badge (e.g. Bestseller, New, Hot)</label>
      <input class="form-control" type="text" name="badge"
             value="{{ old('badge', $product->badge ?? '') }}" placeholder="Bestseller" />
    </div>
    <div class="form-group">
      <label class="form-label">Product Image</label>
      <input class="form-control" type="file" name="image" accept="image/*" />
      @if(isset($product) && $product->image)
        <img src="{{ asset('storage/'.\->image) }}" alt="{{ $product->name }}" class="admin-img-preview" />
      @endif
    </div>
    <div class="form-group form-group--checkboxes">
      <label class="form-label form-label--checkbox">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }} />
        Active
      </label>
      <label class="form-label form-label--checkbox">
        <input type="checkbox" name="is_available" value="1" {{ old('is_available', $product->is_available ?? true) ? 'checked' : '' }} />
        Available
      </label>
      <label class="form-label form-label--checkbox">
        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }} />
        Featured (show on home page)
      </label>
    </div>
    <button type="submit" class="btn btn--primary">{{ isset($product) ? 'Update' : 'Create' }} Product</button>
  </form>
</div>
@endsection
