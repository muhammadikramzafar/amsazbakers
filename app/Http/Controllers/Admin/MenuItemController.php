<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuItemController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index(Request $request)
    {
        $query = MenuItem::with('category')->orderBy('sort_order');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('sku', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->filled('category_id')) {
            $query->where('menu_category_id', $request->category_id);
        }
        if ($request->filled('status')) {
            match ($request->status) {
                'active'           => $query->where('is_active', true),
                'inactive'         => $query->where('is_active', false),
                'featured'         => $query->where('is_featured', true),
                'bestseller'       => $query->where('is_bestseller', true),
                'chef_recommended' => $query->where('is_chef_recommended', true),
                'unavailable'      => $query->where('is_available', false),
                default            => null,
            };
        }

        $items      = $query->paginate(20)->withQueryString();
        $categories = MenuCategory::active()->get();

        return view('admin.menu.items.index', compact('items', 'categories'));
    }

    public function create()
    {
        $categories = MenuCategory::active()->get();
        return view('admin.menu.items.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_category_id'   => 'required|exists:menu_categories,id',
            'name'               => 'required|string|max:255|unique:menu_items',
            'sku'                => 'nullable|string|max:100|unique:menu_items,sku',
            'price'              => 'required|numeric|min:0',
            'discount_price'     => 'nullable|numeric|min:0',
            'short_description'  => 'nullable|string',
            'description'        => 'nullable|string',
            'ingredients'        => 'nullable|string',
            'nutritional_info'   => 'nullable|string',
            'allergens'          => 'nullable|string|max:500',
            'calories'           => 'nullable|integer|min:0',
            'serving_size'       => 'nullable|string|max:100',
            'preparation_time'   => 'nullable|string|max:50',
            'featured_image'     => 'nullable|image|max:2048',
            'gallery_images.*'   => 'nullable|image|max:2048',
            'is_available'       => 'boolean',
            'is_featured'        => 'boolean',
            'is_bestseller'      => 'boolean',
            'is_chef_recommended'=> 'boolean',
            'is_seasonal'        => 'boolean',
            'sort_order'         => 'nullable|integer',
            'is_active'          => 'boolean',
        ]);

        $validated['slug']               = Str::slug($validated['name']);
        $validated['is_available']       = $request->boolean('is_available', true);
        $validated['is_featured']        = $request->boolean('is_featured');
        $validated['is_bestseller']      = $request->boolean('is_bestseller');
        $validated['is_chef_recommended']= $request->boolean('is_chef_recommended');
        $validated['is_seasonal']        = $request->boolean('is_seasonal');
        $validated['is_active']          = $request->boolean('is_active', true);
        $validated['sku']                = $request->filled('sku') ? $request->sku : null;

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

        MenuItem::create($validated);

        return redirect()->route('admin.menu.items.index')
            ->with('success', 'Menu item created.');
    }

    public function edit(MenuItem $menuItem)
    {
        $categories = MenuCategory::active()->get();
        return view('admin.menu.items.form', compact('menuItem', 'categories'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'menu_category_id'   => 'required|exists:menu_categories,id',
            'name'               => 'required|string|max:255|unique:menu_items,name,'.$menuItem->id,
            'sku'                => 'nullable|string|max:100|unique:menu_items,sku,'.$menuItem->id,
            'price'              => 'required|numeric|min:0',
            'discount_price'     => 'nullable|numeric|min:0',
            'short_description'  => 'nullable|string',
            'description'        => 'nullable|string',
            'ingredients'        => 'nullable|string',
            'nutritional_info'   => 'nullable|string',
            'allergens'          => 'nullable|string|max:500',
            'calories'           => 'nullable|integer|min:0',
            'serving_size'       => 'nullable|string|max:100',
            'preparation_time'   => 'nullable|string|max:50',
            'featured_image'     => 'nullable|image|max:2048',
            'gallery_images.*'   => 'nullable|image|max:2048',
            'gallery_remove'     => 'nullable|array',
            'gallery_remove.*'   => 'nullable|string',
            'is_available'       => 'boolean',
            'is_featured'        => 'boolean',
            'is_bestseller'      => 'boolean',
            'is_chef_recommended'=> 'boolean',
            'is_seasonal'        => 'boolean',
            'sort_order'         => 'nullable|integer',
            'is_active'          => 'boolean',
        ]);

        $validated['slug']               = Str::slug($validated['name']);
        $validated['is_available']       = $request->boolean('is_available', true);
        $validated['is_featured']        = $request->boolean('is_featured');
        $validated['is_bestseller']      = $request->boolean('is_bestseller');
        $validated['is_chef_recommended']= $request->boolean('is_chef_recommended');
        $validated['is_seasonal']        = $request->boolean('is_seasonal');
        $validated['is_active']          = $request->boolean('is_active', true);
        $validated['sku']                = $request->filled('sku') ? $request->sku : null;

        if ($request->hasFile('featured_image')) {
            $this->imageService->delete($menuItem->featured_image);
            $validated['featured_image'] = $this->imageService->uploadProduct($request->file('featured_image'));
        }

        $gallery  = $menuItem->gallery ?? [];
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

        $menuItem->update($validated);

        return redirect()->route('admin.menu.items.index')
            ->with('success', 'Menu item updated.');
    }

    public function destroy(MenuItem $menuItem)
    {
        $this->imageService->delete($menuItem->featured_image);
        foreach ($menuItem->gallery ?? [] as $path) {
            $this->imageService->delete($path);
        }
        $menuItem->delete();
        return redirect()->route('admin.menu.items.index')
            ->with('success', 'Menu item deleted.');
    }
}
