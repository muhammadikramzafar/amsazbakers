<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SignatureDish;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class SignatureDishController extends Controller
{
    public function index()
    {
        $dishes = SignatureDish::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.homepage.signature-dishes.index', compact('dishes'));
    }

    public function create()
    {
        return view('admin.homepage.signature-dishes.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'price'       => 'nullable|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'tag'         => 'nullable|string|max:50',
            'is_active'   => 'nullable|boolean',
            'sort_order'  => 'required|integer|min:0',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['image']     = $this->uploadImage($request);
        SignatureDish::create($data);
        return redirect()->route('admin.homepage.signature-dishes.index')->with('success', 'Dish created.');
    }

    public function edit(SignatureDish $signatureDish)
    {
        return view('admin.homepage.signature-dishes.form', ['dish' => $signatureDish]);
    }

    public function update(Request $request, SignatureDish $signatureDish): RedirectResponse
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'price'       => 'nullable|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'tag'         => 'nullable|string|max:50',
            'is_active'   => 'nullable|boolean',
            'sort_order'  => 'required|integer|min:0',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            if ($signatureDish->image) Storage::disk('public')->delete($signatureDish->image);
            $data['image'] = $this->uploadImage($request);
        } else {
            unset($data['image']);
        }
        $signatureDish->update($data);
        return redirect()->route('admin.homepage.signature-dishes.index')->with('success', 'Dish updated.');
    }

    public function destroy(SignatureDish $signatureDish): RedirectResponse
    {
        if ($signatureDish->image) Storage::disk('public')->delete($signatureDish->image);
        $signatureDish->delete();
        return back()->with('success', 'Dish deleted.');
    }

    private function uploadImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) return null;
        $file = $request->file('image');
        $name = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = "signature-dishes/{$name}";
        $img  = Image::read($file->getPathname())->scaleDown(800, 800);
        Storage::disk('public')->put($path, (string) $img->encode());
        return $path;
    }
}
