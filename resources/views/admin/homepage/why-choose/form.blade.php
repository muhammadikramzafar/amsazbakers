@extends('admin.layouts.app')
@section('title', isset($feature) ? 'Edit Feature' : 'Add Feature')
@section('breadcrumb', isset($feature) ? 'Edit Feature' : 'Add Feature')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">{{ isset($feature) ? 'Edit Feature' : 'Add Why Choose Feature' }}</h1>
  <a href="{{ route('admin.homepage.why-choose.index') }}" class="btn btn--outline">Back</a>
</div>

<form method="POST"
      action="{{ isset($feature) ? route('admin.homepage.why-choose.update', $feature) : route('admin.homepage.why-choose.store') }}"
      novalidate>
  @csrf
  @if(isset($feature)) @method('PUT') @endif

  <div class="admin-card" style="max-width:600px;">
    <div class="form-group">
      <label class="form-label">Icon <span style="color:red">*</span></label>
      <select class="form-control" name="icon_name" required>
        @foreach($icons as $key => $label)
          <option value="{{ $key }}" {{ old('icon_name', $feature->icon_name ?? '') === $key ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label class="form-label">Title <span style="color:red">*</span></label>
      <input class="form-control @error('title') is-invalid @enderror" type="text" name="title"
             value="{{ old('title', $feature->title ?? '') }}" required autofocus>
      @error('title')<p class="form-error">{{ $message }}</p>@enderror
    </div>
    <div class="form-group">
      <label class="form-label">Description</label>
      <textarea class="form-control" name="description" rows="3"
                placeholder="One or two sentences about this benefit…">{{ old('description', $feature->description ?? '') }}</textarea>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input class="form-control" type="number" name="sort_order" min="0"
               value="{{ old('sort_order', $feature->sort_order ?? 0) }}">
      </div>
      <div class="form-group" style="display:flex;align-items:flex-end;padding-bottom:2px;">
        <label class="form-label--checkbox" style="font-size:14px;">
          <input type="hidden" name="is_active" value="0">
          <input type="checkbox" name="is_active" value="1"
                 {{ old('is_active', $feature->is_active ?? true) ? 'checked' : '' }}>
          Active
        </label>
      </div>
    </div>
    <button type="submit" class="btn btn--primary">{{ isset($feature) ? 'Update Feature' : 'Save Feature' }}</button>
  </div>
</form>
@endsection
