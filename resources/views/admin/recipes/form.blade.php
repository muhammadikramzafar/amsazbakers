@extends('admin.layouts.app')
@section('title', isset($recipe) ? 'Edit Recipe' : 'Add Recipe')
@section('breadcrumb', isset($recipe) ? 'Edit Recipe' : 'Add Recipe')

@push('styles')
<style>
.prod-tabs{display:flex;gap:0;border-bottom:2px solid var(--clr-border);margin-bottom:24px;flex-wrap:wrap}
.prod-tab{padding:10px 18px;border:none;background:none;cursor:pointer;font-weight:500;color:#888;border-bottom:3px solid transparent;margin-bottom:-2px;transition:color .15s;font-size:13px}
.prod-tab--active{color:var(--clr-primary);border-bottom-color:var(--clr-primary)}
.prod-panel{display:none}
.prod-panel--active{display:block}
.gallery-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(110px,1fr));gap:10px;margin-top:10px}
.gallery-item{position:relative}
.gallery-item img{width:100%;aspect-ratio:1;object-fit:cover;border-radius:6px;border:2px solid var(--clr-border)}
.gallery-item__del{position:absolute;top:4px;right:4px;background:rgba(255,50,50,.85);color:#fff;border:none;border-radius:50%;width:20px;height:20px;font-size:12px;cursor:pointer;display:flex;align-items:center;justify-content:center}
.step-hint{font-size:12px;color:#888;margin-top:4px}
</style>
@endpush

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">{{ isset($recipe) ? 'Edit' : 'Add' }} Recipe</h1>
  <a href="{{ route('admin.recipes.index') }}" class="btn btn--outline">Back</a>
</div>

<form method="POST"
      action="{{ isset($recipe) ? route('admin.recipes.update', $recipe) : route('admin.recipes.store') }}"
      enctype="multipart/form-data">
  @csrf
  @if(isset($recipe)) @method('PUT') @endif

  <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">

    {{-- LEFT --}}
    <div>
      <div class="admin-card">
        <div class="prod-tabs">
          <button type="button" class="prod-tab prod-tab--active" data-panel="basics">Basic Info</button>
          <button type="button" class="prod-tab" data-panel="ingredients">Ingredients</button>
          <button type="button" class="prod-tab" data-panel="steps">Steps</button>
          <button type="button" class="prod-tab" data-panel="notes">Chef Notes</button>
          <button type="button" class="prod-tab" data-panel="images">Images</button>
          <button type="button" class="prod-tab" data-panel="seo">SEO</button>
        </div>

        {{-- BASICS --}}
        <div class="prod-panel prod-panel--active" id="panel-basics">
          <div class="form-group">
            <label class="form-label">Recipe Title *</label>
            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title"
                   value="{{ old('title', $recipe->title ?? '') }}" required />
            @error('title')<p class="form-error">{{ $message }}</p>@enderror
          </div>
          <div class="form-group">
            <label class="form-label">Short Description</label>
            <textarea class="form-control" name="short_description" rows="3"
              placeholder="Brief intro shown on listing cards…">{{ old('short_description', $recipe->short_description ?? '') }}</textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Full Description / Introduction</label>
            <textarea class="form-control" name="description" rows="6"
              placeholder="Background story, occasion, why you'll love it…">{{ old('description', $recipe->description ?? '') }}</textarea>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Prep Time</label>
              <input class="form-control" type="text" name="prep_time"
                     value="{{ old('prep_time', $recipe->prep_time ?? '') }}" placeholder="15 mins" />
            </div>
            <div class="form-group">
              <label class="form-label">Cook Time</label>
              <input class="form-control" type="text" name="cook_time"
                     value="{{ old('cook_time', $recipe->cook_time ?? '') }}" placeholder="30 mins" />
            </div>
            <div class="form-group">
              <label class="form-label">Total Time</label>
              <input class="form-control" type="text" name="total_time"
                     value="{{ old('total_time', $recipe->total_time ?? '') }}" placeholder="45 mins" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Servings</label>
              <input class="form-control" type="number" name="servings" min="1"
                     value="{{ old('servings', $recipe->servings ?? '') }}" placeholder="4" />
            </div>
            <div class="form-group">
              <label class="form-label">Difficulty *</label>
              <select class="form-control @error('difficulty') is-invalid @enderror" name="difficulty">
                <option value="easy"   {{ old('difficulty', $recipe->difficulty ?? 'medium') === 'easy'   ? 'selected' : '' }}>Easy</option>
                <option value="medium" {{ old('difficulty', $recipe->difficulty ?? 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="hard"   {{ old('difficulty', $recipe->difficulty ?? 'medium') === 'hard'   ? 'selected' : '' }}>Hard</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Sort Order</label>
              <input class="form-control" type="number" name="sort_order" min="0"
                     value="{{ old('sort_order', $recipe->sort_order ?? 0) }}" />
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Video URL (YouTube / Vimeo)</label>
            <input class="form-control @error('video_url') is-invalid @enderror" type="url" name="video_url"
                   value="{{ old('video_url', $recipe->video_url ?? '') }}" placeholder="https://youtube.com/watch?v=…" />
            @error('video_url')<p class="form-error">{{ $message }}</p>@enderror
          </div>
        </div>

        {{-- INGREDIENTS --}}
        <div class="prod-panel" id="panel-ingredients">
          <div class="form-group">
            <label class="form-label">Ingredients List</label>
            <textarea class="form-control" name="ingredients" rows="14"
              placeholder="Enter each ingredient on a separate line:&#10;2 cups all-purpose flour&#10;1 cup sugar&#10;½ cup unsalted butter, softened&#10;2 large eggs&#10;1 tsp vanilla extract">{{ old('ingredients', $recipe->ingredients ?? '') }}</textarea>
            <p class="step-hint">One ingredient per line. On the frontend each line becomes a bullet point.</p>
          </div>
          <div class="form-group">
            <label class="form-label">Nutritional Information</label>
            <textarea class="form-control" name="nutritional_info" rows="4"
              placeholder="Per serving: Calories 320, Protein 5g, Carbs 52g, Fat 12g">{{ old('nutritional_info', $recipe->nutritional_info ?? '') }}</textarea>
          </div>
        </div>

        {{-- STEPS --}}
        <div class="prod-panel" id="panel-steps">
          <div class="form-group">
            <label class="form-label">Cooking Instructions</label>
            <textarea class="form-control" name="instructions" rows="18"
              placeholder="Enter each step on a separate line:&#10;Preheat your oven to 180°C (350°F). Grease a 9-inch round pan.&#10;In a large bowl, beat butter and sugar until light and fluffy.&#10;Add eggs one at a time, beating well after each addition.&#10;Sift in flour and fold gently until just combined.&#10;Pour into prepared pan and bake for 30–35 minutes.">{{ old('instructions', $recipe->instructions ?? '') }}</textarea>
            <p class="step-hint">One step per line. On the frontend each line becomes a numbered step.</p>
          </div>
        </div>

        {{-- NOTES --}}
        <div class="prod-panel" id="panel-notes">
          <div class="form-group">
            <label class="form-label">Chef Notes</label>
            <textarea class="form-control" name="chef_notes" rows="6"
              placeholder="Special notes from the chef, substitutions, pairing suggestions…">{{ old('chef_notes', $recipe->chef_notes ?? '') }}</textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Tips & Tricks</label>
            <textarea class="form-control" name="tips" rows="6"
              placeholder="Helpful tips, common mistakes to avoid, make-ahead notes…">{{ old('tips', $recipe->tips ?? '') }}</textarea>
          </div>
        </div>

        {{-- IMAGES --}}
        <div class="prod-panel" id="panel-images">
          <div class="form-group">
            <label class="form-label">Featured Image</label>
            <input class="form-control" type="file" name="featured_image" accept="image/*" />
            @if(isset($recipe) && $recipe->featured_image)
              <img src="{{ Storage::url($recipe->featured_image) }}" alt="{{ $recipe->title }}" class="admin-img-preview" />
            @endif
          </div>
          <div class="form-group">
            <label class="form-label">Gallery Images</label>
            <input class="form-control" type="file" name="gallery_images[]" multiple accept="image/*" />
            <p class="form-hint">Multiple files allowed. Max 2MB each.</p>
            @if(isset($recipe) && !empty($recipe->gallery))
              <div class="gallery-grid">
                @foreach($recipe->gallery as $path)
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

        {{-- SEO --}}
        <div class="prod-panel" id="panel-seo">
          <div class="form-group">
            <label class="form-label">SEO Title</label>
            <input class="form-control" type="text" name="seo_title"
                   value="{{ old('seo_title', $recipe->seo_title ?? '') }}"
                   placeholder="Best Chocolate Cake Recipe — Azmeer Bakery" />
          </div>
          <div class="form-group">
            <label class="form-label">Meta Description</label>
            <textarea class="form-control" name="seo_description" rows="3"
              placeholder="Under 160 characters…">{{ old('seo_description', $recipe->seo_description ?? '') }}</textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Meta Keywords</label>
            <input class="form-control" type="text" name="seo_keywords"
                   value="{{ old('seo_keywords', $recipe->seo_keywords ?? '') }}"
                   placeholder="chocolate cake, baking recipe, homemade cake" />
          </div>
        </div>
      </div>
    </div>

    {{-- RIGHT --}}
    <div>
      <div class="admin-card" style="margin-bottom:16px;">
        <h3 class="admin-card__heading">Category *</h3>
        <div class="form-group">
          <select class="form-control @error('recipe_category_id') is-invalid @enderror" name="recipe_category_id" required>
            <option value="">Select category</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ old('recipe_category_id', $recipe->recipe_category_id ?? '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
              </option>
            @endforeach
          </select>
          @error('recipe_category_id')<p class="form-error">{{ $message }}</p>@enderror
        </div>
      </div>

      <div class="admin-card" style="margin-bottom:16px;">
        <h3 class="admin-card__heading">Publishing</h3>
        <div style="display:flex;flex-direction:column;gap:10px;">
          <label class="form-label form-label--checkbox">
            <input type="checkbox" name="is_published" value="1"
                   {{ old('is_published', $recipe->is_published ?? true) ? 'checked' : '' }} />
            Published (visible on site)
          </label>
          <label class="form-label form-label--checkbox">
            <input type="checkbox" name="is_featured" value="1"
                   {{ old('is_featured', $recipe->is_featured ?? false) ? 'checked' : '' }} />
            Featured Recipe
          </label>
        </div>
      </div>

      <button type="submit" class="btn btn--primary btn--full">
        {{ isset($recipe) ? 'Update Recipe' : 'Publish Recipe' }}
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
