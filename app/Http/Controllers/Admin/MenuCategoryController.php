<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuCategoryController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index()
    {
        $categories = MenuCategory::withCount('menuItems')->orderBy('sort_order')->get();
        return view('admin.menu.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.menu.categories.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:menu_categories',
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

        MenuCategory::create($validated);

        return redirect()->route('admin.menu.categories.index')
            ->with('success', 'Menu category created.');
    }

    public function edit(MenuCategory $menuCategory)
    {
        return view('admin.menu.categories.form', compact('menuCategory'));
    }

    public function update(Request $request, MenuCategory $menuCategory)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:menu_categories,name,'.$menuCategory->id,
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'sort_order'  => 'nullable|integer',
            'is_active'   => 'boolean',
        ]);

        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $this->imageService->delete($menuCategory->image);
            $validated['image'] = $this->imageService->uploadCategory($request->file('image'));
        }

        $menuCategory->update($validated);

        return redirect()->route('admin.menu.categories.index')
            ->with('success', 'Menu category updated.');
    }

    public function destroy(MenuCategory $menuCategory)
    {
        $this->imageService->delete($menuCategory->image);
        $menuCategory->delete();
        return redirect()->route('admin.menu.categories.index')
            ->with('success', 'Menu category deleted.');
    }
}
