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

    public function index()
    {
        $products = Product::with('category')->orderBy('sort_order')->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:255|unique:products',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'sale_price'   => 'nullable|numeric|min:0|lt:price',
            'badge'        => 'nullable|string|max:50',
            'image'        => 'nullable|image|max:2048',
            'is_featured'  => 'boolean',
            'is_active'    => 'boolean',
            'is_available' => 'boolean',
            'sort_order'   => 'nullable|integer',
        ]);

        $validated['slug']         = Str::slug($validated['name']);
        $validated['is_featured']  = $request->boolean('is_featured');
        $validated['is_active']    = $request->boolean('is_active', true);
        $validated['is_available'] = $request->boolean('is_available', true);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->imageService->uploadProduct($request->file('image'));
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:255|unique:products,name,'.$product->id,
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'sale_price'   => 'nullable|numeric|min:0',
            'badge'        => 'nullable|string|max:50',
            'image'        => 'nullable|image|max:2048',
            'is_featured'  => 'boolean',
            'is_active'    => 'boolean',
            'is_available' => 'boolean',
            'sort_order'   => 'nullable|integer',
        ]);

        $validated['slug']         = Str::slug($validated['name']);
        $validated['is_featured']  = $request->boolean('is_featured');
        $validated['is_active']    = $request->boolean('is_active', true);
        $validated['is_available'] = $request->boolean('is_available', true);

        if ($request->hasFile('image')) {
            $this->imageService->delete($product->image);
            $validated['image'] = $this->imageService->uploadProduct($request->file('image'));
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $this->imageService->delete($product->image);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }
}
