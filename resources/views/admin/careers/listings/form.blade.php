@extends('admin.layouts.app')
@section('title', isset($jobListing) ? 'Edit Job Listing' : 'New Job Listing')

@push('styles')
<style>
.prod-tabs { display:flex; gap:0; border-bottom:2px solid var(--clr-border); }
.prod-tab  { padding:10px 20px; border:none; background:none; cursor:pointer; font-size:14px; font-weight:600; color:#888; border-bottom:2px solid transparent; margin-bottom:-2px; }
.prod-tab--active { color:var(--clr-primary); border-bottom-color:var(--clr-primary); }
.prod-panel { display:none; padding:24px; }
.prod-panel--active { display:block; }
</style>
@endpush

@section('content')
<div class="admin-page">
  <div class="admin-page__header">
    <h1 class="admin-page__title">{{ isset($jobListing) ? 'Edit: '.$jobListing->title : 'New Job Listing' }}</h1>
    <a href="{{ route('admin.careers.listings.index') }}" class="btn btn--outline">Back</a>
  </div>

  @if($errors->any())<div class="alert alert--error">{{ $errors->first() }}</div>@endif

  <form method="POST"
        action="{{ isset($jobListing) ? route('admin.careers.listings.update', $jobListing) : route('admin.careers.listings.store') }}">
    @csrf
    @if(isset($jobListing)) @method('PUT') @endif

    <div style="display:grid;grid-template-columns:1fr 280px;gap:24px;align-items:start;">
      <div class="admin-card" style="padding:0;overflow:hidden;">
        <div class="prod-tabs">
          <button type="button" class="prod-tab prod-tab--active" data-panel="tab-basic">Basic</button>
          <button type="button" class="prod-tab" data-panel="tab-desc">Description</button>
          <button type="button" class="prod-tab" data-panel="tab-req">Requirements</button>
        </div>
        <div class="prod-panel prod-panel--active" id="tab-basic">
          <div class="form-group">
            <label class="form-label">Job Title *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $jobListing->title ?? '') }}" required />
          </div>
          <div class="form-group">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug', $jobListing->slug ?? '') }}" placeholder="auto-generated" />
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group">
              <label class="form-label">Department</label>
              <input type="text" name="department" class="form-control" value="{{ old('department', $jobListing->department ?? '') }}" placeholder="e.g. Kitchen, Sales" />
            </div>
            <div class="form-group">
              <label class="form-label">Location</label>
              <input type="text" name="location" class="form-control" value="{{ old('location', $jobListing->location ?? '') }}" placeholder="e.g. Lahore, Pakistan" />
            </div>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group">
              <label class="form-label">Employment Type *</label>
              <select name="type" class="form-control">
                <option value="full-time"  {{ old('type', $jobListing->type ?? 'full-time') === 'full-time'  ? 'selected':'' }}>Full-Time</option>
                <option value="part-time"  {{ old('type', $jobListing->type ?? '') === 'part-time'  ? 'selected':'' }}>Part-Time</option>
                <option value="contract"   {{ old('type', $jobListing->type ?? '') === 'contract'   ? 'selected':'' }}>Contract</option>
                <option value="internship" {{ old('type', $jobListing->type ?? '') === 'internship' ? 'selected':'' }}>Internship</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Salary Range</label>
              <input type="text" name="salary_range" class="form-control" value="{{ old('salary_range', $jobListing->salary_range ?? '') }}" placeholder="e.g. Rs. 30,000 – 50,000" />
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Benefits</label>
            <textarea name="benefits" class="form-control" rows="3">{{ old('benefits', $jobListing->benefits ?? '') }}</textarea>
          </div>
        </div>
        <div class="prod-panel" id="tab-desc">
          <div class="form-group">
            <label class="form-label">Job Description *</label>
            <textarea name="description" class="form-control" rows="14">{{ old('description', $jobListing->description ?? '') }}</textarea>
          </div>
        </div>
        <div class="prod-panel" id="tab-req">
          <div class="form-group">
            <label class="form-label">Requirements</label>
            <textarea name="requirements" class="form-control" rows="14" placeholder="One requirement per line…">{{ old('requirements', $jobListing->requirements ?? '') }}</textarea>
          </div>
        </div>
      </div>

      <div class="admin-card" style="padding:20px;">
        <div class="form-group">
          <label class="form-label">Application Deadline</label>
          <input type="date" name="application_deadline" class="form-control" value="{{ old('application_deadline', isset($jobListing->application_deadline) ? $jobListing->application_deadline->format('Y-m-d') : '') }}" />
        </div>
        <div class="form-group">
          <label class="form-label">Sort Order</label>
          <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $jobListing->sort_order ?? 0) }}" />
        </div>
        <div class="form-group">
          <label class="form-check">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', ($jobListing->is_active ?? true) ? '1':'0') == '1' ? 'checked':'' }} />
            <span>Active / Accepting Applications</span>
          </label>
        </div>
        <button type="submit" class="btn btn--primary" style="width:100%;margin-top:8px;">
          {{ isset($jobListing) ? 'Update Listing' : 'Create Listing' }}
        </button>
      </div>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.prod-tab').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.prod-tab').forEach(b => b.classList.remove('prod-tab--active'));
    document.querySelectorAll('.prod-panel').forEach(p => p.classList.remove('prod-panel--active'));
    btn.classList.add('prod-tab--active');
    document.getElementById(btn.dataset.panel).classList.add('prod-panel--active');
  });
});
</script>
@endpush
