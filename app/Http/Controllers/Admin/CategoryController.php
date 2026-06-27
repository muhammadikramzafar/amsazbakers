<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index()
    {
        $topLevel = Category::with(['children' => function ($q) {
            $q->withCount('products')->orderBy('sort_order');
        }])
        ->withCount('products')
        ->whereNull('parent_id')
        ->orderBy('sort_order')
        ->get();

        return view('admin.categories.index', compact('topLevel'));
    }

    public function create()
    {
        $parents = Category::whereNull('parent_id')->active()->orderBy('name')->get();
        return view('admin.categories.form', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_id'   => 'nullable|exists:categories,id',
            'name'        => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:50',
            'image'       => 'nullable|image|max:2048',
            'is_active'   => 'boolean',
            'sort_order'  => 'nullable|integer',
        ]);

        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['parent_id'] = $request->filled('parent_id') ? $request->parent_id : null;

        if ($request->hasFile('image')) {
            $validated['image'] = $this->imageService->uploadCategory($request->file('image'));
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        // Only top-level categories can be parents
        $parents = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->active()->orderBy('name')->get();

        return view('admin.categories.form', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'parent_id'   => 'nullable|exists:categories,id',
            'name'        => 'required|string|max:255|unique:categories,name,'.$category->id,
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:50',
            'image'       => 'nullable|image|max:2048',
            'is_active'   => 'boolean',
            'sort_order'  => 'nullable|integer',
        ]);

        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['parent_id'] = $request->filled('parent_id') ? $request->parent_id : null;

        if ($request->hasFile('image')) {
            $this->imageService->delete($category->image);
            $validated['image'] = $this->imageService->uploadCategory($request->file('image'));
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $this->imageService->delete($category->image);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }
}
