@extends('admin.layouts.app')
@section('title', 'Blog Tags')

@section('content')
<div class="admin-page">
  <div class="admin-page__header">
    <div>
      <h1 class="admin-page__title">Blog Tags</h1>
      <p class="admin-page__sub">{{ $tags->total() }} tags</p>
    </div>
    <a href="{{ route('admin.blog.posts.index') }}" class="btn btn--outline">Back to Posts</a>
  </div>

  @if(session('success'))<div class="alert alert--success">{{ session('success') }}</div>@endif

  <div style="display:grid;grid-template-columns:340px 1fr;gap:24px;align-items:start;">

    <!-- Add Tag -->
    <div class="admin-card" style="padding:24px;">
      <h2 style="font-size:16px;font-weight:700;margin-bottom:16px;">Add New Tag</h2>
      @if($errors->any())<div class="alert alert--error" style="margin-bottom:12px;">{{ $errors->first() }}</div>@endif
      <form method="POST" action="{{ route('admin.blog.tags.store') }}">
        @csrf
        <div class="form-group">
          <label class="form-label">Tag Name *</label>
          <input type="text" name="name" class="form-control" value="{{ old('name') }}" required />
        </div>
        <button type="submit" class="btn btn--primary" style="width:100%;">Add Tag</button>
      </form>
    </div>

    <!-- Tags List -->
    <div class="admin-card">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Slug</th>
            <th>Posts</th>
            <th style="width:120px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($tags as $tag)
          <tr>
            <td><strong>{{ $tag->name }}</strong></td>
            <td><code style="font-size:12px;color:#888;">{{ $tag->slug }}</code></td>
            <td>{{ $tag->posts_count }}</td>
            <td class="admin-table__actions">
              <button onclick="openEditTag({{ $tag->id }}, '{{ addslashes($tag->name) }}')" class="btn btn--sm btn--outline">Edit</button>
              <form method="POST" action="{{ route('admin.blog.tags.destroy', $tag) }}" onsubmit="return confirm('Delete tag?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn--sm btn--danger">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="4" class="admin-table__empty">No tags yet.</td></tr>
          @endforelse
        </tbody>
      </table>
      <div class="admin-card__footer">{{ $tags->links() }}</div>
    </div>
  </div>
</div>

<!-- Edit Tag Modal -->
<div id="editTagModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center;">
  <div style="background:#fff;border-radius:12px;padding:28px;min-width:340px;max-width:420px;">
    <h2 style="font-size:16px;font-weight:700;margin-bottom:16px;">Edit Tag</h2>
    <form method="POST" id="editTagForm">
      @csrf @method('PUT')
      <div class="form-group">
        <label class="form-label">Tag Name *</label>
        <input type="text" name="name" id="editTagName" class="form-control" required />
      </div>
      <div style="display:flex;gap:10px;margin-top:16px;">
        <button type="submit" class="btn btn--primary" style="flex:1;">Update</button>
        <button type="button" onclick="closeEditTag()" class="btn btn--outline" style="flex:1;">Cancel</button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
function openEditTag(id, name) {
  document.getElementById('editTagName').value = name;
  document.getElementById('editTagForm').action = '/admin/blog/tags/' + id;
  document.getElementById('editTagModal').style.display = 'flex';
}
function closeEditTag() {
  document.getElementById('editTagModal').style.display = 'none';
}
</script>
@endpush
@endsection
