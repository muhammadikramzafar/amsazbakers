<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoBanner;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class PromoBannerController extends Controller
{
    public function index()
    {
        $banners = PromoBanner::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.homepage.promo-banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.homepage.promo-banners.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'      => 'required|string|max:255',
            'subtitle'   => 'nullable|string|max:500',
            'btn_text'   => 'nullable|string|max:100',
            'btn_url'    => 'nullable|string|max:500',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'is_active'  => 'nullable|boolean',
            'sort_order' => 'required|integer|min:0',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['image']     = $this->uploadImage($request);
        PromoBanner::create($data);
        return redirect()->route('admin.homepage.promo-banners.index')->with('success', 'Banner created.');
    }

    public function edit(PromoBanner $promoBanner)
    {
        return view('admin.homepage.promo-banners.form', ['banner' => $promoBanner]);
    }

    public function update(Request $request, PromoBanner $promoBanner): RedirectResponse
    {
        $data = $request->validate([
            'title'      => 'required|string|max:255',
            'subtitle'   => 'nullable|string|max:500',
            'btn_text'   => 'nullable|string|max:100',
            'btn_url'    => 'nullable|string|max:500',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'is_active'  => 'nullable|boolean',
            'sort_order' => 'required|integer|min:0',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            if ($promoBanner->image) Storage::disk('public')->delete($promoBanner->image);
            $data['image'] = $this->uploadImage($request);
        } else {
            unset($data['image']);
        }
        $promoBanner->update($data);
        return redirect()->route('admin.homepage.promo-banners.index')->with('success', 'Banner updated.');
    }

    public function destroy(PromoBanner $promoBanner): RedirectResponse
    {
        if ($promoBanner->image) Storage::disk('public')->delete($promoBanner->image);
        $promoBanner->delete();
        return back()->with('success', 'Banner deleted.');
    }

    private function uploadImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) return null;
        $file = $request->file('image');
        $name = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = "promo-banners/{$name}";
        $img  = Image::read($file->getPathname())->scaleDown(1200, 800);
        Storage::disk('public')->put($path, (string) $img->encode());
        return $path;
    }
}
