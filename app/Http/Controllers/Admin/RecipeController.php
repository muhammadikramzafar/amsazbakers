<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\RecipeCategory;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RecipeController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index(Request $request)
    {
        $query = Recipe::with('category')->orderBy('sort_order');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }
        if ($request->filled('category_id')) {
            $query->where('recipe_category_id', $request->category_id);
        }
        if ($request->filled('status')) {
            match ($request->status) {
                'published'   => $query->where('is_published', true),
                'unpublished' => $query->where('is_published', false),
                'featured'    => $query->where('is_featured', true),
                default       => null,
            };
        }

        $recipes    = $query->paginate(20)->withQueryString();
        $categories = RecipeCategory::active()->get();

        return view('admin.recipes.index', compact('recipes', 'categories'));
    }

    public function create()
    {
        $categories = RecipeCategory::active()->get();
        return view('admin.recipes.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipe_category_id' => 'required|exists:recipe_categories,id',
            'title'              => 'required|string|max:255|unique:recipes',
            'short_description'  => 'nullable|string',
            'description'        => 'nullable|string',
            'prep_time'          => 'nullable|string|max:50',
            'cook_time'          => 'nullable|string|max:50',
            'total_time'         => 'nullable|string|max:50',
            'servings'           => 'nullable|integer|min:1',
            'difficulty'         => 'required|in:easy,medium,hard',
            'ingredients'        => 'nullable|string',
            'instructions'       => 'nullable|string',
            'chef_notes'         => 'nullable|string',
            'tips'               => 'nullable|string',
            'video_url'          => 'nullable|url|max:500',
            'nutritional_info'   => 'nullable|string',
            'featured_image'     => 'nullable|image|max:2048',
            'gallery_images.*'   => 'nullable|image|max:2048',
            'is_featured'        => 'boolean',
            'seo_title'          => 'nullable|string|max:255',
            'seo_description'    => 'nullable|string',
            'seo_keywords'       => 'nullable|string|max:500',
            'is_published'       => 'boolean',
            'sort_order'         => 'nullable|integer',
        ]);

        $validated['slug']         = Str::slug($validated['title']);
        $validated['is_featured']  = $request->boolean('is_featured');
        $validated['is_published'] = $request->boolean('is_published', true);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->imageService->uploadProduct($request->file('featured_image'));
        }

        $gallery = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $gallery[] = $this->imageService->uploadGallery($file);
            }
        }
        $validated['gallery'] = !empty($gallery) ? $gallery : null;

        Recipe::create($validated);

        return redirect()->route('admin.recipes.index')
            ->with('success', 'Recipe created.');
    }

    public function edit(Recipe $recipe)
    {
        $categories = RecipeCategory::active()->get();
        return view('admin.recipes.form', compact('recipe', 'categories'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'recipe_category_id' => 'required|exists:recipe_categories,id',
            'title'              => 'required|string|max:255|unique:recipes,title,'.$recipe->id,
            'short_description'  => 'nullable|string',
            'description'        => 'nullable|string',
            'prep_time'          => 'nullable|string|max:50',
            'cook_time'          => 'nullable|string|max:50',
            'total_time'         => 'nullable|string|max:50',
            'servings'           => 'nullable|integer|min:1',
            'difficulty'         => 'required|in:easy,medium,hard',
            'ingredients'        => 'nullable|string',
            'instructions'       => 'nullable|string',
            'chef_notes'         => 'nullable|string',
            'tips'               => 'nullable|string',
            'video_url'          => 'nullable|url|max:500',
            'nutritional_info'   => 'nullable|string',
            'featured_image'     => 'nullable|image|max:2048',
            'gallery_images.*'   => 'nullable|image|max:2048',
            'gallery_remove'     => 'nullable|array',
            'gallery_remove.*'   => 'nullable|string',
            'is_featured'        => 'boolean',
            'seo_title'          => 'nullable|string|max:255',
            'seo_description'    => 'nullable|string',
            'seo_keywords'       => 'nullable|string|max:500',
            'is_published'       => 'boolean',
            'sort_order'         => 'nullable|integer',
        ]);

        $validated['slug']         = Str::slug($validated['title']);
        $validated['is_featured']  = $request->boolean('is_featured');
        $validated['is_published'] = $request->boolean('is_published', true);

        if ($request->hasFile('featured_image')) {
            $this->imageService->delete($recipe->featured_image);
            $validated['featured_image'] = $this->imageService->uploadProduct($request->file('featured_image'));
        }

        $gallery  = $recipe->gallery ?? [];
        $toRemove = $request->input('gallery_remove', []);
        foreach ($toRemove as $path) {
            $this->imageService->delete($path);
            $gallery = array_values(array_filter($gallery, fn($p) => $p !== $path));
        }
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $gallery[] = $this->imageService->uploadGallery($file);
            }
        }
        $validated['gallery'] = !empty($gallery) ? array_values($gallery) : null;

        $recipe->update($validated);

        return redirect()->route('admin.recipes.index')
            ->with('success', 'Recipe updated.');
    }

    public function destroy(Recipe $recipe)
    {
        $this->imageService->delete($recipe->featured_image);
        foreach ($recipe->gallery ?? [] as $path) {
            $this->imageService->delete($path);
        }
        $recipe->delete();
        return redirect()->route('admin.recipes.index')
            ->with('success', 'Recipe deleted.');
    }
}
