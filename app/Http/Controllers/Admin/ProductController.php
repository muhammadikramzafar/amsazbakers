<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index(Request $request)
    {
        $query = Product::with(['category', 'subcategory'])->orderBy('sort_order');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('sku', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            match ($request->status) {
                'active'      => $query->where('is_active', true),
                'inactive'    => $query->where('is_active', false),
                'featured'    => $query->where('is_featured', true),
                'bestseller'  => $query->where('is_bestseller', true),
                'unavailable' => $query->where('is_available', false),
                default       => null,
            };
        }

        $products   = $query->paginate(20)->withQueryString();
        $categories = Category::whereNull('parent_id')->active()->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories    = Category::whereNull('parent_id')->active()->orderBy('name')->get();
        $subcategories = Category::whereNotNull('parent_id')->active()->orderBy('name')->get();
        return view('admin.products.form', compact('categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'subcategory_id'   => 'nullable|exists:categories,id',
            'name'             => 'required|string|max:255|unique:products',
            'sku'              => 'nullable|string|max:100|unique:products,sku',
            'description'      => 'nullable|string',
            'short_description'=> 'nullable|string',
            'full_description' => 'nullable|string',
            'ingredients'      => 'nullable|string',
            'nutritional_info' => 'nullable|string',
            'allergens'        => 'nullable|string|max:500',
            'price'            => 'required|numeric|min:0',
            'sale_price'       => 'nullable|numeric|min:0',
            'badge'            => 'nullable|string|max:50',
            'image'            => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',
            'is_featured'      => 'boolean',
            'is_bestseller'    => 'boolean',
            'is_seasonal'      => 'boolean',
            'is_active'        => 'boolean',
            'is_available'     => 'boolean',
            'sort_order'       => 'nullable|integer',
        ]);

        $validated['slug']           = Str::slug($validated['name']);
        $validated['is_featured']    = $request->boolean('is_featured');
        $validated['is_bestseller']  = $request->boolean('is_bestseller');
        $validated['is_seasonal']    = $request->boolean('is_seasonal');
        $validated['is_active']      = $request->boolean('is_active', true);
        $validated['is_available']   = $request->boolean('is_available', true);
        $validated['subcategory_id'] = $request->filled('subcategory_id') ? $request->subcategory_id : null;
        $validated['sku']            = $request->filled('sku') ? $request->sku : null;

        if ($request->hasFile('image')) {
            $validated['image'] = $this->imageService->uploadProduct($request->file('image'));
        }

        $gallery = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $gallery[] = $this->imageService->uploadGallery($file);
            }
        }
        $validated['gallery'] = !empty($gallery) ? $gallery : null;

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories    = Category::whereNull('parent_id')->active()->orderBy('name')->get();
        $subcategories = Category::whereNotNull('parent_id')->active()->orderBy('name')->get();
        return view('admin.products.form', compact('product', 'categories', 'subcategories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'subcategory_id'   => 'nullable|exists:categories,id',
            'name'             => 'required|string|max:255|unique:products,name,'.$product->id,
            'sku'              => 'nullable|string|max:100|unique:products,sku,'.$product->id,
            'description'      => 'nullable|string',
            'short_description'=> 'nullable|string',
            'full_description' => 'nullable|string',
            'ingredients'      => 'nullable|string',
            'nutritional_info' => 'nullable|string',
            'allergens'        => 'nullable|string|max:500',
            'price'            => 'required|numeric|min:0',
            'sale_price'       => 'nullable|numeric|min:0',
            'badge'            => 'nullable|string|max:50',
            'image'            => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',
            'gallery_remove'   => 'nullable|array',
            'gallery_remove.*' => 'nullable|string',
            'is_featured'      => 'boolean',
            'is_bestseller'    => 'boolean',
            'is_seasonal'      => 'boolean',
            'is_active'        => 'boolean',
            'is_available'     => 'boolean',
            'sort_order'       => 'nullable|integer',
        ]);

        $validated['slug']           = Str::slug($validated['name']);
        $validated['is_featured']    = $request->boolean('is_featured');
        $validated['is_bestseller']  = $request->boolean('is_bestseller');
        $validated['is_seasonal']    = $request->boolean('is_seasonal');
        $validated['is_active']      = $request->boolean('is_active', true);
        $validated['is_available']   = $request->boolean('is_available', true);
        $validated['subcategory_id'] = $request->filled('subcategory_id') ? $request->subcategory_id : null;
        $validated['sku']            = $request->filled('sku') ? $request->sku : null;

        if ($request->hasFile('image')) {
            $this->imageService->delete($product->image);
            $validated['image'] = $this->imageService->uploadProduct($request->file('image'));
        }

        // Handle gallery: remove marked images, then append new uploads
        $gallery = $product->gallery ?? [];

        $toRemove = $request->input('gallery_remove', []);
        if (!empty($toRemove)) {
            foreach ($toRemove as $path) {
                $this->imageService->delete($path);
                $gallery = array_values(array_filter($gallery, fn($p) => $p !== $path));
            }
        }

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $gallery[] = $this->imageService->uploadGallery($file);
            }
        }

        $validated['gallery'] = !empty($gallery) ? array_values($gallery) : null;

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $this->imageService->delete($product->image);
        foreach ($product->gallery ?? [] as $path) {
            $this->imageService->delete($path);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }
}
