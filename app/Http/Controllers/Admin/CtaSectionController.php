<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CtaSection;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class CtaSectionController extends Controller
{
    public function index()
    {
        $ctas = CtaSection::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.homepage.cta.index', compact('ctas'));
    }

    public function create()
    {
        return view('admin.homepage.cta.form');
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
        CtaSection::create($data);
        return redirect()->route('admin.homepage.cta.index')->with('success', 'CTA created.');
    }

    public function edit(CtaSection $ctaSection)
    {
        return view('admin.homepage.cta.form', ['cta' => $ctaSection]);
    }

    public function update(Request $request, CtaSection $ctaSection): RedirectResponse
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
            if ($ctaSection->image) Storage::disk('public')->delete($ctaSection->image);
            $data['image'] = $this->uploadImage($request);
        } else {
            unset($data['image']);
        }
        $ctaSection->update($data);
        return redirect()->route('admin.homepage.cta.index')->with('success', 'CTA updated.');
    }

    public function destroy(CtaSection $ctaSection): RedirectResponse
    {
        if ($ctaSection->image) Storage::disk('public')->delete($ctaSection->image);
        $ctaSection->delete();
        return back()->with('success', 'CTA deleted.');
    }

    private function uploadImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) return null;
        $file = $request->file('image');
        $name = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = "cta/{$name}";
        $img  = Image::read($file->getPathname())->scaleDown(1600, 600);
        Storage::disk('public')->put($path, (string) $img->encode());
        return $path;
    }
}
