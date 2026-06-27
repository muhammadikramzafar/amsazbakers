<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index()
    {
        $categories = BlogCategory::withCount('posts')->orderBy('sort_order')->paginate(20);
        return view('admin.blog.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.blog.categories.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:120',
            'slug'        => 'nullable|string|max:150|unique:blog_categories,slug',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:4096',
            'color'       => 'nullable|string|max:20',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ]);
        $data['slug']      = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $data['image'] = $this->imageService->uploadCategory($request->file('image'));
        }

        BlogCategory::create($data);
        return redirect()->route('admin.blog.categories.index')->with('success', 'Category created.');
    }

    public function edit(BlogCategory $blogCategory)
    {
        return view('admin.blog.categories.form', ['category' => $blogCategory]);
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:120',
            'slug'        => 'nullable|string|max:150|unique:blog_categories,slug,'.$blogCategory->id,
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:4096',
            'color'       => 'nullable|string|max:20',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ]);
        $data['slug']      = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', false);

        if ($request->hasFile('image')) {
            if ($blogCategory->image) $this->imageService->delete($blogCategory->image);
            $data['image'] = $this->imageService->uploadCategory($request->file('image'));
        }

        $blogCategory->update($data);
        return redirect()->route('admin.blog.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(BlogCategory $blogCategory)
    {
        if ($blogCategory->image) $this->imageService->delete($blogCategory->image);
        $blogCategory->delete();
        return back()->with('success', 'Category deleted.');
    }
}
