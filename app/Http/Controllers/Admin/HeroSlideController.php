<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.homepage.hero-slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.homepage.hero-slides.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'      => 'required|string|max:255',
            'subtitle'   => 'nullable|string|max:500',
            'btn1_text'  => 'required|string|max:100',
            'btn1_url'   => 'required|string|max:500',
            'btn2_text'  => 'nullable|string|max:100',
            'btn2_url'   => 'nullable|string|max:500',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'is_active'  => 'nullable|boolean',
            'sort_order' => 'required|integer|min:0',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['image']     = $this->uploadImage($request, 'image', 'hero-slides');

        HeroSlide::create($data);
        return redirect()->route('admin.homepage.hero-slides.index')->with('success', 'Slide created.');
    }

    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.homepage.hero-slides.form', ['slide' => $heroSlide]);
    }

    public function update(Request $request, HeroSlide $heroSlide): RedirectResponse
    {
        $data = $request->validate([
            'title'      => 'required|string|max:255',
            'subtitle'   => 'nullable|string|max:500',
            'btn1_text'  => 'required|string|max:100',
            'btn1_url'   => 'required|string|max:500',
            'btn2_text'  => 'nullable|string|max:100',
            'btn2_url'   => 'nullable|string|max:500',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'is_active'  => 'nullable|boolean',
            'sort_order' => 'required|integer|min:0',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            if ($heroSlide->image) Storage::disk('public')->delete($heroSlide->image);
            $data['image'] = $this->uploadImage($request, 'image', 'hero-slides');
        } else {
            unset($data['image']);
        }

        $heroSlide->update($data);
        return redirect()->route('admin.homepage.hero-slides.index')->with('success', 'Slide updated.');
    }

    public function destroy(HeroSlide $heroSlide): RedirectResponse
    {
        if ($heroSlide->image) Storage::disk('public')->delete($heroSlide->image);
        $heroSlide->delete();
        return back()->with('success', 'Slide deleted.');
    }

    private function uploadImage(Request $request, string $field, string $folder): ?string
    {
        if (! $request->hasFile($field)) return null;
        $file = $request->file($field);
        $name = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = "{$folder}/{$name}";
        $img  = Image::read($file->getPathname())->scaleDown(1920, 1080);
        Storage::disk('public')->put($path, (string) $img->encode());
        return $path;
    }
}
