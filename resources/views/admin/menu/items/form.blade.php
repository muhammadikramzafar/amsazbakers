@extends('admin.layouts.app')
@section('title', isset($menuItem) ? 'Edit Menu Item' : 'Add Menu Item')
@section('breadcrumb', isset($menuItem) ? 'Edit Menu Item' : 'Add Menu Item')

@push('styles')
<style>
.prod-tabs{display:flex;gap:0;border-bottom:2px solid var(--clr-border);margin-bottom:24px}
.prod-tab{padding:10px 20px;border:none;background:none;cursor:pointer;font-weight:500;color:#888;border-bottom:3px solid transparent;margin-bottom:-2px;transition:color .15s}
.prod-tab--active{color:var(--clr-primary);border-bottom-color:var(--clr-primary)}
.prod-panel{display:none}
.prod-panel--active{display:block}
.gallery-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(110px,1fr));gap:10px;margin-top:10px}
.gallery-item{position:relative}
.gallery-item img{width:100%;aspect-ratio:1;object-fit:cover;border-radius:6px;border:2px solid var(--clr-border)}
.gallery-item__del{position:absolute;top:4px;right:4px;background:rgba(255,50,50,.85);color:#fff;border:none;border-radius:50%;width:20px;height:20px;font-size:12px;cursor:pointer;display:flex;align-items:center;justify-content:center}
</style>
@endpush

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">{{ isset($menuItem) ? 'Edit' : 'Add' }} Menu Item</h1>
  <a href="{{ route('admin.menu.items.index') }}" class="btn btn--outline">Back</a>
</div>

<form method="POST"
      action="{{ isset($menuItem) ? route('admin.menu.items.update', $menuItem) : route('admin.menu.items.store') }}"
      enctype="multipart/form-data">
  @csrf
  @if(isset($menuItem)) @method('PUT') @endif

  <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">

    {{-- LEFT: Tabs --}}
    <div>
      <div class="admin-card">
        <div class="prod-tabs">
          <button type="button" class="prod-tab prod-tab--active" data-panel="basic">Basic</button>
          <button type="button" class="prod-tab" data-panel="detail">Detail</button>
          <button type="button" class="prod-tab" data-panel="nutrition">Nutrition</button>
          <button type="button" class="prod-tab" data-panel="images">Images</button>
        </div>

        {{-- BASIC --}}
        <div class="prod-panel prod-panel--active" id="panel-basic">
          <div class="form-group">
            <label class="form-label">Item Name *</label>
            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                   value="{{ old('name', $menuItem->name ?? '') }}" required />
            @error('name')<p class="form-error">{{ $message }}</p>@enderror
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Price (Rs.) *</label>
              <input class="form-control @error('price') is-invalid @enderror" type="number" name="price" step="0.01" min="0"
                     value="{{ old('price', $menuItem->price ?? '') }}" required />
              @error('price')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
              <label class="form-label">Discount Price (Rs.)</label>
              <input class="form-control" type="number" name="discount_price" step="0.01" min="0"
                     value="{{ old('discount_price', $menuItem->discount_price ?? '') }}" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">SKU</label>
              <input class="form-control @error('sku') is-invalid @enderror" type="text" name="sku"
                     value="{{ old('sku', $menuItem->sku ?? '') }}" placeholder="MENU-001" />
            </div>
            <div class="form-group">
              <label class="form-label">Sort Order</label>
              <input class="form-control" type="number" name="sort_order" min="0"
                     value="{{ old('sort_order', $menuItem->sort_order ?? 0) }}" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Preparation Time</label>
              <input class="form-control" type="text" name="preparation_time"
                     value="{{ old('preparation_time', $menuItem->preparation_time ?? '') }}" placeholder="15–20 mins" />
            </div>
            <div class="form-group">
              <label class="form-label">Serving Size</label>
              <input class="form-control" type="text" name="serving_size"
                     value="{{ old('serving_size', $menuItem->serving_size ?? '') }}" placeholder="1 serving (250g)" />
            </div>
          </div>
        </div>

        {{-- DETAIL --}}
        <div class="prod-panel" id="panel-detail">
          <div class="form-group">
            <label class="form-label">Short Description (card preview)</label>
            <textarea class="form-control" name="short_description" rows="3"
              placeholder="Brief 1–2 sentence description…">{{ old('short_description', $menuItem->short_description ?? '') }}</textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Full Description</label>
            <textarea class="form-control" name="description" rows="7"
              placeholder="Detailed description, preparation notes, flavour profile…">{{ old('description', $menuItem->description ?? '') }}</textarea>
          </div>
        </div>

        {{-- NUTRITION --}}
        <div class="prod-panel" id="panel-nutrition">
          <div class="form-group">
            <label class="form-label">Ingredients</label>
            <textarea class="form-control" name="ingredients" rows="4"
              placeholder="Flour, Sugar, Eggs, Butter, Vanilla Extract…">{{ old('ingredients', $menuItem->ingredients ?? '') }}</textarea>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Calories (per serving)</label>
              <input class="form-control" type="number" name="calories" min="0"
                     value="{{ old('calories', $menuItem->calories ?? '') }}" placeholder="320" />
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Nutritional Information</label>
            <textarea class="form-control" name="nutritional_info" rows="4"
              placeholder="Per 100g: Protein 5g, Carbs 52g, Fat 12g…">{{ old('nutritional_info', $menuItem->nutritional_info ?? '') }}</textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Allergens</label>
            <input class="form-control" type="text" name="allergens"
                   value="{{ old('allergens', $menuItem->allergens ?? '') }}"
                   placeholder="Contains: Gluten, Dairy, Eggs" />
          </div>
        </div>

        {{-- IMAGES --}}
        <div class="prod-panel" id="panel-images">
          <div class="form-group">
            <label class="form-label">Featured Image</label>
            <input class="form-control" type="file" name="featured_image" accept="image/*" />
            @if(isset($menuItem) && $menuItem->featured_image)
              <img src="{{ Storage::url($menuItem->featured_image) }}" alt="{{ $menuItem->name }}" class="admin-img-preview" />
            @endif
          </div>
          <div class="form-group">
            <label class="form-label">Gallery Images</label>
            <input class="form-control" type="file" name="gallery_images[]" multiple accept="image/*" />
            <p class="form-hint">Hold Ctrl/Cmd to select multiple files.</p>
            @if(isset($menuItem) && !empty($menuItem->gallery))
              <div class="gallery-grid">
                @foreach($menuItem->gallery as $path)
                <div class="gallery-item" id="gitem-{{ $loop->index }}">
                  <img src="{{ Storage::url($path) }}" alt="" />
                  <button type="button" class="gallery-item__del"
                          onclick="removeGallery('{{ $path }}', {{ $loop->index }})">&times;</button>
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
      <div class="admin-card" style="margin-bottom:16px;">
        <h3 class="admin-card__heading">Category *</h3>
        <div class="form-group">
          <select class="form-control @error('menu_category_id') is-invalid @enderror" name="menu_category_id" required>
            <option value="">Select category</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ old('menu_category_id', $menuItem->menu_category_id ?? '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
              </option>
            @endforeach
          </select>
          @error('menu_category_id')<p class="form-error">{{ $message }}</p>@enderror
        </div>
      </div>

      <div class="admin-card" style="margin-bottom:16px;">
        <h3 class="admin-card__heading">Availability</h3>
        <div style="display:flex;flex-direction:column;gap:10px;">
          <label class="form-label form-label--checkbox">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $menuItem->is_active ?? true) ? 'checked' : '' }} />
            Active (visible on menu)
          </label>
          <label class="form-label form-label--checkbox">
            <input type="checkbox" name="is_available" value="1" {{ old('is_available', $menuItem->is_available ?? true) ? 'checked' : '' }} />
            Currently Available
          </label>
        </div>
      </div>

      <div class="admin-card" style="margin-bottom:16px;">
        <h3 class="admin-card__heading">Labels</h3>
        <div style="display:flex;flex-direction:column;gap:10px;">
          <label class="form-label form-label--checkbox">
            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $menuItem->is_featured ?? false) ? 'checked' : '' }} />
            Featured Item
          </label>
          <label class="form-label form-label--checkbox">
            <input type="checkbox" name="is_bestseller" value="1" {{ old('is_bestseller', $menuItem->is_bestseller ?? false) ? 'checked' : '' }} />
            Bestseller
          </label>
          <label class="form-label form-label--checkbox">
            <input type="checkbox" name="is_chef_recommended" value="1" {{ old('is_chef_recommended', $menuItem->is_chef_recommended ?? false) ? 'checked' : '' }} />
            Chef's Recommendation
          </label>
          <label class="form-label form-label--checkbox">
            <input type="checkbox" name="is_seasonal" value="1" {{ old('is_seasonal', $menuItem->is_seasonal ?? false) ? 'checked' : '' }} />
            Seasonal Item
          </label>
        </div>
      </div>

      <button type="submit" class="btn btn--primary btn--full">
        {{ isset($menuItem) ? 'Update Item' : 'Create Item' }}
      </button>
    </div>
  </div>
</form>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.prod-tab').forEach(tab => {
  tab.addEventListener('click', () => {
    document.querySelectorAll('.prod-tab').forEach(t => t.classList.remove('prod-tab--active'));
    document.querySelectorAll('.prod-panel').forEach(p => p.classList.remove('prod-panel--active'));
    tab.classList.add('prod-tab--active');
    document.getElementById('panel-' + tab.dataset.panel).classList.add('prod-panel--active');
  });
});
function removeGallery(path, index) {
  const item = document.getElementById('gitem-' + index);
  if (item) item.remove();
  const input = document.createElement('input');
  input.type = 'hidden';
  input.name = 'gallery_remove[]';
  input.value = path;
  document.getElementById('galleryRemoveInputs').appendChild(input);
}
</script>
@endpush
