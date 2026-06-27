<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecipeCategory;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RecipeCategoryController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index()
    {
        $categories = RecipeCategory::withCount('recipes')->orderBy('sort_order')->get();
        return view('admin.recipe-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.recipe-categories.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:recipe_categories',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'sort_order'  => 'nullable|integer',
            'is_active'   => 'boolean',
        ]);

        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->imageService->uploadCategory($request->file('image'));
        }

        RecipeCategory::create($validated);

        return redirect()->route('admin.recipe-categories.index')
            ->with('success', 'Recipe category created.');
    }

    public function edit(RecipeCategory $recipeCategory)
    {
        return view('admin.recipe-categories.form', compact('recipeCategory'));
    }

    public function update(Request $request, RecipeCategory $recipeCategory)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:recipe_categories,name,'.$recipeCategory->id,
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'sort_order'  => 'nullable|integer',
            'is_active'   => 'boolean',
        ]);

        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $this->imageService->delete($recipeCategory->image);
            $validated['image'] = $this->imageService->uploadCategory($request->file('image'));
        }

        $recipeCategory->update($validated);

        return redirect()->route('admin.recipe-categories.index')
            ->with('success', 'Recipe category updated.');
    }

    public function destroy(RecipeCategory $recipeCategory)
    {
        $this->imageService->delete($recipeCategory->image);
        $recipeCategory->delete();
        return redirect()->route('admin.recipe-categories.index')
            ->with('success', 'Recipe category deleted.');
    }
}
