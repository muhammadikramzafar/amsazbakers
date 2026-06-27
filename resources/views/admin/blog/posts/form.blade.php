@extends('admin.layouts.app')
@section('title', isset($post) ? 'Edit Post' : 'New Blog Post')

@push('styles')
<style>
.prod-tabs { display:flex; gap:0; border-bottom:2px solid var(--clr-border); margin-bottom:0; }
.prod-tab  { padding:10px 20px; border:none; background:none; cursor:pointer; font-size:14px; font-weight:600; color:#888; border-bottom:2px solid transparent; margin-bottom:-2px; }
.prod-tab--active { color:var(--clr-primary); border-bottom-color:var(--clr-primary); }
.prod-panel { display:none; padding:24px; }
.prod-panel--active { display:block; }
</style>
@endpush

@section('content')
<div class="admin-page">
  <div class="admin-page__header">
    <h1 class="admin-page__title">{{ isset($post) ? 'Edit: '.Str::limit($post->title,50) : 'New Blog Post' }}</h1>
    <a href="{{ route('admin.blog.posts.index') }}" class="btn btn--outline">Back</a>
  </div>

  @if($errors->any())<div class="alert alert--error">{{ $errors->first() }}</div>@endif

  <form method="POST"
        action="{{ isset($post) ? route('admin.blog.posts.update', $post) : route('admin.blog.posts.store') }}"
        enctype="multipart/form-data">
    @csrf
    @if(isset($post)) @method('PUT') @endif

    <div style="display:grid;grid-template-columns:1fr 300px;gap:24px;align-items:start;">

      <!-- Main content -->
      <div>
        <div class="admin-card" style="padding:0;overflow:hidden;">
          <div class="prod-tabs">
            <button type="button" class="prod-tab prod-tab--active" data-panel="tab-content">Content</button>
            <button type="button" class="prod-tab" data-panel="tab-seo">SEO</button>
            <button type="button" class="prod-tab" data-panel="tab-gallery">Gallery</button>
          </div>

          <!-- Content Tab -->
          <div class="prod-panel prod-panel--active" id="tab-content">
            <div class="form-group">
              <label class="form-label">Title *</label>
              <input type="text" name="title" id="postTitle" class="form-control" value="{{ old('title', $post->title ?? '') }}" required />
            </div>
            <div class="form-group">
              <label class="form-label">Slug</label>
              <input type="text" name="slug" id="postSlug" class="form-control" value="{{ old('slug', $post->slug ?? '') }}" placeholder="auto-generated" />
            </div>
            <div class="form-group">
              <label class="form-label">Excerpt <span style="color:#aaa;font-weight:400;">(max 500 chars)</span></label>
              <textarea name="excerpt" class="form-control" rows="3" maxlength="500">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
            </div>
            <div class="form-group">
              <label class="form-label">Content (Rich Text)</label>
              <textarea name="content" id="postContent" class="form-control" rows="20">{{ old('content', $post->content ?? '') }}</textarea>
            </div>
          </div>

          <!-- SEO Tab -->
          <div class="prod-panel" id="tab-seo">
            <div class="form-group">
              <label class="form-label">SEO Title</label>
              <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title', $post->seo_title ?? '') }}" />
            </div>
            <div class="form-group">
              <label class="form-label">SEO Description <span style="color:#aaa;font-weight:400;">(max 320 chars)</span></label>
              <textarea name="seo_description" class="form-control" rows="3" maxlength="320">{{ old('seo_description', $post->seo_description ?? '') }}</textarea>
            </div>
            <div class="form-group">
              <label class="form-label">Keywords <span style="color:#aaa;font-weight:400;">(comma-separated)</span></label>
              <input type="text" name="seo_keywords" class="form-control" value="{{ old('seo_keywords', $post->seo_keywords ?? '') }}" />
            </div>
          </div>

          <!-- Gallery Tab -->
          <div class="prod-panel" id="tab-gallery">
            <div class="form-group">
              <label class="form-label">Featured Image</label>
              @if(isset($post) && $post->image_url)
                <img src="{{ $post->image_url }}" style="max-width:300px;border-radius:8px;margin-bottom:10px;display:block;" />
              @endif
              <input type="file" name="featured_image" class="form-control" accept="image/*" />
            </div>
            <div class="form-group">
              <label class="form-label">Additional Gallery Images</label>
              @if(isset($post) && $post->gallery)
                <div id="galleryRemoveInputs"></div>
                <div style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:12px;">
                  @foreach($post->gallery_urls as $i => $url)
                    <div id="gitem-{{ $i }}" style="position:relative;">
                      <img src="{{ $url }}" style="width:90px;height:90px;object-fit:cover;border-radius:6px;" />
                      <button type="button" onclick="removeGalleryImage('{{ $post->gallery[$i] }}', {{ $i }})"
                              style="position:absolute;top:-6px;right:-6px;background:#e74c3c;color:#fff;border:none;border-radius:50%;width:20px;height:20px;cursor:pointer;font-size:12px;">×</button>
                    </div>
                  @endforeach
                </div>
              @else
                <div id="galleryRemoveInputs"></div>
              @endif
              <input type="file" name="gallery_images[]" class="form-control" multiple accept="image/*" />
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div>
        <div class="admin-card" style="padding:20px;margin-bottom:16px;">
          <h3 style="font-size:14px;font-weight:700;margin-bottom:14px;">Publishing</h3>
          <div class="form-group">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
              <option value="draft"     {{ old('status', $post->status ?? 'draft') === 'draft'     ? 'selected':'' }}>Draft</option>
              <option value="published" {{ old('status', $post->status ?? '') === 'published' ? 'selected':'' }}>Published</option>
              <option value="scheduled" {{ old('status', $post->status ?? '') === 'scheduled' ? 'selected':'' }}>Scheduled</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Published At</label>
            <input type="datetime-local" name="published_at" class="form-control"
                   value="{{ old('published_at', isset($post->published_at) ? $post->published_at->format('Y-m-d\TH:i') : '') }}" />
          </div>
          <div class="form-group">
            <label class="form-label">Sort Order</label>
            <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $post->sort_order ?? 0) }}" />
          </div>
          <div class="form-group">
            <label class="form-check"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $post->is_featured ?? false) ? 'checked':'' }} /> <span>Featured Post</span></label>
          </div>
          <div class="form-group">
            <label class="form-check"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $post->is_active ?? true) ? 'checked':'' }} /> <span>Active</span></label>
          </div>
          <button type="submit" class="btn btn--primary" style="width:100%;">
            {{ isset($post) ? 'Update Post' : 'Create Post' }}
          </button>
        </div>

        <div class="admin-card" style="padding:20px;margin-bottom:16px;">
          <h3 style="font-size:14px;font-weight:700;margin-bottom:14px;">Category</h3>
          <select name="blog_category_id" class="form-control">
            <option value="">— No Category —</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ old('blog_category_id', $post->blog_category_id ?? '') == $cat->id ? 'selected':'' }}>{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="admin-card" style="padding:20px;">
          <h3 style="font-size:14px;font-weight:700;margin-bottom:14px;">Tags</h3>
          <div style="display:flex;flex-wrap:wrap;gap:8px;">
            @foreach($tags as $tag)
              @php $selected = isset($post) ? $post->tags->pluck('id')->contains($tag->id) : false; @endphp
              <label style="display:flex;align-items:center;gap:5px;font-size:13px;cursor:pointer;">
                <input type="checkbox" name="tag_ids[]" value="{{ $tag->id }}" {{ (collect(old('tag_ids', []))->contains($tag->id) || $selected) ? 'checked':'' }} />
                {{ $tag->name }}
              </label>
            @endforeach
          </div>
          @if($tags->isEmpty())
            <p style="font-size:13px;color:#aaa;margin:0;"><a href="{{ route('admin.blog.tags.index') }}">Add tags</a></p>
          @endif
        </div>
      </div>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
  selector: '#postContent',
  height: 500,
  menubar: false,
  plugins: 'lists link image media table code wordcount',
  toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image media table | code',
  content_style: 'body { font-family: -apple-system, sans-serif; font-size: 15px; line-height: 1.7; }',
  branding: false,
});

document.querySelectorAll('.prod-tab').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.prod-tab').forEach(b => b.classList.remove('prod-tab--active'));
    document.querySelectorAll('.prod-panel').forEach(p => p.classList.remove('prod-panel--active'));
    btn.classList.add('prod-tab--active');
    document.getElementById(btn.dataset.panel).classList.add('prod-panel--active');
  });
});

const titleInput = document.getElementById('postTitle');
const slugInput  = document.getElementById('postSlug');
titleInput && titleInput.addEventListener('blur', () => {
  if (!slugInput.value) {
    slugInput.value = titleInput.value.toLowerCase().replace(/[^a-z0-9\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-').replace(/^-|-$/g,'');
  }
});

function removeGalleryImage(path, index) {
  const item = document.getElementById('gitem-' + index);
  if (item) item.remove();
  const container = document.getElementById('galleryRemoveInputs');
  const input = document.createElement('input');
  input.type = 'hidden';
  input.name = 'gallery_remove[]';
  input.value = path;
  container.appendChild(input);
}
</script>
@endpush
