@extends('admin.layouts.app')
@section('title', isset($award) ? 'Edit Award' : 'New Award')

@section('content')
<div class="admin-page">
  <div class="admin-page__header">
    <h1 class="admin-page__title">{{ isset($award) ? 'Edit: '.$award->title : 'New Award / Certification' }}</h1>
    <a href="{{ route('admin.awards.index') }}" class="btn btn--outline">Back</a>
  </div>

  @if($errors->any())<div class="alert alert--error">{{ $errors->first() }}</div>@endif

  <form method="POST"
        action="{{ isset($award) ? route('admin.awards.update', $award) : route('admin.awards.store') }}"
        enctype="multipart/form-data">
    @csrf
    @if(isset($award)) @method('PUT') @endif

    <div style="display:grid;grid-template-columns:1fr 300px;gap:24px;align-items:start;">
      <div class="admin-card" style="padding:28px;">
        <div class="form-group">
          <label class="form-label">Title *</label>
          <input type="text" name="title" class="form-control" value="{{ old('title', $award->title ?? '') }}" required />
        </div>
        <div class="form-group">
          <label class="form-label">Awarding Body / Organization</label>
          <input type="text" name="awarding_body" class="form-control" value="{{ old('awarding_body', $award->awarding_body ?? '') }}" />
        </div>
        <div class="form-group">
          <label class="form-label">Year</label>
          <input type="number" name="year" class="form-control" min="1900" max="2099" value="{{ old('year', $award->year ?? date('Y')) }}" style="max-width:120px;" />
        </div>
        <div class="form-group">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control" rows="5">{{ old('description', $award->description ?? '') }}</textarea>
        </div>
      </div>

      <div class="admin-card" style="padding:24px;">
        <div class="form-group">
          <label class="form-label">Image / Badge</label>
          @if(isset($award) && $award->image_url)
            <img src="{{ $award->image_url }}" style="width:100%;border-radius:8px;margin-bottom:10px;" />
          @endif
          <input type="file" name="image" class="form-control" accept="image/*" />
        </div>
        <div class="form-group">
          <label class="form-label">Sort Order</label>
          <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $award->sort_order ?? 0) }}" />
        </div>
        <div class="form-group">
          <label class="form-check">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', ($award->is_active ?? true) ? '1':'0') == '1' ? 'checked':'' }} />
            <span>Active</span>
          </label>
        </div>
        <button type="submit" class="btn btn--primary" style="width:100%;margin-top:8px;">
          {{ isset($award) ? 'Update Award' : 'Create Award' }}
        </button>
      </div>
    </div>
  </form>
</div>
@endsection
