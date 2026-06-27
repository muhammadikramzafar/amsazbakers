<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.homepage.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.homepage.testimonials.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_role' => 'nullable|string|max:255',
            'quote'         => 'required|string|max:1000',
            'rating'        => 'required|integer|min:1|max:5',
            'avatar'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'     => 'nullable|boolean',
            'sort_order'    => 'required|integer|min:0',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['avatar']    = $this->uploadAvatar($request);
        Testimonial::create($data);
        return redirect()->route('admin.homepage.testimonials.index')->with('success', 'Testimonial created.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.homepage.testimonials.form', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_role' => 'nullable|string|max:255',
            'quote'         => 'required|string|max:1000',
            'rating'        => 'required|integer|min:1|max:5',
            'avatar'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'     => 'nullable|boolean',
            'sort_order'    => 'required|integer|min:0',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar) Storage::disk('public')->delete($testimonial->avatar);
            $data['avatar'] = $this->uploadAvatar($request);
        } else {
            unset($data['avatar']);
        }
        $testimonial->update($data);
        return redirect()->route('admin.homepage.testimonials.index')->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        if ($testimonial->avatar) Storage::disk('public')->delete($testimonial->avatar);
        $testimonial->delete();
        return back()->with('success', 'Testimonial deleted.');
    }

    private function uploadAvatar(Request $request): ?string
    {
        if (! $request->hasFile('avatar')) return null;
        $file = $request->file('avatar');
        $name = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = "testimonials/{$name}";
        $img  = Image::read($file->getPathname())->scaleDown(200, 200);
        Storage::disk('public')->put($path, (string) $img->encode());
        return $path;
    }
}
