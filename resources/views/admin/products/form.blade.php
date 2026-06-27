@extends('admin.layouts.app')
@section('title', isset($product) ? 'Edit Product' : 'Add Product')
@section('breadcrumb', isset($product) ? 'Edit Product' : 'Add Product')

@push('styles')
<style>
.prod-tabs { display:flex; gap:0; border-bottom:2px solid var(--clr-border); margin-bottom:24px; }
.prod-tab { padding:10px 20px; border:none; background:none; cursor:pointer; font-weight:500; color:#888; border-bottom:3px solid transparent; margin-bottom:-2px; transition:color .15s; }
.prod-tab--active { color:var(--clr-primary); border-bottom-color:var(--clr-primary); }
.prod-panel { display:none; }
.prod-panel--active { display:block; }
.gallery-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(110px,1fr)); gap:10px; margin-top:10px; }
.gallery-item { position:relative; }
.gallery-item img { width:100%; aspect-ratio:1; object-fit:cover; border-radius:6px; border:2px solid var(--clr-border); }
.gallery-item__del { position:absolute; top:4px; right:4px; background:rgba(255,50,50,.85); color:#fff; border:none; border-radius:50%; width:20px; height:20px; font-size:12px; cursor:pointer; display:flex; align-items:center; justify-content:center; line-height:1; }
</style>
@endpush

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">{{ isset($product) ? 'Edit' : 'Add' }} Product</h1>
  <a href="{{ route('admin.products.index') }}" class="btn btn--outline">Back</a>
</div>

<form method="POST"
      action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
      enctype="multipart/form-data"
      id="productForm">
  @csrf
  @if(isset($product)) @method('PUT') @endif

  <div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start;">

    {{-- LEFT: Main content --}}
    <div>
      <div class="admin-card">
        <div class="prod-tabs">
          <button type="button" class="prod-tab prod-tab--active" data-panel="basic">Basic Info</button>
          <button type="button" class="prod-tab" data-panel="desc">Descriptions</button>
          <button type="button" class="prod-tab" data-panel="nutrition">Ingredients & Nutrition</button>
          <button type="button" class="prod-tab" data-panel="images">Images</button>
        </div>

        {{-- BASIC --}}
        <div class="prod-panel prod-panel--active" id="panel-basic">
          <div class="form-group">
            <label class="form-label">Product Name *</label>
            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                   value="{{ old('name', $product->name ?? '') }}" required />
            @error('name')<p class="form-error">{{ $message }}</p>@enderror
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">SKU (unique)</label>
              <input class="form-control @error('sku') is-invalid @enderror" type="text" name="sku"
                     value="{{ old('sku', $product->sku ?? '') }}" placeholder="e.g. BAK-001" />
              @error('sku')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
              <label class="form-label">Badge</label>
              <input class="form-control" type="text" name="badge"
                     value="{{ old('badge', $product->badge ?? '') }}" placeholder="New, Hot, Sale…" />
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Price (Rs.) *</label>
              <input class="form-control @error('price') is-invalid @enderror" type="number" name="price"
                     step="0.01" min="0" value="{{ old('price', $product->price ?? '') }}" required />
              @error('price')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
              <label class="form-label">Sale Price (Rs.)</label>
              <input class="form-control" type="number" name="sale_price" step="0.01" min="0"
                     value="{{ old('sale_price', $product->sale_price ?? '') }}" />
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Sort Order</label>
              <input class="form-control" type="number" name="sort_order" min="0"
                     value="{{ old('sort_order', $product->sort_order ?? 0) }}" />
            </div>
          </div>
        </div>

        {{-- DESCRIPTIONS --}}
        <div class="prod-panel" id="panel-desc">
          <div class="form-group">
            <label class="form-label">Short Description (listing preview)</label>
            <textarea class="form-control" name="short_description" rows="3"
              placeholder="Brief 1–2 sentence description shown on product cards…">{{ old('short_description', $product->short_description ?? '') }}</textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Full Description</label>
            <textarea class="form-control" name="full_description" rows="8"
              placeholder="Detailed description shown on product detail page…">{{ old('full_description', $product->full_description ?? '') }}</textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Legacy Description</label>
            <textarea class="form-control" name="description" rows="3">{{ old('description', $product->description ?? '') }}</textarea>
            <p class="form-hint">Backward-compatible field. Prefer using Short/Full descriptions above.</p>
          </div>
        </div>

        {{-- NUTRITION --}}
        <div class="prod-panel" id="panel-nutrition">
          <div class="form-group">
            <label class="form-label">Ingredients</label>
            <textarea class="form-control" name="ingredients" rows="4"
              placeholder="Flour, Sugar, Butter, Eggs, Vanilla Extract…">{{ old('ingredients', $product->ingredients ?? '') }}</textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Nutritional Information</label>
            <textarea class="form-control" name="nutritional_info" rows="5"
              placeholder="Per 100g: Calories 320 kcal, Protein 4g, Carbohydrates 52g…">{{ old('nutritional_info', $product->nutritional_info ?? '') }}</textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Allergens</label>
            <input class="form-control" type="text" name="allergens"
                   value="{{ old('allergens', $product->allergens ?? '') }}"
                   placeholder="Contains: Gluten, Dairy, Eggs, Nuts" />
          </div>
        </div>

        {{-- IMAGES --}}
        <div class="prod-panel" id="panel-images">
          <div class="form-group">
            <label class="form-label">Featured Image</label>
            <input class="form-control" type="file" name="image" accept="image/*" />
            @if(isset($product) && $product->image)
              <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="admin-img-preview" />
            @endif
          </div>
          <div class="form-group">
            <label class="form-label">Gallery Images (multiple)</label>
            <input class="form-control" type="file" name="gallery_images[]" multiple accept="image/*" />
            <p class="form-hint">Hold Ctrl/Cmd to select multiple files. Max 2MB each, scaled to 800×600.</p>

            @if(isset($product) && !empty($product->gallery))
              <div class="gallery-grid" id="galleryGrid">
                @foreach($product->gallery as $imgPath)
                <div class="gallery-item" id="gitem-{{ $loop->index }}">
                  <img src="{{ Storage::url($imgPath) }}" alt="Gallery image {{ $loop->iteration }}" />
                  <input type="hidden" name="gallery_keep[]" value="{{ $imgPath }}" />
                  <button type="button" class="gallery-item__del"
                          onclick="removeGalleryImage('{{ $imgPath }}', {{ $loop->index }})"
                          title="Remove this image">&times;</button>
                </div>
                @endforeach
              </div>
              <div id="galleryRemoveInputs"></div>
            @endif
          </div>
        </div>
      </div>
    </div>

    {{-- RIGHT: Sidebar --}}
    <div>
      {{-- Category --}}
      <div class="admin-card" style="margin-bottom:16px;">
        <h3 class="admin-card__heading">Classification</h3>
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
          <label class="form-label">Subcategory</label>
          <select class="form-control @error('subcategory_id') is-invalid @enderror" name="subcategory_id">
            <option value="">— None —</option>
            @foreach($subcategories as $sub)
              <option value="{{ $sub->id }}" {{ old('subcategory_id', $product->subcategory_id ?? '') == $sub->id ? 'selected' : '' }}>
                {{ $sub->parent->name ?? '' }} &rsaquo; {{ $sub->name }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      {{-- Status --}}
      <div class="admin-card" style="margin-bottom:16px;">
        <h3 class="admin-card__heading">Status</h3>
        <div style="display:flex;flex-direction:column;gap:10px;">
          <label class="form-label form-label--checkbox">
            <input type="checkbox" name="is_active" value="1"
                   {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }} />
            Active (visible on frontend)
          </label>
          <label class="form-label form-label--checkbox">
            <input type="checkbox" name="is_available" value="1"
                   {{ old('is_available', $product->is_available ?? true) ? 'checked' : '' }} />
            In Stock / Available
          </label>
        </div>
      </div>

      {{-- Labels --}}
      <div class="admin-card" style="margin-bottom:16px;">
        <h3 class="admin-card__heading">Product Labels</h3>
        <div style="display:flex;flex-direction:column;gap:10px;">
          <label class="form-label form-label--checkbox">
            <input type="checkbox" name="is_featured" value="1"
                   {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }} />
            Featured (shown on homepage)
          </label>
          <label class="form-label form-label--checkbox">
            <input type="checkbox" name="is_bestseller" value="1"
                   {{ old('is_bestseller', $product->is_bestseller ?? false) ? 'checked' : '' }} />
            Bestseller
          </label>
          <label class="form-label form-label--checkbox">
            <input type="checkbox" name="is_seasonal" value="1"
                   {{ old('is_seasonal', $product->is_seasonal ?? false) ? 'checked' : '' }} />
            Seasonal / Limited
          </label>
        </div>
      </div>

      <button type="submit" class="btn btn--primary btn--full">
        {{ isset($product) ? 'Update Product' : 'Create Product' }}
      </button>
    </div>
  </div>
</form>
@endsection

@push('scripts')
<script>
// Tab switching
document.querySelectorAll('.prod-tab').forEach(tab => {
  tab.addEventListener('click', () => {
    document.querySelectorAll('.prod-tab').forEach(t => t.classList.remove('prod-tab--active'));
    document.querySelectorAll('.prod-panel').forEach(p => p.classList.remove('prod-panel--active'));
    tab.classList.add('prod-tab--active');
    document.getElementById('panel-' + tab.dataset.panel).classList.add('prod-panel--active');
  });
});

// If there are validation errors in a non-basic tab, switch to that tab
@if($errors->has('short_description') || $errors->has('full_description') || $errors->has('description'))
  document.querySelector('[data-panel="desc"]').click();
@elseif($errors->has('ingredients') || $errors->has('nutritional_info') || $errors->has('allergens'))
  document.querySelector('[data-panel="nutrition"]').click();
@endif

// Gallery image removal
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
